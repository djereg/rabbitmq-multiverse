#!/bin/bash
docker compose up master nestjs laravel symfony --scale laravel=3 --scale nestjs=3 --scale symfony=3
