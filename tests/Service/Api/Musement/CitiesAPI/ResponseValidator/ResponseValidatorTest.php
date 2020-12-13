<?php

namespace App\Tests\Service\Api\Musement\CitiesAPI\ResponseValidator;

use App\Service\Api\Musement\CitiesAPI\Entities\City;
use App\Service\Api\Musement\CitiesAPI\ResponseValidator\ResponseValidator;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class ResponseValidatorTest extends TestCase
{

    use ProphecyTrait;

    public function testEmptyCitiesArray()
    {
        $validator = $this->getResonseValidatorInstance();

        $cities = [];

        $result = $validator->areCitiesOK($cities);

        $this->assertEquals(false, $result);

        /** @var \Throwable $error */
        $error = $validator->getValidationError();
        $this->assertEquals("Empty cities array.", $error->getMessage());
    }


    public function testEmptyName()
    {
        $validator = $this->getResonseValidatorInstance();

        $city = new City();
        $cities = [$city];


        $result = $validator->areCitiesOK($cities);

        $this->assertEquals(false, $result);

        /** @var \Throwable $error */
        $error = $validator->getValidationError();
        $this->assertEquals("City in position 0 does not have a name.", $error->getMessage());
    }



    public function testEmptyLongitude()
    {
        $validator = $this->getResonseValidatorInstance();

        $city = new City();
        $city->setName("Test city");
        $cities = [$city];


        $result = $validator->areCitiesOK($cities);

        $this->assertEquals(false, $result);

        /** @var \Throwable $error */
        $error = $validator->getValidationError();
        $this->assertEquals("City in position 0 does not have longitude.", $error->getMessage());
    }



    public function testEmptyLatitude()
    {
        $validator = $this->getResonseValidatorInstance();

        $city = new City();
        $city->setName("Test city");
        $city->setLongitude(1.2);
        $cities = [$city];


        $result = $validator->areCitiesOK($cities);

        $this->assertEquals(false, $result);

        /** @var \Throwable $error */
        $error = $validator->getValidationError();
        $this->assertEquals("City in position 0 does not have latitude.", $error->getMessage());
    }


    public function testValidationsSuccess()
    {
        $validator = $this->getResonseValidatorInstance();

        $city = new City();
        $city->setName("Test city");
        $city->setLongitude(1.2);
        $city->setLatitude(3.4);
        $cities = [$city];

        $result = $validator->areCitiesOK($cities);
        $this->assertEquals(true, $result);

        $error = $validator->getValidationError();
        $this->assertEquals(null, $error);
    }



    private function getResonseValidatorInstance(): ResponseValidator
    {
        return new ResponseValidator();
    }
}
