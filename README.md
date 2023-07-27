- Copy file **.env.example** menjadi **.env**
- Atur database
   
        DB_HOST=127.0.0.1
        DB_PORT=5432
        DB_DATABASE=database_name
        DB_USERNAME=database_user
        DB_PASSWORD=database_password

- Jalankan `composer install`
- Jalankan `php artisan jwt:secret`
- Jalankan `php artisan migrate` atau `php artisan migrate:fresh`
- Jalankan `php artisan db:seed`
- Jalankan `php artisan serve`
