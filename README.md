# SimpNot
A simple HTTP notification system

## Contributors
* [Okiemute Omuta](https://github.com/kheme)

## Project Requirements 
* MySQL database
* Apache web server
* PHP 7.2.5 or higher

## Local Setup
The SimpNot project can be setup locally by following the steps below:

### Database Setup 
* Create a new MySQL database
* Create a new MySQL database user specifically for the new database 
* Grant the new MySQL database user full privileges to the new database 

### Project Initialization & Configuration 
* In your project root folder, launch a new terminal window and run the follwoing commands: 
* `git clone https://github.com/kheme/simpnot.git`
* `cd simpnot`
* `cp .env.example .env`
* `php artisan key:generate`
* `composer install`
* `php artisan migrate`
* Finally, run the development server for the Publisher using `php -S localhost:8000 -t ./public`
* You may also run another development server for the Subscriber using the `php -S localhost:9000 -t ./public`