@extends('admin.layout')

@section('title', 'Projects')

@section('actions')
  <a href="{{ route('admin.projects.create') }}" class="btn btn-accent btn-sm"><i class="fa fa-plus"></i> New project</a>
@endsection

@section('content')
<div class="adm-card">
  <div class="adm-card-header">
    <ul class="nav nav-pills">
      <li class="nav-item"><a class="nav-link {{ $trashed ? '' : 'active' }}" href="{{ route('admin.projects.index') }}">All projects</a></li>
      <li class="nav-item"><a class="nav-link {{ $trashed ? 'active' : '' }}" href="{{ route('admin.projects.index', ['view' => 'trash']) }}">Trash ({{ $trashCount }})</a></li>
    </ul>
    @unless ($trashed)
    <form class="form-inline ml-auto" method="get" data-no-loading>
      <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm mr-2" placeholder="Search name or location">
      <select name="status" class="form-control form-control-sm custom-select mr-2" onchange="this.form.submit()">
        <option value="">All statuses</option>
        @foreach (\App\Models\Project::STATUSES as $k => $v)
          <option value="{{ $k }}" @selected(request('status') === $k)>{{ $v }}</option>
        @endforeach
      </select>
      <button class="btn btn-light btn-sm" type="submit"><i class="fa fa-search"></i></button>
    </form>
    @endunless
  </div>

  @if ($projects->isEmpty())
    <div class="adm-empty">
      <i class="fa fa-building-o"></i>
      @if ($trashed) Trash is empty. @elseif (request()->hasAny(['q', 'status'])) No projects match your search. @else No projects yet. <a href="{{ route('admin.projects.create') }}">Add your first project</a>. @endif
    </div>
  @else
  <div class="table-responsive">
    <table class="table adm-table">
      <thead>
        <tr><th></th><th>Project</th><th>Status</th><th>Units / Photos</th><th>Published</th><th>Featured</th><th></th></tr>
      </thead>
      <tbody>
      @foreach ($projects as $project)
        <tr>
          <td style="width:80px"><img class="adm-thumb" src="{{ $project->coverUrl() }}" alt=""></td>
          <td>
            <strong>{{ $project->name }}</strong>
            <div class="text-muted small">{{ $project->location ?: '—' }} · {{ \App\Models\Project::TYPES[$project->type] ?? $project->type }}</div>
          </td>
          <td><span class="adm-pill adm-pill-{{ $project->status }}">{{ \App\Models\Project::STATUSES[$project->status] ?? $project->status }}</span></td>
          <td class="text-muted">{{ $project->units_count }} / {{ $project->gallery_count }}</td>
          @if ($trashed)
            <td colspan="2" class="text-muted small">Deleted {{ $project->deleted_at->diffForHumans() }}</td>
            <td class="adm-actions-cell">
              <form method="post" action="{{ route('admin.projects.restore', $project->id) }}">@csrf
                <button class="btn btn-sm btn-light" type="submit"><i class="fa fa-undo"></i> Restore</button>
              </form>
              <form method="post" action="{{ route('admin.projects.force-delete', $project->id) }}" data-confirm="Permanently delete &quot;{{ $project->name }}&quot; and all its photos, floor plans and units? This cannot be undone.">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger" type="submit"><i class="fa fa-trash"></i> Delete forever</button>
              </form>
            </td>
          @else
            <td>
              <form method="post" action="{{ route('admin.projects.toggle', [$project, 'is_published']) }}">@csrf @method('PATCH')
                <button type="submit" class="btn btn-link p-0" title="Click to {{ $project->is_published ? 'unpublish' : 'publish' }}">
                  <span class="adm-pill {{ $project->is_published ? 'adm-pill-on' : 'adm-pill-off' }}">{{ $project->is_published ? 'Published' : 'Draft' }}</span>
                </button>
              </form>
            </td>
            <td>
              <form method="post" action="{{ route('admin.projects.toggle', [$project, 'is_featured']) }}">@csrf @method('PATCH')
                <button type="submit" class="btn btn-link p-0" title="Click to toggle featured">
                  <i class="fa {{ $project->is_featured ? 'fa-star text-warning' : 'fa-star-o text-muted' }} fa-lg"></i>
                </button>
              </form>
            </td>
            <td class="adm-actions-cell">
              @if ($project->is_published)
                <a class="btn btn-sm btn-light" href="{{ route('project.show', $project) }}" target="_blank" rel="noopener" title="View on website"><i class="fa fa-external-link"></i></a>
              @endif
              <a class="btn btn-sm btn-light" href="{{ route('admin.projects.edit', $project) }}"><i class="fa fa-pencil"></i> Edit</a>
              <form method="post" action="{{ route('admin.projects.destroy', $project) }}" data-confirm="Move &quot;{{ $project->name }}&quot; to trash? It will disappear from the website.">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger" type="submit" title="Delete"><i class="fa fa-trash"></i></button>
              </form>
            </td>
          @endif
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
  <div class="px-3">{{ $projects->links('pagination::bootstrap-4') }}</div>
  @endif
</div>
@endsection
