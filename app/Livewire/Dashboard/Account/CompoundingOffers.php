<?php

namespace App\Livewire\Dashboard\Account;

use App\Models\CompoundingOffer as CompoundingOfferModel;
use App\Models\Stake;
use App\Services\CompoundingOfferService;
use DomainException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class CompoundingOffers extends Component
{
    public bool $notifyDaily = false;
    public bool $loading = false;

    public function getPendingOfferProperty()
    {
        $offer = CompoundingOfferModel::where('user_id', auth()->id())
            ->where('status', 'offered')
            ->latest('offered_at')
            ->first();

        return ($offer && $offer->isPending()) ? $offer : null;
    }

    public function getActiveTermProperty()
    {
        return Stake::where('user_id', auth()->id())
            ->where('is_compounding_offer', true)
            ->where('status', 'active')
            ->latest()
            ->first();
    }

    public function getHistoryProperty()
    {
        return CompoundingOfferModel::where('user_id', auth()->id())
            ->latest('offered_at')
            ->limit(10)
            ->get();
    }

    public function accept()
    {
        $this->loading = true;
        $this->resetErrorBag();

        $offer = $this->pendingOffer;

        if (! $offer) {
            $this->addError('offer', 'This offer is no longer available.');
            $this->loading = false;
            return;
        }

        try {
            CompoundingOfferService::accept($offer, $this->notifyDaily);
        } catch (DomainException $e) {
            $this->addError('offer', $e->getMessage());
            $this->loading = false;
            return;
        }

        $this->loading = false;
        $this->dispatch('toast', payload: [
            'message' => 'Compounding term started successfully.',
            'timeout' => 5000,
        ]);
    }

    public function decline()
    {
        $this->loading = true;
        $this->resetErrorBag();

        $offer = $this->pendingOffer;

        if (! $offer) {
            $this->addError('offer', 'This offer is no longer available.');
            $this->loading = false;
            return;
        }

        try {
            CompoundingOfferService::decline($offer);
        } catch (DomainException $e) {
            $this->addError('offer', $e->getMessage());
            $this->loading = false;
            return;
        }

        $this->loading = false;
        $this->dispatch('toast', payload: [
            'message' => 'Offer declined.',
            'timeout' => 5000,
        ]);
    }

    public function render()
    {
        return view('livewire.dashboard.account.compounding-offers');
    }
}
