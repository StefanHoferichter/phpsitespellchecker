@extends('phpspellchecker')
@section('submenu')
@include ('include_dummy_menu')     
@endsection
@section('title', 'Page Details')
@section('url', env('APP_URL').'/show_page_detail/'.$page->id)


@section('content')
        <h1>Scanned Page Details</h1>
        <h2><a href="{{$page->url}}" target="_blank">{{$page->url}}</a></h2>

        <a href="/show_job_detail/{{$page->spellcheck_job_id}}">back to spellcheck job</a>

        <br><br>
        <table>
            @foreach($misspellings as $misspelling) 
              <tr><td>{{ $misspelling->word }}</td><td>{{ $misspelling->line }}</td><td>{{$misspelling->offset}}</td><td><a href="/add_word_to_dict/{{$misspelling->id}}/{{$page->id}}">Add to Dictionary</a></td><td><a href="/add_word_to_ignored/{{$misspelling->id}}/{{$page->id}}">Add to Ignored</a></td></tr>
            @endforeach
        </table>
        
        
@endsection