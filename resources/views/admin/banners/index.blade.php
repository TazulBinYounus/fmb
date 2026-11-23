@extends('admin.layout')

@section('title', 'Home banners')

@section('actions')
  <a href="{{ route('admin.banners.create') }}" class="btn btn-accent btn-sm"><i class="fa fa-plus"></i> New banner</a>
@endsection

@section('content')
<div class="adm-card">
  <div class="adm-card-header"><h2>Homepage slider</h2><span class="text-muted small ml-2">Active banners rotate at the top of the homepage, in display order.</span></div>
  @if ($banners->isEmpty())
    <div class="adm-empty"><i class="fa fa-picture-o"></i>No banners yet. <a href="{{ route('admin.banners.create') }}">Add one</a>.</div>
  @else
  <div class="table-responsive">
    <table class="table adm-table">
      <thead><tr><th></th><th>Title</th><th>Button</th><th>Order</th><th>Status</th><th></th></tr></thead>
      <tbody>
      @foreach ($banners as $banner)
        <tr>
          <td style="width:130px"><img src="{{ media_url($banner->image) }}" alt="" class="adm-thumb" style="width:110px;height:56px"></td>
          <td><strong>{{ $banner->title }}</strong><div class="text-muted small">{{ $banner->subtitle }}</div></td>
          <td class="small">{{ $banner->button_text ?: '—' }} @if ($banner->button_link)<div class="text-muted">{{ $banner->button_link }}</div>@endif</td>
          <td>{{ $banner->sort_order }}</td>
          <td><span class="adm-pill {{ $banner->is_active ? 'adm-pill-on' : 'adm-pill-off' }}">{{ $banner->is_active ? 'Active' : 'Hidden' }}</span></td>
          <td class="adm-actions-cell">
            <a class="btn btn-sm btn-light" href="{{ route('admin.banners.edit', $banner) }}"><i class="fa fa-pencil"></i> Edit</a>
            <form method="post" action="{{ route('admin.banners.destroy', $banner) }}" data-confirm="Delete this banner?">@csrf @method('DELETE')
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
