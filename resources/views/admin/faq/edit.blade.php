@extends('layouts.admin')
@include('admin.sitebar')
@section('content')
    @section('title')
        FAQ o'zgatirish — Professional Panel
    @endsection
    <link rel="stylesheet" href="{{ asset('./assets/css/main.css') }}">

    <div class="form-card">
        <div class="header-section">
            <h2>FAQ O'zgartirish</h2>
            <p>Ma'lumotlarni to'liq to'ldiring!</p>
        </div>

        <form action="{{ route('admin.faq.update', $faq->id) }}" method="POST" class="create-form"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="input-group">
                <label for="name">FAQ nomi</label>

                @error('name')
                    <div style="color:red; font-size:14px; margin-bottom:5px;">
                        {{ $message }}
                    </div>
                @enderror

                <input type="text" id="name" name="name" placeholder="Masalan: VIP TURNIRLAR" required value="{{ old('name', $faq->name) }}">

            </div>


            <div class="input-group">
                <label for="text">Text</label>
                <input class="locked-input " type="text" id="text" name="text" placeholder="Text yangilik reklamasi" 
                    value="{{ old('slug', $faq->text) }}">
            </div>

            <div class="input-group">
                <label for="link">Text</label>
                <input class="locked-input " type="text" id="link" name="link" placeholder="Button Linki" 
                    value="{{ old('slug', $faq->link) }}">
            </div>


            <div class="button-wrapper">
                <button type="submit" class="btn-submit">Yuklashni Boshlash</button>
                <a href="{{ route("admin.faq.index") }}" style="text-align: center;" type="button"
                    class="btn-cancel">Bekor Qilish</a>
            </div>
        </form>
    </div>
@endsection