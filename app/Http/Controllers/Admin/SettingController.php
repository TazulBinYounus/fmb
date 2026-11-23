<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingsRequest;
use App\Models\ActivityLog;
use App\Models\Setting;
use App\Support\Uploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.edit', ['s' => Setting::pluck('value', 'key')->all()]);
    }

    public function update(SettingsRequest $request): RedirectResponse
    {
        $values = collect($request->validated())->except(SettingsRequest::IMAGES)->all();
        $old = Setting::whereIn('key', SettingsRequest::IMAGES)->pluck('value', 'key')->all();

        foreach (SettingsRequest::IMAGES as $key) {
            if ($request->hasFile($key)) {
                $values[$key] = Uploads::store($request->file($key), 'settings');
            }
        }
        Setting::put($values);

        foreach (SettingsRequest::IMAGES as $key) {
            if (isset($values[$key]) && ($old[$key] ?? null) && $old[$key] !== $values[$key]) {
                Uploads::delete($old[$key]);
            }
        }

        ActivityLog::create(['user_id' => auth()->id(), 'action' => 'updated', 'description' => 'Updated website settings']);

        return redirect()->route('admin.settings.edit')->with('success', 'Settings saved. The website has been updated.');
    }
}
