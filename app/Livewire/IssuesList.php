<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Issue;
use Livewire\Component;
use Livewire\WithPagination;

class IssuesList extends Component
{
    use WithPagination;

    public $title = 'Issues List';

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->dispatch('setPageTitle', $this->title);
    }

    public function render()
    {
        // Sort issues by latest event

        $issues = Issue::with('location', 'location.source', 'events')
            ->select('issues.*')
            ->leftJoinSub(
                Event::select('issue_id', Event::raw('MAX(occurred_at) as latest_occurred_at'))
                    ->groupBy('issue_id'),
                'latest_events',
                'issues.id',
                '=',
                'latest_events.issue_id'
            )
            ->orderBy('latest_events.latest_occurred_at', 'desc')
            ->paginate(10);

        return view('livewire.issues-list', [
            'issues' => $issues,
        ]);
    }
}
