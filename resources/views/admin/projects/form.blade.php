@extends('admin.layout')

@php $isNew = ! $project->exists; @endphp
@section('title', $isNew ? 'New project' : 'Edit: '.$project->name)

@section('actions')
  <a href="{{ route('admin.projects.index') }}" class="btn btn-light btn-sm"><i class="fa fa-arrow-left"></i> All projects</a>
  @if (! $isNew && $project->is_published)
    <a href="{{ route('project.show', $project) }}" target="_blank" rel="noopener" class="btn btn-light btn-sm"><i class="fa fa-external-link"></i> View</a>
  @endif
@endsection

@section('content')
<form method="post" enctype="multipart/form-data" action="{{ $isNew ? route('admin.projects.store') : route('admin.projects.update', $project) }}">
  @csrf
  @unless ($isNew) @method('PUT') @endunless

  <div class="row">
    <div class="col-xl-9">
      <div class="adm-card">
        <div class="adm-card-header p-0 px-3 pt-2">
          <ul class="nav nav-tabs adm-tabs border-0" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#t-basic" role="tab">Basic info</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#t-details" role="tab">Details & pricing</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#t-specs" role="tab">Specs & amenities</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#t-media" role="tab">Media</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#t-location" role="tab">Location</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#t-seo" role="tab">SEO</a></li>
          </ul>
        </div>
        <div class="adm-card-body tab-content">

          {{-- Basic --}}
          <div class="tab-pane fade show active" id="t-basic" role="tabpanel">
            <div class="row">
              <div class="col-md-6"><x-admin.input name="name" label="Project name" :value="$project->name" required /></div>
              <div class="col-md-6"><x-admin.input name="name_bn" label="Project name" :value="$project->name_bn" bn /></div>
              <div class="col-md-6"><x-admin.input name="slug" label="URL slug" :value="$project->slug" data-slug-source="#f_name" help="Used in the web address: /development/projects/your-slug. Leave empty to create it from the name." /></div>
              <div class="col-md-3"><x-admin.select name="type" label="Type" :options="\App\Models\Project::TYPES" :value="$project->type" required /></div>
              <div class="col-md-3"><x-admin.select name="status" label="Status" :options="\App\Models\Project::STATUSES" :value="$project->status" required /></div>
              <div class="col-md-6"><x-admin.textarea name="summary" label="Short summary" :value="$project->summary" rows="3" help="Shown on project cards (max 500 characters)." /></div>
              <div class="col-md-6"><x-admin.textarea name="summary_bn" label="Short summary" :value="$project->summary_bn" rows="3" bn /></div>
              <div class="col-12"><x-admin.textarea name="description" label="Full description" :value="$project->description" editor /></div>
              <div class="col-12"><x-admin.textarea name="description_bn" label="Full description" :value="$project->description_bn" editor bn /></div>
            </div>
          </div>

          {{-- Details & pricing --}}
          <div class="tab-pane fade" id="t-details" role="tabpanel">
            <div class="row">
              <div class="col-md-4"><x-admin.input name="price_from" label="Starting price (BDT)" type="number" step="1" min="0" :value="$project->price_from !== null ? (int) $project->price_from : null" help="Leave empty to hide prices." /></div>
              <div class="col-md-4"><x-admin.input name="price_to" label="Maximum price (BDT)" type="number" step="1" min="0" :value="$project->price_to !== null ? (int) $project->price_to : null" /></div>
              <div class="col-md-4"><x-admin.input name="price_note" label="Price note" :value="$project->price_note" placeholder="e.g. per flat, excl. parking" /></div>
              <div class="col-md-6"><x-admin.textarea name="payment_info" label="Payment information" :value="$project->payment_info" rows="5" help="Booking money, instalments, bank loan support … One point per line." /></div>
              <div class="col-md-6"><x-admin.textarea name="payment_info_bn" label="Payment information" :value="$project->payment_info_bn" rows="5" bn /></div>
              <div class="col-md-4"><x-admin.input name="handover_date" label="Expected handover" type="date" :value="$project->handover_date?->format('Y-m-d')" /></div>
            </div>
          </div>

          {{-- Specs & amenities --}}
          <div class="tab-pane fade" id="t-specs" role="tabpanel">
            <h3 class="h6 font-weight-bold">At a glance</h3>
            <p class="text-muted small">Any facts you like (land area, storeys, facing …). Rows with an empty value show "To be announced" on the website. Delete a row to hide it.</p>
            <div data-repeater>
              <template>
                <div class="adm-repeater-row">
                  <input class="form-control" name="specs[__INDEX__][label]" placeholder="Label, e.g. Land area">
                  <input class="form-control" name="specs[__INDEX__][label_bn]" placeholder="লেবেল (বাংলা)">
                  <input class="form-control" name="specs[__INDEX__][value]" placeholder="Value, e.g. 10 Katha">
                  <input class="form-control" name="specs[__INDEX__][value_bn]" placeholder="মান (বাংলা)">
                  <button type="button" class="btn btn-outline-danger" data-repeater-remove title="Remove"><i class="fa fa-times"></i></button>
                </div>
              </template>
              <div data-repeater-list>
                @foreach (old('specs', $project->specs ?? []) as $i => $row)
                  <div class="adm-repeater-row">
                    <input class="form-control" name="specs[{{ $i }}][label]" value="{{ $row['label'] ?? '' }}" placeholder="Label">
                    <input class="form-control" name="specs[{{ $i }}][label_bn]" value="{{ $row['label_bn'] ?? '' }}" placeholder="লেবেল (বাংলা)">
                    <input class="form-control" name="specs[{{ $i }}][value]" value="{{ $row['value'] ?? '' }}" placeholder="Value">
                    <input class="form-control" name="specs[{{ $i }}][value_bn]" value="{{ $row['value_bn'] ?? '' }}" placeholder="মান (বাংলা)">
                    <button type="button" class="btn btn-outline-danger" data-repeater-remove title="Remove"><i class="fa fa-times"></i></button>
                  </div>
                @endforeach
              </div>
              <button type="button" class="btn btn-light btn-sm" data-repeater-add><i class="fa fa-plus"></i> Add row</button>
            </div>

            <hr class="my-4">
            <h3 class="h6 font-weight-bold">Features & amenities</h3>
            <div data-repeater>
              <template>
                <div class="adm-repeater-row">
                  <input class="form-control" name="amenities[__INDEX__][name]" placeholder="e.g. Lift, Generator backup, Rooftop garden">
                  <input class="form-control" name="amenities[__INDEX__][name_bn]" placeholder="বাংলা">
                  <button type="button" class="btn btn-outline-danger" data-repeater-remove title="Remove"><i class="fa fa-times"></i></button>
                </div>
              </template>
              <div data-repeater-list>
                @foreach (old('amenities', $project->amenities ?? []) as $i => $row)
                  <div class="adm-repeater-row">
                    <input class="form-control" name="amenities[{{ $i }}][name]" value="{{ $row['name'] ?? '' }}">
                    <input class="form-control" name="amenities[{{ $i }}][name_bn]" value="{{ $row['name_bn'] ?? '' }}" placeholder="বাংলা">
                    <button type="button" class="btn btn-outline-danger" data-repeater-remove title="Remove"><i class="fa fa-times"></i></button>
                  </div>
                @endforeach
              </div>
              <button type="button" class="btn btn-light btn-sm" data-repeater-add><i class="fa fa-plus"></i> Add amenity</button>
            </div>
          </div>

          {{-- Media --}}
          <div class="tab-pane fade" id="t-media" role="tabpanel">
            <div class="row">
              <div class="col-md-6"><x-admin.image name="cover_image" label="Cover image" :current="$project->cover_image" help="Main photo for cards and the page header. Landscape, at least 1600 px wide." /></div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="f_gallery">{{ $isNew ? 'Gallery photos' : 'Add gallery photos' }}</label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="f_gallery" name="gallery[]" accept="image/jpeg,image/png,image/webp" multiple>
                    <label class="custom-file-label" for="f_gallery">Choose files</label>
                  </div>
                  <small class="form-text text-muted">Select several at once (max 30, 5 MB each). Manage captions and order below after saving.</small>
                </div>
              </div>
              <div class="col-md-6"><x-admin.input name="video_url" label="Video link" type="url" :value="$project->video_url" placeholder="https://www.youtube.com/watch?v=…" help="YouTube or Facebook video." /></div>
              <div class="col-md-6"><x-admin.image name="brochure" label="Brochure (PDF)" :current="$project->brochure" accept="application/pdf" help="PDF, max 15 MB." removable /></div>
            </div>
          </div>

          {{-- Location --}}
          <div class="tab-pane fade" id="t-location" role="tabpanel">
            <div class="row">
              <div class="col-md-6"><x-admin.input name="area" label="Area (short)" :value="$project->area" placeholder="e.g. Bashundhara Riverview" help="Used in titles like “Flat for sale in …”." /></div>
              <div class="col-md-6"><x-admin.input name="area_bn" label="Area (short)" :value="$project->area_bn" bn /></div>
              <div class="col-md-6"><x-admin.input name="location" label="Location" :value="$project->location" placeholder="e.g. Bashundhara Riverview Residential Area, Dhaka" /></div>
              <div class="col-md-6"><x-admin.input name="location_bn" label="Location" :value="$project->location_bn" bn /></div>
              <div class="col-md-12"><x-admin.input name="address" label="Full address" :value="$project->address" placeholder="Road, block, plot …" /></div>
              <div class="col-md-6"><x-admin.input name="map_query" label="Google Maps search" :value="$project->map_query" help="Place or address shown on the map. Ignored if coordinates are filled in." /></div>
              <div class="col-md-3"><x-admin.input name="latitude" label="Latitude" type="number" step="any" :value="$project->latitude" placeholder="23.8103" /></div>
              <div class="col-md-3"><x-admin.input name="longitude" label="Longitude" type="number" step="any" :value="$project->longitude" placeholder="90.4125" /></div>
              @if ($project->mapEmbedUrl())
                <div class="col-12"><iframe src="{{ $project->mapEmbedUrl() }}" style="width:100%;height:280px;border:0;border-radius:8px" loading="lazy" title="Map preview"></iframe></div>
              @endif
            </div>
          </div>

          {{-- SEO --}}
          <div class="tab-pane fade" id="t-seo" role="tabpanel">
            <x-admin.input name="seo_title" label="SEO title" :value="$project->seo_title" help="Leave empty to use “Flat for Sale in {area} – {name}”." />
            <x-admin.textarea name="seo_description" label="Meta description" :value="$project->seo_description" rows="3" maxlength="300" help="About 150–160 characters, shown in Google results." />
            <x-admin.input name="seo_keywords" label="Keywords" :value="$project->seo_keywords" placeholder="flat sale Dhaka, apartment Bashundhara" />
            <x-admin.image name="og_image" label="Social sharing image" :current="$project->og_image" help="Shown when the link is shared on Facebook/WhatsApp. 1200×630 recommended. Defaults to the cover image." removable />
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3">
      <div class="adm-card">
        <div class="adm-card-header"><h2>Publishing</h2></div>
        <div class="adm-card-body">
          <x-admin.switch name="is_published" label="Published on website" :checked="$project->is_published" help="Drafts are only visible here." />
          <x-admin.switch name="is_featured" label="Featured on homepage" :checked="$project->is_featured" />
          <x-admin.input name="sort_order" label="Display order" type="number" min="0" :value="$project->sort_order ?? 0" help="Lower numbers appear first." />
          <button type="submit" class="btn btn-accent btn-block"><i class="fa fa-save"></i> {{ $isNew ? 'Create project' : 'Save changes' }}</button>
          @unless ($isNew)
            <p class="small text-muted mt-3 mb-0">Last updated {{ $project->updated_at->diffForHumans() }}</p>
          @endunless
        </div>
      </div>
    </div>
  </div>
