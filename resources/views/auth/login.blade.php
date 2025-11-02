@extends('layouts.auth')
@section('title', 'Login')

@section('content')
    <div class="">
        <div class="halpha-flex halpha-flex-col halpha-justify-center halpha-items-center halpha-gap-8 section small">
            <!-- <div class="divider inside-card---top"></div> -->
            <img src="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dfd7898bb88ef1b6c53a2b_contact-card-bg-top-cryptomatic-webflow-ecommerce-template.png"
                loading="eager"
                sizes="(max-width: 479px) 100vw, (max-width: 991px) 95vw, (max-width: 1439px) 55vw, 727.6015625px"
                srcset="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dfd7898bb88ef1b6c53a2b_contact-card-bg-top-cryptomatic-webflow-ecommerce-template-p-500.png 500w, https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dfd7898bb88ef1b6c53a2b_contact-card-bg-top-cryptomatic-webflow-ecommerce-template-p-800.png 800w, https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dfd7898bb88ef1b6c53a2b_contact-card-bg-top-cryptomatic-webflow-ecommerce-template-p-1080.png 1080w, https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64dfd7898bb88ef1b6c53a2b_contact-card-bg-top-cryptomatic-webflow-ecommerce-template.png 2184w"
                alt="" class="bg-gradient-top height-66 link-item-dark-image !halpha-border">

            <div class="halpha-flex halpha-flex-col halpha-gap-3 halpha-items-center">
                <img src="https://cdn.prod.website-files.com/64d2cc2d27b51cf1b517c011/64d539504d98654e1c7fa66f_create-an-account-circle-icon-cryptomatic-webflow-ecommerce-template.png"
                    loading="eager" alt="Create An Account - Cryptomatic X Webflow Template" class="halpha-w-16">
                <h2 class="halpha-text-4xl halpha-text-gray-300 !halpha-mb-0">Welcome back</h2>
                <p class="halpha-text-gray-400 halpha-text-lg">Please fill your email and password to sign in.</p>
            </div>

            <form class="halpha-w-full">
                <div class="form halpha-space-y-4">
                    <div>
                        <input type="text"
                            class="input bg-transparent w-input halpha-text-xl placeholder:halpha-text-xl !halpha-rounded-[22px] !halpha-py-8 placeholder:!halpha-text-[#dddddd4d] focus:!halpha-border-none"
                            placeholder="Enter your email address">
                    </div>
                    <div>
                        <input type="password"
                            class="input bg-transparent w-input halpha-text-xl placeholder:halpha-text-xl !halpha-rounded-[22px] !halpha-py-8 placeholder:!halpha-text-[#dddddd4d]"
                            placeholder="Enter your password">
                    </div>
                    <div class="halpha-flex halpha-justify-between">
                        <div class="!halpha-flex !halpha-gap-2 !halpha-items-center">
                            <input
                                type="checkbox"
                                id="remember"
                                class="halpha-appearance-none halpha-bg-transparent 
                                        halpha-border halpha-border-[#7b8ca1]/60  <!-- blue-grayish border -->
                                        halpha-rounded halpha-w-4 halpha-h-4 
                                        halpha-cursor-pointer halpha-transition halpha-duration-200
                                        checked:halpha-bg-[#7b8ca1]/30 checked:halpha-border-[#7b8ca1]
                                        focus:halpha-outline-none focus:halpha-ring-0"
                            />
                            <label class="!halpha-mb-0 halpha-text-[#afabab] halpha-font-normal" for="remember">Remember me</label>
                        </div>

                        <a href="{{ route('login') }}" class="halpha-text-[#afabab]">
                            Forgot password?
                        </a>
                    </div>

                    <input type="submit" value="Log in" class="halpha-bg-gray-200 halpha-w-full halpha-py-4 halpha-rounded-full halpha-font-bold halpha-text-gray-800 !halpha-mt-10 halpha-cursor-pointer">
                </div>
            </form>
        </div>
    </div>
@endsection