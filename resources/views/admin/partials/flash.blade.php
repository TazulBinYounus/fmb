@if (session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert" data-autohide>
    <i class="fa fa-check-circle mr-1"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  </div>
@endif
@if (session('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fa fa-exclamation-triangle mr-1"></i> {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  </div>
@endif
@if ($errors->any())
  <div class="alert alert-danger" role="alert">
    <strong><i class="fa fa-exclamation-triangle mr-1"></i> Please fix the following:</strong>
    <ul class="mb-0 mt-1">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
