<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Livewire\Attributes\On;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode as SimpleSoftwareIO;

class QrCode extends Component {
    public $qrCode;

    public function mount() {
        $this->qrCode = null;
    }

    #[On('address-available')]
    public function setQrCode($address) {
        $this->qrCode = $this->generateQr($address);
    }

    private function generateQr($walletAddress) {
        // $walletAddress = '0x123abc456...';
        $logoPath = public_path('images/coin-logo.png');
        $size = 512;
        $logoRatio = 0.12;
        $logoSize = intval($size * $logoRatio);
        $logoX = intval(($size - $logoSize) / 2);
        $logoY = intval(($size - $logoSize) / 2);

        $dir = public_path('qrcodes');
        if (! File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }
        
        $final_name = Auth::id() . '_' . time() . '_' . '.svg';
        $outputSvg = "$dir/$final_name";

        $svg = SimpleSoftwareIO::format('svg')
            ->size($size)
            ->margin(2)
            ->errorCorrection('H')
            ->generate($walletAddress);

        if (! file_exists($logoPath)) {
            abort(500, 'Logo not found: ' . $logoPath);
        }

        $logoData = base64_encode(file_get_contents($logoPath));
        $logoMime = mime_content_type($logoPath); // e.g. image/png


        $circleSvg = "<circle cx=\"" . ($size/2) . "\" cy=\"" . ($size/2) . "\" r=\"" . ($logoSize/2 + 8) . "\" fill=\"#ffffff\" />";
        $imageSvg  = "<image href=\"data:{$logoMime};base64,{$logoData}\" x=\"{$logoX}\" y=\"{$logoY}\" width=\"{$logoSize}\" height=\"{$logoSize}\" preserveAspectRatio=\"xMidYMid slice\" />";


        $injected = preg_replace('/<\/svg>$/', $circleSvg . $imageSvg . '</svg>', $svg);

        file_put_contents($outputSvg, $injected);

        return asset("qrcodes/$final_name");
    }
    public function render() {
        return view('livewire.qr-code');
    }
}
