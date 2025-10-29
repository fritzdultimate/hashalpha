@extends('layouts.guest')
@section('title', 'Contact Support')
@section('content')

    <div class="halpha-max-w-3xl halpha-mx-auto halpha-px-6 halpha-py-12">
        <div class="halpha-bg-[#0b0b0d] halpha-rounded-2xl halpha-p-6 halpha-border halpha-border-gray-800">
            <h2 class="halpha-text-2xl halpha-font-semibold">Contact Support</h2>
            <p class="halpha-text-sm halpha-text-gray-400 halpha-mt-2">General enquiries — we usually reply within 24 hours.
            </p>

            <form action="{{ route('support.contact.submit') }}" method="post" class="halpha-mt-6"
                enctype="multipart/form-data">
                @csrf
                <div class="halpha-grid halpha-gap-4">
                    <input name="name" placeholder="Full name" value="{{ old('name') }}"
                        class="halpha-w-full halpha-px-4 halpha-py-3 halpha-rounded halpha-bg-[#070708] halpha-border !halpha-border-gray-700 halpha-text-gray-300 focus:halpha-outline-none focus:halpha-ring-0" />
                    <input name="email" placeholder="Email address" value="{{ old('email') }}"
                        class="halpha-w-full halpha-px-4 halpha-py-3 halpha-rounded halpha-bg-[#070708] halpha-border !halpha-border-gray-700 halpha-text-gray-300 focus:halpha-outline-none focus:halpha-ring-0" />
                    <input name="subject" placeholder="Subject" value="{{ old('subject') }}"
                        class="halpha-w-full halpha-px-4 halpha-py-3 halpha-rounded halpha-bg-[#070708] halpha-border !halpha-border-gray-700 halpha-text-gray-300 focus:halpha-outline-none focus:halpha-ring-0" />
                    <textarea name="message" placeholder="How can we help?" rows="6"
                        class="halpha-w-full halpha-px-4 halpha-py-3 halpha-rounded halpha-bg-[#070708] halpha-border !halpha-border-gray-700 halpha-text-gray-300 focus:halpha-outline-none focus:halpha-ring-0">{{ old('message') }}</textarea>

                    <div>
                        <label class="halpha-text-xs halpha-text-gray-400">Attachment (optional)</label>
                        <input type="file" name="attachment" class="halpha-mt-2" />
                    </div>

                    <div>
                        <button class="!halpha-bg-blue-600 halpha-text-white halpha-px-4 halpha-py-2 halpha-rounded">Send
                            Message</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection