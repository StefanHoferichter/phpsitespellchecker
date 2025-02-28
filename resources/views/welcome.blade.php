@extends('phpsitespellchecker')
@section('submenu')
@include ('include_dummy_menu')     
@endsection
@section('title', 'Welcome')
@section('url', env('APP_URL').'/')


@section('content')
        <h1>Welcome to PHPSiteSpellChecker</h1>

With this tool you can scan complete web sites (projects) and check it for typos and misspellings. You will receive a detailed report of all found misspellings. You can create your own custom dictionaries to maintain domain specific words.        
<br>
Start with creating a project. Give it a name and provide the URL of the sitemap. It will tell PHPSiteSpellChecker which URLs to scan. You can also set an optional limit of a maximum number of pages to be checked and a delay between scanning of pages.
<br>
Once you have created a project you can trigger a spellcheck run from the jobs page. Select the project you want to scan and click the "Start" button. The run will go through several states:
<ul>
<li>Q - Queued</li>
<li>S - Started</li>
<li>E - End</li>
<li>F - Failed</li>
</ul>
Once a scan has reached status E and completion level of 100% you can dig into the found misspellings by clicking on the project name. You will see then all scanned pages and a preview of the found misspellings. When you click on the individual page URL you will see all misspellings. 
You can either fix the typo in your webproject or you can add a word to your custom dictionary. After adding a word to a dictionary you need to compile the dictionary, so that the PHPSiteSpellChecker can consider your custom word entry.
@endsection