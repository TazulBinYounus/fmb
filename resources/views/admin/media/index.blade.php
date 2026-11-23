@extends('admin.layout')

@section('title', 'Media library')

@section('content')
<div class="adm-card">
  <div class="adm-card-header">
    <h2>Upload files</h2>
    <form method="post" enctype="multipart/form-data" action="{{ route('admin.media.store') }}" class="form-inline ml-auto">
      @csrf
      <div class="custom-file mr-2" style="width:260px">
        <input type="file" class="custom-file-input" id="media_files" name="files[]" multiple required accept="image/jpeg,image/png,image/webp,application/pdf">
        <label class="custom-file-label" for="media_files">Choose images or PDFs</label>
      </div>
      <button class="btn btn-accent btn-sm" type="submit"><i class="fa fa-upload"></i> Upload</button>
    </form>
  </div>
  <div class="adm-card-body py-2 small text-muted">
    Every file uploaded anywhere in the admin is listed here. Use <i class="fa fa-link"></i> to copy a file’s address, for example to add an image to a page.
  </div>
</div>

<div class="adm-card">
  <div class="adm-card-header">
    <ul class="nav nav-pills">
      @foreach (['' => 'All', 'images' => 'Images', 'documents' => 'PDFs'] as $k => $v)
        <li class="nav-item"><a class="nav-link {{ request('type', '') === $k ? 'active' : '' }}" href="{{ route('admin.media.index', array_filter(['type' => $k, 'q' => request('q')])) }}">{{ $v }}</a></li>
      @endforeach
    </ul>
    <form class="form-inline ml-auto" method="get" data-no-loading>
      <input type="hidden" name="type" value="{{ request('type') }}">
      <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm mr-2" placeholder="Search file name">
      <button class="btn btn-light btn-sm" type="submit"><i class="fa fa-search"></i></button>
    </form>
  </div>
  <div class="adm-card-body">
    @if ($media->isEmpty())
      <div class="adm-empty"><i class="fa fa-folder-open-o"></i>No files yet.</div>
    @else
      <div class="adm-media-grid">
        @foreach ($media as $m)
          <div class="adm-media-item">
            <a href="{{ $m->url() }}" target="_blank" rel="noopener" class="d-block">
              @if ($m->isImage())
                <div class="adm-media-thumb" style="background-image:url('{{ $m->url() }}')"></div>
              @else
                <div class="adm-media-thumb"><i class="fa fa-file-pdf-o"></i></div>
              @endif
            </a>
            <div class="adm-media-meta">
              <div class="adm-media-name" title="{{ $m->original_name }}">{{ $m->original_name }}</div>
              <div class="text-muted">{{ $m->humanSize() }} @if ($m->width)· {{ $m->width }}×{{ $m->height }}@endif</div>
              <div class="d-flex align-items-center mt-1" style="gap:4px">
                @if ($m->in_use)<span class="badge badge-success">In use</span>@endif
                <button type="button" class="btn btn-light btn-sm ml-auto" title="Copy link" data-copy="{{ $m->url() }}"><i class="fa fa-link"></i></button>
                <form method="post" action="{{ route('admin.media.destroy', $m) }}" data-confirm="Delete {{ $m->original_name }}? This cannot be undone.">@csrf @method('DELETE')
                  <button class="btn btn-outline-danger btn-sm" type="submit" title="{{ $m->in_use ? 'In use – replace it where it is used first' : 'Delete' }}" @disabled($m->in_use)><i class="fa fa-trash"></i></button>
                </form>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      <div class="mt-3">{{ $media->links('pagination::bootstrap-4') }}</div>
    @endif
  </div>
</div>
@endsection
