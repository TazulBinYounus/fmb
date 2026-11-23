<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Support\Uploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/** Library of every uploaded file, with free-standing uploads for use in page content. */
class MediaController extends Controller
{
    public function index(Request $request): View
    {
        $media = Media::query()
            ->when($request->query('type') === 'images', fn ($q) => $q->where('mime_type', 'like', 'image/%'))
            ->when($request->query('type') === 'documents', fn ($q) => $q->where('mime_type', 'not like', 'image/%'))
            ->when($request->filled('q'), fn ($q) => $q->where('original_name', 'like', '%'.$request->q.'%'))
            ->latest()
            ->paginate(36)
            ->withQueryString();

        $media->getCollection()->each(fn ($m) => $m->setAttribute('in_use', Uploads::referenceCount($m->path) > 0));

        return view('admin.media.index', compact('media'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'files' => ['required', 'array', 'max:20'],
            'files.*' => ['file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:15360'],
        ], ['files.*.mimes' => 'Only JPG, PNG, WebP images and PDF files can be uploaded.']);

        foreach ($request->file('files') as $file) {
            if (str_starts_with((string) $file->getMimeType(), 'image/') && $file->getSize() > 5 * 1024 * 1024) {
                return back()->with('error', $file->getClientOriginalName().' is larger than 5 MB. Images must be 5 MB or smaller.');
            }
        }
        foreach ($request->file('files') as $file) {
            Uploads::store($file, 'library');
        }

        return redirect()->route('admin.media.index')->with('success', count($request->file('files')).' file(s) uploaded. Copy a link to use it in page content.');
    }

    public function update(Request $request, Media $medium): RedirectResponse
    {
        $medium->update($request->validate(['alt' => ['nullable', 'string', 'max:255']]));

        return back()->with('success', 'Description saved.');
    }

    public function destroy(Media $medium): RedirectResponse
    {
        if (Uploads::referenceCount($medium->path) > 0) {
            return back()->with('error', '"'.$medium->original_name.'" is still used on the website (project, banner, page or settings). Replace it there first.');
        }
        Uploads::forceDelete($medium->path);

        return back()->with('success', 'File deleted.');
    }
}
