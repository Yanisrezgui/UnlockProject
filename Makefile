## —— 🐋 Docker ——

build:
	@docker-compose build

run:
	@docker-compose up -d

stop:
	@docker-compose stop

## —— 🐘 PHP / Composer ——

install-slim:
	@docker exec -d unlock-php composer require slim/slim:"4.*"

install-psr:
	@docker exec -d unlock-php composer require slim/psr7


