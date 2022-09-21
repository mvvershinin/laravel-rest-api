## About

Simple REST API based on Laravel v9.


## Install
copy <b>.env.example</b> to <b>.env</b> and set your variables

    composer install

    php artisan key:generate

    php artisan storage:link


### Running unit tests

For local testing need make local test <u>PostgreSQL</u> database, it's not works with sqlite in memory. After it, create <b>.env.testing</b> file with 

    php artisan test
or

    vendor/bin/phpunit --testdox
