### Docker
DC=docker compose
PHP=$(DC) exec -T php

### Symfony
CONSOLE=bin/console

.PHONY: help \
	db-create db-drop db-migrate db-make-migration \
	db-reset db-reset-full db-fixtures

help:
	@echo ""
	@echo "Available commands:"
	@echo "  make db-create            Create database"
	@echo "  make db-drop              Drop database"
	@echo "  make db-migrate           Run migrations"
	@echo "  make db-make-migration    Generate a new migration"
	@echo "  make db-reset             Drop, create and migrate database"
	@echo "  make db-reset-full        Drop, create, migrate and load fixtures"
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

### Fixtures
db-fixtures:
	$(PHP) $(CONSOLE) doctrine:fixtures:load --no-interaction

### Reset database
db-reset:
	$(MAKE) db-drop
	$(MAKE) db-create
	$(MAKE) db-migrate

### Reset database + fixtures
db-reset-full:
	$(MAKE) db-reset
	$(MAKE) db-fixtures
