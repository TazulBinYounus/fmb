<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContentRequest;
use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        return view('admin.faqs.index', ['faqs' => Faq::orderBy('category')->orderBy('sort_order')->orderBy('id')->get()]);
    }

    public function create(): View
    {
        return view('admin.faqs.form', ['faq' => new Faq(['is_active' => true, 'category' => 'real_estate'])]);
    }

    public function store(ContentRequest $request): RedirectResponse
    {
        Faq::create($request->validated());

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ added.');
    }

    public function edit(Faq $faq): View
    {
        return view('admin.faqs.form', compact('faq'));
    }

    public function update(ContentRequest $request, Faq $faq): RedirectResponse
    {
        $faq->update($request->validated());

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ saved.');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ deleted.');
    }
}
