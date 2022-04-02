composer install ;

composer update ;
php artisan migrate ;
php artisan make:migration fpay

# Vamos rodar!
php -S localhost:8000 -t public