<?php

namespace App\Http\Controllers;

class LegalController extends Controller
{

    public function terms() {
        return view('landing.legal.terms', [
            'lastUpdated' => 'January 2026',

            'intro' => 'These Terms and Conditions govern the use of the Hashalpha platform, including staking, account access, digital assets, and related services.',

            'sections' => [
                [
                    'title' => '1. Definitions',
                    'paragraphs' => [
                        '“Platform” refers to the Hashalpha digital asset platform...',
                        '“User” means any individual or entity accessing the services...',
                    ],
                ],

                [
                    'title' => '2. Eligibility',
                    'paragraphs' => [
                        'Users must be at least 18 years of age...',
                    ],
                ],

                [
                    'title' => '3. Staking & Investment Risks',
                    'paragraphs' => [
                        'Cryptocurrency staking involves substantial risk...',
                        'Returns are not guaranteed...',
                    ],
                    'list' => [
                        'Market volatility',
                        'Smart contract risks',
                        'Regulatory uncertainty',
                    ]
                ],

                // Continue until EVERY section in the PDF is represented
            ]
        ]);
    }
}
