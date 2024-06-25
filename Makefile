.PHONY: install run-recommender test
install:
		docker compose run -it --rm composer install

run-recommender:
		docker compose run -it --rm php bin/console app:movie:recommender

test:
		docker compose run -it --rm php ./vendor/bin/phpunit