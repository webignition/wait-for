<?php

declare(strict_types=1);

namespace webignition\WaitFor\Exception;

class ThresholdExceededException extends \Exception
{
    public function __construct(
        public readonly int $waitThresholdInSeconds,
        public readonly ?string $action = null,
    ) {
        $message = sprintf(
            'Exceeded threshold waiting %d seconds%s.',
            $waitThresholdInSeconds,
            (function (?string $action = null) {
                if (null === $action) {
                    return '';
                }

                return sprintf(' for %s', $action);
            })($action),
        );

        parent::__construct($message);
    }
}
