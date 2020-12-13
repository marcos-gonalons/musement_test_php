<?php

namespace App\Tests\Service\Api\Musement;

use App\Service\Api\Musement\CitiesAPI\CitiesApi;
use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument\Token\AnyValuesToken;
use Prophecy\Argument\Token\IdenticalValueToken;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class CitiesApiTest extends TestCase
{

    use ProphecyTrait;

    private string $apiUrl;
    private ObjectProphecy $httpClientMock;


    public function testGetCitiesBadStatus()
    {
        $apiService = $this->getCitiesApiInstance();

        $responseMock = $this->prophesize(ResponseInterface::class);
        $responseMock->getStatusCode(
            new AnyValuesToken()
        )->willReturn(500);

        $this->httpClientMock->request(
            new IdenticalValueToken("GET"),
            new IdenticalValueToken($this->apiUrl),
        )->willReturn($responseMock->reveal());

        try {
            $apiService->getCities();

            // Should never execute this
            $this->assertTrue(false);
        } catch (\Throwable $e) {
            $this->assertEquals("Bad response from API -> 500", $e->getMessage());
        }
    }


    public function testGetCitiesBadResponseBody()
    {
        $apiService = $this->getCitiesApiInstance();

        $responseMock = $this->prophesize(ResponseInterface::class);
        $responseMock->getStatusCode(
            new AnyValuesToken()
        )->willReturn(200);

        $responseBodyMock = $this->prophesize(StreamInterface::class);
        $responseBodyMock->getContents(
            new AnyValuesToken()
        )->willReturn("{bad json");
        $responseMock->getBody(
            new AnyValuesToken()
        )->willReturn($responseBodyMock);

        $this->httpClientMock->request(
            new IdenticalValueToken("GET"),
            new IdenticalValueToken($this->apiUrl),
        )->willReturn($responseMock->reveal());

        try {
            $apiService->getCities();

            // Should never execute this
            $this->assertTrue(false);
        } catch (\Throwable $e) {
            $this->assertEquals("An error happened while mapping the response body -> json_decode error: Syntax error", $e->getMessage());
        }
    }


    public function testGetCitiesSuccess()
    {
        $apiService = $this->getCitiesApiInstance();

        $responseMock = $this->prophesize(ResponseInterface::class);
        $responseMock->getStatusCode(
            new AnyValuesToken()
        )->willReturn(200);

        $responseBodyMock = $this->prophesize(StreamInterface::class);
        $responseBodyMock->getContents(
            new AnyValuesToken()
        )->willReturn($this->getCitiesResponseString());
        $responseMock->getBody(
            new AnyValuesToken()
        )->willReturn($responseBodyMock);

        $this->httpClientMock->request(
            new IdenticalValueToken("GET"),
            new IdenticalValueToken($this->apiUrl),
        )->willReturn($responseMock->reveal());

        $cities = $apiService->getCities();

        $this->assertEquals(1, count($cities));
        $this->assertEquals(1, $cities[0]->getId());
        $this->assertEquals("Test city", $cities[0]->getName());
        $this->assertEquals("Test code", $cities[0]->getCode());
        $this->assertEquals("Test content", $cities[0]->getContent());
        $this->assertEquals("Test description", $cities[0]->getDescription());
        $this->assertEquals("Test title", $cities[0]->getTitle());
        $this->assertEquals("Test headline", $cities[0]->getHeadline());
        $this->assertEquals("Test more", $cities[0]->getMore());
        $this->assertEquals(123, $cities[0]->getWeight());
        $this->assertEquals(1.2, $cities[0]->getLatitude());
        $this->assertEquals(3.4, $cities[0]->getLongitude());
        $this->assertEquals(1, $cities[0]->getCountry()->getId());
        $this->assertEquals("Test country", $cities[0]->getCountry()->getName());
        $this->assertEquals("Test iso code", $cities[0]->getCountry()->getIsoCode());
        $this->assertEquals("Test cover image url", $cities[0]->getCoverImageUrl());
        $this->assertEquals("Test url", $cities[0]->getUrl());
        $this->assertEquals(200, $cities[0]->getActivitiesCount());
        $this->assertEquals("Test timezone", $cities[0]->getTimezone());
        $this->assertEquals(100, $cities[0]->getVenueCount());
        $this->assertEquals(true, $cities[0]->getShowInPopular());
    }


    private function getCitiesResponseString(): string
    {
        $city = new \StdClass();
        $city->id = 1;
        $city->name = "Test city";
        $city->code = "Test code";
        $city->content = "Test content";
        $city->description = "Test description";
        $city->title = "Test title";
        $city->headline = "Test headline";
        $city->more = "Test more";
        $city->weight = 123;
        $city->latitude = 1.2;
        $city->longitude = 3.4;
        $city->country = new \StdClass();
        $city->country->id = 1;
        $city->country->name = "Test country";
        $city->country->isoCode = "Test iso code";
        $city->coverImageUrl = "Test cover image url";
        $city->url = "Test url";
        $city->activitiesCount = 200;
        $city->timezone = "Test timezone";
        $city->venueCount = 100;
        $city->showInPopular = true;

        return json_encode([$city]);
    }


    private function getCitiesApiInstance(): CitiesApi
    {
        $this->apiUrl = "dummy";
        $this->httpClientMock = $this->prophesize(ClientInterface::class);
        return new CitiesApi(
            $this->apiUrl,
            $this->httpClientMock->reveal()
        );
    }
}
