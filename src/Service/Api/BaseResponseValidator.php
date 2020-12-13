<?php

namespace App\Service\Api;

use Throwable;

class BaseResponseValidator implements BaseResponseValidatorInterface
{

    protected ?Throwable $validationError;

    public function getValidationError(): ?Throwable
    {
        return $this->validationError;
    }
}
