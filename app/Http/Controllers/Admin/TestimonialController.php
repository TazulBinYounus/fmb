<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContentRequest;
use App\Models\Project;
use App\Models\Testimonial;
use App\Support\Uploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(): View
    {
        return view('admin.testimonials.index', ['testimonials' => Testimonial::with('project')->orderBy('sort_order')->orderByDesc('id')->get()]);
    }

    public function create(): View
    {
        return view('admin.testimonials.form', ['testimonial' => new Testimonial(['is_active' => true]), 'projects' => $this->projects()]);
    }

    public function store(ContentRequest $request): RedirectResponse
    {
        $data = collect($request->validated())->except('photo')->all();
        if ($request->hasFile('photo')) {
            $data['photo'] = Uploads::store($request->file('photo'), 'testimonials');
        }
        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial added.');
    }

    public function edit(Testimonial $testimonial): View
    {
        return view('admin.testimonials.form', ['testimonial' => $testimonial, 'projects' => $this->projects()]);
    }

    public function update(ContentRequest $request, Testimonial $testimonial): RedirectResponse
    {
        $data = collect($request->validated())->except('photo')->all();
        $old = $testimonial->photo;
        if ($request->hasFile('photo')) {
            $data['photo'] = Uploads::store($request->file('photo'), 'testimonials');
        } elseif ($request->boolean('remove_photo')) {
            $data['photo'] = null;
        }
        $testimonial->update($data);
        if ($old && $old !== $testimonial->photo) {
            Uploads::delete($old);
        }

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial saved.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $photo = $testimonial->photo;
        $testimonial->delete();
        Uploads::delete($photo);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial deleted.');
    }

    private function projects(): array
    {
        return Project::orderBy('name')->pluck('name', 'id')->all();
    }
}
