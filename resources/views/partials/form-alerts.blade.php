@if (session('contact_success'))
  <div class="alert alert-success">{{ __('Thank you! Your message has been sent. We will contact you soon.') }}</div>
@endif
@if (session('contact_error'))
  <div class="alert alert-danger">{{ __('Sorry, your message could not be sent. Please email or WhatsApp us directly.') }}</div>
@endif
@if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb0">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
