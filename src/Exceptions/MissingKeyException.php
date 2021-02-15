<?php
declare(strict_types=1);

namespace Vcg\Exceptions;

use Throwable;

class MissingKeyException extends \Exception
{
    private string $defaultMessage = 'Missing key';

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $outputMessage = $this->createOutputMessage($message);

        parent::__construct($outputMessage, $code, $previous);
    }

    private function createOutputMessage(string $message): string
    {
        return empty($message)
            ? $this->defaultMessage
            : sprintf('%s: %s', $this->defaultMessage, $message);
    }
}
