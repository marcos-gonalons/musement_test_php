<?php

namespace App\Service\Api\Weather;

use App\Service\Api\Musement\CitiesApi\Entities\City;
use App\Service\Api\Weather\Entities\ForecastDay;
use App\Service\Api\Weather\Entities\Weather;
use GuzzleHttp\ClientInterface;
use Symfony\Component\HttpFoundation\Response;

class WeatherApi implements WeatherApiInterface
{

    private string $apiKey;
    private string $url;
    private ClientInterface $httpClient;

    public function __construct(
        string $apiKey,
        string $url,
        ClientInterface $httpClient
    ) {
        $this->apiKey = $apiKey;
        $this->url = $url;
        $this->httpClient = $httpClient;
    }


    public function getWeather(City $city, int $days): Weather
    {
        $response = $this->httpClient->request("GET", $this->url . "?" . $this->getQueryString($city, $days));

        $statusCode = $response->getStatusCode();
        if ($statusCode !== Response::HTTP_OK) {
            throw new \Exception("Bad response from API -> " . $statusCode);
        }

        try {
            $decodedBody = json_decode($response->getBody()->getContents());

            $mapper = new \JsonMapper();
            $weather = new Weather();
            $mapper->map($decodedBody, $weather);

            $forecastDays = [];
            foreach ($weather->getForecast()->getForecastDay() as $day) {
                $forecastDay = new ForecastDay();
                $mapper->map($day, $forecastDay);
                $forecastDays[] = $forecastDay;
            }
            $weather->getForecast()->setForecastDay($forecastDays);

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
