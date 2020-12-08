IMAGE_NAME = mgonalons-musement-test-image
CONTAINER_NAME = mgonalons-musement-test-container

build:
	docker build -t $(IMAGE_NAME) .

# after building: create container and install dependencies

run:
	@docker container rm $(CONTAINER_NAME) 2> /dev/null ||:
	docker run --name $(CONTAINER_NAME) $(IMAGE_NAME) php -v

tests:
	echo "run app tests here"