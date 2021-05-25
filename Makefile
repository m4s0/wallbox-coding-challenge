.DEFAULT_GOAL:=help

.PHONY: install
install:
	cd docker && docker-compose run --rm php sh -c 'composer install --no-interaction --no-suggest --ansi'
