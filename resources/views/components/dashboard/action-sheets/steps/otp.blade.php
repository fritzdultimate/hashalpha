<div class="halpha-space-y-3">
    <div>
        <div class="halpha-text-sm halpha-text-gray-300">Enter the OTP sent to your phone/email</div>
    </div>

    <div>
        <label class="halpha-text-xs halpha-text-gray-300">OTP</label>
        <input type="text" maxlength="6" x-model="otp"
            class="halpha-w-full halpha-mt-1 halpha-px-3 halpha-py-2 halpha-rounded halpha-bg-gray-700 halpha-text-white" />
    </div>

    <div class="halpha-flex halpha-items-center halpha-gap-2">
        <button @click="verifyOtp"
            class="halpha-flex-1 halpha-py-2 halpha-rounded halpha-bg-indigo-600 halpha-text-white">Verify</button>
        <button @click="resendOtp"
            class="halpha-px-4 halpha-py-2 halpha-rounded halpha-border halpha-border-gray-600 halpha-text-gray-300">Resend</button>
    </div>

    <div x-show="error" class="halpha-text-sm halpha-text-red-400" x-text="error"></div>
</div>