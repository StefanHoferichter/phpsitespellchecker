cd /var/www/html/phpsitespellchecker
cp -a /tmp/vendor /var/www/html/phpsitespellchecker
cp /tmp/completeinstall.sh /var/www/html/phpsitespellchecker
composer require tigitz/php-spellchecker
service supervisor start
apache2-foreground

