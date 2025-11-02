<div class="">
    <div
        class="halpha-w-full sm:halpha-max-w-2xl halpha-mx-auto halpha-bg-gradient-to-b halpha-from-[#0b0b0b] halpha-to-[#0b0b0b]/80 halpha-rounded-2xl halpha-shadow-xl halpha-overflow-hidden section small">

        <!-- <img src="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dfd7898bb88ef1b6c53a2b_contact-card-bg-top-cryptomatic-webflow-ecommerce-template.png"
            loading="eager"
            sizes="(max-width: 479px) 100vw, (max-width: 991px) 95vw, (max-width: 1439px) 55vw, 727.6015625px" alt=""
            class="bg-gradient-top height-66d"> -->

        <div class="halpha-p-3 sm:halpha-p-8 halpha-flex halpha-flex-col halpha-gap-3 halpha-items-center">

            <img src="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64e656a83eb4595b1e9c44bf_password-page-circle-icon-cryptomatic-webflow-ecommerce-template.png"
                class="halpha-w-16 !halpha-z-10" alt="icon">

            <h2 class="halpha-text-2xl sm:halpha-text-3xl halpha-text-gray-200 halpha-font-semibold !halpha-z-10">
                Password Recovery</h2>
            <p class="halpha-text-gray-400 halpha-text-sm sm:halpha-text-base halpha-text-center !halpha-z-10">
                Please provide your email address registered with us.
            </p>

            @error('email')
                <span class="halpha-text-red-400 halpha-text-sm">{{ $message }}</span>
            @enderror

            <form wire:submit.prevent="send" class="halpha-w-full">
                <div class="halpha-space-y-4">
                    <input wire:model.defer="email" type="email" placeholder="Enter your email address"
                        class="halpha-w-full halpha-bg-transparent halpha-border halpha-border-gray-700 halpha-rounded-[22px] halpha-py-4 halpha-px-5 halpha-text-lg halpha-placeholder-gray-400 halpha-focus:outline-none input !z-10">

                    <!-- <div class="halpha-flex halpha-items-center halpha-justify-between halpha-text-sm">
                        <label class="halpha-flex halpha-items-center halpha-gap-2 halpha-text-gray-400">
                            <input 
                                wire:model="remember" 
                                type="checkbox" 
                                class="halpha-h-4 halpha-w-4 halpha-rounded 
                                halpha-border-gray-600 halpha-bg-transparent 
                                focus:halpha-outline-none focus:halpha-ring-0 focus:halpha-ring-offset-0 
                                checked:!halpha-bg-gray-600 checked:halpha-border-gray-600 
                                halpha-text-gray-200 halpha-cursor-pointer"
                            /> 
                            <span>logout other devices</span>
                        </label>

                        <a href="{{ route('login') }}" class="halpha-text-gray-400 hover:halpha-underline">
                            Forgot password?
                        </a>
                    </div> -->

                    <button wire:loading.attr="disabled" type="submit"
                        class="halpha-w-full halpha-py-3 halpha-rounded-full halpha-font-bold halpha-bg-gray-200 halpha-text-gray-800 !halpha-mt-5 hover:halpha-opacity-95" wire:loading.class="hover:halpha-opacity-100 halpha-opacity-50">
                        <span wire:loading.remove wire:target="send">Send Code</span>
                        <x-codicon-loading wire:loading wire:target="send" class="halpha-w-5 halpha-h-5 halpha-animate-spin" />
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
    <style>
        /* small extra polish so mobile looks like your reference while large screens look mature */
        @media (min-width: 1024px) {
            .halpha-rounded-\[22px\] {
                border-radius: 18px;
            }
        }
    </style>
@endpush