@extends('phpspellchecker')
@section('submenu')
@include ('dictionaries.include_dictionaries_menu')
@endsection
@section('title', 'Edit Word')
@section('url', env('APP_URL').'/edit_word')


@section('content')
        <h1>Edit Word</h1>

        <br><br>
		   @include ('dictionaries.include_word', ['action'=>'/save_word' ])    
        
@endsection