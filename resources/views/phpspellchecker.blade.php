<!DOCTYPE html>
<html lang="de">
  <head>
    <title>PHPSpellChecker - @yield('title')</title>
    <link rel="canonical" href="@yield('url')" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <META NAME="Content-Language" CONTENT="de">
    <meta name="referrer" content=“no-referrer-when-downgrade“>
    <META NAME="ROBOTS" CONTENT="index, follow">
    <meta name="Description" content="@yield('description')">
    <meta name="KeyWords" content="PHPSpellchecker, Spellcheck, typo, PHP, Laravel, aspell">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">	
	<meta property="og:title" content="@yield('title')">
    <meta property="og:description" content="@yield('description')">
    <meta property="og:url" content="@yield('url')">
    <meta property="og:image" content="@yield('image')">
    <meta property="og:type" content="article">
    <meta name="thumbnail" content="@yield('image')" />
    <meta name="google-adsense-account" content="ca-pub-5066242446416572">
    <link rel="stylesheet" href="/phpspellchecker.css">
	<link rel="apple-touch-icon" sizes="180x180" href="/images/logo/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/logo/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/logo/favicon-16x16.png">
    <link rel="manifest" href="/images/logo/site.webmanifest">  	
  </head>
  <body>
        <nav>
              <div class="nav_logo"><a  href="/"><img width="300px" src="/images/logo/PhpSpellChecker_v3.png"></a></div>
              <div class="nav_jobs"><a  class="nav_item"  href="/jobs">Jobs</a></div>
              <div class="nav_projects"><a  class="nav_item"  href="/show_projects">Projects</a></div>
              <div class="nav_dict"><a  class="nav_item"  href="/show_dictionaries">Dictionaries</a></div>
              <div class="nav_dummy">&nbsp;</div>
              @yield('submenu')
        </nav>
        
	 	<article>
	    	<div class="home">
            	@yield('content')
	    	</div>
      	</article>
      	
      	<footer>
	        <div class="footer_menu">
              <div class="footer_impressum"><a class="nav_item" href="/impressum">Impressum</a></div>
              <div class="footer_threads"><a class="nav_item" target="_blank" href="https://www.threads.net/@stefanhoferichter"><img src="/images/icon/threads-logo.png" width="20" alt="Threads"></a></div>
 			</div>
  		</footer>
      	
  </body>
</html>