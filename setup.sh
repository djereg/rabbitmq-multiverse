#!/bin/bash
echo "Building Docker images..."
docker compose build
echo "Installing Laravel dependencies..."
docker compose run --rm laravel composer install
echo "Installing Symfony dependencies..."
docker compose run --rm symfony composer install
echo "Installing NestJS dependencies..."
docker compose run --rm nestjs npm ci
echo "Installing Master dependencies..."
docker compose run --rm master npm ci
echo "Starting RabbitMQ..."
docker compose up -d rabbitmq
echo "Waiting for RabbitMQ to start..."
sleep 10
echo "RabbitMQ started!"
