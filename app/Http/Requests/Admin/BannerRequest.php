<?php

namespace App\Http\Requests\Admin;

use App\Models\Banner;
use App\Support\Uploads;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->isAdmin();
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['is_active' => $this->boolean('is_active'), 'sort_order' => $this->input('sort_order') ?: 0]);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:120'],
            'title_bn' => ['nullable', 'string', 'max:120'],
            'subtitle' => ['nullable', 'string', 'max:200'],
            'subtitle_bn' => ['nullable', 'string', 'max:200'],
            'button_text' => ['nullable', 'string', 'max:40', 'required_with:button_link'],
            'button_text_bn' => ['nullable', 'string', 'max:40'],
            'button_link' => ['nullable', 'string', 'max:255', 'regex:~^(/|https?://|#)~'],
            'image_position' => ['required', Rule::in(array_keys(Banner::POSITIONS))],
            'is_active' => ['boolean'],
            'sort_order' => ['integer', 'min:0', 'max:9999'],
            'image' => [$this->route('banner') ? 'nullable' : 'required', ...Uploads::IMAGE_RULES],
        ];
    }

    public function messages(): array
    {
        return ['button_link.regex' => 'The button link must start with / (a page on this site) or https://.'];
    }
}
