<?php

namespace App\Http\Requests\Admin;

use App\Support\Uploads;
use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
{
    /** Text settings that have a Bangla twin ({key}_bn). */
    public const TRANSLATABLE = [
        'address_line1', 'address_line2', 'office_hours', 'footer_about', 'seo_title', 'seo_description',
        'home_about_title', 'home_about_subtitle', 'home_about_lead', 'home_about_text', 'home_cta_title', 'home_cta_text',
    ];

    public const IMAGES = ['og_image', 'home_about_image'];

    public const TOGGLES = ['home_show_featured_projects', 'home_show_testimonials', 'home_show_faqs'];

    public function authorize(): bool
    {
        return (bool) $this->user()?->isAdmin();
    }

    protected function prepareForValidation(): void
    {
        $merge = [];
        foreach (self::TOGGLES as $toggle) {
            $merge[$toggle] = $this->boolean($toggle) ? '1' : '0';
        }
        // Keep only digits for the WhatsApp number (wa.me needs 8801XXXXXXXXX).
        $merge['whatsapp'] = preg_replace('/\D/', '', (string) $this->input('whatsapp'));
        $this->merge($merge);

        // Image fields only accept uploads; ignore any non-file value so the current image is kept.
        foreach (self::IMAGES as $key) {
            if (! $this->hasFile($key)) {
                $this->request->remove($key);
            }
        }
    }

    public function rules(): array
    {
        $rules = [
            'site_name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:20', 'regex:/^\+?[0-9]{6,15}$/'],
            'phone_display' => ['required', 'string', 'max:30'],
            'whatsapp' => ['nullable', 'regex:/^[0-9]{8,15}$/'],
            'email' => ['required', 'email', 'max:150'],
            'real_estate_phone' => ['nullable', 'string', 'max:20', 'regex:/^\+?[0-9]{6,15}$/'],
            'real_estate_phone_display' => ['nullable', 'string', 'max:30'],
            'real_estate_email' => ['nullable', 'email', 'max:150'],
            'map_query' => ['nullable', 'string', 'max:255'],
            'facebook_url' => ['nullable', 'url:https', 'max:255'],
            'messenger_url' => ['nullable', 'url:https', 'max:255'],
            'linkedin_url' => ['nullable', 'url:https', 'max:255'],
            'youtube_url' => ['nullable', 'url:https', 'max:255'],
            'instagram_url' => ['nullable', 'url:https', 'max:255'],
            'seo_keywords' => ['nullable', 'string', 'max:500'],
            'og_image' => ['nullable', ...Uploads::IMAGE_RULES],
            'home_about_image' => ['nullable', ...Uploads::IMAGE_RULES],
        ];

        foreach (self::TRANSLATABLE as $key) {
            $max = in_array($key, ['home_about_text', 'footer_about'], true) ? 5000 : ($key === 'seo_description' ? 300 : 255);
            $required = in_array($key, ['address_line1', 'seo_title'], true) ? 'required' : 'nullable';
            $rules[$key] = [$required, 'string', 'max:'.$max];
            $rules[$key.'_bn'] = ['nullable', 'string', 'max:'.$max];
        }
        foreach (self::TOGGLES as $toggle) {
            $rules[$toggle] = ['in:0,1'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'Enter the phone number with country code and digits only, e.g. +8801612149719.',
            'real_estate_phone.regex' => 'Enter the phone number with country code and digits only, e.g. +8801312149719.',
            'whatsapp.regex' => 'Enter the WhatsApp number with country code, e.g. 8801612149719.',
        ];
    }
}
