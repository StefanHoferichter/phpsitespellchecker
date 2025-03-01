# PHPSiteSpellChecker
 
With this tool you can scan complete web sites (projects) and check it for typos and misspellings. You will receive a detailed report of all found misspellings. You can create your own custom dictionaries to maintain domain specific words.
Start with creating a project. Give it a name and provide the URL of the sitemap. It will tell PHPSiteSpellChecker which URLs to scan. You can also set an optional limit of a maximum number of pages to be checked and a delay between scanning of pages.
Once you have created a project you can trigger a spellcheck run from the jobs page. Select the project you want to scan and click the "Start" button. The run will go through several states:

    Q - Queued
    S - Started
    E - End
    F - Failed

Once a scan has reached status E and completion level of 100% you can dig into the found misspellings by clicking on the project name. You will see then all scanned pages and a preview of the found misspellings. When you click on the individual page URL you will see all misspellings. You can either fix the typo in your webproject or you can add a word to your custom dictionary. After adding a word to a dictionary you need to compile the dictionary, so that the PHPSiteSpellChecker can consider your custom word entry. 

## prerequisites

PHPSiteSpellChecker is a Laravel app. It requires PHP, Apache (or another web server) and MariaDB.  
It uses a package from Philippe SEGATORI (tigitz) php-spellchecker: https://github.com/tigitz/php-spellchecker
It requires aspell. There is currently no active Windows port for aspell, so it limits PHPSiteSpellChecker to Linux. I have test it so far only under Debian, but other Linux distributions can be tested as well on demand.
It uses Laravel queues and workers. Supervisor is recommended to keep the worker process running.
