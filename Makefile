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

migrate:
	docker exec flk-backend bash -c "php artisan migrate"
test:
	docker exec flk-backend bash -c "php artisan test"
