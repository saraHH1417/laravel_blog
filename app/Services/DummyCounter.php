<?php

namespace App\Services;

use App\Contracts\CounterContract;

class DummyCounter implements  CounterContract
{
    public function increment(string $key, array $tags = null): int
    {
        dd('I am Dummy Counter , Not implemented Yet.');

        return 0;
    }
}
