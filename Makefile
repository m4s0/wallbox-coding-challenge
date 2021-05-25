.DEFAULT_GOAL:=help

.PHONY: install
install:
	cd docker && docker-compose run --rm php sh -c 'composer install --no-interaction --no-suggest --ansi'

.PHONY: test
test:
	cd docker && docker-compose run --rm php sh -c 'vendor/bin/phpunit --testdox --exclude-group=none --colors=always'

.PHONY: cs
cs:
	cd docker && docker-compose run --rm php sh -c 'vendor/bin/php-cs-fixer fix --no-interaction --diff --verbose'

.PHONY: stan
stan:
	cd docker && docker-compose run --rm php sh -c 'vendor/bin/phpstan analyse --memory-limit=-1'
