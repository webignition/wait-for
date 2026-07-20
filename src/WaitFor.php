<?php

declare(strict_types=1);

namespace webignition\WaitFor;

use webignition\WaitFor\Exception\ThresholdExceededException;

final readonly class WaitFor
{
    private const int MICROSECONDS_PER_SECOND = 1000000;

    /**
     * @param callable(): bool $checkCondition
     *
     * @throws ThresholdExceededException
     */
    public function waitFor(
        int $waitThresholdInSeconds,
        callable $checkCondition,
        ?string $action = null,
    ): void {
        $waitThreshold = self::MICROSECONDS_PER_SECOND * $waitThresholdInSeconds;
        $totalWaitTime = 0;
        $period = (int) (self::MICROSECONDS_PER_SECOND * 0.1);

        $checkOutcome = false;

        while (false === $checkOutcome && $totalWaitTime < $waitThreshold) {
            $totalWaitTime += $period;
            usleep($period);

            $checkOutcome = $checkCondition();
        }

        if ($totalWaitTime >= $waitThreshold) {
            throw new ThresholdExceededException($waitThreshold, $action);
        }
    }
}
