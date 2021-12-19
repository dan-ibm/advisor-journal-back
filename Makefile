env = ./.env.example

ifneq ("$(wildcard ./.env)","")
    env = ./.env
endif

docker = docker-compose -f ./docker/docker-compose.yml -f ./docker/docker-compose.override.yml --env-file ${env}

include ${env}
export

# Запустить установку проекта
.PHONY: install
install:
	echo ${env}
	cp docker/example.docker-compose.override.yml docker/docker-compose.override.yml
	cp .env.example .env
	make run
	${docker} exec php-fpm sh -c "composer update"
	${docker} exec php-fpm sh -c "php artisan key:generate"
	${docker} exec php-fpm sh -c "php artisan storage:link"
	${docker} exec php-fpm sh -c "php artisan migrate:fresh --seed"


# Запустить Docker демона
.PHONY: run
run:
	${docker} up -d
	${docker} exec php-fpm sh -c "php artisan migrate --seed"

# Остановить работу Docker'а
.PHONY: stop
stop:
	${docker} stop

# Зайти в bash php-fpm
.PHONY: php
php:
	${docker} exec php-fpm bash -l

# Зайти в bash php-fpm под root пользователем
.PHONY: php-root
php-root:
	${docker} exec -u root php-fpm bash -l

# Зайти в sh mariadb
.PHONY: mariadb
mariadb:
	${docker} exec mariadb sh -l

# Зайти в sh postgres
.PHONY: postgres
postgres:
	${docker} exec postgres sh -l

# Зайти в sh redis
.PHONY: redis
redis:
	${docker} exec redis sh -l

# Зайти в sh nginx
.PHONY: nginx
nginx:
	${docker} exec nginx sh -l

# Зайти в sh mongo
.PHONY: mongo
mongo:
	${docker} exec mongo sh -l

# Зайти в sh adminer
.PHONY: adminer
adminer:
	${docker} exec adminer sh -l

# Зайти в bash mongo-express
.PHONY: mongo-express
mongo-express:
	${docker} exec mongo-express bash -l

# Зайти в bash elasticsearch
.PHONY: elasticsearch
elasticsearch:
	${docker} exec elasticsearch bash -l

.PHONY: tests
tests:
	${docker} exec php-fpm php artisan test
