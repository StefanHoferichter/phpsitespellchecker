echo "changing working directory"
cd /var/www/html/phpsitespellchecker

echo "copying .env file"
cp .docker/.env .

echo "set permissions"

chown -R www-data:www-data dict storage
chmod -R 777 storage
chmod -R 777 dict
rm -f storage/logs/*.log

echo "migrate DB"
php artisan migrate --seed

echo "start supervisor"
service supervisor stop
sleep 5
service supervisor start

