<?php

namespace App\Http\Controllers;

use App\Logger\LogProcessor;
use App\Logger\LogWatchParser;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        // extract hostname from subject using regex
        preg_match('/\b((?:[a-zA-Z0-9-]+\.)+[a-zA-Z]{2,})\b/', $request->subject, $matches);
        $source = $matches[0];

        $logParser = new LogWatchParser($source);
        $logProcessor = new LogProcessor($logParser);
        $logProcessor->process($request->body);

        return response('OK', 200);
    }
}
