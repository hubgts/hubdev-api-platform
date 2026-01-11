### Docker
DC=docker compose
PHP=$(DC) exec php

### Symfony
CONSOLE=bin/console

.PHONY: help db-create db-drop db-migrate db-make-migration db-reset

help:
	@echo ""
	@echo "Available commands:"
	@echo "  make db-create           Create database"
	@echo "  make db-drop             Drop database"
	@echo "  make db-migrate          Run migrations"
	@echo "  make db-make-migration   Generate a new migration"
	@echo "  make db-reset            Drop, create and migrate database"
	@echo ""

### Database
db-create:
	$(PHP) $(CONSOLE) doctrine:database:create --if-not-exists

db-drop:
	$(PHP) $(CONSOLE) doctrine:database:drop --if-exists --force

db-migrate:
	$(PHP) $(CONSOLE) doctrine:migrations:migrate --no-interaction

db-make-migration:
	$(PHP) $(CONSOLE) make:migration

### Reset database
db-reset:
	$(MAKE) db-drop
	$(MAKE) db-create
	$(MAKE) db-migrate
