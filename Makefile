#Linters

lint-all:
	$(MAKE) lint-services
	$(MAKE) lint-twig
	$(MAKE) lint-yaml
	$(MAKE) lint-bdd

lint-services:
	php bin/console lint:container

lint-twig:
	php bin/console lint:twig ./templates

lint-yaml:
	php bin/console lint:yaml ./config

lint-bdd:
	php bin/console doctrine:schema:validate

#CS-FIXER

cs-fixer:
	PHP_CS_FIXER_IGNORE_ENV=1 vendor/bin/php-cs-fixer fix src --diff

cs-fixer-dry:
	PHP_CS_FIXER_IGNORE_ENV=1 vendor/bin/php-cs-fixer fix src --diff --dry-run

#PHPStan

stan:
	"vendor/phpstan/phpstan/phpstan" analyse -c phpstan.dist.neon --memory-limit=1G