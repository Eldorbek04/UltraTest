@extends('layouts.admin')
@include('admin.sitebar')

@section('title')
    Test — Professional Panel
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('./assets/css/main.css') }}">

    <style>
        /* Asosiy konteyner sozlamalari */
        .content {
            margin-left: 260px;
            /* Sidebar kengligiga mos */
            padding: 0;
            min-height: 100vh;
            background-color: #0f172a;
            display: block !important;
        }

        .table-container {
            width: 100%;
            display: block;
            overflow: visible;
        }

        /* Sahifa tepasini to'g'irlash */
        .container-fluid {
            max-width: 1300px;
            margin: 0 auto;
            padding: 40px 40px;
            /* Tepadan bo'shliq ko'paytirildi */
        }

        /* Header qismi */
        .main-header {
            margin-bottom: 90px;
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        /* Kartochka va Uzun Matnni (Title) To'g'irlash */
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 24px;
            transition: transform 0.3s ease;
            position: relative;
            overflow: hidden;
            /* PRO yorlig'i kesilishi uchun */
        }

        .quiz-title {
            color: white;
            margin: 0 0 15px 0;
            font-size: 1.3rem;
            line-height: 1.4;
            /* Uzun matnni keyingi qatorga o'tkazish */
            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-word;
            /* PRO yorlig'i ostiga tushib qolmasligi uchun padding */
            padding-right: 45px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* Maksimal 2 qator matn */
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 12px;
            cursor: pointer;
            width: 100%;
            font-weight: 600;
            margin-top: auto;
            /* Tugmani har doim pastga suradi */
        }

        /* Mobil moslashuv */
        @media (max-width: 992px) {
            .content {
                margin-left: 0;
            }
        }

        .test-grid {
            margin-top: 100px;
        }

        .main-header {
            margin-bottom: 40%;
        }
    </style>

    <main class="content">
        @if(session('error'))
            <div
                style="background: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; color: #f87171; padding: 15px; border-radius: 12px; margin-bottom: 20px;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div
                style="background: rgba(34, 197, 94, 0.2); border: 1px solid #22c55e; color: #4ade80; padding: 15px; border-radius: 12px; margin-bottom: 20px;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        <div class="container-fluid">
            <header class="main-header">
                <div class="header-top">
                    <div class="logo-area">
                        <h1 style="font-size: 2.2rem; font-weight: 800; letter-spacing: -1px; margin: 0; color: #fff;">
                            ULTRA<span style="color: #3b82f6;">TEST</span>
                        </h1>
                    </div>

                    <div class="search-wrapper glass-card"
                        style="padding: 10px 20px; flex: 1; max-width: 400px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-search" style="opacity: 0.5; color: white;"></i>
                        <input type="text" id="test-search" placeholder="Qidirish..."
                            style="background: transparent; border: none; color: white; width: 100%; outline: none;">
                    </div>

                </div>

                <div class="header-categories" style="display: flex; gap: 15px; overflow-x: auto; padding-bottom: 5px;">
                    <a href="{{ route('admin.testing.index') }}" class="cat-item" style="color: {{ !request('category_id') ? '#3b82f6' : 'white' }}; 
                                            text-decoration: none; 
                                            font-weight: {{ !request('category_id') ? 'bold' : 'normal' }}; 
                                            border-bottom: {{ !request('category_id') ? '2px solid #3b82f6' : 'none' }}; 
                                            padding-bottom: 5px; opacity: {{ !request('category_id') ? '1' : '0.7' }};">
                        Barchasi
                    </a>
                    @foreach ($categories->reverse() as $category)
                        <a href="{{ route('admin.testing.index', ['category_id' => $category->id]) }}" class="cat-item" style="color: {{ request('category_id') == $category->id ? '#3b82f6' : 'white' }}; 
                                                        opacity: {{ request('category_id') == $category->id ? '1' : '0.7' }}; 
                                                        text-decoration: none; 
                                                        white-space: nowrap;
                                                        font-weight: {{ request('category_id') == $category->id ? 'bold' : 'normal' }};
                                                        border-bottom: {{ request('category_id') == $category->id ? '2px solid #3b82f6' : 'none' }};
                                                        padding-bottom: 5px;">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </header>

            <div class="test-grid"
                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">

                @foreach($quizzes->shuffle() as $quiz)
    @php
        // 1. Foydalanuvchi bu testni sotib olganmi?
        $hasPurchased = \App\Models\Purchase::where('user_id', auth()->id())
                                            ->where('quiz_id', $quiz->id)
                                            ->exists();

        // 2. Foydalanuvchi bu testning muallifimi?
        $isAuthor = $quiz->user_id == auth()->id();

        // 3. Admin yoki Tester bo'lsa ham hamma test ochiq bo'lishi mumkin (ixtiyoriy)
        $isAdmin = auth()->user()->hasRole('admin'); 

        // Test ochiq bo'lish shartlari
        $isOpen = !$quiz->is_paid || $hasPurchased || $isAuthor || $isAdmin;
    @endphp

    <div class="glass-card" style="display: flex; flex-direction: column; min-height: 300px;">
        @if($quiz->is_paid)
            <div style="position: absolute; top: 12px; right: -35px; background: #fbbf24; color: #000; padding: 5px 40px; transform: rotate(45deg); font-size: 0.75rem; font-weight: 800; z-index: 10;">
                PRO
            </div>
        @endif

        <div style="flex-grow: 1;">
            <h3 class="quiz-title">
                <b style="color: yellow;">{{ $quiz->title }}</b>
            </h3>

            <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
                <span style="opacity: 0.7; font-size: 0.95rem; color: white;">
                    <i class="far fa-user"></i> Muallif: <b style="color: yellow;">{{ $quiz->user->name ?? 'Noma\'lum' }}</b>
                </span>

                <span style="opacity: 0.7; font-size: 0.95rem; color: white;">
                <i class="far fa-file-alt"></i> Test soni: <b style="color: yellow;">{{ $quiz->questions->count() }}</b>
                </span>
                
                <span style="opacity: 0.7; font-size: 0.95rem; color: white;">
                    <i class="far fa-clock"></i> Vaqt: <b style="color: yellow;">{{ $quiz->duration }}</b> daqiqa
                </span>

                {{-- Holat ko'rsatkichi --}}
                @if($isAuthor)
                    <span style="color: #60a5fa; font-weight: 700; font-size: 0.9rem;">
                        <i class="fas fa-user-edit"></i> O'zingiz yuklagan test
                    </span>
                @elseif($hasPurchased)
                    <span style="color: #4ade80; font-weight: 700; font-size: 0.9rem;">
                        <i class="fas fa-check-circle"></i> Sotib olingan
                    </span>
                @elseif($quiz->is_paid)
                    <span style="color: #fbbf24; font-weight: 700; font-size: 1.1rem; margin-top: 5px;">
                        <i class="fas fa-crown"></i> {{ number_format($quiz->price, 0, ',', ' ') }} so'm
                    </span>
                @else
                    <span style="color: #94a3b8; font-weight: 700; font-size: 0.9rem;">
                        <i class="fas fa-unlock"></i> Tekin kirish
                    </span>
                @endif
            </div>
        </div>

        <div style="margin-top: auto;">
            @if($isOpen)
                {{-- Ochiq testlar uchun --}}
                <button class="btn-primary" onclick="location.href='{{ route('admin.testing.show', $quiz->id) }}'">
                    <i class="fas fa-play-circle"></i> Testni Boshlash
                </button>
            @else
                {{-- Pullik va sotib olinmagan testlar uchun --}}
                <form action="{{ route('admin.testing.purchase', $quiz->id) }}" method="POST" class="purchase-form">
                    @csrf
                    <button type="button" class="btn-primary buy-button"
                            data-price="{{ number_format($quiz->price, 0, ',', ' ') }}" 
                            data-title="{{ $quiz->title }}"
                            style="background: linear-gradient(135deg, #fbbf24, #d97706); color: #000; border: none; width: 100%; padding: 12px; border-radius: 12px; font-weight: 700; cursor: pointer;">
                        <i class="fas fa-shopping-cart"></i> Sotib olish
                    </button>
                </form>
            @endif
        </div>
    </div>
@endforeach
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Qidiruv tizimi
        document.getElementById('test-search').addEventListener('input', function (e) {
            let searchValue = e.target.value.toLowerCase();
            document.querySelectorAll('.test-grid > .glass-card').forEach(card => {
                let title = card.querySelector('.quiz-title').innerText.toLowerCase();
                card.style.display = title.includes(searchValue) ? 'flex' : 'none';
            });
        });

        // Sotib olish tugmasi (SweetAlert bilan)
        document.querySelectorAll('.buy-button').forEach(button => {
            button.addEventListener('click', function (e) {
                const currentForm = this.closest('form');
                Swal.fire({
                    title: 'Testni sotib olasizmi?',
                    text: "Sizning balansingizdan belgilangan pul yechiladi.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ha, sotib olaman',
                    cancelButtonText: 'Bekor qilish',
                    background: '#1e293b',
                    color: '#fff',
                    confirmButtonColor: '#3b82f6',
                    cancelButtonColor: '#475569'
                }).then((result) => {
                    if (result.isConfirmed) {
                        currentForm.submit();
                    }
                });
            });
        });

        // Xatolik bo'lganda (Balans yetmasa)
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Xatolik!',
                text: "{{ session('error') }}",
                showCancelButton: true,
                confirmButtonText: 'Hisobni to\'ldirish',
                cancelButtonText: 'Yopish',
                background: '#1e293b',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('admin.profile.index') }}";
                }
            });
        @endif

        // Muvaffaqiyatli xarid
        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Tayyor!', text: "{{ session('success') }}", background: '#1e293b', color: '#fff' });
        @endif
    </script>
@endsection