# Unlock

## Requirements

#### Linux / MacOS

* Docker
* docker-compose

#### Windows

* WSL 2
* Docker
* docker-compose

## Start Project

#### Building, running, and stopping Docker containers

Build containers :
```
make build
```
Start containers :
```
make run
```
Stop containers :
```
make stop
```
#### Install Composer dependencies
🐘 Connect to PHP Container
```
make container-php:
```
Install Slim :
```
composer update
```
```
composer require slim/slim:"4.*"
```
```
composer require slim/psr7
```
#### Database

To Do (create DB - reset DB)

## Link
http://localhost:8080/
