<?php

namespace App\Livewire;

use App\Models\Issue;
use Livewire\Component;

class IssueView extends Component
{
    public $title = 'Issue';

    public Issue $issue;

    public function mount($id)
    {
        $this->issue = Issue::findOrFail($id);
        $this->title = "Issue #{$this->issue->id}";
    }

    public function render()
    {
        $this->issue->load('location', 'location.source', 'events');

        return view('livewire.issue-view', [
            'issue' => $this->issue,
        ]);
    }
}
