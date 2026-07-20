<?php

declare(strict_types=1);

namespace webignition\WaitFor;

use webignition\WaitFor\Exception\FooException;

final readonly class WaitFor
{
    private const int MICROSECONDS_PER_SECOND = 1000000;

    /**
     * @throws FooException
     */
    public function waitFor(
        $waitThresholdInSeconds,
        callable $foo,
        ?string $action = null,
    ): void {
        $waitThreshold = self::MICROSECONDS_PER_SECOND * $waitThresholdInSeconds;
        $totalWaitTime = 0;
        $period = (int) (self::MICROSECONDS_PER_SECOND * 0.1);

        $checkCondition = false;

        while (false === $checkCondition && $totalWaitTime < $waitThreshold) {
            $totalWaitTime += $period;
            usleep($period);

            $checkCondition = $foo();
        }

        if ($totalWaitTime >= $waitThreshold) {
            throw new FooException($waitThreshold, $action);
        }
    }
}
