<?php

namespace App\Logger;

use App\Actions\AddIssue;

class LogProcessor
{
    private $parser;

    public function __construct(LogWatchParser $parser)
    {
        $this->parser = $parser;
    }

    public function process($bodyContent)
    {
        $entries = $this->parser->parse($bodyContent);

        foreach ($entries as $entry) {
            $action = new AddIssue($entry);
            $action->execute();
        }
    }
}
