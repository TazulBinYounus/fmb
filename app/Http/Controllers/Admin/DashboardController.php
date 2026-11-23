<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Enquiry;
use App\Models\Project;
use App\Models\ProjectUnit;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $byStatus = Project::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');

        // Enquiries per day for the last 14 days (Dhaka time).
        $since = now()->subDays(13)->startOfDay();
        $perDay = Enquiry::where('created_at', '>=', $since)
            ->selectRaw('DATE(created_at) as day, count(*) as total')->groupBy('day')->pluck('total', 'day');
        $trend = collect(range(13, 0))->map(fn ($i) => [
            'day' => now()->subDays($i)->format('d M'),
            'total' => (int) ($perDay[now()->subDays($i)->toDateString()] ?? 0),
        ]);

        return view('admin.dashboard', [
            'stats' => [
                'projects' => Project::count(),
                'published' => Project::published()->count(),
                'featured' => Project::featured()->count(),
                'units' => ProjectUnit::count(),
                'available_units' => ProjectUnit::where('availability', 'available')->count(),
                'new_enquiries' => Enquiry::where('status', 'new')->count(),
                'enquiries_30d' => Enquiry::where('created_at', '>=', now()->subDays(30))->count(),
            ],
            'byStatus' => $byStatus,
            'trend' => $trend,
            'latestEnquiries' => Enquiry::with('project')->latest()->limit(6)->get(),
            'activity' => ActivityLog::with('user')->latest('created_at')->limit(10)->get(),
            'recentProjects' => Project::latest('updated_at')->limit(5)->get(),
        ]);
    }
}
