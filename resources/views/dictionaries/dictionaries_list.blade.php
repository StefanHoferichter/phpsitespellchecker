@extends('phpspellchecker')
@section('submenu')
@include ('dictionaries.include_dictionaries_menu')  
@endsection
@section('title', 'Dictionaries List')
@section('url', env('APP_URL').'/show_dictionaries')


@section('content')
        <h1>Dictionaries</h1>

        <br><br>
        <table>
            @foreach($languages as $language) 
              <tr><td>{{ $language->id }}</td><td><a href="/show_words/{{$language->id}}">{{ $language->long_name }}</td></tr>
            @endforeach
        </table>
        
        
@endsection