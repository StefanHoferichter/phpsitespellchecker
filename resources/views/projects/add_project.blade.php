@extends('phpsitespellchecker')
@section('submenu')
@include ('projects.include_projects_menu');        
@endsection
@section('title', 'Add Project')
@section('url', env('APP_URL').'/add_project')


@section('content')
        <h1>Add Project</h1>

        <br><br>
		   @include ('projects.include_project', ['action'=>'/add_project' ])      
        
@endsection