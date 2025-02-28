<?php

namespace App\Http\Controllers;

use App\Models\IgnoredWord;
use App\Models\Language;
use App\Models\Misspelling;
use App\Models\Page;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;

 
class DictionariesController extends Controller
{
    public function showDictionaries()
    {
        $languages= Language::all();
        
        return view('dictionaries.dictionaries_list', ['languages' => $languages]);
    }

    public function showWords2($langId)
    {
        return $this->showWords($langId, 'A'); 
    }
    
    public function showWords($langId, $startsWith)
    {
        $w_chars = [] ;
        for ($i=0;$i<26;$i++)
        {
            $letter = chr(ord("A")+$i);
            $w_chars[$i] = $letter;
        }
        
        $words = DB::select("select * from words where language_id=? and name like  '" . substr($startsWith, 0, 1) . "%' order by name", [$langId]);
        
        return view('dictionaries.words_list', ['words' => $words, 'w_chars'=> $w_chars, 'starts_with'=> $startsWith, 'language_id'=> $langId]);
    }
    
    public function addWordInit()
    {
        $word = new Word;
        $languages= Language::all();
        
        return view('dictionaries.add_word', ['word' => $word, 'languages' => $languages]);
    }
    public function addWord(Request $request)
    {
        $word = new Word;
        $this->populate($word, $request);
        $word->save();
        return redirect('/show_words/'. $word->language_id . '/' . strtoupper(substr($word->name, 0, 1)));
    }
    
    public function editWord($id)
    {
        $word = Word::find($id);
        $languages= Language::all();
        
        return view('dictionaries.edit_word', ['word' => $word, 'languages' => $languages]);
    }
    public function saveWord(Request $request)
    {
        $word = Word::find($request->id);
        $this->populate($word, $request);
        $word->save();
        return redirect('/show_words/'. $word->language_id . '/' . strtoupper(substr($word->name, 0, 1)));
    }
    
    public function deleteWord($id)
    {
        $word = Word::find($id);
        
        Word::destroy($id);
        return redirect('/show_words/'. $word->language_id. '/' . strtoupper(substr($word->name, 0, 1)));
    }
    
    public function exportCustomDict()
    {
        $languages = Language::all();
        
        foreach($languages as $language)
        {
            $words = DB::select('select * from words where language_id=? order by name', [$language->id]);
            
            $filename = config('dict.folder') . '/custom_'. $language->short_name . '.txt';
            if (!$fp = fopen($filename, 'w'))
            {
                echo "Cannot open file ($filename)";
                exit;
            }
            
            foreach($words as $word)
            {
                // Write $somecontent to our opened file.
                if (fwrite($fp, $word->name."\n") === FALSE)
                {
                    echo "Cannot write to file ($filename)";
                    exit;
                }
            }
            
            fclose($fp);
            
        }
        $words = DB::select('select * from ignored_words order by name');
        
        $filename = config('dict.folder') . '/ignored.txt';
        if (!$fp = fopen($filename, 'w'))
        {
            echo "Cannot open file ($filename)";
            exit;
        }
        
        foreach($words as $word)
        {
            // Write $somecontent to our opened file.
            if (fwrite($fp, $word->name."\n") === FALSE)
            {
                echo "Cannot write to file ($filename)";
                exit;
            }
        }
        
        fclose($fp);
        
        return $this->buildCustomDict();
    }
    public function buildCustomDict()
    {
        $languages = Language::all();
        $errors = "";
        $output = "";
        
        foreach($languages as $language)
        {
            $folder = config('dict.folder');
            $lang_short = $language->short_name;
            
            $result = Process::path($folder)->run('aspell --encoding=UTF-8 --lang=' . $lang_short . ' create master ' . $folder . '/custom_' . $lang_short . '.rws < ' . $folder . '/custom_' . $lang_short . '.txt');
            
            $errors = $errors . $result->errorOutput();
            $output = $output . $result->output();
        }
        
        return view('dictionaries.compile', ['errors' => $errors, 'output' => $output]);
    }
    
    public function addWordToDict($id, $page_id)
    {
        $misspellings = DB::select('select * from misspellings where page_id = ?', [$page_id]);
        $page = Page::find($page_id);
        
        $language_ids = DB::select('select p.language_id from projects p, spellcheck_jobs s where  s.project_id=p.id and s.id = ?', [$page->spellcheck_job_id]);
        
        $misspelling = Misspelling::find($id);
        
        $word=new Word();
        $word->language_id=$language_ids[0]->language_id;
        $word->name=$misspelling->word;
        $word->save();
        
        return view('misspellings_list', ['misspellings' => $misspellings, 'page' => $page]);
    }
    
    public function addWordToIgnored($id, $page_id)
    {
        $misspellings = DB::select('select * from misspellings where page_id = ?', [$page_id]);
        $page = Page::find($page_id);
        
        $misspelling = Misspelling::find($id);
        
        $word=new IgnoredWord();
        $word->name=$misspelling->word;
        $word->save();
        
        return view('misspellings_list', ['misspellings' => $misspellings, 'page' => $page]);
    }
    
    
    private function populate(&$word, Request $request)
    {
        $word->name=$request->name;
        $word->language_id=$request->language_id;
    }
    
}
