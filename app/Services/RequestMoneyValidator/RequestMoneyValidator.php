<?php

namespace App\Services\RequestMoneyValidator;

use App\Services\RequestMoneyValidator\DTO\Request;
use App\Services\RequestMoneyValidator\DTO\Transaction;
use Illuminate\Support\Facades\Config;

class RequestMoneyValidator
{
    private float $deviation;

    public function __construct()
    {
        $this->deviation = Config::get('app.deviation');
    }

    private function getDifference(
        Request     $request,
        Transaction $transaction,
    ): float {
        return abs($request->amount - $transaction->amount);
    }

    private function getDeviation(
        Request $request,
    ): float {
        return round($request->amount / 100 * $this->deviation, 2);
    }

    public function validate(
        Request     $request,
        Transaction $transaction,
    ): bool {
        if ($request->currency->value != $transaction->currency->value) {
            return false;
        }

        $difference = $this->getDifference($request, $transaction);

        $deviation = $this->getDeviation($request);

        if ($difference > $deviation) {
            return false;
        }

        return true;
    }
}
