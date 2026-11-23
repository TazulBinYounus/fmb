@extends('admin.layout')

@section('title', 'Testimonials')

@section('actions')
  <a href="{{ route('admin.testimonials.create') }}" class="btn btn-accent btn-sm"><i class="fa fa-plus"></i> New testimonial</a>
@endsection

@section('content')
<div class="adm-card">
  @if ($testimonials->isEmpty())
    <div class="adm-empty"><i class="fa fa-quote-left"></i>No testimonials yet. Add real quotes from flat owners or buyers – the homepage section stays hidden until you do.</div>
  @else
  <div class="table-responsive">
    <table class="table adm-table">
      <thead><tr><th></th><th>Name</th><th>Quote</th><th>Project</th><th>Status</th><th></th></tr></thead>
      <tbody>
      @foreach ($testimonials as $t)
        <tr>
          <td style="width:60px">@if ($t->photo)<img src="{{ media_url($t->photo) }}" class="adm-thumb" style="width:44px;height:44px;border-radius:50%" alt="">@else<i class="fa fa-user-circle fa-2x text-muted"></i>@endif</td>
          <td><strong>{{ $t->name }}</strong><div class="small text-muted">{{ $t->designation }}</div></td>
          <td class="small">{{ \Illuminate\Support\Str::limit($t->quote, 90) }}</td>
          <td class="small">{{ $t->project?->name ?? '—' }}</td>
          <td><span class="adm-pill {{ $t->is_active ? 'adm-pill-on' : 'adm-pill-off' }}">{{ $t->is_active ? 'Shown' : 'Hidden' }}</span></td>
          <td class="adm-actions-cell">
            <a class="btn btn-sm btn-light" href="{{ route('admin.testimonials.edit', $t) }}"><i class="fa fa-pencil"></i> Edit</a>
            <form method="post" action="{{ route('admin.testimonials.destroy', $t) }}" data-confirm="Delete this testimonial?">@csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger" type="submit" title="Delete"><i class="fa fa-trash"></i></button>
            </form>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
  @endif
</div>
@endsection
