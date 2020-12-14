IMAGE_NAME = mgonalons-musement-test-image
CONTAINER_NAME = mgonalons-musement-test-container

build:
	docker build -t $(IMAGE_NAME) .
	docker run --name $(CONTAINER_NAME) $(IMAGE_NAME) composer install

cleanup-tmp-container:
	@-docker rmi -f $(IMAGE_NAME)-tmp 1> /dev/null
	@-docker container rm $(CONTAINER_NAME)-tmp 1> /dev/null

create-tmp-container:
	@docker commit $(CONTAINER_NAME) $(IMAGE_NAME)-tmp 1> /dev/null

phpstan: cleanup-tmp-container create-tmp-container _phpstan cleanup-tmp-container
_phpstan:
	@-docker run --name $(CONTAINER_NAME)-tmp --entrypoint=/bin/bash $(IMAGE_NAME)-tmp -c "vendor/bin/phpstan --level=8 analyse src/"

run: cleanup-tmp-container create-tmp-container _run cleanup-tmp-container
_run:
	-docker run --name $(CONTAINER_NAME)-tmp --entrypoint=/bin/bash $(IMAGE_NAME)-tmp -c "php bin/console 'app:get-forecasts'"

sniff: cleanup-tmp-container create-tmp-container _sniff cleanup-tmp-container
_sniff:
	@-docker run --name $(CONTAINER_NAME)-tmp --entrypoint=/bin/bash $(IMAGE_NAME)-tmp -c "vendor/bin/phpcs --standard=PSR12 src/"

sniff-fix: cleanup-tmp-container create-tmp-container _sniff-fix cleanup-tmp-container
_sniff-fix:
	@-docker run --name $(CONTAINER_NAME)-tmp --entrypoint=/bin/bash $(IMAGE_NAME)-tmp -c "vendor/bin/phpcbf --standard=PSR12 src/"

tests: cleanup-tmp-container create-tmp-container _tests cleanup-tmp-container
_tests:
	@-docker run --name $(CONTAINER_NAME)-tmp --entrypoint=/bin/bash $(IMAGE_NAME)-tmp -c "vendor/bin/phpunit"

tests-coverage: cleanup-tmp-container create-tmp-container _tests-coverage cleanup-tmp-container
_tests-coverage:
	@-docker run --name $(CONTAINER_NAME)-tmp --entrypoint=/bin/bash $(IMAGE_NAME)-tmp -c "php -d xdebug.mode=coverage vendor/bin/phpunit --coverage-html coverage --whitelist src"
	docker cp $(CONTAINER_NAME)-tmp:/app/coverage ./coverage