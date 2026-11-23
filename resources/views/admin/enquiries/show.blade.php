@extends('admin.layout')

@section('title', 'Enquiry from '.$enquiry->name)

@section('actions')
  <a href="{{ route('admin.enquiries.index') }}" class="btn btn-light btn-sm"><i class="fa fa-arrow-left"></i> All enquiries</a>
@endsection

@section('content')
@php
  $digits = preg_replace('/\D/', '', $enquiry->phone);
  $wa = str_starts_with($digits, '880') ? $digits : (str_starts_with($digits, '01') ? '88'.$digits : $digits);
@endphp
<div class="row">
  <div class="col-xl-8">
    <div class="adm-card">
      <div class="adm-card-header">
        <h2>{{ $enquiry->subject ?: (\App\Models\Enquiry::TYPES[$enquiry->type] ?? 'Enquiry') }}</h2>
        <span class="adm-pill adm-pill-{{ $enquiry->status }} ml-auto">{{ \App\Models\Enquiry::STATUSES[$enquiry->status] }}</span>
      </div>
      <div class="adm-card-body">
        <dl class="row mb-0">
          <dt class="col-sm-3">Received</dt><dd class="col-sm-9">{{ $enquiry->created_at->format('l, d M Y \a\t H:i') }} (Dhaka time)</dd>
          <dt class="col-sm-3">Type</dt><dd class="col-sm-9">{{ \App\Models\Enquiry::TYPES[$enquiry->type] ?? $enquiry->type }}</dd>
          <dt class="col-sm-3">Name</dt><dd class="col-sm-9">{{ $enquiry->name }}</dd>
          <dt class="col-sm-3">Phone</dt><dd class="col-sm-9"><a href="tel:{{ $enquiry->phone }}">{{ $enquiry->phone }}</a></dd>
          @if ($enquiry->email)<dt class="col-sm-3">Email</dt><dd class="col-sm-9"><a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a></dd>@endif
          @if ($enquiry->company)<dt class="col-sm-3">Company</dt><dd class="col-sm-9">{{ $enquiry->company }}</dd>@endif
          @if ($enquiry->project)<dt class="col-sm-3">Project</dt><dd class="col-sm-9"><a href="{{ route('admin.projects.edit', $enquiry->project) }}">{{ $enquiry->project->name }}</a></dd>@endif
          @foreach ($enquiry->details ?? [] as $key => $value)
            <dt class="col-sm-3">{{ ucfirst(str_replace('_', ' ', $key)) }}</dt><dd class="col-sm-9">{{ $value }}</dd>
          @endforeach
        </dl>
        @if ($enquiry->message)
          <hr>
          <p class="mb-0" style="white-space:pre-line">{{ $enquiry->message }}</p>
        @endif
      </div>
    </div>
  </div>
  <div class="col-xl-4">
    <div class="adm-card"><div class="adm-card-body">
      <a href="tel:{{ $enquiry->phone }}" class="btn btn-accent btn-block mb-2"><i class="fa fa-phone"></i> Call {{ $enquiry->phone }}</a>
      <a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener" class="btn btn-success btn-block mb-2"><i class="fa fa-whatsapp"></i> WhatsApp</a>
      @if ($enquiry->email)
        <a href="mailto:{{ $enquiry->email }}?subject={{ rawurlencode('Re: '.($enquiry->subject ?: 'Your enquiry')) }}" class="btn btn-light btn-block mb-3"><i class="fa fa-envelope"></i> Reply by email</a>
      @endif
      <form method="post" action="{{ route('admin.enquiries.update', $enquiry) }}" class="mb-3">
        @csrf @method('PATCH')
        <label for="status" class="font-weight-bold small">Status</label>
        <div class="input-group">
          <select id="status" name="status" class="form-control custom-select">
            @foreach (\App\Models\Enquiry::STATUSES as $k => $v)<option value="{{ $k }}" @selected($enquiry->status === $k)>{{ $v }}</option>@endforeach
          </select>
          <div class="input-group-append"><button class="btn btn-light" type="submit">Update</button></div>
        </div>
      </form>
      <form method="post" action="{{ route('admin.enquiries.destroy', $enquiry) }}" data-confirm="Delete this enquiry permanently?">
        @csrf @method('DELETE')
        <button class="btn btn-outline-danger btn-block btn-sm" type="submit"><i class="fa fa-trash"></i> Delete enquiry</button>
      </form>
    </div></div>
  </div>
</div>
@endsection
