@extends('phpsitespellchecker')
@section('submenu')
@include ('dictionaries.include_dictionaries_menu')     
@endsection
@section('title', 'Add Word')
@section('url', env('APP_URL').'/add_word')


@section('content')
        <h1>Add Word</h1>

        <br><br>
		   @include ('dictionaries.include_word', ['action'=>'/add_word' ])   
        
@endsection