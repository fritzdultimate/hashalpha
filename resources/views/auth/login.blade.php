@extends('layouts.auth')
@section('title','Login')

@section('content')
<div class="halpha-flex halpha-flex-col halpha-items-center halpha-gap-4 halpha-pt-2">
  <div class="halpha-rounded-full halpha-w-16 halpha-h-16 halpha-flex halpha-items-center halpha-justify-center halpha-bg-white halpha-bg-opacity-5">
    <svg class="halpha-w-7 halpha-h-7 halpha-text-white halpha-opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11a4 4 0 10-8 0M12 14v7"></path>
    </svg>
  </div>

  <h1 class="halpha-text-2xl halpha-font-semibold">Welcome back</h1>
  <p class="halpha-text-sm halpha-text-gray-400">Please fill your email and password to sign in.</p>

  <form method="POST" action="{{ route('login.attempt') }}" class="halpha-w-full halpha-mt-2">
    @csrf

    <div class="halpha-space-y-4">
      <div>
        <label for="email" class="halpha-text-xs halpha-text-gray-400">Email</label>
        <input id="email" name="email" type="email" required value="{{ old('email') }}"
          class="input halpha-w-full halpha-px-4 halpha-py-3 halpha-rounded-xl halpha-border halpha-border-gray-700 halpha-bg-transparent focus:halpha-ring-0 focus:halpha-outline-none" />
        @error('email') <div class="halpha-text-xs halpha-text-red-400 halpha-mt-1">{{ $message }}</div> @enderror
      </div>

      <div>
        <label for="password" class="halpha-text-xs halpha-text-gray-400">Password</label>
        <input id="password" name="password" type="password" required
          class="input halpha-w-full halpha-px-4 halpha-py-3 halpha-rounded-xl halpha-border halpha-border-gray-700 halpha-bg-transparent focus:halpha-ring-0 focus:halpha-outline-none" />
        @error('password') <div class="halpha-text-xs halpha-text-red-400 halpha-mt-1">{{ $message }}</div> @enderror
      </div>

      <div class="halpha-flex halpha-items-center halpha-justify-between halpha-text-sm">
        <label class="halpha-flex halpha-items-center halpha-gap-2 halpha-text-gray-300">
          <input type="checkbox" name="remember" class="halpha-form-checkbox halpha-h-4 halpha-w-4" />
          <span>Remember me</span>
        </label>
        <a href="{{ route('password.request') }}" class="halpha-text-sm halpha-text-gray-400 hover:halpha-underline">Forgot password?</a>
      </div>

      <div>
        <button type="submit" class="halpha-w-full halpha-py-3 halpha-rounded-xl halpha-bg-gradient-to-r halpha-from-blue-600 halpha-to-purple-600 halpha-font-semibold">Sign in</button>
      </div>

      <div class="halpha-text-center halpha-text-sm halpha-text-gray-400">
        <span>Don’t have an account?</span>
        <a href="{{ route('register') }}" class="halpha-text-white halpha-underline">Register</a>
      </div>
    </div>
  </form>
</div>
@endsection
