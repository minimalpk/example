<?php

namespace App\Services\RequestMoneyValidator\DTO;

use App\Services\RequestMoneyValidator\Enums\Currency;

class Base
{
    public function __construct(
        public readonly float    $amount,
        public readonly Currency $currency
    ) {}
}
