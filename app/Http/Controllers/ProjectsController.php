<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Project;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

 
class ProjectsController extends Controller
{
     public function showProjects()
    {
        $projects =  DB::select('select p.id, p.title, p.sitemap, p.language_id, l.long_name, p.max_pages, p.delay_ms, t.name tool from projects p, languages l, tools t where p.tool_id=t.id and p.language_id = l.id');
        
        return view('projects.projects_list', ['projects' => $projects]);
    }
    
    public function addProjectInit()
    {
        $project = new Project;
        $languages= Language::all();
        $tools= Tool::all();
        
        return view('projects.add_project', ['project' => $project, 'languages' => $languages, 'tools' => $tools]);
    }
    public function addProject(Request $request)
    {
        $project = new Project;
        $this->populate($project, $request);
        $project->save();
        return redirect('/show_projects');
    }
    
    public function editProject($id)
    {
        $project = Project::find($id);
        $languages= Language::all();
        $tools= Tool::all();
        
        return view('projects.edit_project', ['project' => $project, 'languages' => $languages, 'tools' => $tools]);
    }
    public function saveProject(Request $request)
    {
        $project = Project::find($request->id);
        $this->populate($project, $request);
        $project->save();
        return redirect('/show_projects');
    }
    
    public function deleteProject($id)
    {
        Project::destroy($id);
        return redirect('/show_projects');
    }
    
    
    private function populate(&$project, Request $request)
    {
        $project->title=$request->title;
        $project->sitemap=$request->sitemap;
        $project->max_pages=$request->max_pages;
        $project->delay_ms=$request->delay_ms;
        $project->language_id=$request->language_id;
        $project->tool_id=$request->tool_id;
    }
    
}
