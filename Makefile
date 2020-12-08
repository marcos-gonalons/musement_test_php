IMAGE_NAME = mgonalons-musement-test-image
CONTAINER_NAME = mgonalons-musement-test-container

build:
	docker build -t $(IMAGE_NAME) .
	docker run --name $(CONTAINER_NAME) $(IMAGE_NAME) composer install

run:
	@docker commit $(CONTAINER_NAME) $(IMAGE_NAME)-tmp 1> /dev/null
	@-docker run --name $(CONTAINER_NAME)-tmp --entrypoint=/bin/bash $(IMAGE_NAME)-tmp -c "php -v"
	@-docker rmi -f $(IMAGE_NAME)-tmp 1> /dev/null
	@-docker container rm $(CONTAINER_NAME)-tmp 1> /dev/null

tests:
	echo "run app tests here"