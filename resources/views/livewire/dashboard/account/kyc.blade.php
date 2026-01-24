<div class="halpha-space-y-6">

    <div>
        <h1 class="halpha-text-xl halpha-font-semibold halpha-text-white">
            Identity Verification (KYC)
        </h1>
        <p class="halpha-text-xs halpha-text-gray-400">
            Complete verification to unlock full account access.
        </p>
    </div>

    {{-- Status --}}
    <div class="halpha-card halpha-p-3 halpha-text-xs">
        <span class="halpha-text-gray-400">Status:</span>
        <span class="
            halpha-font-semibold
            @if($kyc?->status === 'approved') halpha-text-success
            @elseif($kyc?->status === 'rejected') halpha-text-danger
            @elseif($kyc) halpha-text-yellow-600
            @else halpha-text-gray-300
            @endif
        ">
            {{ ucfirst($kyc->status ?? 'Not Submitted') }}
        </span>
    </div>

    {{-- Info --}}
    <div class="halpha-card halpha-bg-card-soft halpha-p-3 halpha-text-xs halpha-text-gray-400">
        <ul class="halpha-list-disc halpha-pl-4 halpha-space-y-1">
            <li>Use valid government-issued documents only.</li>
            <li>Ensure images are clear and readable.</li>
            <li>Verification is reviewed within 24–48 hours.</li>
            <li>Documents are encrypted and securely stored.</li>
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
    @if(!$kyc || $kyc->status === 'rejected')
        <div class="halpha-card halpha-p-4 halpha-space-y-4">

            <input wire:model="address" placeholder="Full Address" class="halpha-input" />

            <input wire:model="country" placeholder="Country"
                class="halpha-input" />

            <input
                wire:model="date_of_birth"
                type="text"
                class="halpha-input"
                onfocus="this.type='date'"
                onblur="if(!this.value)this.type='text'"
                placeholder="Date of Birth"
            />

            <select wire:model="document_type" class="halpha-input">
                <option value="passport">Passport</option>
                <option value="national_id">National ID</option>
                <option value="drivers_license">Driver’s License</option>
            </select>

            <div class="halpha-grid halpha-grid-cols-1 md:halpha-grid-cols-3 halpha-gap-5">

                <div class="halpha-space-y-2 halpha-flex halpha-flex-col">

                    <p class="halpha-text-xs halpha-text-gray-400">
                        Front of Identification Document
                    </p>

                    <label
                        class="halpha-card halpha-border halpha-border-dashed halpha-border-gray-600
                            halpha-p-4 halpha-text-center halpha-cursor-pointer
                            hover:halpha-border-accent-2 halpha-transition">

                        <input type="file" wire:model="document_front" class="halpha-hidden" accept="image/*">

                        @if ($document_front)
                            <img
                                src="{{ $document_front->temporaryUrl() }}"
                                class="halpha-w-full halpha-h-40 halpha-object-cover halpha-rounded"
                            >
                            <p class="halpha-text-xs halpha-text-gray-400 halpha-mt-2">
                                Click to replace image
                            </p>
                        @else
                            <div class="halpha-space-y-2">
                                <div class="halpha-text-gray-500">
                                    📤
                                </div>
                                <p class="halpha-text-xs halpha-text-gray-300">
                                    Upload document front
                                </p>
                                <p class="halpha-text-[10px] halpha-text-gray-500">
                                    JPG or PNG • Max 4MB
                                </p>
                            </div>
                        @endif

                    </label>

                </div>

                <div class="halpha-space-y-2 halpha-flex halpha-flex-col">

                    <p class="halpha-text-xs halpha-text-gray-400">
                        Back of Identification Document (optional)
                    </p>

                    <label class="halpha-card halpha-border halpha-border-dashed halpha-border-gray-600 halpha-p-4 halpha-text-center halpha-cursor-pointer hover:halpha-border-accent-2 halpha-transition">

                        <input type="file" wire:model="document_back" class="halpha-hidden" accept="image/*">

                        @if ($document_back)
                            <img src="{{ $document_back->temporaryUrl() }}"
                                class="halpha-w-full halpha-h-40 halpha-object-cover halpha-rounded">
                            <p class="halpha-text-xs halpha-text-gray-400 halpha-mt-2">
                                Click to replace image
                            </p>
                        @else
                            <div class="halpha-space-y-2">
                                <div class="halpha-text-gray-500">
                                    📤
                                </div>
                                <p class="halpha-text-xs halpha-text-gray-300">
                                    Upload document back
                                </p>
                                <p class="halpha-text-[10px] halpha-text-gray-500">
                                    JPG or PNG • Max 4MB
                                </p>
                            </div>
                        @endif

                    </label>

                </div>

            </div>

            <div 
                wire:loading wire:target="document_front,document_back,selfie"
                class="halpha-text-xs halpha-text-accent-2"
            >
                Uploading image, please wait…
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
                We couldn’t submit your verification
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
