<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    private const REAL_ESTATE_TYPES = ['property', 'site_visit', 'landowner'];

    public function send(Request $request): RedirectResponse
    {
        // Honeypot: real visitors never fill this hidden field.
        if ($request->filled('website')) {
            return back()->with('contact_success', true);
        }

        // Real estate leads (flat buyers, landowners) are usually phone-first in Bangladesh,
        // so email and subject are optional for them.
        $realEstate = in_array($request->input('type'), self::REAL_ESTATE_TYPES, true);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'company' => ['nullable', 'string', 'max:150'],
            'email' => [$realEstate ? 'nullable' : 'required', 'email', 'max:150'],
            // Accepts Bangladeshi mobiles (01XXXXXXXXX, +8801XXXXXXXXX) and international numbers.
            'phone' => ['required', 'string', 'max:20', 'regex:/^\+?[0-9][0-9\s\-]{6,18}$/'],
            'type' => ['nullable', 'in:garments,property,site_visit,landowner,other'],
            'project_id' => ['nullable', 'integer', Rule::exists('projects', 'id')->where('is_published', true)->whereNull('deleted_at')],
            'preferred_date' => ['nullable', 'date', 'after_or_equal:today'],
            'land_location' => ['required_if:type,landowner', 'nullable', 'string', 'max:200'],
            'land_size' => ['required_if:type,landowner', 'nullable', 'string', 'max:50'],
            'road_width' => ['nullable', 'string', 'max:50'],
            'subject' => [$realEstate ? 'nullable' : 'required', 'string', 'max:150'],
            'message' => [$realEstate ? 'nullable' : 'required', 'string', 'max:3000'],
        ], [
            'phone.regex' => __('Please enter a valid phone number, e.g. 01712345678 or +8801712345678.'),
        ]);

        $project = isset($data['project_id']) ? Project::find($data['project_id']) : null;
        $data['phone'] = self::normalizeBdPhone($data['phone']);
        $data['type'] ??= 'garments';
        $data['subject'] ??= match ($data['type']) {
            'site_visit' => 'Site visit request'.($project ? ' – '.$project->name : ''),
            'landowner' => 'Landowner / joint venture proposal',
            default => 'Property enquiry'.($project ? ' – '.$project->name : ''),
        };

        // 1. Save the lead so it appears in the admin panel even if email delivery fails.
        $details = array_filter([
            'preferred_date' => $data['preferred_date'] ?? null,
            'land_location' => $data['land_location'] ?? null,
            'land_size' => $data['land_size'] ?? null,
            'road_width' => $data['road_width'] ?? null,
        ]);
        $enquiry = Enquiry::create([
            'type' => $data['type'],
            'project_id' => $project?->id,
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'],
            'company' => $data['company'] ?? null,
            'subject' => $data['subject'],
            'message' => $data['message'] ?? null,
            'details' => $details ?: null,
            'ip_address' => $request->ip(),
        ]);

        // 2. Email it. Real estate enquiries go to FMB Developments Ltd, everything else to the group inbox.
        $to = in_array($data['type'], self::REAL_ESTATE_TYPES, true)
            ? setting('real_estate_email', setting('email', config('mail.from.address')))
            : setting('email', config('mail.from.address'));

        $lines = array_filter([
            'Name' => $enquiry->name, 'Phone' => $enquiry->phone, 'Email' => $enquiry->email,
            'Company' => $enquiry->company, 'Project' => $project?->name, 'Type' => $enquiry->type,
        ] + collect($details)->mapWithKeys(fn ($v, $k) => [ucfirst(str_replace('_', ' ', $k)) => $v])->all());
        $body = collect($lines)->map(fn ($v, $k) => "$k: $v")->implode("\n")
            ."\n\n".($enquiry->message ?? '')
            ."\n\nView in admin: ".route('admin.enquiries.show', $enquiry);

        try {
            Mail::raw($body, function ($mail) use ($enquiry, $to) {
                $mail->to($to)->subject('Website enquiry ['.$enquiry->type.']: '.$enquiry->subject);
                if ($enquiry->email) {
                    $mail->replyTo($enquiry->email, $enquiry->name);
                }
            });
        } catch (\Throwable $e) {
            // The enquiry is already saved in the database, so the visitor still gets a success message.
            Log::error('Enquiry email failed', ['enquiry_id' => $enquiry->id, 'error' => $e->getMessage()]);
        }

        return back()->with('contact_success', true);
    }

    /**
     * Turns local Bangladeshi mobile numbers (017..., 88017...) into +8801... form.
     */
    public static function normalizeBdPhone(string $phone): string
    {
        $digits = preg_replace('/[^0-9+]/', '', $phone);

        if (preg_match('/^01[3-9][0-9]{8}$/', $digits)) {
            return '+88'.$digits;
        }
        if (preg_match('/^8801[3-9][0-9]{8}$/', $digits)) {
            return '+'.$digits;
        }

        return $digits;
    }
}
