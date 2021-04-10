# Netzme API

Ini adalah project test simple aplikasi api (Backend).

## Prerequisites
- PHP >= 7.2.5
- Composer
- PostgreSQL Database

## Fitur
- Implementing JWT Auth token
- Handle CORS
- Stateless
- Pagination Data

## Build Setup
1. Create Database and Set configuration Environment
create file ```.env``` in root project.
Copy inside ```.env.example``` to ```.env``` or use bash.
```bash
$ cp .env.example .env
```

2. Lakukan setting database pada ```.env``` Note: database menggunakan PostgreSQL.

3. Run bash script dalam project
```bash
$ composer install
$ php artisan key:generate
```

4. Migrate database
```bash
$ php artisan migrate
```

5. Passport Install
```bash
$ php artisan passport:install --uuids
> type yes [enter]
```
Setelah sukses copy value ```client_id``` dan ```client_secret``` di bagian Password grant client ke Environment Postman
untuk test API

6. Run Storage link to linked store file
```bash
$ php artisan storage:link
```

7. Run User Seeder untuk login dan data customer
```bash
$ php artisan db:seed
```

Run application
```bash
$ php artisan serve
```
