<?php

namespace Tests\RequestMoneyValidator;

use App\Services\RequestMoneyValidator\Enums\Currency;
use Tests\TestCase;
use ValueError;

class EnumTest extends TestCase
{
    /**
     * @var array Valid currencies
     */
    const array VALID_CURRENCIES = [
        'usd' => 'usd',
        'USD' => 'usd',
        'eur' => 'eur',
        'EUR' => 'eur',
    ];

    /**
     * @var string Not valid currrency
     */
    const string NOT_VALID_CURRENCY = 'uah';

    public function test_check_valid_currencies(): void
    {
        foreach (self::VALID_CURRENCIES as $input => $output) {
            $currency = Currency::make($input);

            $this->assertEquals($currency->value, $output);
        }
    }

    public function test_check_not_valid_currency(): void
    {
        $this->expectException(ValueError::class);

        Currency::make(self::NOT_VALID_CURRENCY);
    }
}
