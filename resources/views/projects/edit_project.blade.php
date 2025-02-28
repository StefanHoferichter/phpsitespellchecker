@extends('phpsitespellchecker')
@section('submenu')
@include ('projects.include_projects_menu')
@endsection
@section('title', 'Edit Project')
@section('url', env('APP_URL').'/edit_project')


@section('content')
        <h1>Edit Project</h1>

        <br><br>
		   @include ('projects.include_project', ['action'=>'/save_project' ])    
        
@endsection