<?php

namespace App\Service\Api;

interface BaseResponseValidatorInterface
{

    public function getValidationError(): ?\Throwable;
}
