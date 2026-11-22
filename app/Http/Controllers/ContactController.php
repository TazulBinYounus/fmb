<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request): RedirectResponse
    {
        // Honeypot: real visitors never fill this hidden field.
        if ($request->filled('website')) {
            return back()->with('contact_success', true);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'company' => ['nullable', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150'],
            // Accepts Bangladeshi mobiles (01XXXXXXXXX, +8801XXXXXXXXX) and international numbers.
            'phone' => ['required', 'string', 'max:20', 'regex:/^\+?[0-9][0-9\s\-]{6,18}$/'],
            'type' => ['nullable', 'in:garments,property,other'],
            'subject' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:3000'],
        ], [
            'phone.regex' => __('Please enter a valid phone number, e.g. 01712345678 or +8801712345678.'),
        ]);

        $data['phone'] = self::normalizeBdPhone($data['phone']);
        $data['type'] ??= 'garments';

        // Property enquiries go to FMB Developments Ltd, everything else to the group inbox.
        $to = $data['type'] === 'property' ? 'fmb@fmbgroupbd.com' : config('mail.from.address');

        $body = collect($data)->map(fn ($v, $k) => ucfirst($k).': '.$v)->implode("\n");

        try {
            Mail::raw($body, function ($mail) use ($data, $to) {
                $mail->to($to)
                    ->replyTo($data['email'], $data['name'])
                    ->subject('Website enquiry ['.$data['type'].']: '.$data['subject']);
            });
        } catch (\Throwable $e) {
            Log::error('Contact form mail failed', ['error' => $e->getMessage(), 'enquiry' => $data]);

            return back()->withInput()->with('contact_error', true);
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
