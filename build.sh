composer install ;

composer update ;

echo "DB_DATABASE:" ;
read db_database ;

echo "DB_USERNAME:" ;
read db_username ;

echo "DB_PASSWORD: " ;
read db_password ;

arg_database="DB_DATABASE="$db_database ;
arg_username="DB_USERNAME="$db_username ;
arg_password="DB_PASSWORD="$db_password ;

echo $arg_database >> ./.env.example ;
echo $arg_username >> ./.env.example ;
echo $arg_password >> ./.env.example ;

cp ./.env.example ./.env ;

php artisan migrate ;

php artisan make:migration fpay ;

# Vamos rodar!
php -S localhost:8000 -t public
