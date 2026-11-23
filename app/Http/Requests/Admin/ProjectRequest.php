<?php

namespace App\Http\Requests\Admin;

use App\Models\Project;
use App\Support\Uploads;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->isAdmin();
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->input('slug') ?: $this->input('name', '')),
            'is_featured' => $this->boolean('is_featured'),
            'is_published' => $this->boolean('is_published'),
            'sort_order' => $this->input('sort_order') ?: 0,
        ]);
    }

    public function rules(): array
    {
        $project = $this->route('project');

        return [
            'name' => ['required', 'string', 'max:255'],
            'name_bn' => ['nullable', 'string', 'max:255'],
            'slug' => ['required', 'alpha_dash', 'max:120', Rule::unique('projects', 'slug')->ignore($project?->id)],
            'type' => ['required', Rule::in(array_keys(Project::TYPES))],
            'status' => ['required', Rule::in(array_keys(Project::STATUSES))],
            'area' => ['nullable', 'string', 'max:255'],
            'area_bn' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'location_bn' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'summary' => ['nullable', 'string', 'max:500'],
            'summary_bn' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string', 'max:65000'],
            'description_bn' => ['nullable', 'string', 'max:65000'],
            'price_from' => ['nullable', 'numeric', 'min:0', 'max:999999999999'],
            'price_to' => ['nullable', 'numeric', 'min:0', 'max:999999999999', 'gte:price_from'],
            'price_note' => ['nullable', 'string', 'max:100'],
            'payment_info' => ['nullable', 'string', 'max:5000'],
            'payment_info_bn' => ['nullable', 'string', 'max:5000'],
            'specs' => ['nullable', 'array', 'max:50'],
            'specs.*.label' => ['nullable', 'string', 'max:100'],
            'specs.*.label_bn' => ['nullable', 'string', 'max:100'],
            'specs.*.value' => ['nullable', 'string', 'max:255'],
            'specs.*.value_bn' => ['nullable', 'string', 'max:255'],
            'amenities' => ['nullable', 'array', 'max:80'],
            'amenities.*.name' => ['nullable', 'string', 'max:100'],
            'amenities.*.name_bn' => ['nullable', 'string', 'max:100'],
            'map_query' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90', 'required_with:longitude'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180', 'required_with:latitude'],
            'video_url' => ['nullable', 'url:https', 'max:255', 'regex:~(youtube\.com|youtu\.be|facebook\.com|fb\.watch)~i'],
            'handover_date' => ['nullable', 'date'],
            'is_featured' => ['boolean'],
            'is_published' => ['boolean'],
            'sort_order' => ['integer', 'min:0', 'max:9999'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:300'],
            'seo_keywords' => ['nullable', 'string', 'max:255'],
            'cover_image' => ['nullable', ...Uploads::IMAGE_RULES],
            'og_image' => ['nullable', ...Uploads::IMAGE_RULES],
            'brochure' => ['nullable', ...Uploads::PDF_RULES],
            'gallery' => ['nullable', 'array', 'max:30'],
            'gallery.*' => Uploads::IMAGE_RULES,
        ];
    }

    public function messages(): array
    {
        return [
            'video_url.regex' => 'The video link must be a YouTube or Facebook video URL.',
            'price_to.gte' => 'The maximum price must be greater than or equal to the starting price.',
            'gallery.*.image' => 'Each gallery file must be an image.',
            'gallery.*.max' => 'Each gallery image must be 5 MB or smaller.',
        ];
    }

    public function attributes(): array
    {
        return ['price_from' => 'starting price', 'price_to' => 'maximum price', 'og_image' => 'social sharing image'];
    }
}
