All "make" commands require Docker to be installed and running.

### Setup
To install, run: 

`$ make install`

Alternatively, you can run: 

`$ composer install`

### Movies recommender command
To run the recommender, execute:

`$ make run-recommender`

or

`$ php bin/console app:movie:recommender`

### Tests
To run tests, execute:

`$ make test`

or

`$ php ./vendor/bin/phpunit`
