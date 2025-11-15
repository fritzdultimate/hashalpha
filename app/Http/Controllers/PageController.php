<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PageController extends Controller {

    public function index() {
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

        return view('landing.home', compact('milestones'));
    }
}
