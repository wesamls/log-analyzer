<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('issues.index') }}" wire:navigate>Issues</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <span class="badge {{ $issue->type == 'ER' ? 'bg-warning' : 'bg-danger' }}">{{ $issue->type }}</span>
                Issue # {{ $issue->id }}
            </li>
        </ol>
    </nav>

    <h2>{{ $issue->title }}</h2>

    <div class="row">
        <div class="col-md-9">
    <div class="card">
        <div class="card-body">
            <pre><code>{{ $issue->message }}</code></pre>
        </div>
    </div>
        </div>

        <div class="col-md-3">
            <div class="row ">
                <div class="col bg-danger-subtle border border-danger me-2">
                    Last Seen:<br>{{ $issue->last_seen['date'] }}
                </div>
                <div class="col bg-warning-subtle border border-warning me-2">
                    Since:<br>{{ $issue->since['date'] }}
                </div>
                <div class="col bg-primary-subtle border border-primary me-2">
                    Events:<br><span class="fs-3">{{ $issue->events->count() }}</span>
                </div>
            </div>

            <h3>Occurrences</h3>

            <ul class="list-group">
                @foreach($issue->events->sortByDesc('occurred_at') as $event)
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        {{ $event->occurred_at }}
                    </li>
                @endforeach
            </ul>
        </div>
</div>
