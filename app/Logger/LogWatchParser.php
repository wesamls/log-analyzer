<?php

namespace App\Logger;

/**
 * Parses log sent to email by `logwatch.php` script
 */
class LogWatchParser
{
    const NEWLINE = "\n";

    private $pattern = '/\[(\d{2}-[A-Za-z]{3}-\d{4} \d{2}:\d{2}:\d{2} Etc\/GMT-2)\]\s*(.*?)(?=\[\d{2}-[A-Za-z]{3}-\d{4}|\z)/s';

    public function __construct(private string $source) {}

    public function parse($content)
    {
        $content = str_replace("\r\n", "\n", $content);
        $content = str_replace('Log Files Changes:', '', $content);
        $parts = array_filter(array_map('trim', explode('==LOG_ENTRY_END==', $content)));
        $entries = [];

        foreach ($parts as $part) {
            $lines = explode("\n", $part);
            $location = str_replace(['>> ', ':'], '', $lines[0]);
            $part = str_replace($lines[0]."\n\n", '', $part);

            preg_match_all($this->pattern, $part, $matches);

            foreach ($matches[1] as $k => $date) {
                $entries[] = new LogEntry($date, trim($matches[2][$k]), $this->source, $location);
            }
        }

        return $entries;
    }
}
