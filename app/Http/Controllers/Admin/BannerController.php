<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BannerRequest;
use App\Models\Banner;
use App\Support\Uploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BannerController extends Controller
{
    public function index(): View
    {
        return view('admin.banners.index', ['banners' => Banner::orderBy('sort_order')->orderBy('id')->get()]);
    }

    public function create(): View
    {
        return view('admin.banners.form', ['banner' => new Banner(['is_active' => true, 'image_position' => 'center'])]);
    }

    public function store(BannerRequest $request): RedirectResponse
    {
        $data = collect($request->validated())->except('image')->all();
        $data['image'] = Uploads::store($request->file('image'), 'banners');
        Banner::create($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner added to the homepage slider.');
    }

    public function edit(Banner $banner): View
    {
        return view('admin.banners.form', compact('banner'));
    }

    public function update(BannerRequest $request, Banner $banner): RedirectResponse
    {
        $data = collect($request->validated())->except('image')->all();
        $old = $banner->image;
        if ($request->hasFile('image')) {
            $data['image'] = Uploads::store($request->file('image'), 'banners');
        }
        $banner->update($data);
        if ($old !== $banner->image) {
            Uploads::delete($old);
        }

        return redirect()->route('admin.banners.index')->with('success', 'Banner saved.');
    }

    public function destroy(Banner $banner): RedirectResponse
    {
        if (Banner::count() === 1) {
            return back()->with('error', 'The homepage needs at least one banner. Add another one before deleting this.');
        }
        $image = $banner->image;
        $banner->delete();
        Uploads::delete($image);

        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted.');
    }
}
