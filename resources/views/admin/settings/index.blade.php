@extends('layouts.admin')
@include('admin.sitebar')
@section('content')
    @section('title')
        Referal Boshqaruv — Professional Panel
    @endsection

    <style>
        /* UltraTest Dark Theme Integration */
        :root {
            --bg-dark: #151921;
            /* Panel orqa foni */
            --card-dark: #1f242d;
            /* Kartochka foni */
            --accent-purple: #6366f1;
            /* Tugma va fokus rangi */
            --text-main: #ffffff;
            --text-muted: #6c7293;
            --input-bg: #2a303c;
        }

        .settings-card {
            background: var(--card-dark);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            padding: 35px;
            max-width: 550px;
            margin: 20px auto;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .settings-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 10px;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .custom-input {
            width: 100%;
            padding: 14px 18px;
            background: var(--input-bg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            font-size: 1rem;
            color: var(--text-main);
            transition: all 0.3s ease;
            outline: none;
        }

        .custom-input:focus {
            border-color: var(--accent-purple);
            background: #232936;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
        }

        .input-wrapper span {
            position: absolute;
            right: 18px;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.9rem;
            pointer-events: none;
        }

        .save-btn {
            background: var(--accent-purple);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
            font-size: 1rem;
            margin-top: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .save-btn:hover {
            background: #4f46e5;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(99, 102, 241, 0.3);
        }

        /* Alert styling */
        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: #10b981;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .settings-card {
                margin: 10px;
                padding: 20px;
            }
        }
    </style>

    <main class="content">
        <header class="header"
            style="margin-bottom: 40px; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 style="font-size: 1.8rem; font-weight: 700; color: var(--text-main);">Referal Boshqaruvi</h1>
                <p style="color: var(--text-muted); margin-top: 5px;">Referal tizimni umumiy boshqaruv paneli.</p>
            </div>

            <div style="display: flex; gap: 15px; align-items: center;">
                <div class="referral-section"
                    style="margin-top: 20px; padding: 15px; background: #1f242d; border-radius: 10px;">
                    <h5 style="color: #fff;">Mening taklif havolam:</h5>
                    <div style="display: flex; gap: 10px; margin-top: 10px; position: relative;">
                        <input type="text" id="referralLink" readonly
                            value="{{ url('/register') . '?ref=' . (auth()->user()->referral_code ?? '') }}"
                            style="width: 100%; padding: 10px 45px 10px 10px; border-radius: 8px; background: #2a303c; color: #00ff00; border: 1px solid #444; font-size: 0.9rem; outline: none;">

                        <button onclick="copyToClipboard()"
                            style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); background: #6366f1; border: none; color: white; padding: 7px 10px; border-radius: 6px; cursor: pointer; transition: 0.3s;"
                            title="Nusxa olish">
                            <i class="fas fa-copy" id="copyIcon"></i>
                        </button>
                    </div>
                    <small id="copyMessage" style="color: #6c7293; display: block; margin-top: 8px; transition: 0.3s;">
                        Ushbu link orqali do'stlaringizni taklif qiling!
                    </small>
                </div>
            </div>
        </header>

        <section class="settings-section">
            <div class="settings-card">
                <h2 class="settings-title">
                    <i class="fas fa-sliders-h" style="color: var(--accent-purple);"></i>
                    Sozlamalarni tahrirlash
                </h2>

                @if(session('success'))
                    <div class="alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.settings.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="referral_bonus">Taklif qilgan (Referrer) bonusi</label>
                        <div class="input-wrapper">
                            <input type="number" name="referral_bonus" id="referral_bonus" class="custom-input"
                                placeholder="Masalan: 2000" value="{{ get_setting('referral_bonus') }}">
                            <span>so'm</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="welcome_bonus">Yangi foydalanuvchi (Welcome) bonusi</label>
                        <div class="input-wrapper">
                            <input type="number" name="welcome_bonus" id="welcome_bonus" class="custom-input"
                                placeholder="Masalan: 5000" value="{{ get_setting('welcome_bonus') }}">
                            <span>so'm</span>
                        </div>
                    </div>

                    <button type="submit" class="save-btn">
                        <i class="fas fa-save" style="margin-right: 8px;"></i> Saqlash
                    </button>
                </form>
            </div>
        </section>
    </main>

    {{-- Script qismi o'zgarishsiz qoladi --}}
    <script>
        function copyToClipboard() {
            // Inputni tanlash
            var copyText = document.getElementById("referralLink");
            var icon = document.getElementById("copyIcon");
            var message = document.getElementById("copyMessage");

            // Nusxa olish
            copyText.select();
            copyText.setSelectionRange(0, 99999); // Mobil qurilmalar uchun
            navigator.clipboard.writeText(copyText.value);

            // Effekt: Ikonkani o'zgartirish
            icon.classList.remove("fa-copy");
            icon.classList.add("fa-check");

            // Effekt: Xabarni o'zgartirish
            message.innerText = "Nusxa olindi!";
            message.style.color = "#00ff00";

            // 2 soniyadan keyin asl holiga qaytarish
            setTimeout(function () {
                icon.classList.remove("fa-check");
                icon.classList.add("fa-copy");
                message.innerText = "Ushbu link orqali do'stlaringizni taklif qiling!";
                message.style.color = "#6c7293";
            }, 2000);
        }
    </script>
@endsection