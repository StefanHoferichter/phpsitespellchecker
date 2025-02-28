<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\StaticController@welcome');
Route::get('/impressum', 'App\Http\Controllers\StaticController@impressum');

Route::get('/api/get_job_status', 'App\Http\Controllers\SpellController@getJobStatus');

Route::get('/jobs', 'App\Http\Controllers\SpellController@showJobs');
Route::get('/show_page_detail/{id}', 'App\Http\Controllers\SpellController@showPageDetails');
Route::get('/show_job_detail/{id}', 'App\Http\Controllers\SpellController@showJobDetails');
Route::get('/delete_job/{id}', 'App\Http\Controllers\SpellController@deleteSpellcheckJob');
Route::post('/trigger_job', 'App\Http\Controllers\SpellController@triggerJob');

Route::get('/show_projects', 'App\Http\Controllers\ProjectsController@showProjects');
Route::get('/add_project', 'App\Http\Controllers\ProjectsController@addProjectInit');
Route::post('/add_project', 'App\Http\Controllers\ProjectsController@addProject');
Route::get ('/delete_project/{id}', 'App\Http\Controllers\ProjectsController@deleteProject');
Route::get ('/edit_project/{id}', 'App\Http\Controllers\ProjectsController@editProject');
Route::post('/save_project', 'App\Http\Controllers\ProjectsController@saveProject');

Route::get('/show_dictionaries', 'App\Http\Controllers\DictionariesController@showDictionaries');
Route::get('/show_words/{id}', 'App\Http\Controllers\DictionariesController@showWords2');
Route::get('/show_words/{id}/{c}', 'App\Http\Controllers\DictionariesController@showWords');
Route::get('/add_word', 'App\Http\Controllers\DictionariesController@addWordInit');
Route::post('/add_word', 'App\Http\Controllers\DictionariesController@addWord');
Route::get ('/delete_word/{id}', 'App\Http\Controllers\DictionariesController@deleteWord');
Route::get ('/edit_word/{id}', 'App\Http\Controllers\DictionariesController@editWord');
Route::post('/save_word', 'App\Http\Controllers\DictionariesController@saveWord');
Route::get('/compile_dictionary', 'App\Http\Controllers\DictionariesController@exportCustomDict');
Route::get('/add_word_to_dict/{id}/{page_id}', 'App\Http\Controllers\DictionariesController@addWordToDict');
Route::get('/add_word_to_ignored/{id}/{page_id}', 'App\Http\Controllers\DictionariesController@addWordToIgnored');
