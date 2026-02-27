@extends('layouts.admin')
@include('admin.sitebar')
@section('content')
    @section('title')
        Kategoriyalar qo'shish — Professional Panel
    @endsection
    <link rel="stylesheet" href="{{ asset('./assets/css/main.css') }}">
    <style>
        .locked-input {
            background-color: #1a263e;
            cursor: not-allowed;
            opacity: 0.7;
        }
    </style>
    <div class="form-card">
        <div class="header-section">
            <h2>Fan Kategoryasini qo'shish</h2>
            <p>Ma'lumotlarni to'liq to'ldiring!</p>
        </div>

        <form action="{{ route('admin.category.store') }}" method="POST" class="create-form">
            @csrf

            <div class="input-group">
                <label for="name">Kategoriya nomi</label>

                @error('name')
                    <div style="color:red; font-size:14px; margin-bottom:5px;">
                        {{ $message }}
                    </div>
                @enderror

                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Masalan: Informatika"
                    required>
            </div>


            <div class="input-group">
                <label for="slug">Slug (Majburiy emas)</label>
                <input class="locked-input " type="text" id="slug" name="slug" placeholder="Slug" disabled>
            </div>


            <div class="button-wrapper">
                <button type="submit" class="btn-submit">Yuklashni Boshlash</button>
                <a href="{{ route("admin.category.index") }}" style="text-align: center;" type="button"
                    class="btn-cancel">Bekor Qilish</a>
            </div>
        </form>
    </div>
@endsection