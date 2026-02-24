<div class="">
    <div
        class="halpha-w-full sm:halpha-max-w-2xl halpha-mx-auto halpha-bg-gradient-to-b halpha-from-[#0b0b0b] halpha-to-[#0b0b0b]/80 halpha-rounded-2xl halpha-shadow-xl halpha-overflow-hidden section small">

        <!-- <img src="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dfd7898bb88ef1b6c53a2b_contact-card-bg-top-cryptomatic-webflow-ecommerce-template.png"
            loading="eager"
            sizes="(max-width: 479px) 100vw, (max-width: 991px) 95vw, (max-width: 1439px) 55vw, 727.6015625px" alt=""
            class="bg-gradient-top height-66 link-item-dark-image !halpha-border !halpha-z-[2]"> -->

        <div class="halpha-p-3 sm:halpha-p-8 halpha-flex halpha-flex-col halpha-gap-3 halpha-items-center">
            <img src="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64d539504d98654e1c7fa66f_create-an-account-circle-icon-cryptomatic-webflow-ecommerce-template.png"
                class="halpha-w-16 !halpha-z-10" alt="icon">

            <h2 class="halpha-text-2xl sm:halpha-text-3xl halpha-text-gray-200 halpha-font-semibold !halpha-z-10">
                Create account</h2>
            <p class="halpha-text-gray-400 halpha-text-sm sm:halpha-text-base halpha-text-center !halpha-z-10">
                Create your secure account — quick and free.
            </p>

            @if ($errors->any())
                <span class="halpha-text-red-400 halpha-text-sm halpha-text-center">
                    {{ $errors->first() }}
                </span>
            @endif

            <form wire:submit.prevent="submit" class="halpha-w-full">
                <div class="halpha-space-y-4">
                    <input type="hidden" wire:model="ref">
                    <input wire:model.defer="fullname" type="text" placeholder="Enter your legal full name"
                        class="halpha-w-full !halpha-bg-transparent halpha-border halpha-border-gray-700 halpha-rounded-[22px] halpha-py-4 halpha-px-5 halpha-text-lg halpha-placeholder-gray-400 halpha-focus:outline-none input">

                    <input wire:model.defer="email" type="email" placeholder="Enter your email address"
                        class="halpha-w-full !halpha-bg-transparent halpha-border halpha-border-gray-700 halpha-rounded-[22px] halpha-py-4 halpha-px-5 halpha-text-lg halpha-placeholder-gray-400 halpha-focus:outline-none input">

                    <div x-data="{ show: false }" class="halpha-relative">

                        <input 
                            :type="show ? 'text' : 'password'"
                            wire:model.defer="password"
                            placeholder="Enter your password"
                            class="halpha-w-full halpha-bg-transparent halpha-border halpha-border-gray-700 halpha-rounded-[22px] halpha-py-4 halpha-px-5 halpha-pr-12 halpha-text-lg halpha-placeholder-gray-400 halpha-focus:outline-none input"
                        >

                        {{-- Eye Toggle --}}
                        <button 
                            type="button"
                            @click="show = !show"
                            class="halpha-absolute halpha-right-4 halpha-top-1/2 -halpha-translate-y-1/2 halpha-text-gray-400 hover:halpha-text-white halpha-transition"
                        >

                            {{-- Eye (show password) --}}
                            <svg x-show="!show" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="halpha-w-6 halpha-h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0c-1.5 4-5 7-9 7s-7.5-3-9-7c1.5-4 5-7 9-7s7.5 3 9 7z" />
                            </svg>

                            {{-- Eye Off (hide password) --}}
                            <svg x-show="show" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="halpha-w-6 halpha-h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4 0-7.5-3-9-7a9.956 9.956 0 012.042-3.368M6.223 6.223A9.956 9.956 0 0112 5c4 0 7.5 3 9 7a9.956 9.956 0 01-4.293 5.042M15 12a3 3 0 00-4.243-2.828M3 3l18 18" />
                            </svg>

                        </button>

                    </div>

                    <div x-data="{ show: false }" class="halpha-relative">

                        <input 
                            :type="show ? 'text' : 'password'"
                            wire:model.defer="password_confirmation"
                            placeholder="Confirm your password"
                            class="halpha-w-full halpha-bg-transparent halpha-border halpha-border-gray-700 halpha-rounded-[22px] halpha-py-4 halpha-px-5 halpha-pr-12 halpha-text-lg halpha-placeholder-gray-400 halpha-focus:outline-none input"
                        >

                        {{-- Eye Toggle --}}
                        <button 
                            type="button"
                            @click="show = !show"
                            class="halpha-absolute halpha-right-4 halpha-top-1/2 -halpha-translate-y-1/2 halpha-text-gray-400 hover:halpha-text-white halpha-transition"
                        >

                            {{-- Eye (show password) --}}
                            <svg x-show="!show" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="halpha-w-6 halpha-h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0c-1.5 4-5 7-9 7s-7.5-3-9-7c1.5-4 5-7 9-7s7.5 3 9 7z" />
                            </svg>

                            {{-- Eye Off (hide password) --}}
                            <svg x-show="show" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="halpha-w-6 halpha-h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4 0-7.5-3-9-7a9.956 9.956 0 012.042-3.368M6.223 6.223A9.956 9.956 0 0112 5c4 0 7.5 3 9 7a9.956 9.956 0 01-4.293 5.042M15 12a3 3 0 00-4.243-2.828M3 3l18 18" />
                            </svg>

                        </button>

                    </div>

                    <input wire:model.defer="ref" type="text" placeholder="Sponsor code" required
                        class="halpha-w-full !halpha-bg-transparent halpha-border halpha-border-gray-700 halpha-rounded-[22px] halpha-py-4 halpha-px-5 halpha-text-lg halpha-placeholder-gray-400 halpha-focus:outline-none input">

                    

                    <label class="halpha-flex halpha-items-center halpha-gap-2 halpha-justify-center">
                        <input 
                            wire:model="terms" 
                            type="checkbox" 
                            class="halpha-h-4 halpha-w-4 halpha-rounded 
                                halpha-border-gray-600 halpha-bg-transparent 
                                focus:halpha-outline-none focus:halpha-ring-0 focus:halpha-ring-offset-0 
                                checked:!halpha-bg-gray-600 checked:halpha-border-gray-600 
                                halpha-text-gray-200 halpha-cursor-pointer"
                        /> 
                        <span class="@error('terms') halpha-text-red-500 @else halpha-text-gray-500 @enderror">
                            I hereby accept all the <a class="halpha-text-gray-400" href="{{ route('terms') }}"> terms & conditions </a>
                        </span>
                    </label>

                    <button wire:loading.attr="disabled" type="submit"
                        class="halpha-w-full halpha-py-3 halpha-rounded-full halpha-font-bold halpha-bg-gray-200 halpha-text-gray-800 halpha-mt-8 hover:halpha-opacity-95" wire:loading.class="hover:halpha-opacity-100 halpha-opacity-50">
                        <span wire:loading.remove wire:target="submit">{{ $statusMessage ?: 'Register' }}</span>
                        <x-codicon-loading wire:loading wire:target="submit" class="halpha-w-5 halpha-h-5 halpha-animate-spin" />
                    </button>
                    
                    <p class="halpha-text-white halpha-text-center">
                        Already have an account? <a class="halpha-text-gray-400" href="{{ route('login') }}">Login</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
    <style>
        @media (min-width: 1024px) {
            .halpha-rounded-\[22px\] {
                border-radius: 18px;
            }
        }
    </style>
@endpush