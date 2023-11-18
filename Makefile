composer-install:
	docker-compose exec -u $(shell id -u):$(shell id -g) php composer install --dev
.PHONY: composer-

composer-require:
	docker-compose exec -u $(shell id -u):$(shell id -g) php composer require ${PACKAGE}

behat:
	docker-compose exec -u $(shell id -u):$(shell id -g) php vendor/bin/behat
.PHONY: behat

start: docker-build docker-up composer-install

stop:
	@docker-compose down --remove-orphans

docker-build:
	@docker-compose build

docker-up:
	@docker-compose up -d

restart: stop start