{{-- Expects $project (App\Models\Project). --}}
<div class="bd-project">
  <a href="{{ route('project.show', $project->slug) }}" class="bd-project-img d-block" style="background-image:url('{{ $project->coverUrl() }}')" aria-label="{{ $project->tr('name') }}">
    <span class="bd-badge bd-status-{{ $project->status }}">{{ $project->statusLabel() }}</span>
  </a>
  <div class="p25">
    <h4><a href="{{ route('project.show', $project->slug) }}" class="text-dark">{{ $project->tr('name') }}</a></h4>
    @if ($project->tr('location'))<p class="mb10"><i class="fa fa-map-marker text-thm mr5"></i> {{ $project->tr('location') }}</p>@endif
    @if ($project->priceRange())<p class="mb10 font-weight-bold">{{ $project->priceRange() }}</p>@endif
    @if ($project->tr('summary'))<p>{{ $project->tr('summary') }}</p>@endif
    <a href="{{ route('project.show', $project->slug) }}" class="btn btn-thm">{{ __('View Project') }}</a>
    <a href="{{ route('project.show', $project->slug) }}#visit" class="btn btn-outline-secondary ml5">{{ __('Book a Site Visit') }}</a>
  </div>
</div>
