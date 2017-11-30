laravel kit
===========

## prepare vars

    cp .env.example .env

## prepare environment

    composer install

    artisan migrate
    artisan key:generate
    artisan passport:keys
    artisan passport:client --personal

