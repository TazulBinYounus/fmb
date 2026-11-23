@extends('admin.layout')

@section('title', 'My profile')

@section('content')
<div class="row">
  <div class="col-lg-6">
    <div class="adm-card">
      <div class="adm-card-header"><h2>Account details</h2></div>
      <div class="adm-card-body">
        <form method="post" action="{{ route('admin.profile.update') }}">
          @csrf @method('PUT')
          <x-admin.input name="name" label="Name" :value="$user->name" required />
          <x-admin.input name="email" label="Login email" type="email" :value="$user->email" required />
          <p class="small text-muted">Last login: {{ $user->last_login_at?->format('d M Y, H:i') ?? '—' }}</p>
          <button class="btn btn-accent" type="submit"><i class="fa fa-save"></i> Save</button>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="adm-card">
      <div class="adm-card-header"><h2>Change password</h2></div>
      <div class="adm-card-body">
        <form method="post" action="{{ route('admin.profile.password') }}">
          @csrf @method('PUT')
          <x-admin.input name="current_password" label="Current password" type="password" required autocomplete="current-password" />
          <x-admin.input name="password" label="New password" type="password" required autocomplete="new-password" help="At least 8 characters, with letters and numbers." />
          <x-admin.input name="password_confirmation" label="Repeat new password" type="password" required autocomplete="new-password" />
          <button class="btn btn-accent" type="submit"><i class="fa fa-key"></i> Change password</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
