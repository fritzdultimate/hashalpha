@extends('layouts.auth')
@section('title','Reset Password')

@section('content')
<div class="halpha-flex halpha-flex-col halpha-items-center halpha-gap-4">
  <h1 class="halpha-text-2xl halpha-font-semibold">Reset Password</h1>
  <p class="halpha-text-sm halpha-text-gray-400">Set a new password for your account.</p>

  <form method="POST" action="{{ route('password.update') }}" class="halpha-w-full halpha-mt-4">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}" />
    <input name="email" type="email" required placeholder="you@example.com" class="halpha-w-full halpha-px-4 halpha-py-3 halpha-rounded-xl halpha-border halpha-border-gray-700 halpha-bg-transparent" />
    <input name="password" type="password" required placeholder="New password" class="halpha-w-full halpha-px-4 halpha-py-3 halpha-rounded-xl halpha-border halpha-border-gray-700 halpha-bg-transparent halpha-mt-3" />
    <input name="password_confirmation" type="password" required placeholder="Confirm password" class="halpha-w-full halpha-px-4 halpha-py-3 halpha-rounded-xl halpha-border halpha-border-gray-700 halpha-bg-transparent halpha-mt-3" />
    <button class="halpha-w-full halpha-py-3 halpha-rounded-xl halpha-bg-blue-600 halpha-mt-3">Reset password</button>
  </form>
</div>
@endsection
