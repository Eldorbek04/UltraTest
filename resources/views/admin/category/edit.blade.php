@extends('layouts.admin')
@include('admin.sitebar')
@section('content')
    @section('title')
        Kategoriyani o'zgatirish — Professional Panel
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
            <h2>Fan Kategoryasini O'zgartirish</h2>
            <p>Ma'lumotlarni to'liq to'ldiring!</p>
        </div>

        <form action="{{ route('admin.category.update', $category->id) }}" method="POST" class="create-form"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="input-group">
                <label for="name">Kategoriya nomi</label>

                @error('name')
                    <div style="color:red; font-size:14px; margin-bottom:5px;">
                        {{ $message }}
                    </div>
                @enderror

                <input type="text" id="name" name="name" placeholder="Masalan: Informatika" required value="{{ old('name', $category->name) }}">

            </div>


            <div class="input-group">
                <label for="slug">Slug (Majburiy emas)</label>
                <input class="locked-input " type="text" id="slug" name="slug" placeholder="Slug" disabled
                    value="{{ old('slug', $category->slug) }}">
            </div>


            <div class="button-wrapper">
                <button type="submit" class="btn-submit">Yuklashni Boshlash</button>
                <a href="{{ route("admin.category.index") }}" style="text-align: center;" type="button"
                    class="btn-cancel">Bekor Qilish</a>
            </div>
        </form>
    </div>
@endsection