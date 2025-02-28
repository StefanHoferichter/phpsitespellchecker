@extends('phpspellchecker')
@section('submenu')
@include ('dictionaries.include_dictionaries_menu')     
@endsection
@section('title', 'Compile Dictionary')
@section('url', env('APP_URL').'/compile_dictionary')


@section('content')
        <h1>Compile Dictionary</h1>

        
              {{ $errors }}
              
              {{ $output }}
        
        
@endsection