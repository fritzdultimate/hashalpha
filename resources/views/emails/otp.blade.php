<x-mail::message>
    # Your OTP Code

    Your one-time password is: {{ $otp }}

    <x-mail::button :url="''">
        {{ $otp }}
    </x-mail::button>

    It is valid for 10 minutes.

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>