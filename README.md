# Netzme API

Ini adalah project test simple aplikasi api.

1. Set configuration Environment
create file ```.env```
copy ```.env.example``` to ```.env``` or use bash.
```bash
cp .env.example .env
```

2. Lakukan setting database pada ```.env``` Note: database menggunakan PostgreSQL.

3. Run bash script dalam project
```bash
composer install
php artisan key:generate
```

4. Migrate database
```bash
php artisan migrate
```

5. Passport Install
```bash
php artisan passport:install --uuids
> type yes [enter]
```
Setelah sukses copy value ```client_id``` dan ```client_secret``` di bagian Password grant client ke Environment Postman
untuk test API

6. Run User Seeder untuk login
```bash
php artisan db:seed
```

Run application
```php artisan serve```
