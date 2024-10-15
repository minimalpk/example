<?php

namespace Tests\RequestMoneyValidator;

use App\Services\RequestMoneyValidator\DTO\Request;
use App\Services\RequestMoneyValidator\DTO\Transaction;
use App\Services\RequestMoneyValidator\Enums\Currency;
use App\Services\RequestMoneyValidator\RequestMoneyValidator;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    private function setDeviation(float $deviation): void
    {
        Config::set('app.deviation', $deviation);
    }

    private function makeRequest(float $amount, string $currency): Request
    {
        return new Request($amount, Currency::make($currency));
    }

    private function makeTransaction(float $amount, string $currency): Transaction
    {
        return new Transaction($amount, Currency::make($currency));
    }

    public function test_valid_validators_result(): void
    {
        $this->setDeviation(10);

        $validator = new RequestMoneyValidator();

        $this->assertTrue($validator->validate(
            $this->makeRequest(100, 'usd'),
            $this->makeTransaction(90, 'usd'),
        ));

        $this->assertTrue($validator->validate(
            $this->makeRequest(900.9, 'eur'),
            $this->makeTransaction(990.09, 'eur'),
        ));

        $this->assertTrue($validator->validate(
            $this->makeRequest(900.00, 'eur'),
            $this->makeTransaction(810, 'eur'),
        ));
    }

    public function test_not_valid_validators_result(): void
    {
        $this->setDeviation(1);

        $validator = new RequestMoneyValidator();

        $this->assertFalse($validator->validate(
            $this->makeRequest(100, 'usd'),
            $this->makeTransaction(97.54, 'usd'),
        ));

        $this->assertFalse($validator->validate(
            $this->makeRequest(100, 'usd'),
            $this->makeTransaction(90, 'eur'),
        ));

        $this->assertFalse($validator->validate(
            $this->makeRequest(900.9, 'eur'),
            $this->makeTransaction(990.09, 'eur'),
        ));

        $this->assertFalse($validator->validate(
            $this->makeRequest(900.00, 'eur'),
            $this->makeTransaction(810, 'eur'),
        ));
    }
}
