.PHONY: clean test test-unit test-integration \
	coverage install-dependencies update-dependencies xdebug-disable xdebug-enable
.DEFAULT_GOAL := help

PHPUNIT = ./vendor/bin/phpunit -c ./phpunit.xml
PHPUNIT_NO_COVERAGE = ./vendor/bin/phpunit -c ./phpunit.xml --no-coverage
PHPUNIT_INTEGRATION = ./vendor/bin/phpunit -c ./phpunit.integration.xml --no-coverage
PHPCSFIXER_FIX = PHP_CS_FIXER_IGNORE_ENV=1 ./vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.php -v --diff --using-cache=no
PHPCSFIXER_CHECK = ${PHPCSFIXER_FIX} --dry-run
PHPCS = ./vendor/bin/phpcs --standard=phpcs.xml
PHPCBF = ./vendor/bin/phpcbf --standard=phpcs.xml
COVCHECK = ./vendor/bin/coverage-check

clean:
	rm -rf ./build ./vendor

test:
	${PHPUNIT_NO_COVERAGE}

test-unit:
	${PHPUNIT_NO_COVERAGE} --testsuite=Unit

test-integration:
	${PHPUNIT_INTEGRATION} --testsuite=Integration

coverage:
	mkdir -p build/logs/phpunit
	${PHPUNIT} --testsuite=Unit && ${COVCHECK} ./build/logs/phpunit/coverage/coverage.xml 100

install-dependencies:
	composer install

update-dependencies:
	composer update

xdebug-enable:
	@sudo php-ext-enable xdebug

xdebug-disable:
	@sudo php-ext-disable xdebug

help:
	# Usage:
	#   make <target> [OPTION=value]
	#
	# Targets:
	#   clean                   Cleans the coverage and the vendor directory
	#   test	               	Run all tests
	#   test-unit               Run unit tests
	#   test-integration        Run integration tests
	#   coverage                Code Coverage display
	#   install-dependencies    Install dependencies
	#   update-dependencies     Run composer update
	#   xdebug-enable           Enables xdebug
	#   xdebug-disable          Disables xdebug
	#   help                    You're looking at it!
