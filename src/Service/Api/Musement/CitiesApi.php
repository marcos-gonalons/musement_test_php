<?php

namespace App\Service\Api\Musement;

use GuzzleHttp\ClientInterface;
use App\Service\Api\Musement\Entities\City;
use GuzzleHttp\Utils;
use Symfony\Component\HttpFoundation\Response;

class CitiesApi implements CitiesApiInterface
{

    private string $url;
    private ClientInterface $httpClient;

    public function __construct(string $url, ClientInterface $httpClient)
    {
        $this->url = $url;
        $this->httpClient = $httpClient;
    }

    /**
     * @return City[]
     */
    public function getCities(): array
    {
        $response = $this->httpClient->request("GET", $this->url);

        $statusCode = $response->getStatusCode();
        if ($statusCode !== Response::HTTP_OK) {
            throw new \Exception("Bad response from API -> " . $statusCode);
        }

        try {
            $decodedBody = Utils::jsonDecode($response->getBody()->getContents());

            $cities = [];
            $mapper = new \JsonMapper();
            foreach ($decodedBody as $c) {
                $city = new City();
                $mapper->map($c, $city);
                $cities[] = $city;
            }

            return $cities;
        } catch (\Throwable $e) {
            throw new \Exception("An error happened while mapping the response body -> " . $e->getMessage());
        }
    }
}
