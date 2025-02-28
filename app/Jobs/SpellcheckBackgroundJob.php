<?php

namespace App\Jobs;

use App\Models\IgnoredWord;
use App\Models\Language;
use App\Models\Misspelling;
use App\Models\Page;
use App\Models\Project;
use App\Models\SpellcheckJob;
use Carbon\Exceptions\Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use PhpSpellcheck\Spellchecker\Aspell;
use ErrorException;


class SpellcheckBackgroundJob implements ShouldQueue
{
    use Queueable;

    public $sc;
    /**
     * Create a new job instance.
     */
    public function __construct(SpellcheckJob $sc)
    {
        $this->sc = $sc;
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {        
        Log::info('start handling spellcheck job');
        
        $sc = $this->sc;
        $project = Project::find($sc->project_id);
        $language = Language::find($project->language_id);
        $sitemap= $project->sitemap;
        $sc->completion = 0;
        $sc->status = "S";
        $sc->save();
        
        $xml = $this->retrieveURL($sitemap);
        if ($xml === false or $xml == null)
            $this->cancelRun($sc);
        else 
        {
            $urls = $this->parseSitemap($xml);
            $xml=null;
            
            $ignoredWords = IgnoredWord::all();
            
            $sc->pages = count($urls);
            $sc->save();
            
            $total_misspellings = 0;
            $faulty_pages = 0;
            $max_pages = count($urls);
            if ($max_pages > $project->max_pages and $project->max_pages != 0)
                $max_pages = $project->max_pages;
            for ($i=0;$i<$max_pages;$i++)
            {
                echo "handle: " . $urls[$i] ."\n";
                Log::info( "sleep ");
                usleep($project->delay_ms*1000);
                Log::info( "before html retrieval ");
                $html = $this->retrieveURL($urls[$i]);
                Log::info("before spellcheck");
                $misspellings = $this->spellcheckURL($html, $language, $ignoredWords);
                $html=null;
                Log::info("after spellcheck");
                $misspell_array = iterator_to_array($misspellings);
                $misspellings = null;
                $total_misspellings = $total_misspellings + count($misspell_array);
                if (count($misspell_array) > 0)
                    $faulty_pages++;
                    $page=new Page();
                    $page->spellcheck_job_id = $sc->id;
                    $page->url = $urls[$i];
                    $page->misspellings = count($misspell_array);
                    $cnt=0;
                    $preview = "";
                    foreach($misspell_array as $misspelling)
                    {
                        $cnt++;
                        if ($cnt == 1)
                            $preview = $misspelling->getWord();
                            else if ($cnt < 6)
                                $preview = $preview. " ".$misspelling->getWord();
                    }
                    $page->preview = $preview;
                    $page->save();
                    Log::debug ("page id: " . $page->id . " page url " . $page->url);
                    
                    foreach($misspell_array as $misspelling)
                    {
                        $ms = new Misspelling();
                        $ms->page_id = $page->id;;
                        $ms->word = $misspelling->getWord();
                        $ms->line = $misspelling->getLineNumber();
                        $ms->offset = $misspelling->getOffset();
                        $ms->save();
                        $ms=null;
                    }
                    $page=null;
                    $misspell_array=null;
                    Log::info("after saving misspells");
                    
                    if ($i % 5 == 0)
                    {
                        $sc->completion = intval(100.0*($i+1)/$max_pages);
                        $sc->status = "S";
                        $sc->save();
                    }
                    
            }
            Log::info("save end status");
            $sc->faulty_pages = $faulty_pages;
            $sc->misspellings = $total_misspellings;
            $sc->completion = 100;
            $sc->status = "E";
            $sc->save();
        }
        
        
        Log::info('end handling spellcheck job');
    }

    private function cancelRun($sc)
    {
        Log::info("save end status");
        $sc->faulty_pages = 0;
        $sc->misspellings = 0;
        $sc->completion = -1;
        $sc->status = "F";
        $sc->save();
        
        Log::info('cancelling run');
        
    }
    private function retrieveURL($url)
    {
        Log::info("retrieving $url");;
        
        
        try 
        {
            $options  = array('http' => array('user_agent' => 'PHPSpellChecker agent'));
            $context  = stream_context_create($options);
            $html = file_get_contents($url, false, $context);
        } 
        catch (Exception $exception)
        {
            Log::error('This should not happen: ' . $exception->getMessage());
            $html=null;
        }
        catch (ErrorException $exception)
        {
            Log::error('This should not happen ee: ' . $exception->getMessage());
            $html=null;
        }
        
        if ($html === false)
        {
            $error = error_get_last();
            Log::error( "HTTP request failed. Error was: " . $error['message']);
        }
        
        return $html;
    }
    
    private function parseSitemap($xml)
    {
        $urls = array();
        $parsed = simplexml_load_string($xml);
        if ($parsed === false)
        {
            Log::error("Failed loading XML: ");
            foreach(libxml_get_errors() as $error)
            {
                Log::error($error->message);
            }
        }
        else
        {
            foreach ($parsed as $row)
            {
                array_push($urls, $row->loc);
            }
            
        }
        
        return $urls;
    }
    
    private function spellcheckURL($html, $language, $ignoredWords)
    {
        $raw = $html."";
        $aspell = Aspell::create();

        $loop=true;
        while ($loop)
        {
            $first = strpos($raw, "<script");
            $end = strpos($raw, "</script>");
            if ($first > 0 and $end > 0)
                $raw = substr($raw, 0, $first) . substr($raw, $end+9);
                else
                    $loop=false;
        }
        
        $raw2 = htmlspecialchars_decode($raw);
        
        foreach($ignoredWords as $ignore)
        {
            Log::debug("ignore: ". $ignore->name . "!");
            $raw2 = str_replace($ignore->name, "", $raw2);
        }
        $str = strip_tags($raw2);
        Log::info("before aspell");
        $misspellings = $aspell->check($str, [$language->short_name], ['']);
        Log::info("after aspell");
        
        return $misspellings;
    }
    
    private function extractLinks($html)
    {
        $linkArray = array();
        if(preg_match_all('/<a\s+.*?href=[\"\']?([^\"\' >]*)[\"\']?[^>]*>(.*?)<\/a>/i', $html, $matches, PREG_SET_ORDER))
        {
            foreach ($matches as $match) {
                array_push($linkArray, array($match[1], $match[2]));
            }
        }
        return $linkArray;
    }
    
}
