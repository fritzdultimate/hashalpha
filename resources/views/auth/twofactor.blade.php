@extends('layouts.auth')
@section('title','Two-step verification')

@section('content')
<div class="halpha-flex halpha-flex-col halpha-items-center halpha-gap-4">
  <h1 class="halpha-text-2xl halpha-font-semibold">Two-step verification</h1>
  <p class="halpha-text-sm halpha-text-gray-400">Enter the 6-digit code sent to your email.</p>

  <form method="POST" action="{{ route('2fa.verify') }}" class="halpha-w-full halpha-mt-4">
    @csrf
    <input name="code" type="text" inputmode="numeric" maxlength="6" placeholder="123456" class="halpha-w-full halpha-text-center halpha-tracking-widest halpha-px-4 halpha-py-3 halpha-rounded-xl halpha-border halpha-border-gray-700 halpha-bg-transparent halpha-text-lg" />
    @error('code') <div class="halpha-text-xs halpha-text-red-400 halpha-mt-1">{{ $message }}</div> @enderror
    <div class="halpha-flex halpha-justify-between halpha-items-center halpha-mt-4 halpha-text-sm halpha-text-gray-400">
      <a href="{{ route('password.request') }}" class="halpha-underline">Resend code</a>
      <button class="halpha-bg-blue-600 halpha-px-4 halpha-py-2 halpha-rounded-xl">Verify</button>
    </div>
  </form>
</div>
@endsection
