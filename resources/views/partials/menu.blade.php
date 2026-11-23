{{-- Recursive menu list. Expects $items (MenuItem collection) and $level. --}}
@foreach ($items as $item)
  <li class="{{ $level === 0 && $item->children->isEmpty() ? 'last' : '' }}">
    <a href="{{ $item->href() }}" @if ($item->open_in_new_tab) target="_blank" rel="noopener" @endif>
      @if ($level < 2)<span class="title">{{ $item->tr('label') }}</span>@else{{ $item->tr('label') }}@endif
    </a>
    @if ($item->children->isNotEmpty())
      <ul>
        @include('partials.menu', ['items' => $item->children, 'level' => $level + 1])
      </ul>
    @endif
  </li>
@endforeach
