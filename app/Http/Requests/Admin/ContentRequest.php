<?php

namespace App\Http\Requests\Admin;

use App\Models\Faq;
use App\Models\MenuItem;
use App\Models\Page;
use App\Support\Uploads;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * Validation for pages, testimonials, FAQs and menu items.
 * The rule set is chosen from the route name (admin.pages.*, admin.faqs.* …).
 */
class ContentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->isAdmin();
    }

    private function module(): string
    {
        return explode('.', (string) $this->route()?->getName())[1] ?? '';
    }

    protected function prepareForValidation(): void
    {
        $merge = ['sort_order' => $this->input('sort_order') ?: 0];
        foreach (['is_active', 'is_published', 'open_in_new_tab'] as $flag) {
            if ($this->has($flag)) {
                $merge[$flag] = $this->boolean($flag);
            }
        }
        if ($this->module() === 'pages') {
            $page = $this->route('page');
            // System pages (about, contact) keep their slug.
            $merge['slug'] = $page?->isSystem() ? $page->slug : Str::slug($this->input('slug') ?: $this->input('title', ''));
        }
        $this->merge($merge);
    }

    public function rules(): array
    {
        return match ($this->module()) {
            'pages' => [
                'title' => ['required', 'string', 'max:255'],
                'title_bn' => ['nullable', 'string', 'max:255'],
                'slug' => array_filter([
                    'required', 'alpha_dash', 'max:120',
                    Rule::unique('pages', 'slug')->ignore($this->route('page')?->id),
                    // Custom pages may not take over addresses used by the site itself.
                    $this->route('page')?->isSystem() ? null : Rule::notIn(['admin', 'lang', 'contact', 'about', 'development', 'landowners', 'collection', 'garments', 'our-management']),
                ]),
                'content' => ['nullable', 'string', 'max:200000'],
                'content_bn' => ['nullable', 'string', 'max:200000'],
                'is_published' => ['boolean'],
                'seo_title' => ['nullable', 'string', 'max:255'],
                'seo_description' => ['nullable', 'string', 'max:300'],
                'seo_keywords' => ['nullable', 'string', 'max:255'],
                'banner_image' => ['nullable', ...Uploads::IMAGE_RULES],
                'og_image' => ['nullable', ...Uploads::IMAGE_RULES],
            ],
            'testimonials' => [
                'name' => ['required', 'string', 'max:120'],
                'name_bn' => ['nullable', 'string', 'max:120'],
                'designation' => ['nullable', 'string', 'max:150'],
                'designation_bn' => ['nullable', 'string', 'max:150'],
                'project_id' => ['nullable', 'integer', 'exists:projects,id'],
                'quote' => ['required', 'string', 'max:2000'],
                'quote_bn' => ['nullable', 'string', 'max:2000'],
                'rating' => ['nullable', 'integer', 'between:1,5'],
                'is_active' => ['boolean'],
                'sort_order' => ['integer', 'min:0', 'max:9999'],
                'photo' => ['nullable', ...Uploads::IMAGE_RULES],
            ],
            'faqs' => [
                'category' => ['required', Rule::in(array_keys(Faq::CATEGORIES))],
                'question' => ['required', 'string', 'max:255'],
                'question_bn' => ['nullable', 'string', 'max:255'],
                'answer' => ['required', 'string', 'max:5000'],
                'answer_bn' => ['nullable', 'string', 'max:5000'],
                'is_active' => ['boolean'],
                'sort_order' => ['integer', 'min:0', 'max:9999'],
            ],
            'menus' => [
                'location' => ['required', Rule::in(array_keys(MenuItem::LOCATIONS))],
                'parent_id' => ['nullable', 'integer', Rule::exists('menu_items', 'id')->where('location', $this->input('location')),
                    Rule::notIn([$this->route('menu')?->id])],
                'label' => ['required', 'string', 'max:80'],
                'label_bn' => ['nullable', 'string', 'max:80'],
                'url' => ['required', 'string', 'max:255', 'regex:~^(/|#|https?://|mailto:|tel:)~'],
                'open_in_new_tab' => ['boolean'],
                'is_active' => ['boolean'],
                'sort_order' => ['integer', 'min:0', 'max:9999'],
            ],
            default => [],
        };
    }

    public function messages(): array
    {
        return [
            'url.regex' => 'The link must start with / (a page on this site), #, https://, mailto: or tel:.',
            'slug.not_in' => 'This web address is already used by the website. Choose another slug.',
            'parent_id.exists' => 'The parent item must be in the same menu.',
            'parent_id.not_in' => 'A menu item cannot be its own parent.',
        ];
    }
}
