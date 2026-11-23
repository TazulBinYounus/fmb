<tr>
  <td style="padding-left: {{ 16 + $depth * 28 }}px">
    @if ($depth)<span class="text-muted">└</span>@endif
    <strong>{{ $item->label }}</strong> @if ($item->label_bn)<span class="text-muted small">· {{ $item->label_bn }}</span>@endif
  </td>
  <td class="small text-muted">{{ $item->url }} @if ($item->open_in_new_tab)<i class="fa fa-external-link" title="Opens in a new tab"></i>@endif</td>
  <td>{{ $item->sort_order }}</td>
  <td><span class="adm-pill {{ $item->is_active ? 'adm-pill-on' : 'adm-pill-off' }}">{{ $item->is_active ? 'Shown' : 'Hidden' }}</span></td>
  <td class="adm-actions-cell">
    @if ($depth < 2 && $item->location === 'header')
      <a class="btn btn-sm btn-light" href="{{ route('admin.menus.create', ['location' => $item->location, 'parent' => $item->id]) }}" title="Add sub-item"><i class="fa fa-plus"></i></a>
    @endif
    <a class="btn btn-sm btn-light" href="{{ route('admin.menus.edit', $item) }}"><i class="fa fa-pencil"></i> Edit</a>
    <form method="post" action="{{ route('admin.menus.destroy', $item) }}" data-confirm="Delete &quot;{{ $item->label }}&quot;{{ $item->allChildren->isNotEmpty() ? ' and its sub-items' : '' }}?">@csrf @method('DELETE')
      <button class="btn btn-sm btn-outline-danger" type="submit" title="Delete"><i class="fa fa-trash"></i></button>
    </form>
  </td>
</tr>
@foreach ($item->allChildren as $child)
  @include('admin.menus.row', ['item' => $child, 'depth' => $depth + 1])
@endforeach
