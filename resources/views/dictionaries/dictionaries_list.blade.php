@extends('phpsitespellchecker')
@section('submenu')
@include ('dictionaries.include_dictionaries_menu')  
@endsection
@section('title', 'Dictionaries List')
@section('url', env('APP_URL').'/show_dictionaries')


@section('content')
        <h1>Dictionaries</h1>

        <br><br>
        <table>
            <tr class="tableheader"><td>ID</td><td>Language</td></tr>
            @foreach($languages as $language) 
              @if ($loop->index % 2 == 0)
              	<tr class="evenrow">
              @else
              	<tr>
              @endif	
				<td>{{ $language->id }}</td><td><a href="/show_words/{{$language->id}}">{{ $language->long_name }}</td></tr>
            @endforeach
        </table>
        
        
@endsection