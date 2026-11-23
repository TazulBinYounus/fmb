<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileRequest;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('admin.profile.edit', ['user' => Auth::user()]);
    }

    public function update(ProfileRequest $request): RedirectResponse
    {
        $request->user()->update($request->validated());

        return back()->with('success', 'Profile updated.');
    }

    public function password(ProfileRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->forceFill(['password' => $request->validated('password')])->save();

        // Sign out every other device that was logged in with the old password.
        Auth::logoutOtherDevices($request->validated('password'));
        $request->session()->regenerate();

        ActivityLog::create(['user_id' => $user->id, 'action' => 'updated', 'description' => 'Changed account password']);

        return back()->with('success', 'Password changed. Other devices have been logged out.');
    }
}
