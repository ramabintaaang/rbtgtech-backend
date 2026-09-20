@extends('layouts.guest')

@section('title', 'Login - RBTGTech Admin')

@section('content')
<div class="w-full max-w-md bg-surface-container-lowest rounded-2xl p-8 soft-shadow border border-outline-variant">
    <!-- Header Logo & Title -->
    <div class="flex flex-col items-center text-center mb-8">
        <div class="h-16 flex items-center justify-center mb-3">
            <img src="{{ asset('logo-rbtgtech.png') }}" alt="RBTG Tech Logo" class="h-14 w-auto object-contain"/>
        </div>
        <h1 class="text-headline-md font-headline-md font-bold text-on-surface">Admin Login</h1>
        <p class="text-body-md text-on-surface-variant mt-1">Masuk ke Dashboard RBTGTech</p>
    </div>

    <!-- Error Alerts -->
    @if ($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-error-container text-on-error-container text-body-md flex items-start gap-3">
            <span class="material-symbols-outlined text-error text-[20px] shrink-0 mt-0.5">error</span>
            <div>
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Field -->
        <div>
            <label for="email" class="block text-label-md font-label-md text-on-surface mb-2 font-semibold">Alamat Email</label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">mail</span>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email', 'admin@rbtgtech.com') }}" 
                    required 
                    autofocus 
                    class="w-full bg-surface-container-low border border-outline-variant rounded-xl pl-11 pr-4 py-3 text-body-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                    placeholder="nama@email.com"
                />
            </div>
        </div>

        <!-- Password Field -->
        <div>
            <label for="password" class="block text-label-md font-label-md text-on-surface mb-2 font-semibold">Password</label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">lock</span>
                <input 
                    id="password" 
                    type="password" 
                    name="password" 
                    required 
                    class="w-full bg-surface-container-low border border-outline-variant rounded-xl pl-11 pr-4 py-3 text-body-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"
                    placeholder="••••••••"
                />
            </div>
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between text-body-md pt-1">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remember" class="w-4 h-4 rounded text-primary focus:ring-primary border-outline-variant bg-surface-container-low">
                <span class="text-on-surface-variant text-label-md">Ingat saya</span>
            </label>
        </div>

        <!-- Submit Button -->
        <button 
            type="submit" 
            class="w-full bg-primary hover:bg-surface-tint text-on-primary font-bold text-label-md py-3.5 rounded-xl flex items-center justify-center gap-2 transition-colors soft-shadow mt-6"
        >
            <span>Masuk ke Dashboard</span>
            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
        </button>
    </form>
</div>
@endsection
