help:
	@echo "/--- Flashcard -------------------------------------------------------/";
	@echo "env  		Create .env file"
	@echo "migrate  	Run the migrations"
	@echo "seed       	Run the seeders"
	@echo "up	        Create and start containers"
	@echo "destroy		Stop and remove containers"
	@echo "run      	Start application"
	@echo "test     	Run all the application tests"
	@echo "/-----------------------------------------------------------------/";

env:
	cp .env.example .env

migrate:
	./vendor/bin/sail artisan migrate

seed:
	./vendor/bin/sail artisan db:seed

up:
	./vendor/bin/sail up

destroy:
	./vendor/bin/sail down

run:
	./vendor/bin/sail artisan flashcard:interactive

test:
	./vendor/bin/sail artisan test
