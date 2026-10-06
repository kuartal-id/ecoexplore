<a href="{{ route('restore.show', $project) }}" class="restore-card">
    <div class="card-image short" style="background-image:url('{{ asset($project->image ?: 'assets/img/forest.svg') }}')">
        <span class="card-chip">{{ __('ui.restore.type.'.$project->type) }}</span>
        <span class="card-chip sample">{{ __('ui.common.sample') }}</span>
    </div>
    <div class="card-body">
        <div class="impact-label">{{ $project->location }}</div>
        <h3>{{ $project->tr('title') }}</h3>
        <p>{{ $project->tr('summary') }}</p>
        <div class="progress" aria-label="{{ __('ui.restore.progress') }}"><i style="width: {{ $project->progressPercent() }}%"></i></div>
        <small class="muted">{{ __('ui.restore.funded_of', ['n' => num($project->funded_units), 't' => num($project->target_units), 'unit' => $project->tr('unit_label')]) }}</small>
        <div class="restore-price">{{ idr($project->unit_price_idr) }} <small>/ {{ $project->tr('unit_label') }}</small></div>
        <span class="btn btn-primary small">{{ __('ui.restore.fund_cta') }} <x-icon name="arrow" size="16"/></span>
    </div>
</a>
