<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportTicket;
use Illuminate\Support\Facades\Storage;
use App\Mail\SupportReceived;
use Illuminate\Support\Facades\Mail;

class SupportController extends Controller {
    public function index() {
        return view('landing.support.index');
    }

    public function contactForm() {
        return view('landing.support.contact');
    }

    public function submitContact(Request $r) {
        $r->validate([
            'name'=>'required|string|max:120',
            'email'=>'required|email',
            'subject'=>'required|string|max:150',
            'message'=>'required|string|min:10',
            'attachment'=>'nullable|file|mimes:png,jpg,jpeg,pdf,txt|max:10240'
        ]);

        $path = null;
        if ($r->hasFile('attachment')) {
            $path = $r->file('attachment')->store('support/attachments','private'); // private disk for security
        }

        $ticket = SupportTicket::create([
            'user_id' => auth()->id(),
            'subject' => $r->subject,
            'message' => "From: {$r->name}\n\n{$r->message}",
            'type' => 'general',
            'priority' => 'normal',
            'meta' => ['email'=>$r->email],
            'attachment_path' => $path,
        ]);

        // Notify support team (email, Slack, etc.) — example email
        Mail::to(config('support.team_email'))->queue(new SupportReceived($ticket));

        return back()->with('success','Your message has been submitted. We will respond soon.');
    }

    public function liveChat() {
        return view('support.chat'); // page that embeds chat widget
    }

    public function kycForm() {
        return view('support.kyc');
    }

    public function submitKyc(Request $r)
    {
        $r->validate([
            'full_name'=>'required|string|max:120',
            'email'=>'required|email',
            'country'=>'required|string',
            'id_type'=>'required|string',
            'id_document'=>'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'selfie'=>'nullable|file|mimes:jpg,jpeg,png|max:5120',
        ]);

        // Store documents on private disk; never expose direct URL
        $idPath = $r->file('id_document')->store('kyc/documents', 'private');
        $selfiePath = $r->hasFile('selfie') ? $r->file('selfie')->store('kyc/selfies', 'private') : null;

        // Create ticket for KYC team
        $ticket = SupportTicket::create([
            'user_id' => auth()->id(),
            'subject' => 'KYC Verification Request',
            'message' => "KYC submitted for {$r->full_name}",
            'type' => 'kyc',
            'priority' => 'high',
            'meta' => ['country'=>$r->country,'id_type'=>$r->id_type,'id_path'=>$idPath,'selfie_path'=>$selfiePath],
            'attachment_path' => $idPath,
        ]);

        Mail::to(config('support.kyc_team_email'))->queue(new SupportReceived($ticket));

        return back()->with('success','KYC submitted successfully. We will notify you once verification is complete.');
    }

    public function faq()
    {
        $faqs = cache()->remember('support.faqs', 3600, function () {
            // ideally from DB: SupportFaq::orderBy('priority')->get();
            return [
                ['q'=>'How long does verification take?','a'=>'Typical KYC processing time is 24-72 hours.'],
                ['q'=>'How are bonuses paid?','a'=>'Bonuses are paid within 7 business days after verification.'],
            ];
        });

        return view('landing.support.faq', compact('faqs'));
    }

    public function reportForm() {
        return view('landing.support.report');
    }

    public function submitReport(Request $r) {
        $r->validate([
            'title'=>'required|string|max:150',
            'url'=>'nullable|url',
            'description'=>'required|string|min:10',
            'severity'=>'required|in:low,normal,high,critical',
            'attachment'=>'nullable|file|mimes:png,jpg,jpeg,pdf,zip,txt|max:10240'
        ]);

        $path = null;
        if ($r->hasFile('attachment')) {
            $path = $r->file('attachment')->store('support/reports','private');
        }

        $ticket = SupportTicket::create([
            'user_id'=>auth()->id(),
            'subject'=> $r->title,
            'message'=> $r->description . ($r->url ? ("\n\nURL: ".$r->url) : ''),
            'type' => 'technical',
            'priority' => $r->severity,
            'meta' => ['reported_at'=>now()->toDateTimeString(), 'browser'=> $r->header('User-Agent')],
            'attachment_path' => $path,
        ]);

        return back()->with('success','Issue reported. Thank you — our technical team will investigate.');
    }

}
