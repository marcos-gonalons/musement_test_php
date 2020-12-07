IMAGE_NAME = mgonalons-musement-test-image
CONTAINER_NAME = mgonalons-musement-test-container

build:
	docker build -t $(IMAGE_NAME) .

run:
	@docker container rm $(CONTAINER_NAME) 2> /dev/null ||:
	docker run --name $(CONTAINER_NAME) $(IMAGE_NAME) php -v

test:
	echo "todo"