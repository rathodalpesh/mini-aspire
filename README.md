> ### mini-aspire with Laravel.

----------

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/8.x/installation)


Clone the repository

    git clone https://github.com/rathodalpesh/mini-aspire.git

Switch to the repo folder

    cd mini-aspire

Install all the dependencies using composer

    composer install

edit the env file and make the required configuration changes for database setting

    cp .env.example .env # and enter database details

Generate a new application key

    php artisan key:generate

Generate a passport secret key

    php artisan passport:install

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

    
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve

## Database seeding

**Populate the database with seed data with relationships which includes companies, stations. This can help you to quickly start testing the api or couple a frontend and start using it with ready content.**

Run the database seeder and you're done

    php artisan db:seed

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh

# Code overview

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

----------

# Testing API

Run the laravel development server

    php artisan serve

The api can now be accessed at

    POST = http://127.0.0.1:8000/api/register
    POST = http://127.0.0.1:8000/api/login
    
    USER 
    GET = http://127.0.0.1:8000/api/loan 
    POST = http://127.0.0.1:8000/api/loan
    GET = http://127.0.0.1:8000/api/loan/{loan}
    POST = http://127.0.0.1:8000/api/next-loan-payments
    POST = http://127.0.0.1:8000/api/pay-loan-payments
    
    ADMIN
    GET = http://127.0.0.1:8000/api/admin-loan
    POST = http://127.0.0.1:8000/admin-loan/approval-loan
    DELETE = http://127.0.0.1:8000/api/admin-loan/delete/{id}
    
Request headers

| **Required** 	| **Key**              	| **Value**            	|
|----------	|------------------	|------------------	|
| Yes      	| Content-Type     	| application/json 	|

