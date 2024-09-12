<?php

namespace App\Logger;

use DateTime;

class LogEntry
{
    public function __construct(
        private string $timestamp,
        private string $message,
        private string $source,
        private string $location
    ) {}

    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    public function getDateTime(): DateTime
    {
        return DateTime::createFromFormat('d-M-Y H:i:s e', $this->timestamp);
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function getLocation(): string
    {
        return $this->location;
    }
}
