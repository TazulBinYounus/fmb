@extends('admin.layout')

@section('title', 'Dashboard')

@section('actions')
  <a href="{{ route('admin.projects.create') }}" class="btn btn-accent btn-sm"><i class="fa fa-plus"></i> New project</a>
@endsection

@section('content')
<div class="row">
  @foreach ([
    ['Projects', $stats['projects'], $stats['published'].' published · '.$stats['featured'].' featured', 'fa-building', '#c9a54a', route('admin.projects.index')],
    ['New enquiries', $stats['new_enquiries'], $stats['enquiries_30d'].' in the last 30 days', 'fa-inbox', '#dc2626', route('admin.enquiries.index', ['status' => 'new'])],
    ['Unit types', $stats['units'], $stats['available_units'].' available', 'fa-th-large', '#2563eb', route('admin.projects.index')],
    ['Upcoming / ongoing', ($byStatus['upcoming'] ?? 0).' / '.($byStatus['ongoing'] ?? 0), ($byStatus['completed'] ?? 0).' completed · '.($byStatus['sold_out'] ?? 0).' sold out', 'fa-line-chart', '#16a34a', route('admin.projects.index')],
  ] as [$label, $value, $sub, $icon, $color, $link])
    <div class="col-sm-6 col-xl-3">
      <a href="{{ $link }}" class="adm-card adm-stat d-flex text-reset text-decoration-none">
        <div class="adm-stat-icon" style="background: {{ $color }}"><i class="fa {{ $icon }}"></i></div>
        <div>
          <div class="adm-stat-value">{{ $value }}</div>
          <div class="adm-stat-label">{{ $label }}</div>
          <div class="small text-muted">{{ $sub }}</div>
        </div>
      </a>
    </div>
  @endforeach
</div>

<div class="row">
  <div class="col-xl-8">
    <div class="adm-card">
      <div class="adm-card-header"><h2>Enquiries – last 14 days</h2></div>
      <div class="adm-card-body">
        @php $max = max(1, $trend->max('total')); @endphp
        <div class="d-flex align-items-end" style="gap:6px;height:140px" role="img" aria-label="Enquiries per day for the last 14 days">
          @foreach ($trend as $d)
            <div class="flex-fill text-center" title="{{ $d['day'] }}: {{ $d['total'] }}">
              <div class="small text-muted" style="font-size:11px">{{ $d['total'] ?: '' }}</div>
              <div style="height: {{ max(2, round($d['total'] / $max * 110)) }}px; background: {{ $d['total'] ? '#c9a54a' : '#e5e7eb' }}; border-radius: 4px 4px 0 0"></div>
            </div>
          @endforeach
        </div>
        <div class="d-flex justify-content-between small text-muted mt-1"><span>{{ $trend->first()['day'] }}</span><span>Today</span></div>
      </div>
    </div>

    <div class="adm-card">
      <div class="adm-card-header"><h2>Latest enquiries</h2><a href="{{ route('admin.enquiries.index') }}" class="ml-auto small">View all</a></div>
      @if ($latestEnquiries->isEmpty())
        <div class="adm-empty"><i class="fa fa-inbox"></i>No enquiries yet. Website form submissions will appear here.</div>
      @else
        <div class="table-responsive">
          <table class="table adm-table mb-0">
            <tbody>
            @foreach ($latestEnquiries as $e)
              <tr>
                <td><strong>{{ $e->name }}</strong><div class="small text-muted">{{ $e->phone }}</div></td>
                <td class="small">{{ \App\Models\Enquiry::TYPES[$e->type] ?? $e->type }} @if ($e->project)<div class="text-muted">{{ $e->project->name }}</div>@endif</td>
                <td class="small text-muted text-nowrap">{{ $e->created_at->diffForHumans() }}</td>
                <td><span class="adm-pill adm-pill-{{ $e->status }}">{{ \App\Models\Enquiry::STATUSES[$e->status] }}</span></td>
                <td class="adm-actions-cell"><a class="btn btn-sm btn-light" href="{{ route('admin.enquiries.show', $e) }}">Open</a></td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>

  <div class="col-xl-4">
    <div class="adm-card">
      <div class="adm-card-header"><h2>Recently updated projects</h2></div>
      <ul class="list-unstyled mb-0">
        @forelse ($recentProjects as $p)
          <li class="d-flex align-items-center px-3 py-2 border-bottom" style="gap:12px">
            <img src="{{ $p->coverUrl() }}" class="adm-thumb" style="width:48px;height:36px" alt="">
            <div class="flex-fill">
              <a href="{{ route('admin.projects.edit', $p) }}" class="font-weight-bold text-reset">{{ $p->name }}</a>
              <div class="small text-muted">{{ $p->updated_at->diffForHumans() }}</div>
            </div>
            <span class="adm-pill adm-pill-{{ $p->status }}">{{ \App\Models\Project::STATUSES[$p->status] }}</span>
          </li>
        @empty
          <li class="adm-empty">No projects yet.</li>
        @endforelse
      </ul>
    </div>

    <div class="adm-card">
      <div class="adm-card-header"><h2>Recent activity</h2></div>
      <ul class="list-unstyled mb-0">
        @forelse ($activity as $log)
          <li class="px-3 py-2 border-bottom small">
            <i class="fa {{ ['created' => 'fa-plus-circle text-success', 'updated' => 'fa-pencil text-primary', 'deleted' => 'fa-trash text-danger'][$log->action] ?? 'fa-circle-o' }} mr-1"></i>
            {{ $log->description }}
            <div class="text-muted">{{ $log->user?->name ?? 'System' }} · {{ $log->created_at->diffForHumans() }}</div>
          </li>
        @empty
          <li class="adm-empty">Changes you make in the admin will be listed here.</li>
        @endforelse
      </ul>
    </div>
  </div>
</div>
@endsection
