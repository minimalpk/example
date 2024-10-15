<?php

namespace App\Services\RequestMoneyValidator\Enums;

enum Currency: string
{
    case USD = 'usd';
    case EUR = 'eur';

    public static function make(string $value): self
    {
        return Currency::from(strtolower($value));
    }
}
