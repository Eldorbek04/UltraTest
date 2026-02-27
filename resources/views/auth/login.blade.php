@extends('layouts.sitefrond')

@section('title')
ULTRATEST | Login  — Intellektual Test Platformasi
@endsection
@section('content')
<div class="auth-card">
@if ($errors->any())
    <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        <ul style="list-style: none;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="header">
        <div class="mini-logo">ULTRA<span>TEST</span></div>
        <p>Tizimga kirish</p>
    </div>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <input
            type="email"
            name="email"
            placeholder="Email manzil"
            value="{{ old('email') }}"
            required
            autofocus
        >
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror

        <input
            type="password"
            name="password"
            placeholder="Parol"
            required
        >
        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror

        <label class="remember">
            <input type="checkbox" name="remember">
            Eslab qolish
        </label>

        <button type="submit" class="btn-submit">
            Kirish
        </button>
    </form>
    <div class="footer">
        @if (Route::has('password.request'))
            <div style="margin-bottom: 8px;">
                <a href="{{ route('password.request') }}">Parolni unutdingizmi?</a>
            </div>
        @endif
        <span>Hisob yo‘qmi?</span>
        <a href="{{ route('register') }}">Ro‘yxatdan o‘tish</a>
    </div>
</div>
@endsection
