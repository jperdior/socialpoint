composer-install:
	docker-compose exec -u $(shell id -u):$(shell id -g) php composer install --dev
.PHONY: composer-

composer-require:
	docker-compose exec -u $(shell id -u):$(shell id -g) php composer require ${PACKAGE}

composer-remove:
	docker-compose exec -u $(shell id -u):$(shell id -g) php composer remove ${PACKAGE}

behat:
	docker-compose exec -u $(shell id -u):$(shell id -g) php vendor/bin/behat
.PHONY: behat

behat-feature:
	docker-compose exec -u $(shell id -u):$(shell id -g) php vendor/bin/behat /tests/Functional/Features/${FEATURE}.feature
.PHONY: behat-feature

start: docker-build docker-up composer-install

stop:
	@docker-compose down --remove-orphans

docker-build:
	@docker-compose build

docker-up:
	@docker-compose up -d

restart: stop start

fix-dry:
	@docker-compose exec -u $(shell id -u):$(shell id -g) php php vendor/bin/php-cs-fixer fix src --dry-run --diff

fix:
	@docker-compose exec -u $(shell id -u):$(shell id -g) php php vendor/bin/php-cs-fixer fix src