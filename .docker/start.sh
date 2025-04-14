cp -a /tmp/vendor /var/www/html/phpsitespellchecker
composer require tigitz/php-spellchecker
service supervisor start
apache2-foreground

