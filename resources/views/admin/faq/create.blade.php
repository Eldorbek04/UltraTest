@extends('layouts.admin')
@include('admin.sitebar')
@section('content')
    @section('title')
        FAQ qo'shish — Professional Panel
    @endsection
    <link rel="stylesheet" href="{{ asset('./assets/css/main.css') }}">

    <div class="form-card">
        <div class="header-section">
            <h2>FAQ qo'shish</h2>
            <p>Ma'lumotlarni to'liq to'ldiring!</p>
        </div>

        <form action="{{ route('admin.faq.store') }}" method="POST" class="create-form">
            @csrf

            <div class="input-group">
                <label for="name">FAQ nomi</label>

                @error('name')
                    <div style="color:red; font-size:14px; margin-bottom:5px;">
                        {{ $message }}
                    </div>
                @enderror

                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Masalan: VIP TURNIRLAR"
                    required>
            </div>


            <div class="input-group">
                <label for="slug">Text</label>
                <input class="locked-input " type="text" id="text" name="text" placeholder="Text yangilik reklamasi" >
            </div>

            <div class="input-group">
                <label for="slug">Link Button uchun</label>
                <input class="locked-input " type="text" id="link" name="link" placeholder="Button Linki" >
            </div>


            <div class="button-wrapper">
                <button type="submit" class="btn-submit">Yuklashni Boshlash</button>
                <a href="{{ route("admin.faq.index") }}" style="text-align: center;" type="button"
                    class="btn-cancel">Bekor Qilish</a>
            </div>
        </form>
    </div>
@endsection