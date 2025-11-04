@extends('layouts.guest')

@section('title', 'Help Center')

@section('content')
    <div class="halpha-min-h-screen halpha-bg-[#070707] halpha-text-white halpha-px-6 halpha-py-12">
        <div class="halpha-max-w-6xl halpha-mx-auto halpha-space-y-10">

            {{-- Header --}}
            <div
                class="halpha-flex halpha-flex-col md:halpha-flex-row halpha-items-center halpha-justify-between halpha-gap-4">
                <div>
                    <h1
                        class="halpha-text-3xl halpha-font-semibold halpha-bg-clip-text halpha-text-transparent halpha-bg-gradient-to-r halpha-from-blue-500 halpha-to-purple-500">
                        Support & Help Center
                    </h1>
                    <p class="halpha-text-gray-300 halpha-mt-2">
                        Get assistance with your account, KYC, technical issues, and more.
                    </p>
                </div>

                <div>
                    <a href="{{ route('resources.index') }}"
                        class="halpha-text-sm halpha-opacity-80 hover:halpha-opacity-100 halpha-transition">← Back to
                        Resources</a>
                </div>
            </div>

            
            <div class="halpha-grid sm:halpha-grid-cols-2 lg:halpha-grid-cols-3 halpha-gap-6">
                
                <a href="{{ route('support.contact') }}"
                    class="halpha-group halpha-bg-[#0b0b0d] halpha-border halpha-border-gray-800 halpha-rounded-2xl halpha-p-6 halpha-transition halpha-duration-300 hover:halpha-border-blue-500 hover:halpha-bg-[#0d0d12]">
                    <div class="halpha-flex halpha-items-center halpha-gap-3">
                        <x-heroicon-o-envelope class="halpha-w-6 halpha-h-6 halpha-text-blue-500" />
                        <h3 class="halpha-text-lg halpha-font-semibold">Contact Form</h3>
                    </div>
                    <p class="halpha-text-sm halpha-text-gray-400 halpha-mt-2">
                        Reach our team directly for account or general inquiries.
                    </p>
                </a>

                
                <a href="{{ route('support.chat') }}"
                    class="halpha-group halpha-bg-[#0b0b0d] halpha-border halpha-border-gray-800 halpha-rounded-2xl halpha-p-6 halpha-transition halpha-duration-300 hover:halpha-border-green-500 hover:halpha-bg-[#0d0d12]">
                    <div class="halpha-flex halpha-items-center halpha-gap-3">
                        <x-heroicon-o-chat-bubble-left-right class="halpha-w-6 halpha-h-6 halpha-text-green-500" />
                        <h3 class="halpha-text-lg halpha-font-semibold">Live Chat</h3>
                    </div>
                    <p class="halpha-text-sm halpha-text-gray-400 halpha-mt-2">
                        Get instant help from our support specialists through live chat.
                    </p>
                </a>

                
                <a href="{{ route('login') }}"
                    class="halpha-group halpha-bg-[#0b0b0d] halpha-border halpha-border-gray-800 halpha-rounded-2xl halpha-p-6 halpha-transition halpha-duration-300 hover:halpha-border-yellow-500 hover:halpha-bg-[#0d0d12]">
                    <div class="halpha-flex halpha-items-center halpha-gap-3">
                        <x-heroicon-o-identification class="halpha-w-6 halpha-h-6 halpha-text-yellow-500" />
                        <h3 class="halpha-text-lg halpha-font-semibold">KYC & Account</h3>
                    </div>
                    <p class="halpha-text-sm halpha-text-gray-400 halpha-mt-2">
                        Submit or update your KYC information and verify your account.
                    </p>
                </a>

                
                <a href="{{ route('support.faq') }}"
                    class="halpha-group halpha-bg-[#0b0b0d] halpha-border halpha-border-gray-800 halpha-rounded-2xl halpha-p-6 halpha-transition halpha-duration-300 hover:halpha-border-purple-500 hover:halpha-bg-[#0d0d12]">
                    <div class="halpha-flex halpha-items-center halpha-gap-3">
                        <x-heroicon-o-question-mark-circle class="halpha-w-6 halpha-h-6 halpha-text-purple-500" />
                        <h3 class="halpha-text-lg halpha-font-semibold">Technical FAQ</h3>
                    </div>
                    <p class="halpha-text-sm halpha-text-gray-400 halpha-mt-2">
                        Find answers to common technical and account-related questions.
                    </p>
                </a>

                
                <a href="{{ route('support.report') }}"
                    class="halpha-group halpha-bg-[#0b0b0d] halpha-border halpha-border-gray-800 halpha-rounded-2xl halpha-p-6 halpha-transition halpha-duration-300 hover:halpha-border-red-500 hover:halpha-bg-[#0d0d12]">
                    <div class="halpha-flex halpha-items-center halpha-gap-3">
                        <x-heroicon-o-exclamation-triangle class="halpha-w-6 halpha-h-6 halpha-text-red-500" />
                        <h3 class="halpha-text-lg halpha-font-semibold">Report an Issue</h3>
                    </div>
                    <p class="halpha-text-sm halpha-text-gray-400 halpha-mt-2">
                        Encountered a bug or problem? Report it directly to our engineers.
                    </p>
                </a>

                {{-- if user is logged in, might remove later --}}
                @auth
                    <a href="{{ route('support.tickets') }}"
                        class="halpha-group halpha-bg-[#0b0b0d] halpha-border halpha-border-gray-800 halpha-rounded-2xl halpha-p-6 halpha-transition halpha-duration-300 hover:halpha-border-cyan-500 hover:halpha-bg-[#0d0d12]">
                        <div class="halpha-flex halpha-items-center halpha-gap-3">
                            <x-heroicon-o-folder-open class="halpha-w-6 halpha-h-6 halpha-text-cyan-500" />
                            <h3 class="halpha-text-lg halpha-font-semibold">My Tickets</h3>
                        </div>
                        <p class="halpha-text-sm halpha-text-gray-400 halpha-mt-2">
                            View the status and responses to your submitted support tickets.
                        </p>
                    </a>
                @endauth
            </div>

            
            <div class="halpha-text-center !halpha-pt-10 halpha-text-sm halpha-text-gray-500">
                <p>
                    Need urgent help? Email us at
                    <a href="mailto:support@halphalpha.io" class="halpha-text-blue-400 hover:halpha-underline">
                        support@halphalpha.io
                    </a>
                </p>
                <p class="halpha-mt-2">
                    Our support hours: <span class="halpha-text-gray-300">Mon–Sat, 9 AM – 8 PM (GMT+1)</span>
                </p>
            </div>
        </div>
    </div>
@endsection