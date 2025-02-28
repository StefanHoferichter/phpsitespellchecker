@extends('phpsitespellchecker')
@section('submenu')
@include ('include_dummy_menu')     
@endsection
@section('title', 'Job Details')
@php if (count($pages) > 0) $jobId = $pages[0]->spellcheck_job_id; else $jobId = 0; @endphp
@section('url', env('APP_URL').'/show_job_detail/'.$jobId)
@section('content')
        <h1>Scanned Pages</h1>
        <h2>Job ID: {{ $jobId }}</h2>
<br>

        <table>
            <tr><td>Orig</td><td>URL</td><td>Misspellings</td><td>Preview</td></tr>
            @foreach($pages as $page) 
              <tr><td><a href="{{$page->url}}" target="_blank">Orig</a></td><td><a href="/show_page_detail/{{$page->id}}">{{ $page->url }}</a></td><td>{{ $page->misspellings }}</td><td>{{$page->preview}}</td></tr>
            @endforeach
        </table>
        
        
@endsection