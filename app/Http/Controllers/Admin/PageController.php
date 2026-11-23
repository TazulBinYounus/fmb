<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContentRequest;
use App\Models\Page;
use App\Support\Html;
use App\Support\Uploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PageController extends Controller
{
    private const FILES = ['banner_image', 'og_image'];

    public function index(): View
    {
        return view('admin.pages.index', ['pages' => Page::orderBy('title')->get()]);
    }

    public function create(): View
    {
        return view('admin.pages.form', ['page' => new Page(['is_published' => true])]);
    }

    public function store(ContentRequest $request): RedirectResponse
    {
        $page = Page::create($this->payload($request));

        return redirect()->route('admin.pages.edit', $page)->with('success', 'Page created. It is available at '.$page->publicUrl());
    }

    public function edit(Page $page): View
    {
        return view('admin.pages.form', compact('page'));
    }

    public function update(ContentRequest $request, Page $page): RedirectResponse
    {
        $old = $page->only(self::FILES);
        $page->update($this->payload($request, $page));
        foreach ($old as $field => $path) {
            if ($path && $path !== $page->$field) {
                Uploads::delete($path);
            }
        }

        return redirect()->route('admin.pages.edit', $page)->with('success', 'Page saved.');
    }

    public function destroy(Page $page): RedirectResponse
    {
        if ($page->isSystem()) {
            return back()->with('error', 'The "'.$page->title.'" page is used by the website and cannot be deleted. You can unpublish it instead.');
        }
        $files = $page->only(self::FILES);
        $page->delete();
        array_map([Uploads::class, 'delete'], array_filter($files));

        return redirect()->route('admin.pages.index')->with('success', 'Page deleted.');
    }

    private function payload(ContentRequest $request, ?Page $page = null): array
    {
        $data = collect($request->validated())->except(self::FILES)->all();
        $data['content'] = Html::clean($data['content'] ?? null);
        $data['content_bn'] = Html::clean($data['content_bn'] ?? null);

        foreach (self::FILES as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = Uploads::store($request->file($field), 'pages');
            } elseif ($page && $request->boolean('remove_'.$field)) {
                $data[$field] = null;
            }
        }

        return $data;
    }
}
