# Laravel Vue.js auth with Cookies

A simple cookie-based solution for API authentication with Laravel 6 Passport and Vue.js that allows you to refresh and keep logged in.

User auth data goes to localStorage.

## Installation

1. composer install
2. npm install
3. php artisan key:generate
4. set your config/database.php credentials
5. php artisan migrate
6. php artisan passport:install

## Run

1. php artisan serve
2. npm run dev
3. launch http://127.0.0.1:8000
