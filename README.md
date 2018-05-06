# How Old Am I On Mars
API service for calculating an age in Mars days and years based on date of birth on Earth.

## Installation
### Configuration Files
Create configuration files for Docker and Laravel.
```bash
$ cp .env.example .env
$ cp docker-compose.yml.example docker-compose.yml
```
Make changes according to your environment.
### Install Dependencies
```bash
$ composer install
```
### Run Docker
```bash
$ docker-compose up
```
### Application Key
```bash
$ docker-compose exec app php artisan key:generate
```

## Run
Make API call:
* `http://0.0.0.0:8080/mymarsage/date-of-birth` - to get your age on Mars, where `date-of-birth` is a date in YYYYMMDD format
* `http://0.0.0.0:8080/amIAllowedToDrinkAlcoholOnMars/date-of-birth` - to get to know if you are allowed to drink alcohol on Mars, where `date-of-birth` is a date in YYYYMMDD format

## Good to know
### General Artisan
```bash
$ docker-compose exec app php artisan some:command
```
### Unit Tests
```bash
$ docker-compose exec app php vendor/bin/phpunit
```