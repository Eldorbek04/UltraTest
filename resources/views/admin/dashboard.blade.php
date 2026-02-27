@extends('layouts.admin')
@include('admin.sitebar')
@section('content')

    @section('title') ULTRA TEST — Dashboard

    @endsection

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        :root {
            --sidebar-width: 280px;
            --bg: #05070a;
            --card-bg: rgba(13, 17, 23, 0.9);
            --primary: #00f2ff;
            --border: rgba(255, 255, 255, 0.08);
        }

        /* Asosiy konteynerni o'ngga suramiz */
        .content {
            margin-left: var(--sidebar-width);
            padding: 30px 40px;
            background-color: var(--bg);
            min-height: 100vh;
            position: relative;
        }

        /* Header qismi */
        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border);
        }

        /* Slayder xatoligini (Overlap) tuzatish */
        .swiper-slide {
            opacity: 0 !important;
            /* Odatiy holatda yashirin */
            transition: opacity 0.6s ease-in-out;
        }

        .swiper-slide-active {
            opacity: 1 !important;
            /* Faqat aktiv slayd ko'rinadi */
        }

        .main-slider {
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid var(--border);
            margin-bottom: 30px;
        }

        .promo-slide {
            height: 260px;
            display: flex;
            align-items: center;
            padding: 0 50px;
        }

        /* Gradient matnlar uchun */
        .promo-content h2 {
            font-size: 2.2rem;
            font-weight: 800;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            margin-bottom: 10px;
        }

        /* Bento Grid (Stats) */
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .bento-item {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 25px;
            transition: 0.3s;
        }
    </style>
    <style>
        /* Til almashtirgich konteyneri */
        .lang-switcher {
            display: flex;
            background: rgba(255, 255, 255, 0.05);
            /* Shaffof fon */
            border: 1px solid rgba(255, 255, 255, 0.1);
            /* Nozik chegara */
            padding: 4px;
            border-radius: 12px;
            backdrop-filter: blur(10px);
            /* Orqa fonni xiralashtirish */
            gap: 4px;
        }

        /* Har bir til elementi */
        .lang-item {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 700;
            text-decoration: none;
            color: #8b949e;
            /* Sust rang */
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-transform: uppercase;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Sichqoncha ustiga kelganda */
        .lang-item:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
        }

        /* Aktiv (tanlangan) til holati */
        .lang-item.active {
            background: #00f2ff;
            /* Sizning asosiy ko'k rangingiz */
            color: #05070a;
            /* Ichidagi matn qora bo'ladi */
            box-shadow: 0 0 15px rgba(0, 242, 255, 0.4);
            /* Neon nuri */
        }

        /* Mobil qurilmalar uchun moslashuvchanlik */
        @media (max-width: 480px) {
            .lang-item {
                padding: 6px 12px;
                font-size: 0.75rem;
            }
        }

        .swiper-slide p {
            width: 65%;
        }

        .promo-content h2 {
            font-size: 32px !important;
            /* Kattaligi */
            font-weight: 800;
            /* Qalinligi */
            margin-bottom: 20px;
            line-height: 1.2;
            text-transform: uppercase;
            /* Hammasi katta harflarda */
            /* Gradient effektini matnga berish */
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent;
        }
    </style>

    <div class="bg-glow"></div>

    <main class="content">
        <div class="bg-glow"></div>

        <div class="top-header">
            <div class="user-greeting">
                <h1 style="color: white; margin: 0; font-size: 1.8rem; font-weight: 800;">
                    Salom, {{ explode(' ', auth()->user()->name)[0] }}! 👋
                </h1>
            </div>
            <div class="lang-switcher">
                <a href="?lang=uz" class="lang-item {{ app()->getLocale() == 'uz' ? 'active' : '' }}">UZ</a>
                <a href="?lang=ru" class="lang-item {{ app()->getLocale() == 'ru' ? 'active' : '' }}">RU</a>
            </div>
        </div>

        <div class="swiper main-slider">
            <div class="swiper-wrapper">
                @php
                    $gradients = [
                        'linear-gradient(45deg, #1a2a6c, #b21f1f, #fdbb2d)',
                        'linear-gradient(45deg, #00b4db, #0083b0)',
                        'linear-gradient(45deg, #834d9b, #d04ed6)',
                        'linear-gradient(45deg, #11998e, #38ef7d)',
                        'linear-gradient(45deg, #ee0979, #ff6a00)'
                    ];
                @endphp

                @foreach ($faq as $index => $faqs)
                    <div class="swiper-slide promo-slide" style="background: {{ $gradients[$index % count($gradients)] }};">
                        {{-- Rang bu yerda almashadi --}}
                        <div class="promo-content">
                            <h2
                                style="background: linear-gradient(to right, #ff9e00, #ff0054); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                {{ $faqs->name }}
                            </h2>
                            <p style="color: #ffffff; opacity: 0.9;">{{ $faqs->text }}</p>
                            <a href="{{ $faqs->link }}">
                                <button class="promo-btn"
                                    style="background: #ff0054; color: white; border: none; padding: 10px 25px; border-radius: 10px; cursor: pointer; margin-top: 15px;">
                                    Batafsil
                                </button>
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>
            <div class="swiper-pagination"></div>
        </div>

        <div class="bento-grid">
            <div class="bento-item" style="grid-column: span 2;">
                <div style="color: #8b949e; font-size: 0.9rem;">Asosiy Balans</div>
                <div style="font-size: 2.2rem; font-weight: 800; color: var(--primary); margin-top: 10px;">
                    {{ number_format(auth()->user()->balance, 0, '.', ' ') }} <small style="font-size: 1rem;">UZS</small>
                </div>
            </div>
            <div class="bento-item">
                <div style="color: #8b949e;">Pulik ishlagan testlarim</div>
                <div style="font-size: 2rem; font-weight: 800; margin-top: 10px;">
                    {{ \App\Models\Purchase::where('user_id', auth()->id())->count() }} ta
                </div>
            </div>
            <div class="bento-item">
                <div style="color: #8b949e;">Faollik</div>
                @php
                    $purchasedCount = \App\Models\Purchase::where('user_id', auth()->id())->count();
                    $target = 10; // 100% bo'lishi uchun kerak bo'lgan testlar soni
                    $percentage = ($purchasedCount / $target) * 100;

                    // Foiz 100 dan oshib ketmasligi uchun:
                    if ($percentage > 100)
                        $percentage = 100;
                @endphp
                <div style="font-size: 2rem; font-weight: 800; margin-top: 10px;">{{ number_format($percentage, 0) }}%</div>
            </div>
            <!-- //tag qismidagi bolimlar -->
            <div class="bento-item">
                <div style="color: #8b949e;">Sizning Jami kirishlaringiz</div>
                <div style="font-size: 2rem; font-weight: 800; margin-top: 10px;">
                    {{ auth()->user()->login_count ?? 0 }} <b style="font-size: 18px;">Marotaba</b>
                </div>
            </div>

            @php
                $userId = auth()->id();
                // Jami yechilgan testlar
                $totalFinishedTests = \App\Models\Result::where('user_id', $userId)->count();

                // Pullik yechilgan testlar (Quiz narxi 0 dan katta bo'lganlari)
                $paidFinished = \App\Models\Result::where('user_id', $userId)
                    ->whereHas('quiz', function ($q) {
                        $q->where('price', '>', 0);
                    })
                    ->count();

                $freeFinished = $totalFinishedTests - $paidFinished;
            @endphp

            <div class="bento-item"
                style="background: var(--card-bg); padding: 20px; border-radius: 15px; border: 1px solid var(--border);">
                <div style="color: #8b949e; font-size: 0.9rem; display: flex; justify-content: space-between;">
                    <span>Jami ishlagan testlarim</span>
                    <i class="fas fa-chart-line" style="color: #3b82f6;"></i>
                </div>

                <div style="font-size: 2.5rem; font-weight: 800; margin-top: 10px; color: white;">
                    {{ $totalFinishedTests }} <span style="font-size: 1rem; font-weight: 400; color: #8b949e;">ta</span>
                </div>

                <div style="margin-top: 15px;">
                    <div style="display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 5px;">
                        <span style="color: #ef4444;">Pullik: {{ $paidFinished }}</span>
                        <span style="color: #10b981;">Bepul: {{ $freeFinished }}</span>
                    </div>
                    <div
                        style="width: 100%; height: 6px; background: rgba(255,255,255,0.1); border-radius: 10px; display: flex; overflow: hidden;">
                        @if($totalFinishedTests > 0)
                            <div style="width: {{ ($paidFinished / $totalFinishedTests) * 100 }}%; background: #ef4444;"></div>
                            <div style="width: {{ ($freeFinished / $totalFinishedTests) * 100 }}%; background: #10b981;"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const swiper = new Swiper('.main-slider', {
                loop: true,
                speed: 800, // Almashish tezligi
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                // Matnlar ustma-ust tushmasligi uchun "fade" effektini to'g'ri sozlash
                effect: 'fade',
                fadeEffect: {
                    crossFade: true // ESKI SLAYDNI TO'LIQ YO'QOTADI
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
            });
        });


    </script>

@endsection