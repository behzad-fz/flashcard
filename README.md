# Flashcard

- [Services](#services) What Dev offers
- [Requirements](#requirements) What are the requirements to use this dockerized playground
- [Installation](#installation) How to create and start
- [Usage](#usage) instructions to use application
- [Run Tests](#run-tests) How to run tests (PHPUnit)
- [Shortcuts](#shortcuts) Use shortcut commands (Makefile)
- [Assumptions](#Assumptions) Assumptions

### Services
- PHP 8.1
- Mysql 8
- Redis

### Requirements
- Docker
- Docker Compose
- Make

### Installation
```
~$ git clone https://github.com/behzad-fz/flashcard.git

~$ cd flashcard

~$ cp .env.example .env

~$ docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs

~$ ./vendor/bin/sail up

~$ ./vendor/bin/sail artisan migrate
```

### Usage
You can start the application by running the following commands:
```
~$ ./vendor/bin/sail artisan flashcard:interactive
```

### Run Tests
You can run tests by entering the following command:
```
~$ ./vendor/bin/sail artisan test
OR
~$ ./vendor/bin/phpunit

Notice: I put ->expectsQuestion('What do you want to do?', 'Exit')->assertExitCode(0);
        at the end of every test because the flashcard application is an ongoing process until user
        terminates it, so if i don't close the app in every test it will be in an infinite loop and 
        tests would fail even though they are asserting as expected.
```
### Shortcuts
You can also use 'make' command as a shortcut.

Run command below to see list of available make commands
```
~$ make

/--- Flashcard -------------------------------------------------------/
build           Build the containers
env             Create .env file
up              Create and start containers
destroy         Stop and remove containers
run             Start application
test            Run all the application tests
/-----------------------------------------------------------------/

EX:
    ~$ make test
        is equal to 
    ~$ ./vendor/bin/sail artisan test
```



### Assumptions
These are the things it wasn't clear, so I had to assume
```
1 - In the assignment PDF it says "store the answer in the DB and print correct/incorrect."
    I assume by this you mean store the status, not the answer user gives since i don't see 
    any option to check the history of user's answers.

 
2 - Taking multi-users mode into consideration, it there should be a n to n relation between user
    and flashcard. I even added the table but since you explicitly mentioned in the assignment PDF
     that "When we say “users”, we don’t actually mean that you should have a user model", So i avoid
     using a user model and a relation between them and kept it simple in the flashcards table.


3- It would be perfect to have a delete option, in case user creates a flashcard and they want to get 
    rid of it.(Even a update option). I only avoid it because it wasn't mentioned in the assignment PDF.
```


