<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ResourceController extends Controller
{
    public function index() {
        $resources = [
            ['title'=>'GitBook', 'type'=>'external', 'url'=>'https://yourproject.gitbook.io', 'description'=>'Full developer & user docs'],
            ['title'=>'Roadmap', 'type'=>'internal', 'url'=>route('resources.roadmap'), 'description'=>'Planned features & delivery timeline'],
            ['title'=>'Whitepaper', 'type'=>'download', 'url'=>route('resources.whitepaper.download'), 'description'=>'In-depth tokenomics & system architecture'],
            ['title'=>'Media Kit / Brand Assets', 'type'=>'download', 'url'=>route('resources.media.download'), 'description'=>'Logos, fonts, banners and brand guidelines'],
            ['title'=>'Blog / Announcements', 'type'=>'external', 'url'=>'/blog', 'description'=>'Platform updates and release notes'],
        ];

        return view('landing.resources.index', compact('resources'));
    }

    public function roadmap() {
        $milestones = [
            [
                'phase' => 'Foundation',
                'date' => 'Q1 2025',
                'title' => 'MVP & Core Architecture',
                'summary' => 'Complete MVP: registration, wallet generation, passphrase services, basic affiliate flow.',
                'status' => 'completed',
                'details' => [
                    'User accounts & KYC flow',
                    'Passphrase generator (BIP-39)',
                    'Basic affiliate tracking'
                ]
            ],
            [
                'phase' => 'Growth',
                'date' => 'Q2 2025',
                'title' => 'Referral Dashboard & Monetization',
                'summary' => 'Advanced affiliate dashboard, banner pack, and first marketing campaign.',
                'status' => 'in-progress',
                'details' => [
                    'Personalized banners & QR generator',
                    'Cash bonus automation',
                    'Analytics & click tracking'
                ]
            ],
            [
                'phase' => 'Scale',
                'date' => 'Q3 2025',
                'title' => 'Multi-network Wallet Support',
                'summary' => 'Add more networks, automated balance-check workers, and Pro/ProMax features.',
                'status' => 'upcoming',
                'details' => [
                    'Add BTC, BSC, USDT support',
                    'Background balance scanner (queue workers)',
                    'Subscription billing integration'
                ]
            ],
            [
                'phase' => 'Enterprise',
                'date' => 'Q4 2025',
                'title' => 'Admin Portal & Partner API',
                'summary' => 'Public API for partners, richer analytics for enterprise clients, marketplace.',
                'status' => 'upcoming',
                'details' => [
                    'Partner API docs (GitBook)',
                    'Marketplace for affiliate assets',
                    'Role-based admin controls'
                ]
            ],
        ];

        return view('landing.resources.roadmap', compact('milestones'));
    }

    public function downloadWhitepaper() {
        $path = 'public/resources/whitepaper.pdf';
        if (!Storage::exists($path)) {
            abort(404, 'Whitepaper not found.');
        }

        return Storage::download($path, 'whitepaper.pdf');
    }

    public function downloadMediaKit() {
        $path = 'public/resources/media-kit.zip';
        if (!Storage::exists($path)) {
            abort(404, 'Media kit not found.');
        }

        return Storage::download($path, 'media-kit.zip');
    }
}
