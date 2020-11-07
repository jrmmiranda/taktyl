## Quick Start
- # Install Dependencies
composer install

- # Creating a .env file
Create a .env file using the content of .env.example

- # Create database
Create a database with the name "taktyl", username "root", and no password

- # Run Migrations
php artisan migrate

- # If you get an error about an encryption key
php artisan key:generate

- # Run application
php artisan serve


## API Endpoints
List all Scores
- GET api/scores

Store score
- POST api/scores/store

## Laravel Version
- Laravel 8.10.0


## PHP Version
- PHP 7.4.10 (cli)
