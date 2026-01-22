<?php

namespace App\Livewire\Dashboard\Transparency;

use App\Models\Stake;
use App\Models\StakingPlan;
use App\Models\ValidatorKey;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Validator extends Component {
    use WithPagination;
    public string $search = '';
    public string $status = 'all';
    public string $region = 'all';

    public bool $showDetails = false;
    public ?array $selectedValidator = null;

    public function viewValidator(array $validator) {
        $this->selectedValidator = $validator;
        $this->showDetails = true;
    }

    public function closeModal() {
        $this->reset('showDetails', 'selectedValidator');
    }

    public function getValidatorsProperty()
    {
        // TEMP STATIC DATA (replace later)
        $validators = collect([
            [
                'id' => 1,
                'name' => 'Validator #1',
                'pubkey' => '0xA91F82D3',
                'status' => 'active',
                'uptime' => '99.8%',
                'region' => 'EU',
                'client' => 'Prysm / Geth',
                'risk' => 'Low',
            ],
            [
                'id' => 2,
                'name' => 'Validator #2',
                'pubkey' => '0xBB21C9AF',
                'status' => 'maintenance',
                'uptime' => '98.9%',
                'region' => 'US',
                'client' => 'Lighthouse / Nethermind',
                'risk' => 'Medium',
            ],
        ]);

        return $validators
            ->filter(fn ($v) =>
                ($this->status === 'all' || $v['status'] === $this->status) &&
                ($this->region === 'all' || $v['region'] === $this->region) &&
                (str_contains(strtolower($v['name']), strtolower($this->search)))
            );
    }

    public function render() {
        $validators = ValidatorKey::query()
            ->when($this->search, fn ($q) =>
                $q->where('public_key', 'like', "%{$this->search}%")
                   ->orWhere('label', 'like', "%{$this->search}%")
            )
            ->when($this->status !== 'all', fn ($q) =>
                $q->where('status', $this->status)
            )
            ->when($this->region !== 'all', fn ($q) =>
                $q->where('meta->region', $this->region)
            )
            ->latest()
            ->paginate(10);
        return view('livewire.dashboard.transparency.validator', [
            'validators' => $validators,
        ]);
    }
}
