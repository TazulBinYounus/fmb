@extends('admin.layout')

@section('title', 'Pages')

@section('actions')
  <a href="{{ route('admin.pages.create') }}" class="btn btn-accent btn-sm"><i class="fa fa-plus"></i> New page</a>
@endsection

@section('content')
<div class="adm-card">
  @if ($pages->isEmpty())
    <div class="adm-empty"><i class="fa fa-file-text-o"></i>No pages yet.</div>
  @else
  <div class="table-responsive">
    <table class="table adm-table">
      <thead><tr><th>Title</th><th>Address</th><th>Status</th><th>Updated</th><th></th></tr></thead>
      <tbody>
      @foreach ($pages as $page)
        <tr>
          <td><strong>{{ $page->title }}</strong> @if ($page->isSystem())<span class="badge badge-light ml-1" title="Used by the website">built-in</span>@endif</td>
          <td><a href="{{ $page->publicUrl() }}" target="_blank" rel="noopener" class="small">{{ parse_url($page->publicUrl(), PHP_URL_PATH) }}</a></td>
          <td><span class="adm-pill {{ $page->is_published ? 'adm-pill-on' : 'adm-pill-off' }}">{{ $page->is_published ? 'Published' : 'Hidden' }}</span></td>
          <td class="text-muted small">{{ $page->updated_at->diffForHumans() }}</td>
          <td class="adm-actions-cell">
            <a class="btn btn-sm btn-light" href="{{ route('admin.pages.edit', $page) }}"><i class="fa fa-pencil"></i> Edit</a>
            @unless ($page->isSystem())
              <form method="post" action="{{ route('admin.pages.destroy', $page) }}" data-confirm="Delete the page &quot;{{ $page->title }}&quot;?">@csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger" type="submit" title="Delete"><i class="fa fa-trash"></i></button>
              </form>
            @endunless
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
  @endif
</div>
<p class="text-muted small">Tip: to show a new page in the navigation, add it under <a href="{{ route('admin.menus.index') }}">Menus</a>.</p>
@endsection
