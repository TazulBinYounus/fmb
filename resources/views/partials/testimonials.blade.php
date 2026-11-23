{{-- Expects $testimonials (collection). Renders nothing when empty. --}}
@if ($testimonials->isNotEmpty())
<section class="{{ $class ?? 'bgc-f7 pt50 pb30' }}">
  <div class="container">
    <div class="main-title text-center">
      <h2>{{ __('What Our Clients Say') }}</h2>
    </div>
    <div class="row justify-content-center">
      @foreach ($testimonials as $t)
        <div class="col-md-6 col-lg-4">
          <figure class="bd-testimonial">
            @if ($t->rating)<div class="bd-stars" aria-label="{{ $t->rating }} / 5">{{ str_repeat('★', $t->rating) }}<span>{{ str_repeat('★', 5 - $t->rating) }}</span></div>@endif
            <blockquote>“{{ $t->tr('quote') }}”</blockquote>
            <figcaption>
              @if ($t->photo)<img src="{{ media_url($t->photo) }}" alt="" loading="lazy">@else<span class="bd-avatar">{{ mb_substr($t->tr('name'), 0, 1) }}</span>@endif
              <div>
                <strong>{{ $t->tr('name') }}</strong>
                @if ($t->tr('designation') || $t->project)
                  <div class="small text-muted">{{ collect([$t->tr('designation'), $t->project?->tr('name')])->filter()->implode(' · ') }}</div>
                @endif
              </div>
            </figcaption>
          </figure>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif
