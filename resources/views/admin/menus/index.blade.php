@extends('admin.layout')

@section('title', 'Menus')

@section('actions')
  <a href="{{ route('admin.menus.create', ['location' => $location]) }}" class="btn btn-accent btn-sm"><i class="fa fa-plus"></i> New menu item</a>
@endsection

@section('content')
<div class="adm-card">
  <div class="adm-card-header">
    <ul class="nav nav-pills">
      @foreach (\App\Models\MenuItem::LOCATIONS as $key => $label)
        <li class="nav-item"><a class="nav-link {{ $location === $key ? 'active' : '' }}" href="{{ route('admin.menus.index', ['location' => $key]) }}">{{ $label }}</a></li>
      @endforeach
    </ul>
    <span class="text-muted small ml-auto">Lower order numbers appear first. Header items can have two levels of sub-items.</span>
  </div>
  @if ($tree->isEmpty())
    <div class="adm-empty"><i class="fa fa-bars"></i>This menu is empty.</div>
  @else
  <div class="table-responsive">
    <table class="table adm-table">
      <thead><tr><th>Label</th><th>Link</th><th>Order</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @foreach ($tree as $item)
          @include('admin.menus.row', ['item' => $item, 'depth' => 0])
        @endforeach
      </tbody>
    </table>
  </div>
  @endif
</div>
@endsection
