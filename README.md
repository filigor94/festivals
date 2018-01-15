# festivals

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.
The project is made in Laravel 5.5. You need to have PHP >= 7.0.
### Deployment

Clone the repository
```
git clone https://github.com/filigor94/festivals.git
```

Do composer update
```
composer update
```

Create symbolic link between storage/app/public and public/storage.
```
php artisan storage:link
```

Rename the '.env.example' file to '.env'

Set the credentials in your new '.env' file

```
DB_DATABASE=your_database_name
DB_USERNAME=your_user_name
DB_PASSWORD=your_password
```

Generate your key

```
php artisan key:generate
```

Run migrations to create the tables

```
php artisan migrate
```

Seed your database with initial data

```
php artisan db:seed
```

You are ready to start the local server

```
php artisan serve
```

## Accessing the web page

By default you can access it at 

```
127.0.0.1:8000
```

### Backend

You can access it at

```
127.0.0.1:8000/login
E-mail Address: admin@admin.com
Password: admin
```

#### Additional

The initial images might not appear. In this case just copy 2 images with names 1.jpg and 2.jpg to

```
project-root-directory/storage/app/public/festivals/1.jpg
project-root-directory/storage/app/public/festivals/2.jpg
```