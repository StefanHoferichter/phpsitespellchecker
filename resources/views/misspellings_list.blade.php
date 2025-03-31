@extends('phpsitespellchecker')
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
            <tr  class="tableheader"><td>Word</td><td>Line</td><td>Offset</td><td>Message</td><td>Context</td></tr>
            @foreach($misspellings as $misspelling) 
              @if ($loop->index % 2 == 0)
              	<tr class="evenrow">
              @else
              	<tr>
              @endif	
				<td>{{ $misspelling->word }}</td><td>{{ $misspelling->line }}</td><td>{{$misspelling->offset}}</td><td>{{$misspelling->message}}</td><td>{{$misspelling->context}}</td>
              @if ($tool_id == 1)
              	<td><a href="/add_word_to_dict/{{$misspelling->id}}/{{$page->id}}">Add to Dictionary</a></td><td><a href="/add_word_to_ignored/{{$misspelling->id}}/{{$page->id}}">Add to Ignored</a></td>
              @else	
              	<td><a href="/add_message_to_ignored/{{urlencode($misspelling->message)}}/{{$page->id}}">Add to Ignored LT Messages</a></td>
              @endif	
              	</tr>
            @endforeach
        </table>
        
        
@endsection