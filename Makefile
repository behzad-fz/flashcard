help:
	@echo "/--- Flashcard -------------------------------------------------------/";
	@echo "build		Build the containers"
	@echo "env  		Create .env file"
	@echo "migrate  	Run the migrations"
	@echo "up	        Create and start containers"
	@echo "destroy		Stop and remove containers"
	@echo "run      	Start application"
	@echo "test     	Run all the application tests"
	@echo "/-----------------------------------------------------------------/";

build:
	docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v $(pwd):/var/www/html \
        -w /var/www/html \
        laravelsail/php81-composer:latest \
        composer install --ignore-platform-reqs

env:
	cp .env.example .env

migrate:
	./vendor/bin/sail artisan migrate

up:
	./vendor/bin/sail up

destroy:
	./vendor/bin/sail down

run:
	./vendor/bin/sail artisan flashcard:interactive

test:
	./vendor/bin/sail artisan test
