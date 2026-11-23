@extends('layout')

@section('title', __('Our Projects').' – FMB Developments')
@section('description', __('Apartment projects by FMB Developments Ltd in Dhaka: upcoming, ongoing and completed residential buildings.'))

@section('content')

<section class="inner_page_breadcrumb">
  <div class="container">
    <div class="row">
      <div class="col-xl-8">
        <div class="breadcrumb_content">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('development') }}">{{ __('Real Estate') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Our Projects') }}</li>
          </ol>
          <h4 class="breadcrumb_title">{{ __('Our Projects') }}</h4>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="pt50 pb30">
  <div class="container">
    <ul class="nav nav-pills justify-content-center mb40 bd-filter" aria-label="{{ __('Filter by status') }}">
      <li class="nav-item"><a class="nav-link {{ $status ? '' : 'active' }}" href="{{ route('projects.index', array_filter(['type' => $type])) }}">{{ __('All') }} ({{ $counts->sum() }})</a></li>
      @foreach (\App\Models\Project::STATUSES as $key => $label)
        @if (($counts[$key] ?? 0) > 0)
          <li class="nav-item"><a class="nav-link {{ $status === $key ? 'active' : '' }}" href="{{ route('projects.index', array_filter(['status' => $key, 'type' => $type])) }}">{{ __($label) }} ({{ $counts[$key] }})</a></li>
        @endif
      @endforeach
    </ul>

    @if ($projects->isEmpty())
      <p class="text-center text-muted">{{ __('New projects are coming soon. Contact us to register your interest.') }}</p>
    @else
      <div class="row">
        @foreach ($projects as $project)
          <div class="col-md-6 col-lg-4">@include('partials.project-card', ['project' => $project])</div>
        @endforeach
      </div>
      <div class="d-flex justify-content-center">{{ $projects->links('pagination::bootstrap-4') }}</div>
    @endif
  </div>
</section>

@endsection
