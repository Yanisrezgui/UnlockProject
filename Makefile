## —— 🐋 Docker ——

build:
	@docker-compose build

run:
	@docker-compose up -d

stop:
	@docker-compose stop

## —— 🐘 PHP / Composer ——

container-php:
	@docker exec -it unlock-php bash

container-mariadb:
	@docker exec -it unlock-mariadb bash


