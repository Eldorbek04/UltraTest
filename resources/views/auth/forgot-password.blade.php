@extends('layouts.sitefrond')
@section('title')
     ULTRATEST | Parolni tiklash — Intellektual Test Platformasi
@endsection
@section('content')
<div class="auth-card">
    <div class="header">
        <div class="mini-logo">ULTRA<span>TEST</span></div>
        <p>Parolni qayta tiklash</p>
    </div>

    <div class="info-text">
        Email manzilingizni kiriting, parolni tiklash havolasini yuboramiz.
    </div>

    @if (session('status'))
        <div class="status">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
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

        <button type="submit" class="btn-submit">
            Parolni tiklash
        </button>
    </form>

    <div class="footer">
        <a href="{{ route('login') }}">← Kirish sahifasiga qaytish</a>
    </div>
</div>
@endsection