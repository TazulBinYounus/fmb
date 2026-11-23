@extends('admin.layout')

@section('title', 'FAQs')

@section('actions')
  <a href="{{ route('admin.faqs.create') }}" class="btn btn-accent btn-sm"><i class="fa fa-plus"></i> New FAQ</a>
@endsection

@section('content')
<div class="adm-card">
  @if ($faqs->isEmpty())
    <div class="adm-empty"><i class="fa fa-question-circle"></i>No FAQs yet. Real-estate FAQs appear on the homepage and the Real Estate page; landowner FAQs on the Landowners page.</div>
  @else
  <div class="table-responsive">
    <table class="table adm-table">
      <thead><tr><th>Question</th><th>Category</th><th>Order</th><th>Status</th><th></th></tr></thead>
      <tbody>
      @foreach ($faqs as $faq)
        <tr>
          <td><strong>{{ $faq->question }}</strong><div class="small text-muted">{{ \Illuminate\Support\Str::limit($faq->answer, 100) }}</div></td>
          <td class="small">{{ \App\Models\Faq::CATEGORIES[$faq->category] ?? $faq->category }}</td>
          <td>{{ $faq->sort_order }}</td>
          <td><span class="adm-pill {{ $faq->is_active ? 'adm-pill-on' : 'adm-pill-off' }}">{{ $faq->is_active ? 'Shown' : 'Hidden' }}</span></td>
          <td class="adm-actions-cell">
            <a class="btn btn-sm btn-light" href="{{ route('admin.faqs.edit', $faq) }}"><i class="fa fa-pencil"></i> Edit</a>
            <form method="post" action="{{ route('admin.faqs.destroy', $faq) }}" data-confirm="Delete this FAQ?">@csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger" type="submit" title="Delete"><i class="fa fa-trash"></i></button>
            </form>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
  @endif
</div>
@endsection
