@extends('admin.layout')

@section('title', 'Enquiries')

@section('actions')
  <a href="{{ route('admin.enquiries.export', request()->query()) }}" class="btn btn-light btn-sm"><i class="fa fa-download"></i> Export CSV</a>
@endsection

@section('content')
<div class="adm-card">
  <div class="adm-card-header">
    <ul class="nav nav-pills">
      <li class="nav-item"><a class="nav-link {{ request('status') ? '' : 'active' }}" href="{{ route('admin.enquiries.index', request()->except('status', 'page')) }}">All ({{ $counts->sum() }})</a></li>
      @foreach (\App\Models\Enquiry::STATUSES as $k => $v)
        <li class="nav-item"><a class="nav-link {{ request('status') === $k ? 'active' : '' }}" href="{{ route('admin.enquiries.index', array_merge(request()->except('page'), ['status' => $k])) }}">{{ $v }} ({{ $counts[$k] ?? 0 }})</a></li>
      @endforeach
    </ul>
    <form class="form-inline ml-auto" method="get" data-no-loading>
      <input type="hidden" name="status" value="{{ request('status') }}">
      <select name="type" class="form-control form-control-sm custom-select mr-2" onchange="this.form.submit()">
        <option value="">All types</option>
        @foreach (\App\Models\Enquiry::TYPES as $k => $v)<option value="{{ $k }}" @selected(request('type') === $k)>{{ $v }}</option>@endforeach
      </select>
      <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm mr-2" placeholder="Name, phone or email">
      <button class="btn btn-light btn-sm" type="submit"><i class="fa fa-search"></i></button>
    </form>
  </div>
  @if ($enquiries->isEmpty())
    <div class="adm-empty"><i class="fa fa-inbox"></i>No enquiries {{ request()->hasAny(['status', 'type', 'q']) ? 'match this filter' : 'yet' }}.</div>
  @else
  <div class="table-responsive">
    <table class="table adm-table">
      <thead><tr><th>Received</th><th>Name</th><th>Phone</th><th>Type</th><th>Subject / project</th><th>Status</th><th></th></tr></thead>
      <tbody>
      @foreach ($enquiries as $e)
        <tr class="{{ $e->status === 'new' ? 'font-weight-bold' : '' }}">
          <td class="small text-nowrap">{{ $e->created_at->format('d M Y, H:i') }}<div class="text-muted">{{ $e->created_at->diffForHumans() }}</div></td>
          <td>{{ $e->name }}<div class="small text-muted">{{ $e->email }}</div></td>
          <td class="text-nowrap"><a href="tel:{{ $e->phone }}">{{ $e->phone }}</a></td>
          <td class="small">{{ \App\Models\Enquiry::TYPES[$e->type] ?? $e->type }}</td>
          <td class="small">{{ \Illuminate\Support\Str::limit($e->subject, 50) }} @if ($e->project)<div class="text-muted">{{ $e->project->name }}</div>@endif</td>
          <td><span class="adm-pill adm-pill-{{ $e->status }}">{{ \App\Models\Enquiry::STATUSES[$e->status] ?? $e->status }}</span></td>
          <td class="adm-actions-cell"><a class="btn btn-sm btn-light" href="{{ route('admin.enquiries.show', $e) }}">Open</a></td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
  <div class="px-3">{{ $enquiries->links('pagination::bootstrap-4') }}</div>
  @endif
</div>
@endsection
