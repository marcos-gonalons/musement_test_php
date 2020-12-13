<?php

namespace App\Service\Api\Weather;

use App\Service\Api\Musement\CitiesAPI\Entities\City;
use App\Service\Api\Weather\Entities\Weather;
use App\Service\Api\Weather\ResponseValidator\ResponseValidatorInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Utils;
use Symfony\Component\HttpFoundation\Response;

class WeatherApi implements WeatherApiInterface
{

    private string $apiKey;
    private string $url;
    private ClientInterface $httpClient;
    private ResponseValidatorInterface $responseValidator;

    public function __construct(
        string $apiKey,
        string $url,
        ClientInterface $httpClient,
        ResponseValidatorInterface $responseValidator
    ) {
        $this->apiKey = $apiKey;
        $this->url = $url;
        $this->httpClient = $httpClient;
        $this->responseValidator = $responseValidator;
    }


    public function getWeather(City $city, int $days): Weather
    {
        $response = $this->httpClient->request("GET", $this->url . "?" . $this->getQueryString($city, $days));

        $statusCode = $response->getStatusCode();
        if ($statusCode !== Response::HTTP_OK) {
            throw new \Exception("Bad response from API -> " . $statusCode);
        }

        try {
            /** @var \stdClass $decodedBody */
            $decodedBody = Utils::jsonDecode($response->getBody()->getContents());

            $mapper = new \JsonMapper();
            $weather = new Weather();
            $mapper->map($decodedBody, $weather);

            $isWeatherOk = $this->responseValidator->isWeatherValid($weather);
            if (!$isWeatherOk) {
                $error = $this->responseValidator->getValidationError();
                if ($error !== null) {
                    throw $error;
                }
                throw new \Exception("Unknown error when validating the get weather response.");
            }

            return $weather;
        } catch (\Throwable $e) {
            throw new \Exception("An error happened while mapping the response body -> " . $e->getMessage());
        }
    }

    private function getQueryString(City $city, int $days): string
    {
        return http_build_query([
            "key" => $this->apiKey,
            "q" => "{$city->getLatitude()},{$city->getLongitude()}",
            "days" => $days
        ]);
    }
}
