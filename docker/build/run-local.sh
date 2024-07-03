#!/usr/bin/env bash

export SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )

docker network create --attachable test_local
docker volume create local_test_database

composer install --ignore-platform-reqs --no-scripts

docker-compose -p textmagic_test -f ../docker/docker-compose.yml up -d

php bin/console doctrine:database:drop --if-exists --force
php bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load -n
