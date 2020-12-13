# Musement Test by Marcos Goñalons

## Needed tools
In order to run the app, only Docker is necessary.

There is no need to have PHP or composer installed in the local machine, since everything happens inside the Docker container.

You can check how to install Docker in your machine here -> https://docs.docker.com/get-docker/


## Setup
```
git clone git@github.com:marcos-gonalons/musement_test_php.git
```
After cloning the repository, we need to build the docker image with the following command

```
make build
```

This will take a couple of minutes. It will also install all the composer dependencies inside the image.

When the build it's done, we can run the app with the following command:
```
make run
```

This command will execute the script and you should start seeing in the console output the "Processed city x | weather today - weather tomorrow" messages :)  

Under the hood is running this command **"php bin/console 'app:get-forecasts'"** inside the docker container.


## Other commands

**make phpstan**  
This command is for running the phpstan static analyzer, with the highest possible level (https://github.com/phpstan/phpstan).  
Runs **"vendor/bin/phpstan --level=8 analyse src/"** inside the docker container.

  
**make sniff**  
To run the PHP_CodeSniffer (https://github.com/squizlabs/PHP_CodeSniffer).  
Runs **"vendor/bin/phpcs --standard=PSR12 src/"** inside the docker container.

**make sniff-fix**  
To fix the autofixable errors found by phpcs.  
Runs **"vendor/bin/phpcbf --standard=PSR12 src/"** inside the docker container.

**make tests**  
For running the tests.  
Runs **"vendor/bin/phpunit"** inside the docker container


**make tests-coverage**  
Runs the tests and generates the coverage report, which will be found in the "coverage" folder.  
Runs **php -d xdebug.mode=coverage vendor/bin/phpunit --coverage-html coverage --whitelist src** inside the docker container.


## Implementation
Symfony 5 was used for this project.  

The code follows the PSR12 coding style standard, and is structured as follows:  


**src/Command**  
Contains the command that will be executed.  
The command's only responsibility is to call the ForecastService, and to output the error if
the ForecastService threw an error.  

**src/Service/Forecast**  
Contains the ForecastService.  
The ForecastService responsability is to hold the business logic.  
It has the weather api and the cities api as dependencies, and it will call them in order to get the forecasts for all the cities.  


**src/Service/API**  
Contains both the Musement Cities API and the Weather API.  
The responsability of the API services is to make the HTTP calls and to validate the responses.

## APIs implementation




## Error handling




## .env file
Here I added 3 environment variables:  

*WEATHER_API_KEY=5f3f1e14e8784c708b6185059200812*
*WEATHER_API_URL=http://api.weatherapi.com/v1/forecast.json*
*CITIES_API_URL=https://api.musement.com/api/v3/cities*  

Secrets and passwords, like the weather api key, should not be commited in .env files.  
I decided to leave it there since it's a free key.  
You can use that one or you can change it with your own api key.
