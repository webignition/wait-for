<?php

declare(strict_types=1);

namespace webignition\WaitFor\Tests;

use PHPUnit\Framework\TestCase;
use webignition\WaitFor\Exception\ThresholdExceededException;
use webignition\WaitFor\WaitFor;

class WaitForTest extends TestCase
{
    public function testWaitSuccessful(): void
    {
        new WaitFor()->waitFor(
            30,
            function () {
                return true;
            }
        );

        self::expectNotToPerformAssertions();
    }

    public function testWaitForReturnsDuration(): void
    {
        $duration = new WaitFor()->waitFor(
            30,
            function () {
                return true;
            }
        );

        self::assertSame(100000, $duration);
    }

    public function testWaitThresholdExceeded(): void
    {
        self::expectException(ThresholdExceededException::class);

        $iterationCount = 0;

        new WaitFor()->waitFor(
            1,
            function () use (&$iterationCount) {
                ++$iterationCount;

                return 10 === $iterationCount;
            }
        );
    }
}
