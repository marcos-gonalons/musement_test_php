<?php

namespace App\Service\Api;

use Throwable;

class BaseResponseValidator implements BaseResponseValidatorInterface
{

    protected ?Throwable $validationError = null;

    public function getValidationError(): ?Throwable
    {
        return $this->validationError;
    }
}
