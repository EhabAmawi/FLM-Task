setup:
	@make build
	@make up
	@make composer-install
build:
	docker-compose build --no-cache --force-rm
up:
	docker-compose up -d
composer-install:
	docker exec flk-backend bash -c "composer install"