@extends('admin.layout')

@section('title', 'Homepage & settings')

@section('content')
<form method="post" enctype="multipart/form-data" action="{{ route('admin.settings.update') }}">
  @csrf @method('PUT')

  <div class="adm-card">
    <div class="adm-card-header p-0 px-3 pt-2">
      <ul class="nav nav-tabs adm-tabs border-0" role="tablist">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#homepage" role="tab">Homepage</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#contact" role="tab">Contact</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#social" role="tab">Social media</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#seo" role="tab">SEO & sharing</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#footer" role="tab">Footer</a></li>
      </ul>
    </div>
    <div class="adm-card-body tab-content">

      <div class="tab-pane fade show active" id="homepage" role="tabpanel">
        <p class="text-muted small">Slider images are managed under <a href="{{ route('admin.banners.index') }}">Home banners</a>; featured projects by the ★ on the <a href="{{ route('admin.projects.index') }}">Projects</a> list.</p>
        <h3 class="h6 font-weight-bold">Sections</h3>
        <div class="row">
          <div class="col-md-4"><x-admin.switch name="home_show_featured_projects" label="Featured projects" :checked="($s['home_show_featured_projects'] ?? '1') === '1'" /></div>
          <div class="col-md-4"><x-admin.switch name="home_show_testimonials" label="Testimonials" :checked="($s['home_show_testimonials'] ?? '1') === '1'" help="Hidden automatically if there are none." /></div>
          <div class="col-md-4"><x-admin.switch name="home_show_faqs" label="FAQs" :checked="($s['home_show_faqs'] ?? '1') === '1'" help="Hidden automatically if there are none." /></div>
        </div>
        <hr>
        <h3 class="h6 font-weight-bold">“Who we are” section</h3>
        <div class="row">
          <div class="col-md-6"><x-admin.input name="home_about_title" label="Heading" :value="$s['home_about_title'] ?? ''" /></div>
          <div class="col-md-6"><x-admin.input name="home_about_title_bn" label="Heading" :value="$s['home_about_title_bn'] ?? ''" bn /></div>
          <div class="col-md-6"><x-admin.input name="home_about_subtitle" label="Sub-heading" :value="$s['home_about_subtitle'] ?? ''" /></div>
          <div class="col-md-6"><x-admin.input name="home_about_subtitle_bn" label="Sub-heading" :value="$s['home_about_subtitle_bn'] ?? ''" bn /></div>
          <div class="col-md-6"><x-admin.input name="home_about_lead" label="Lead line" :value="$s['home_about_lead'] ?? ''" /></div>
          <div class="col-md-6"><x-admin.input name="home_about_lead_bn" label="Lead line" :value="$s['home_about_lead_bn'] ?? ''" bn /></div>
          <div class="col-md-6"><x-admin.textarea name="home_about_text" label="Text" :value="$s['home_about_text'] ?? ''" rows="8" help="Leave an empty line between paragraphs." /></div>
          <div class="col-md-6"><x-admin.textarea name="home_about_text_bn" label="Text" :value="$s['home_about_text_bn'] ?? ''" rows="8" bn /></div>
          <div class="col-md-6"><x-admin.image name="home_about_image" label="Photo" :current="$s['home_about_image'] ?? null" /></div>
        </div>
        <hr>
        <h3 class="h6 font-weight-bold">Call to action (bottom of homepage)</h3>
        <div class="row">
          <div class="col-md-6"><x-admin.input name="home_cta_title" label="Heading" :value="$s['home_cta_title'] ?? ''" /></div>
          <div class="col-md-6"><x-admin.input name="home_cta_title_bn" label="Heading" :value="$s['home_cta_title_bn'] ?? ''" bn /></div>
          <div class="col-md-6"><x-admin.input name="home_cta_text" label="Text" :value="$s['home_cta_text'] ?? ''" /></div>
          <div class="col-md-6"><x-admin.input name="home_cta_text_bn" label="Text" :value="$s['home_cta_text_bn'] ?? ''" bn /></div>
        </div>
      </div>

      <div class="tab-pane fade" id="contact" role="tabpanel">
        <div class="row">
          <div class="col-md-6"><x-admin.input name="site_name" label="Company name" :value="$s['site_name'] ?? 'FMB Group'" required /></div>
          <div class="col-md-6"><x-admin.input name="email" label="Main email" type="email" :value="$s['email'] ?? ''" required help="Also receives garments enquiries from the website." /></div>
          <div class="col-md-4"><x-admin.input name="phone" label="Main phone (for dialling)" :value="$s['phone'] ?? ''" required placeholder="+8801612149719" /></div>
          <div class="col-md-4"><x-admin.input name="phone_display" label="Main phone (as shown)" :value="$s['phone_display'] ?? ''" required placeholder="+880 1612-149719" /></div>
          <div class="col-md-4"><x-admin.input name="whatsapp" label="WhatsApp number" :value="$s['whatsapp'] ?? ''" placeholder="8801612149719" help="Country code + number, digits only." /></div>
          <div class="col-md-4"><x-admin.input name="real_estate_phone" label="Real estate phone (for dialling)" :value="$s['real_estate_phone'] ?? ''" placeholder="+8801312149719" /></div>
          <div class="col-md-4"><x-admin.input name="real_estate_phone_display" label="Real estate phone (as shown)" :value="$s['real_estate_phone_display'] ?? ''" placeholder="01312-149719" /></div>
          <div class="col-md-4"><x-admin.input name="real_estate_email" label="Real estate email" type="email" :value="$s['real_estate_email'] ?? ''" help="Receives flat, site-visit and landowner enquiries." /></div>
          <div class="col-md-6"><x-admin.input name="address_line1" label="Address line 1" :value="$s['address_line1'] ?? ''" required /></div>
          <div class="col-md-6"><x-admin.input name="address_line1_bn" label="Address line 1" :value="$s['address_line1_bn'] ?? ''" bn /></div>
          <div class="col-md-6"><x-admin.input name="address_line2" label="Address line 2" :value="$s['address_line2'] ?? ''" /></div>
          <div class="col-md-6"><x-admin.input name="address_line2_bn" label="Address line 2" :value="$s['address_line2_bn'] ?? ''" bn /></div>
          <div class="col-md-6"><x-admin.input name="office_hours" label="Office hours" :value="$s['office_hours'] ?? ''" /></div>
          <div class="col-md-6"><x-admin.input name="office_hours_bn" label="Office hours" :value="$s['office_hours_bn'] ?? ''" bn /></div>
          <div class="col-md-12"><x-admin.input name="map_query" label="Office location for Google Maps" :value="$s['map_query'] ?? ''" help="Shown on the Contact page." /></div>
        </div>
      </div>

      <div class="tab-pane fade" id="social" role="tabpanel">
        <p class="text-muted small">Leave a field empty to hide that icon.</p>
        <div class="row">
          <div class="col-md-6"><x-admin.input name="facebook_url" label="Facebook page" type="url" :value="$s['facebook_url'] ?? ''" /></div>
          <div class="col-md-6"><x-admin.input name="messenger_url" label="Messenger link" type="url" :value="$s['messenger_url'] ?? ''" placeholder="https://m.me/yourpage" help="Used by the floating Messenger button." /></div>
          <div class="col-md-4"><x-admin.input name="linkedin_url" label="LinkedIn" type="url" :value="$s['linkedin_url'] ?? ''" /></div>
          <div class="col-md-4"><x-admin.input name="youtube_url" label="YouTube" type="url" :value="$s['youtube_url'] ?? ''" /></div>
          <div class="col-md-4"><x-admin.input name="instagram_url" label="Instagram" type="url" :value="$s['instagram_url'] ?? ''" /></div>
        </div>
      </div>

      <div class="tab-pane fade" id="seo" role="tabpanel">
        <p class="text-muted small">Defaults for the homepage and any page without its own SEO fields.</p>
        <div class="row">
          <div class="col-md-6"><x-admin.input name="seo_title" label="Homepage title" :value="$s['seo_title'] ?? ''" required /></div>
          <div class="col-md-6"><x-admin.input name="seo_title_bn" label="Homepage title" :value="$s['seo_title_bn'] ?? ''" bn /></div>
          <div class="col-md-6"><x-admin.textarea name="seo_description" label="Meta description" :value="$s['seo_description'] ?? ''" rows="3" maxlength="300" /></div>
          <div class="col-md-6"><x-admin.textarea name="seo_description_bn" label="Meta description" :value="$s['seo_description_bn'] ?? ''" rows="3" bn /></div>
          <div class="col-md-12"><x-admin.textarea name="seo_keywords" label="Keywords" :value="$s['seo_keywords'] ?? ''" rows="2" /></div>
          <div class="col-md-6"><x-admin.image name="og_image" label="Default social sharing image" :current="$s['og_image'] ?? null" help="Shown when links are shared on Facebook/WhatsApp. 1200×630 recommended." /></div>
        </div>
      </div>

      <div class="tab-pane fade" id="footer" role="tabpanel">
        <div class="row">
          <div class="col-md-6"><x-admin.textarea name="footer_about" label="About text" :value="$s['footer_about'] ?? ''" rows="4" /></div>
          <div class="col-md-6"><x-admin.textarea name="footer_about_bn" label="About text" :value="$s['footer_about_bn'] ?? ''" rows="4" bn /></div>
        </div>
        <p class="text-muted small">Footer quick links are edited under <a href="{{ route('admin.menus.index', ['location' => 'footer']) }}">Menus → Footer quick links</a>.</p>
      </div>
    </div>
  </div>

  <div class="adm-sticky-save">
    <button type="submit" class="btn btn-accent"><i class="fa fa-save"></i> Save settings</button>
  </div>
</form>
@endsection

@push('scripts')
<script>
  (function () {
    var invalid = document.querySelector('.tab-pane .is-invalid');
    var pane = invalid ? invalid.closest('.tab-pane') : (location.hash ? document.querySelector(location.hash + '.tab-pane') : null);
    if (pane) $('a[href="#' + pane.id + '"]').tab('show');
  })();
</script>
@endpush
