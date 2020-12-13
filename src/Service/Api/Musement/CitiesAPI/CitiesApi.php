<?php

namespace App\Service\Api\Musement\CitiesAPI;

use GuzzleHttp\ClientInterface;
use App\Service\Api\Musement\CitiesAPI\Entities\City;
use App\Service\Api\Musement\CitiesAPI\ResponseValidator\ResponseValidatorInterface;
use GuzzleHttp\Utils;
use Symfony\Component\HttpFoundation\Response;

class CitiesApi implements CitiesApiInterface
{

    private string $url;
    private ClientInterface $httpClient;
    private ResponseValidatorInterface $responseValidator;

    public function __construct(
        string $url,
        ClientInterface $httpClient,
        ResponseValidatorInterface $responseValidator
    ) {
        $this->url = $url;
        $this->httpClient = $httpClient;
        $this->responseValidator = $responseValidator;
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
            /** @var \stdClass[] $decodedBody */
            $decodedBody = Utils::jsonDecode($response->getBody()->getContents());

            $cities = [];
            $mapper = new \JsonMapper();
            foreach ($decodedBody as $c) {
                $city = new City();
                $mapper->map($c, $city);
                $cities[] = $city;
            }

            $areCitiesOk = $this->responseValidator->areCitiesOK($cities);
            if (!$areCitiesOk) {
                $error = $this->responseValidator->getValidationError();
                if ($error !== null) {
                    throw $error;
                }
                throw new \Exception("Unknown error when validating the get cities response.");
            }

            return $cities;
        } catch (\Throwable $e) {
            throw new \Exception("An error happened while mapping the response body -> " . $e->getMessage());
        }
    }
}
