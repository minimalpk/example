<?php

namespace Tests\RequestMoneyValidator;

use App\Services\RequestMoneyValidator\DTO\Request;
use App\Services\RequestMoneyValidator\DTO\Transaction;
use App\Services\RequestMoneyValidator\Enums\Currency;
use Tests\TestCase;

class DTOTest extends TestCase
{
    /**
     * @var array Values
     */
    const array VALUES = [
        'usd' => 99.99,
        'eur' => 999,
    ];

    private function checkDTO(
        string $class,
    ): void {
        foreach (self::VALUES as $currency => $amount) {
            $object = new $class($amount, Currency::make($currency));

            $this->assertEquals($object->amount, $amount);
            $this->assertEquals($object->currency->value, $currency);
        }
    }

    public function test_check_valid_request(): void
    {
        $this->checkDTO(Request::class);
    }

    public function test_check_valid_transaction(): void
    {
        $this->checkDTO(Transaction::class);
    }
}
