@extends('phpsitespellchecker')
@section('submenu')
@include ('dictionaries.include_dictionaries_menu')  
@endsection
@section('title', 'Words List')
@section('url', env('APP_URL').'/show_words/'.$language_id.'/'.$starts_with)


@section('content')
        <h1>Dictionary Words</h1>

        <br><br>
        
            @foreach($w_chars as $char)         
        		<a  href="/show_words/{{$language_id}}/{{$char}}">@if ($char == $starts_with)<b>@endif{{$char}}@if ($char == $starts_with)</b>@endif</a>&nbsp;
            @endforeach
        <br><br>
        
        <table>
			<tr class="tableheader"><td>ID</td><td>Word</td></tr>
            @foreach($words as $word) 
              @if ($loop->index % 2 == 0)
              	<tr class="evenrow">
              @else
              	<tr>
              @endif	
			  <td>{{ $word->id }}</td><td>{{ $word->name }}</td><td><a href="/edit_word/{{$word->id}}">Edit</td><td><a href="/delete_word/{{$word->id}}">Delete</td></tr>
            @endforeach
        </table>
        
        
@endsection