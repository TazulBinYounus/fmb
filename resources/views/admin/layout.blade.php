<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="robots" content="noindex, nofollow">
  <title>@yield('title', 'Dashboard') · FMB Admin</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/images/fmb-favicon.png') }}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Hind+Siliguri:wght@400;600&display=swap">
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/admin.css') }}?v=1">
</head>
<body class="adm">
@php
  $newEnquiries = \App\Models\Enquiry::where('status', 'new')->count();
  $nav = [
    ['Overview'],
    ['admin.dashboard', 'fa-tachometer', 'Dashboard'],
    ['admin.enquiries.index', 'fa-inbox', 'Enquiries', $newEnquiries],
    ['Real estate'],
    ['admin.projects.index', 'fa-building', 'Projects'],
    ['Website content'],
    ['admin.banners.index', 'fa-picture-o', 'Home banners'],
    ['admin.settings.edit', 'fa-home', 'Homepage & settings'],
    ['admin.pages.index', 'fa-file-text-o', 'Pages'],
    ['admin.testimonials.index', 'fa-quote-left', 'Testimonials'],
    ['admin.faqs.index', 'fa-question-circle', 'FAQs'],
    ['admin.menus.index', 'fa-bars', 'Menus'],
    ['admin.media.index', 'fa-folder-open', 'Media library'],
    ['Account'],
    ['admin.profile.edit', 'fa-user', 'My profile'],
  ];
@endphp

<aside class="adm-sidebar" aria-label="Admin navigation">
  <a href="{{ route('admin.dashboard') }}" class="adm-brand">
    <img src="{{ asset('assets/images/fmb-logo-white.png') }}" alt="">
    <span>FMB Admin</span>
  </a>
  <ul class="adm-nav">
    @foreach ($nav as $item)
      @if (count($item) === 1)
        <li class="adm-nav-label">{{ $item[0] }}</li>
      @else
        @php $base = preg_replace('/\.(index|edit)$/', '', $item[0]); @endphp
        <li>
          <a href="{{ route($item[0]) }}" class="{{ request()->routeIs($base.'*') ? 'active' : '' }}">
            <i class="fa {{ $item[1] }}"></i> {{ $item[2] }}
            @if (!empty($item[3]))<span class="badge badge-danger">{{ $item[3] }}</span>@endif
          </a>
        </li>
      @endif
    @endforeach
    <li class="adm-nav-label">Site</li>
    <li><a href="{{ url('/') }}" target="_blank" rel="noopener"><i class="fa fa-external-link"></i> View website</a></li>
  </ul>
</aside>

<div class="adm-main">
  <header class="adm-topbar">
    <button class="adm-toggle" type="button" data-adm-toggle aria-label="Open menu"><i class="fa fa-bars"></i></button>
    <h1>@yield('title', 'Dashboard')</h1>
    <div class="adm-actions">
      @yield('actions')
      <div class="dropdown">
        <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
          <i class="fa fa-user-circle"></i> <span class="d-none d-sm-inline">{{ auth()->user()->name }}</span>
        </button>
        <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="{{ route('admin.profile.edit') }}"><i class="fa fa-user mr-2"></i>My profile</a>
          <div class="dropdown-divider"></div>
          <form method="post" action="{{ route('admin.logout') }}">
            @csrf
            <button class="dropdown-item" type="submit" data-no-loading><i class="fa fa-sign-out mr-2"></i>Log out</button>
          </form>
        </div>
      </div>
    </div>
  </header>

  <main class="adm-content">
    @include('admin.partials.flash')
    @yield('content')
  </main>
  <footer class="adm-footer">FMB Group admin · Changes appear on the website immediately after saving.</footer>
</div>

<script src="{{ asset('assets/js/jquery-3.3.1.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/admin/admin.js') }}?v=1"></script>
@stack('scripts')
</body>
</html>
