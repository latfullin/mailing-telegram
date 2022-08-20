#!/bin/sh

export DOCKER_USER="$(id -un)"
export DOCKER_UID="$(id -u)"
export DOCKER_GROUP="$(id -gn)"
export DOCKER_GID="$(id -g)"

docker compose pull
docker compose up --build -d --remove-orphans
docker ps -f "name=telegram-bot-*"