</form>

@unless ($isNew)
  {{-- Gallery & floor plans --}}
  <div class="adm-card" id="media">
    <div class="adm-card-header">
      <h2>Gallery & floor plans</h2>
      <div class="ml-auto">
        <form method="post" enctype="multipart/form-data" action="{{ route('admin.projects.images.store', $project) }}" class="form-inline">
          @csrf
          <select name="type" class="form-control form-control-sm custom-select mr-2" aria-label="Image type">
            <option value="gallery">Gallery photos</option>
            <option value="floor_plan">Floor plans</option>
          </select>
          <div class="custom-file mr-2" style="width:220px">
            <input type="file" class="custom-file-input" id="upload_images" name="images[]" accept="image/jpeg,image/png,image/webp" multiple required>
            <label class="custom-file-label" for="upload_images">Choose images</label>
          </div>
          <button class="btn btn-accent btn-sm" type="submit"><i class="fa fa-upload"></i> Upload</button>
        </form>
      </div>
    </div>
    <div class="adm-card-body">
      @php $groups = ['gallery' => $project->gallery, 'floor_plan' => $project->floorPlans]; @endphp
      @if ($project->gallery->isEmpty() && $project->floorPlans->isEmpty())
        <div class="adm-empty"><i class="fa fa-picture-o"></i>No photos or floor plans yet. Upload them with the form above.</div>
      @else
        <form method="post" action="{{ route('admin.projects.images.update', $project) }}" id="images-form">
          @csrf @method('PUT')
          @foreach ($groups as $type => $images)
            @continue($images->isEmpty())
            <h3 class="h6 font-weight-bold mt-2 mb-3">{{ $type === 'gallery' ? 'Gallery' : 'Floor plans' }} ({{ $images->count() }})</h3>
            <div class="adm-gallery mb-4">
              @foreach ($images as $image)
                <div class="adm-gallery-item">
                  <a href="{{ $image->url() }}" target="_blank" rel="noopener"><img src="{{ $image->url() }}" alt="" loading="lazy"></a>
                  <div class="p-2">
                    @if ($project->cover_image === $image->path)<span class="badge badge-warning mb-1">Cover</span>@endif
                    <input class="form-control form-control-sm mb-1" name="images[{{ $image->id }}][caption]" value="{{ $image->caption }}" placeholder="Caption">
                    <input class="form-control form-control-sm mb-1" name="images[{{ $image->id }}][caption_bn]" value="{{ $image->caption_bn }}" placeholder="ক্যাপশন">
                    <div class="d-flex align-items-center" style="gap:4px">
                      <input class="form-control form-control-sm" style="width:70px" type="number" min="0" name="images[{{ $image->id }}][sort_order]" value="{{ $image->sort_order }}" title="Order">
                      @if ($type === 'gallery' && $project->cover_image !== $image->path)
                        <button class="btn btn-light btn-sm" type="submit" form="cover-{{ $image->id }}" title="Use as cover image"><i class="fa fa-star-o"></i></button>
                      @endif
                      <button class="btn btn-outline-danger btn-sm ml-auto" type="submit" form="del-img-{{ $image->id }}" title="Delete image"><i class="fa fa-trash"></i></button>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          @endforeach
          <button class="btn btn-accent btn-sm" type="submit"><i class="fa fa-save"></i> Save captions & order</button>
        </form>
        @foreach ($project->images as $image)
          <form method="post" action="{{ route('admin.projects.images.destroy', [$project, $image]) }}" id="del-img-{{ $image->id }}" data-confirm="Delete this image?">@csrf @method('DELETE')</form>
          <form method="post" action="{{ route('admin.projects.images.cover', [$project, $image]) }}" id="cover-{{ $image->id }}">@csrf @method('PATCH')</form>
        @endforeach
      @endif
    </div>
  </div>

  {{-- Units --}}
  <div class="adm-card" id="units">
    <div class="adm-card-header"><h2>Unit types & pricing</h2></div>
    <div class="adm-card-body">
      @if ($project->units->isNotEmpty())
        <div class="table-responsive mb-4">
          <table class="table adm-table table-sm">
            <thead><tr><th>Unit</th><th>Beds</th><th>Baths</th><th>Balc.</th><th>Size (sft)</th><th>Price (BDT)</th><th>Availability</th><th>Floor plan</th><th>Order</th><th></th></tr></thead>
            <tbody>
            @foreach ($project->units as $unit)
              <tr>
                <form method="post" enctype="multipart/form-data" action="{{ route('admin.projects.units.update', [$project, $unit]) }}" id="unit-{{ $unit->id }}">@csrf @method('PUT')</form>
                <td><input form="unit-{{ $unit->id }}" class="form-control form-control-sm" name="name" value="{{ $unit->name }}" required style="min-width:110px"></td>
                <td><input form="unit-{{ $unit->id }}" class="form-control form-control-sm" type="number" min="0" name="bedrooms" value="{{ $unit->bedrooms }}" style="width:70px"></td>
                <td><input form="unit-{{ $unit->id }}" class="form-control form-control-sm" type="number" min="0" name="bathrooms" value="{{ $unit->bathrooms }}" style="width:70px"></td>
                <td><input form="unit-{{ $unit->id }}" class="form-control form-control-sm" type="number" min="0" name="balconies" value="{{ $unit->balconies }}" style="width:70px"></td>
                <td><input form="unit-{{ $unit->id }}" class="form-control form-control-sm" type="number" min="1" name="size_sqft" value="{{ $unit->size_sqft }}" style="width:100px"></td>
                <td><input form="unit-{{ $unit->id }}" class="form-control form-control-sm" type="number" min="0" name="price" value="{{ $unit->price !== null ? (int) $unit->price : '' }}" style="width:130px"></td>
                <td>
                  <select form="unit-{{ $unit->id }}" class="form-control form-control-sm custom-select" name="availability">
                    @foreach (\App\Models\ProjectUnit::AVAILABILITY as $k => $v)<option value="{{ $k }}" @selected($unit->availability === $k)>{{ $v }}</option>@endforeach
                  </select>
                </td>
                <td style="min-width:170px">
                  @if ($unit->floor_plan)<a href="{{ media_url($unit->floor_plan) }}" target="_blank" rel="noopener" class="small d-block mb-1"><i class="fa fa-image"></i> View</a>@endif
                  <input form="unit-{{ $unit->id }}" type="file" name="floor_plan" accept="image/jpeg,image/png,image/webp" class="form-control-file form-control-sm">
                </td>
                <td><input form="unit-{{ $unit->id }}" class="form-control form-control-sm" type="number" min="0" name="sort_order" value="{{ $unit->sort_order }}" style="width:65px"></td>
                <td class="adm-actions-cell">
                  <button form="unit-{{ $unit->id }}" class="btn btn-sm btn-accent" type="submit" title="Save unit"><i class="fa fa-save"></i></button>
                  <form method="post" action="{{ route('admin.projects.units.destroy', [$project, $unit]) }}" data-confirm="Delete unit &quot;{{ $unit->name }}&quot;?">@csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" type="submit" title="Delete unit"><i class="fa fa-trash"></i></button>
                  </form>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      @endif

      <h3 class="h6 font-weight-bold">Add a unit type</h3>
      <form method="post" enctype="multipart/form-data" action="{{ route('admin.projects.units.store', $project) }}">
        @csrf
        <div class="form-row">
          <div class="col-md-2 mb-2"><input class="form-control" name="name" placeholder="Name, e.g. Type A" required></div>
          <div class="col-md-1 mb-2"><input class="form-control" type="number" min="0" name="bedrooms" placeholder="Beds"></div>
          <div class="col-md-1 mb-2"><input class="form-control" type="number" min="0" name="bathrooms" placeholder="Baths"></div>
          <div class="col-md-1 mb-2"><input class="form-control" type="number" min="0" name="balconies" placeholder="Balc."></div>
          <div class="col-md-2 mb-2"><input class="form-control" type="number" min="1" name="size_sqft" placeholder="Size (sft)"></div>
          <div class="col-md-2 mb-2"><input class="form-control" type="number" min="0" name="price" placeholder="Price (BDT)"></div>
          <div class="col-md-2 mb-2">
            <select class="form-control custom-select" name="availability">
              @foreach (\App\Models\ProjectUnit::AVAILABILITY as $k => $v)<option value="{{ $k }}">{{ $v }}</option>@endforeach
            </select>
          </div>
          <div class="col-md-1 mb-2"><input class="form-control" type="number" min="0" name="sort_order" placeholder="Order"></div>
          <div class="col-md-6 mb-2">
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="new_unit_plan" name="floor_plan" accept="image/jpeg,image/png,image/webp">
              <label class="custom-file-label" for="new_unit_plan">Floor plan image (optional)</label>
            </div>
          </div>
          <div class="col-md-2 mb-2"><button class="btn btn-accent btn-block" type="submit"><i class="fa fa-plus"></i> Add unit</button></div>
        </div>
      </form>
    </div>
  </div>
@endunless
@endsection

@push('scripts')
<script>
  // Open the tab that contains the first validation error, or the tab from the URL hash.
  (function () {
    var invalid = document.querySelector('.tab-pane .is-invalid');
    var pane = invalid ? invalid.closest('.tab-pane') : null;
    if (pane) $('a[href="#' + pane.id + '"]').tab('show');
  })();
</script>
@endpush
