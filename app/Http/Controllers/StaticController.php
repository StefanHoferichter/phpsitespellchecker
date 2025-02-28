<?php

namespace App\Http\Controllers;

use App\Jobs\SpellcheckBackgroundJob;
use App\Models\IgnoredWord;
use App\Models\Language;
use App\Models\Misspelling;
use App\Models\Page;
use App\Models\Project;
use App\Models\SpellcheckJob;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;

 
class StaticController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }
    public function impressum()
    {
        return view('impressum');
    }
}
