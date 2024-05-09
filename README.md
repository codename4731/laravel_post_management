# Laravel Post Management System

A web application built with Laravel for managing posts, featuring user authentication, CRUD operations, and role-based access control.

## Installation

1. Clone the repository:
    git clone https://github.com/codename4731/laravel_post_management.git

2. Navigate into the project directory:
    cd laravel_post_management

3. Install Composer dependencies:
    composer install

4. Create a copy of the `.env.example` file and rename it to `.env`:
    cp .env.example .env
    
5. Generate an application key:
    php artisan key:generate

6. Set up your database in the `.env` file:
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=
    
7. Run database migrations:
    php artisan migrate

8. Run database seeder
    php artisan db:seed
    
9. Serve the application:
    php artisan serve
    
Visit `http://localhost:8000` in your web browser to access the application.

## Configuration

- Set up file storage symlink for images:
    php artisan storage:link