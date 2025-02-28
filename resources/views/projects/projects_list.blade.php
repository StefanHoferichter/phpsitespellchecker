@extends('phpsitespellchecker')
@section('submenu')
@include ('projects.include_projects_menu')  
@endsection
@section('title', 'Projects List')
@section('url', env('APP_URL').'/show_projects')


@section('content')
        <h1>Projects</h1>

        <br><br>
        <table>
            @foreach($projects as $project) 
              <tr><td>{{ $project->id }}</td><td>{{ $project->title }}</td><td>{{$project->sitemap}}</td><td>{{$project->long_name}}</td><td><a href="/edit_project/{{$project->id}}">Edit</a></td><td><a href="/delete_project/{{$project->id}}">Delete</a></td></tr>
            @endforeach
        </table>
        
        
@endsection