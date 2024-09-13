<?php

namespace App\Actions;

use App\Logger\LogEntry;
use App\Models\Event;
use App\Models\Issue;
use App\Models\Location;
use App\Models\Source;
use App\Notifications\LogEntryOccurred;
use App\Notifications\NewLogEntry;
use Illuminate\Support\Facades\Notification;

class AddIssue
{
    public function __construct(private LogEntry $entry) {}

    public function execute()
    {
        $hash = hash('sha256', $this->entry->getMessage());

        $source = $this->getSource();
        $location = $this->getLocation($source);
        $issue = $this->getIssue($hash, $location);

        $event = new Event;
        $event->issue_id = $issue->id;
        $event->occurred_at = $this->entry->getDateTime()->format('Y-m-d H:i:s');
        $event->raw_date = $this->entry->getTimestamp();
        $event->save();

        if (! $issue->ignored) {
            Notification::route('google_chat', 'dummy')->notify(new LogEntryOccurred($issue));
        }
    }

    private function getSource()
    {
        $source = Source::where('name', $this->entry->getSource())->first();
        if (! $source) {
            $source = new Source;
            $source->name = $this->entry->getSource();
            $source->code = $this->entry->getSource();
            $source->save();
        }

        return $source;
    }

    private function getLocation($source)
    {
        $location = $this->entry->getLocation();
        $location = $source->locations()->where('name', $location)->first();
        if (! $location) {
            $location = new Location;
            $location->source_id = $source->id;
            $location->name = $this->entry->getLocation();
            $location->save();
        }

        return $location;
    }

    private function getIssue($hash, $location)
    {
        $issue = Issue::where('signature', $hash)->where('location_id', $location->id)->first();
        if (! $issue) {
            $issue = new Issue;
            $issue->signature = $hash;
            $issue->location_id = $location->id;
            $issue->message = $this->entry->getMessage();
            $issue->save();

            Notification::route('google_chat', 'only')->notify(new NewLogEntry($issue));
        }

        return $issue;
    }
}
