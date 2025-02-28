<?php

namespace App\Http\Controllers;

use App\Jobs\SpellcheckBackgroundJob;
use App\Models\IgnoredWord;
use App\Models\Language;
use App\Models\Misspelling;
use App\Models\Page;
use App\Models\Project;
use App\Models\SpellcheckJob;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;

 
class SpellController extends Controller
{
    public function showJobs()
    {
        Log::debug('start show jobs');
        $jobs= DB::select('select s.id job_id, p.title, s.status, s.pages, s.faulty_pages, s.misspellings, s.created_at, TIMESTAMPDIFF(MINUTE, s.created_at, s.updated_at)+1 AS duration, s.completion from spellcheck_jobs s, projects p where s.project_id=p.id order by s.id');
        $projects= Project::all();
        Log::debug('end show jobs');
        return view('spellcheck_jobs_list', ['jobs' => $jobs, 'projects' => $projects]);
    }
    
    public function triggerJob(Request $request)
    {
        Log::info("adhoc: ". $request->adhoc);
        echo("adhoc: ". $request->adhoc);
        $sc = new SpellcheckJob();
        $sc->project_id = $request->project_id;
        $sc->status = "Q";
        $sc->save();
        
        if ($request->adhoc == "true")
            SpellcheckBackgroundJob::dispatchSync($sc);
        else
            SpellcheckBackgroundJob::dispatch($sc);
        
        return redirect('/jobs');
    }

    public function showJobDetails($id)
    {
        $pages = DB::select('select * from pages where spellcheck_job_id = ?', [$id]);
        
        
        return view('pages_list', ['pages' => $pages]);
    }
    
    
    public function showPageDetails($id)
    {
        $misspellings = DB::select('select * from misspellings where page_id = ?', [$id]);
        
        $page = Page::find($id);
        
        return view('misspellings_list', ['misspellings' => $misspellings, 'page' => $page]);
    }
    
    
    public function deleteSpellcheckJob($id)
    {
        $language_ids = DB::delete('delete from spellcheck_jobs where id = ?', [$id]);
        
        return $this->showJobs();
    }

    //-------api ---------------
    
    public function getJobStatus()
    {
        $jobs= DB::select('select s.id job_id, p.title, s.status, s.pages, s.faulty_pages, s.misspellings, s.created_at, TIMESTAMPDIFF(MINUTE, s.created_at, s.updated_at)+1 AS duration, s.completion from spellcheck_jobs s, projects p where s.project_id=p.id order by s.id');
        
        return $jobs;
    }
    
 }
