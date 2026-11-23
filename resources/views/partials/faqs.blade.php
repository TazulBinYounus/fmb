{{-- Expects $faqs (collection) and optional $id. Renders nothing when empty. --}}
@if ($faqs->isNotEmpty())
@php $accId = $id ?? 'faq'; @endphp
<section class="{{ $class ?? 'pt50 pb50' }}">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <h2 class="text-center mb30">{{ __('Frequently Asked Questions') }}</h2>
        <div class="bd-faq" id="{{ $accId }}">
          @foreach ($faqs as $faq)
            <details class="bd-faq-item" @if ($loop->first) open @endif>
              <summary>{{ $faq->tr('question') }}</summary>
              <div class="bd-faq-answer">{!! nl2br(e($faq->tr('answer'))) !!}</div>
            </details>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>
@push('head')
<script type="application/ld+json">
{!! json_encode([
  '@context' => 'https://schema.org',
  '@type' => 'FAQPage',
  'mainEntity' => $faqs->map(fn ($f) => ['@type' => 'Question', 'name' => $f->tr('question'), 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f->tr('answer')]])->values(),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}
</script>
@endpush
@endif
