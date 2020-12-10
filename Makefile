IMAGE_NAME = mgonalons-musement-test-image
CONTAINER_NAME = mgonalons-musement-test-container

build:
	docker build -t $(IMAGE_NAME) .
	docker create --name $(CONTAINER_NAME) $(IMAGE_NAME)
	composer install

cleanup-tmp-container:
	@-docker rmi -f $(IMAGE_NAME)-tmp 1> /dev/null
	@-docker container rm $(CONTAINER_NAME)-tmp 1> /dev/null

create-tmp-container:
	@docker commit $(CONTAINER_NAME) $(IMAGE_NAME)-tmp 1> /dev/null

phpstan: create-tmp-container _phpstan cleanup-tmp-container
_phpstan:
	@-docker run --mount type=bind,source="$(shell pwd)",target=/app --name $(CONTAINER_NAME)-tmp --entrypoint=/bin/bash $(IMAGE_NAME)-tmp -c "vendor/bin/phpstan --level=8 analyse src/"

run: create-tmp-container _run cleanup-tmp-container
_run:
	docker run --mount type=bind,source="$(shell pwd)",target=/app --name $(CONTAINER_NAME)-tmp --entrypoint=/bin/bash $(IMAGE_NAME)-tmp -c "php bin/console 'app:get-forecasts'"

sniff: create-tmp-container _sniff cleanup-tmp-container
_sniff:
	@-docker run --mount type=bind,source="$(shell pwd)",target=/app --name $(CONTAINER_NAME)-tmp --entrypoint=/bin/bash $(IMAGE_NAME)-tmp -c "vendor/bin/phpcs --standard=PSR12 src/"

sniff-fix: create-tmp-container _sniff-fix cleanup-tmp-container
_sniff-fix:
	@-docker run --mount type=bind,source="$(shell pwd)",target=/app --name $(CONTAINER_NAME)-tmp --entrypoint=/bin/bash $(IMAGE_NAME)-tmp -c "vendor/bin/phpcbf --standard=PSR12 src/"

tests: create-tmp-container _tests cleanup-tmp-container
_tests:
	@-docker run --mount type=bind,source="$(shell pwd)",target=/app --name $(CONTAINER_NAME)-tmp --entrypoint=/bin/bash $(IMAGE_NAME)-tmp -c "vendor/bin/phpunit"
