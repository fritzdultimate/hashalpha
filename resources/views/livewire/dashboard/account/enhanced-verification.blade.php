<div class="halpha-space-y-6">

    <div>
        <h1 class="halpha-text-xl halpha-font-semibold halpha-text-white">
            Enhanced Verification
        </h1>
        <!-- Required for withdrawals above ${{ number_format($this->threshold, 2) }}.  -->
        <p class="halpha-text-xs halpha-text-gray-400">
            Submit additional documents for manual review by our team.
        </p>
    </div>

    {{-- Status --}}
    <div class="halpha-card halpha-p-3 halpha-text-xs">
        <span class="halpha-text-gray-400">Status:</span>
        <span class="
            halpha-font-semibold
            @if($verification?->status === 'approved') halpha-text-success
            @elseif($verification?->status === 'rejected') halpha-text-danger
            @elseif($verification) halpha-text-yellow-600
            @else halpha-text-gray-300
            @endif
        ">
            {{ ucfirst($verification->status ?? 'Not Submitted') }}
        </span>

        @if($verification?->status === 'approved' && $verification->certificate_number)
            <p class="halpha-text-gray-400 halpha-mt-1">
                Verification reference: <span class="halpha-text-white">{{ $verification->certificate_number }}</span>
            </p>
        @endif

        @if($verification?->status === 'rejected' && $verification->admin_note)
            <p class="halpha-text-danger halpha-mt-1">{{ $verification->admin_note }}</p>
        @endif
    </div>

    {{-- Info --}}
    <div class="halpha-card halpha-bg-card-soft halpha-p-3 halpha-text-xs halpha-text-gray-400">
        <ul class="halpha-list-disc halpha-pl-4 halpha-space-y-1">
            <li>All documents are issued or reviewed by our team internally -- nothing is obtained from an outside provider.</li>
            <li>Proof of funds / source of funds documentation is required.</li>
            <li>Additional supporting documents are optional but can speed up review.</li>
            <li>Review is manual and typically completed within 24–48 hours.</li>
        </ul>
    </div>

    @if (session()->has('success'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 15000)"
            x-show="show"
            class="halpha-card halpha-border halpha-border-success halpha-p-3 halpha-text-xs"
        >
            <p class="halpha-font-medium halpha-text-success halpha-mb-1">
                Verification submitted
            </p>
            <p class="halpha-text-gray-400">
                {{ session('success') }}
            </p>
        </div>
    @endif

    {{-- Form --}}
    @if(!$verification || $verification->status === 'rejected')
        <div class="halpha-card halpha-p-4 halpha-space-y-4">

            <div class="halpha-space-y-2 halpha-flex halpha-flex-col">
                <p class="halpha-text-xs halpha-text-gray-400">Vertex Trading Document</p>
                <label
                    class="halpha-card halpha-border halpha-border-dashed halpha-border-gray-600
                        halpha-p-4 halpha-text-center halpha-cursor-pointer
                        hover:halpha-border-accent-2 halpha-transition">

                    <input type="file" wire:model="proof_of_funds_document" class="halpha-hidden">

                    @if ($proof_of_funds_document)
                        <p class="halpha-text-xs halpha-text-gray-300">{{ $proof_of_funds_document->getClientOriginalName() }}</p>
                        <p class="halpha-text-xs halpha-text-gray-400 halpha-mt-2">Click to replace file</p>
                    @else
                        <div class="halpha-space-y-2">
                            <div class="halpha-text-gray-500">📤</div>
                            <p class="halpha-text-xs halpha-text-gray-300">Upload Vertex Trading Document</p>
                            <p class="halpha-text-[10px] halpha-text-gray-500">PDF, JPG or PNG • Max 8MB</p>
                        </div>
                    @endif
                </label>
            </div>

            <div class="halpha-space-y-2 halpha-flex halpha-flex-col">
                <p class="halpha-text-xs halpha-text-gray-400">Additional Document (optional)</p>
                <label
                    class="halpha-card halpha-border halpha-border-dashed halpha-border-gray-600
                        halpha-p-4 halpha-text-center halpha-cursor-pointer
                        hover:halpha-border-accent-2 halpha-transition">

                    <input type="file" wire:model="additional_document" class="halpha-hidden">

                    @if ($additional_document)
                        <p class="halpha-text-xs halpha-text-gray-300">{{ $additional_document->getClientOriginalName() }}</p>
                        <p class="halpha-text-xs halpha-text-gray-400 halpha-mt-2">Click to replace file</p>
                    @else
                        <div class="halpha-space-y-2">
                            <div class="halpha-text-gray-500">📤</div>
                            <p class="halpha-text-xs halpha-text-gray-300">Upload additional document</p>
                            <p class="halpha-text-[10px] halpha-text-gray-500">PDF, JPG or PNG • Max 8MB</p>
                        </div>
                    @endif
                </label>
            </div>

            <textarea
                wire:model="notes"
                placeholder="Notes about the source of funds (optional)"
                class="halpha-input halpha-h-24"
            ></textarea>

            <div
                wire:loading wire:target="proof_of_funds_document,additional_document"
                class="halpha-text-xs halpha-text-accent-2"
            >
                Uploading file, please wait…
            </div>

            <button
                wire:loading.attr="disabled"
                wire:click="submit"
                class="halpha-bg-accent-2 halpha-text-white halpha-text-sm halpha-w-fullc halpha-h-10 halpha-px-4 halpha-rounded halpha-flex halpha-items-center halpha-justify-center disabled:halpha-opacity-40"
            >
                <span wire:loading.remove wire:target="submit">Submit Verification</span>
                <span wire:loading wire:target="submit" class="halpha-flex halpha-items-center">
                    <x-ri-loader-4-fill class="halpha-w-5 halpha-h-5 halpha-animate-spin" />
                </span>
            </button>

        </div>
    @endif

    @if ($errors->any())
        <div class="halpha-card halpha-border halpha-border-red-500/40 halpha-p-3 halpha-text-xs">
            <p class="halpha-font-medium halpha-mb-2 halpha-text-red-500">
                We couldn't submit your verification
            </p>
            <p class="halpha-text-gray-400 halpha-mb-2">
                Please review the information below and correct the highlighted items before continuing.
            </p>
            <ul class="halpha-list-disc halpha-pl-4 halpha-space-y-1 halpha-text-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
