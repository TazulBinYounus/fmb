<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

/** Leads from the website forms (contact, site visit, landowner). */
class EnquiryController extends Controller
{
    public function index(Request $request): View
    {
        $enquiries = $this->filtered($request)->with('project')->latest()->paginate(25)->withQueryString();

        return view('admin.enquiries.index', [
            'enquiries' => $enquiries,
            'counts' => Enquiry::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status'),
        ]);
    }

    public function show(Enquiry $enquiry): View
    {
        return view('admin.enquiries.show', ['enquiry' => $enquiry->load('project')]);
    }

    public function update(Request $request, Enquiry $enquiry): RedirectResponse
    {
        $enquiry->update($request->validate(['status' => ['required', Rule::in(array_keys(Enquiry::STATUSES))]]));

        return back()->with('success', 'Enquiry marked as '.strtolower(Enquiry::STATUSES[$enquiry->status]).'.');
    }

    public function destroy(Enquiry $enquiry): RedirectResponse
    {
        $enquiry->delete();

        return redirect()->route('admin.enquiries.index')->with('success', 'Enquiry deleted.');
    }

    /** CSV download of the current filter (opens in Excel; UTF-8 with BOM so Bangla names display correctly). */
    public function export(Request $request): StreamedResponse
    {
        $rows = $this->filtered($request)->with('project')->latest()->get();

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['Date', 'Type', 'Status', 'Name', 'Phone', 'Email', 'Company', 'Project', 'Subject', 'Message', 'Details']);
            foreach ($rows as $e) {
                fputcsv($out, [
                    $e->created_at->format('Y-m-d H:i'), Enquiry::TYPES[$e->type] ?? $e->type, $e->status,
                    $e->name, $e->phone, $e->email, $e->company, $e->project?->name, $e->subject, $e->message,
                    collect($e->details ?? [])->map(fn ($v, $k) => str_replace('_', ' ', $k).': '.$v)->implode('; '),
                ]);
            }
            fclose($out);
        }, 'enquiries-'.now()->format('Y-m-d').'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function filtered(Request $request)
    {
        return Enquiry::query()
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->type))
            ->when($request->filled('q'), fn ($q) => $q->where(fn ($w) => $w
                ->where('name', 'like', '%'.$request->q.'%')
                ->orWhere('phone', 'like', '%'.$request->q.'%')
                ->orWhere('email', 'like', '%'.$request->q.'%')));
    }
}
