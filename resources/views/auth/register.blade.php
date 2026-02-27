@extends('layouts.sitefrond')

@section('title')
ULTRATEST | Ro'yxatdan o'tish  — Intellektual Test Platformasi
@endsection

@section('content')

<div class="auth-card">
    <div class="header">
        <div class="mini-logo">ULTRA<span>TEST</span></div>
        <p>Ro'yxatdan o'tish</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <input
            type="text"
            name="name"
            placeholder="Ism Familya"
            value="{{ old('name') }}"
            required
        >
        @error('name')
            <div class="error">{{ $message }}</div>
        @enderror

        <input
            type="email"
            name="email"
            placeholder="Email manzil"
            value="{{ old('email') }}"
            required
        >
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror

        <input
            type="password"
            name="password"
            placeholder="Yangi parol"
            required
        >
        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror

        <input
            type="password"
            name="password_confirmation"
            placeholder="Parolni tasdiqlash"
            required
        >

        <button type="submit" class="btn-submit">Yaratish</button>
    </form>

    <div class="footer">
        <span>Hisob bormi?</span>
        <a href="{{ route('login') }}">Kirish</a>
    </div>
</div>

@endsection