<div class="container-fluid">
<table class="table table-hover">
    <thead><tr><th></th><th>Issue</th><th>Events</th><th></th></tr></thead>
    @foreach($issues as $issue)
        <tr>
            <td>
                <span class="badge {{ $issue->type == 'ER' ? 'bg-warning' : 'bg-danger' }}">{{ $issue->type }}</span>
            </td>
            <td>
                {{ $issue->title }}
                <div class="text-muted">
                    <i class="bi bi-clock"></i> 
                    <span data-bs-toggle="tooltip" data-bs-title="{{ $issue->last_seen['date'] }}">
                        {{ $issue->last_seen['relative'] }}
                    </span>
                    |
                    <i class="bi bi-calendar4-event"></i>
                    <span data-bs-toggle="tooltip" data-bs-title="{{ $issue->since['date'] }}">
                        {{ $issue->since['relative'] }}
                    </span>
                    @if ($issue->ignored)
                        <span class="text-danger"><i class="bi bi-bell-slash"></i> Ignored</span>
                    @else
                        <span class="text-warning"><i class="bi bi-bell"></i> Report</span>
                    @endif
                </div>
            </td>
            
            <td>{{ $issue->events->count() }}</td>
            <td>
                <a href="{{ route('issues.show', $issue) }}" class="btn btn-primary btn-sm" wire:navigate>Show</a>
            </td>
        </tr>
    @endforeach
</table>

{{ $issues->links() }}

@script
<script>
    Livewire.hook('component.init', ({ component, cleanup }) => {
        applyTooltips()
    })
    Livewire.hook('commit', ({ component, commit, respond, succeed, fail }) => {
        respond(() => {
            //destroy old tooltips
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            tooltipTriggerList.forEach(tooltipTriggerEl => {
                const tooltip = bootstrap.Tooltip.getInstance(tooltipTriggerEl)
                tooltip?.dispose()
            })
           
        })
        succeed(({ snapshot, effect }) => {
            applyTooltips()
        })
    })
</script>
@endscript
</div>
