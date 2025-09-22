SHELL := /bin/bash

.PHONY: init
init: ## Copies env file if it does not exist
	@test -f .env || cp .env.example .env
	@echo ".env file checked/created"

.PHONY: setup
setup: init up

.PHONY: up
up: ## Force recreate and start of local containers
	docker compose down --remove-orphans -v
	docker compose pull
	docker compose up -d --force-recreate
