# animo
anime wallpapers download and share your wallpapers built with laravel
# installation
copy this into your terminal/cmd
> you must have php,composer and npm installed
```bat 
git clone https://github.com/Eboubaker/animo animo
cd animo
composer install
php -r "copy('.env.example', '.env');"
php artisan key:generate
php artisan migrate --seed
npm install
npm run dev
php artisan serve
```
> before migrating remember to set up your database  in .env file



open browser to http://127.0.0.1:8000

login: `admin` password: `password`

# images

![search](https://github.com/ZOLDIK0/animo//blob/main/readme_preview/1.png?raw=true)

![homepage](https://github.com/ZOLDIK0/animo//blob/main/readme_preview/2.png?raw=true)

![wallpaper page](https://github.com/ZOLDIK0/animo//blob/main/readme_preview/3.png?raw=true)
