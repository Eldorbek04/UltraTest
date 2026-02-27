@extends('layouts.admin')
@include('admin.sitebar')
@section('content')
    @section('title')
        Mening profilim — Professional Panel
    @endsection

    <style>
        /* O'zgaruvchilar - Ranglar palitrasini boyitish */
        :root {
            --bg-body: #090a0f;
            --card-bg: rgba(23, 26, 39, 0.8);
            --accent: #00d2ff;
            --accent-green: #00ff88;
            --accent-purple: rgb(29, 31, 134);
            --border: rgba(255, 255, 255, 0.08);
            --text-main: #ffffff;
            --text-muted: #a0aec0;
            --shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Asosiy konteyner */
        .profile-container {
            max-width: 1200px;
            margin: 100px auto 40px;
            padding: 0 20px;
            animation: fadeIn 0.8s ease-out;
            margin-top: 110px;
        }

        /* 1. Header Card */
        .profile-header-card {
            background: var(--card-bg);
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid var(--border);
            backdrop-filter: blur(15px);
            margin-bottom: 30px;
            box-shadow: var(--shadow);
        }

        .profile-cover {
            height: 180px;
            background: linear-gradient(135deg, rgb(32, 30, 138) 0%, rgb(246, 78, 59) 50%, rgb(255, 0, 72) 100%);
            position: relative;
        }

        .profile-info-wrapper {
            display: flex;
            align-items: flex-end;
            padding: 0 40px 40px;
            margin-top: -75px;
            gap: 30px;
            position: relative;
        }

        .avatar-container {
            position: relative;
            z-index: 5;
        }

        .profile-avatar {
            width: 160px;
            height: 160px;
            border-radius: 30%;
            /* Modernroq ko'rinish uchun biroz kvadrat-aylana */
            object-fit: cover;
            border: 6px solid #171a27;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            transition: var(--transition);
        }

        .user-meta .user-name {
            font-size: 32px;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .verified-badge {
            color: var(--accent);
            font-size: 24px;
            filter: drop-shadow(0 0 5px rgba(0, 210, 255, 0.5));
        }

        .user-contact-info {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            color: var(--text-muted);
            font-size: 15px;
        }

        .user-contact-info span i {
            color: var(--accent);
            margin-right: 8px;
        }

        /* 2. Grid System */
        .profile-grid {
            display: grid;
            grid-template-columns: 380px 1fr;
            gap: 30px;
        }

        .card {
            background: var(--card-bg);
            padding: 30px;
            border-radius: 24px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            height: fit-content;
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .card-header h3 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* 3. Moliyaviy Holat */
        .balance-display {
            background: rgba(0, 255, 136, 0.05);
            border: 1px solid rgba(0, 255, 136, 0.1);
            padding: 30px 20px;
            border-radius: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        .balance-display .amount {
            color: var(--accent-green);
            font-size: 40px;
            font-weight: 900;
            margin: 5px 0;
            text-shadow: 0 0 25px rgba(0, 255, 136, 0.3);
        }

        /* 4. Form Dizayni */
        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .profile-form input {
            width: 100%;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid var(--border);
            border-radius: 12px;
            color: var(--text-main);
            padding: 14px 18px;
            font-size: 15px;
            transition: var(--transition);
            outline: none;
        }

        .profile-form input:focus {
            border-color: var(--accent);
            background: rgba(0, 0, 0, 0.4);
            box-shadow: 0 0 0 4px rgba(0, 210, 255, 0.1);
        }

        /* Rasm yuklash qismi */
        .upload-design {
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 16px;
            background: rgba(255, 255, 255, 0.02);
            border: 2px dashed #444;
            border-radius: 12px;
            transition: var(--transition);
            color: var(--text-muted);
        }

        .upload-design:hover {
            border-color: var(--accent);
            color: var(--text-main);
            background: rgba(0, 210, 255, 0.05);
        }

        /* Tugmalar */
        .save-btn {
            width: 100%;
            background: linear-gradient(135deg, var(--accent) 0%, #0080ff 100%);
            border: none;
            color: #000;
            font-weight: 700;
            padding: 16px;
            border-radius: 14px;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 10px;
        }

        .save-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 210, 255, 0.4);
        }

        .btn-top-up {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            background: transparent;
            border: 1px solid var(--accent-green);
            color: var(--accent-green);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-top-up:hover {
            background: var(--accent-green);
            color: #000;
        }

        /* Animatsiyalar */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 992px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }

            .profile-info-wrapper {
                flex-direction: column;
                align-items: center;
                text-align: center;
                margin-top: -60px;
            }

            .user-contact-info {
                justify-content: center;
            }

            .profile-container {
                margin-top: 60px;
            }
        }
    </style>

    <main class="content">
        <div class="profile-container">

            <section class="profile-header-card">
                <div class="profile-cover"></div>
                <div class="profile-info-wrapper">
                    <div class="avatar-container">
                        <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('image/images_kok.png') }}"
                            alt="User Avatar" class="profile-avatar" id="avatar-preview">
                    </div>
                    <div class="user-meta">
                        <h1 class="user-name">
                            {{ Auth::user()->name }}
                            <i class="fas fa-check-circle verified-badge" title="Tasdiqlangan"></i>
                        </h1>
                        <div class="user-contact-info">
                            <span><i class="fas fa-envelope"></i> {{ Auth::user()->email }}</span>
                            <span><i class="fas fa-phone-alt"></i> {{ Auth::user()->phone ?? 'Raqam kiritilmagan' }}</span>
                        </div>
                        <div style="margin-top: 15px; display: flex; gap: 10px;">
                            <div style="margin-top: 15px; display: flex; gap: 10px;">
                                @if(Auth::user()->balance >= 3000)
                                    <span
                                        style="padding: 5px 15px; border-radius: 50px; background: rgba(255,189,3,0.1); color: #ffbd03; font-size: 12px; font-weight: 700; border: 1px solid rgba(255,189,3,0.2); display: flex; align-items: center; gap: 5px;">
                                        <i class="fas fa-crown"></i> PREMIUM
                                    </span>
                                @else
                                    <span
                                        style="padding: 5px 15px; border-radius: 50px; background: rgba(255, 109, 2, 0.05); color: #a0aec0; font-size: 12px; font-weight: 600; border: 1px solid rgba(255,178,1,0.1); display: flex; align-items: center; gap: 5px;">
                                        <i style="color: red;" class="fas fa-user"></i> STANDART
                                    </span>
                                @endif

                                <span
                                    style="padding: 5px 15px; border-radius: 50px; background: rgba(255,255,255,0.05); color: var(--text-muted); font-size: 12px; border: 1px solid var(--border);">
                                    HISOB ID: <b style="color: #ffbd03;">{{ Auth::user()->id }}</b>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="profile-grid">
                <div class="left-column">
                    <section class="card">
                        <div class="card-header">
                            <i class="fas fa-wallet" style="color: var(--accent-green); font-size: 1.2rem;"></i>
                            <h3>Hamyon</h3>
                        </div>
                        <div class="balance-display">
                            <span style="color: var(--text-muted); font-size: 13px;">Asosiy balans</span>
                            <div class="amount">{{ number_format(Auth::user()->balance ?? 0, 0, '.', ' ') }}</div>
                            <span style="color: var(--accent-green); font-size: 14px; font-weight: 600;">O'zbek so'mi</span>
                        </div>
                        @hasanyrole('admin|teacher|tester')
                        @else
                            {{-- FAQAT ODDY FOYDALANUVCHILAR UCHUN --}}
                            <button  style="margin: 10px;" class="btn-top-up">
                                <i class="fas fa-plus-circle"></i> Hisobni to'ldirish 
                            </button>
                            <button  style="margin: 10px;" class="btn-top-up payme">
                                <i class="fas fa-plus-circle"></i> Clisk / Payme 
                            </button>
                        @endhasanyrole
                        @role('admin|teacher|tester')
                        <button style="margin: 10px;" class="btn-top-up"><i class="fas fa-hand-holding-usd"></i> Pulni yechish</button>
                        @endrole
                    </section>

                    @hasanyrole('admin|teacher|tester')
                    @else
                    <section class="card" style="margin-top: 25px;">
                        <div class="card-header">
                            <i class="fas fa-share-alt" style="color: var(--accent-purple); font-size: 1.2rem;"></i>
                            <h3>Referral link</h3>
                        </div>
                        <div style="position: relative;">
                            <input type="text" id="referralLink" readonly
                                value="{{ url('/register') . '?ref=' . (auth()->user()->referral_code ?? auth()->user()->id) }}"
                                style="width: 100%; padding: 14px 45px 14px 14px; border-radius: 12px; background: rgba(0,0,0,0.3); color: var(--accent-green); border: 1px solid var(--border); font-size: 0.85rem; outline: none;">
                            <button onclick="copyToClipboard()"
                                style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: var(--accent-purple); border: none; color: white; width: 35px; height: 35px; border-radius: 10px; cursor: pointer;">
                                <i class="fas fa-copy" id="copyIcon"></i>
                            </button>
                        </div>
                        <p id="copyMessage"
                            style="color: var(--text-muted); font-size: 12px; margin-top: 10px; text-align: center;">
                            Do'stlaringizni taklif qiling va bonus oling!
                        </p>
                    </section>
                    @endhasanyrole

                </div>

                <div class="right-column">
                    <section class="card">
                        <div class="card-header">
                            <i class="fas fa-user-cog" style="color: var(--accent); font-size: 1.2rem;"></i>
                            <h3>Profil sozlamalari</h3>
                        </div>
                        <form class="profile-form" action="{{ route('admin.profile.update', Auth::user()->id) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label>Ism va familiya</label>
                                <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                                    placeholder="Ismingizni kiriting" required>
                            </div>

                            <div class="form-group">
                                <label>Telefon raqami</label>
                                <input type="tel" name="phone" value="{{ old('phone', Auth::user()->phone) }}"
                                    placeholder="+998 90 123 45 67">
                            </div>

                            <div class="form-group">
                                <label>Profil rasmi</label>
                                <input type="file" name="image" id="profile-image-input" style="display: none;"
                                    accept="image/*" onchange="previewImage(this)">
                                <label for="profile-image-input" class="upload-design">
                                    <i class="fas fa-camera"></i>
                                    <span id="file-name">Yangi rasm tanlash</span>
                                </label>
                            </div>

                            <button type="submit" class="save-btn">
                                <i class="fas fa-save"></i> O'zgarishlarni saqlash
                            </button>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </main>

    <script>
        function copyToClipboard() {
            const linkInput = document.getElementById("referralLink");
            linkInput.select();
            navigator.clipboard.writeText(linkInput.value);

            const icon = document.getElementById("copyIcon");
            const msg = document.getElementById("copyMessage");

            icon.className = "fas fa-check";
            msg.style.color = "#00ff88";
            msg.textContent = "Nusxa olindi!";

            setTimeout(() => {
                icon.className = "fas fa-copy";
                msg.style.color = "#a0aec0";
                msg.textContent = "Do'stlaringizni taklif qiling va bonus oling!";
            }, 2500);
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    document.getElementById('avatar-preview').src = e.target.result;
                    document.getElementById('avatar-preview').style.transform = "scale(1.05)";
                    setTimeout(() => {
                        document.getElementById('avatar-preview').style.transform = "scale(1)";
                    }, 300);
                }
                reader.readAsDataURL(input.files[0]);
                document.getElementById('file-name').textContent = input.files[0].name;
                document.getElementById('file-name').style.color = "#00d2ff";
            }
        }

        // tugma admin.hisob.index uchun
        const topUpBtn = document.querySelector('.btn-top-up');
        // Tugma bosilganda ishlaydigan funksiya
        topUpBtn.addEventListener('click', function() {
            // Kerakli manzilni shu yerga yozasiz
            window.location.href = '{{ route('admin.hisob.index') }}'; 
        });

         // tugma admin.hisob.index uchun
         const tupayme = document.querySelector('.payme');
        // Tugma bosilganda ishlaydigan funksiya
        tupayme.addEventListener('click', function() {
            // Kerakli manzilni shu yerga yozasiz
            // window.location.href = 'link'; 
            alert("Tez orada ishga tushadi!");
        });
    </script>
@endsection