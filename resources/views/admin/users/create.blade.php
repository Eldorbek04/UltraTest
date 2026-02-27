@extends('layouts.admin')
@include('admin.sitebar')

@section('title')
    Savollar Banki — Professional Panel
@endsection

@section('content')
    <style>
        /* Asosiy fon va masofalar */
        .admin-form-wrapper {
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        .test-card-container {
            width: 100%;
            max-width: 900px;
            background: #161b22;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        }

        .test-card-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 40px;
            border-bottom: 1px solid #30363d;
            padding-bottom: 20px;
        }

        .header-icon {
            font-size: 40px;
            color: #58a6ff;
        }

        .header-text h2 {
            color: #f0f6fc;
            margin: 0;
            font-size: 24px;
        }

        .header-text p {
            color: #8b949e;
            margin: 5px 0 0 0;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .input-box {
            margin-bottom: 25px;
        }

        .input-box label {
            display: block;
            color: #c9d1d9;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .input-box input,
        .input-box select {
            width: 100%;
            padding: 12px 15px;
            background: #0d1117;
            border: 1px solid #30363d;
            border-radius: 10px;
            color: #f0f6fc;
            transition: 0.3s;
        }

        .input-box input:focus {
            border-color: #58a6ff;
            outline: none;
            box-shadow: 0 0 0 3px rgba(88, 166, 255, 0.1);
        }

        /* Fayl yuklash zonasi */
        .file-drop-area {
            position: relative;
            display: flex;
            align-items: center;
            padding: 25px;
            border: 2px dashed #30363d;
            border-radius: 12px;
            background: #0d1117;
            transition: 0.3s;
        }

        .file-drop-area.is-active {
            border-color: #4CAF50;
            background: rgba(76, 175, 80, 0.05);
        }

        .fake-btn {
            background: #21262d;
            border: 1px solid #30363d;
            padding: 8px 15px;
            border-radius: 6px;
            color: #c9d1d9;
            margin-right: 15px;
        }

        .file-input {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #30363d;
        }

        .btn-submit {
            background: #238636;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-submit:hover {
            background: #2ea043;
        }

        .btn-cancel {
            background: transparent;
            border: 1px solid #30363d;
            color: #8b949e;
            padding: 12px 30px;
            border-radius: 10px;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .btn-cancel:hover {
            background: #30363d;
            color: #fff;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <main class="content">
        <div class="admin-form-wrapper">
            <div class="test-card-container">
                <div class="test-card-header">
                    <div class="header-icon"><i class="fas fa-plus-circle"></i></div>
                    <div class="header-text">
                        <h2>Yangi bildirishnoma yuborish</h2>
                        <p>Tizim foydalanuvchilariga umumiy xabar yuborish.</p>
                    </div>
                </div>

                @if ($errors->any())
                    <div
                        style="background: rgba(248,81,73,0.1); border: 1px solid #f85149; color: #f85149; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                        <ul style="margin: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-grid">
                        <div class="form-column">
                            <div class="input-box">
                                <label>Xabar mavzusi</label>
                                <input type="text" name="title" value="{{ old('title') }}"
                                    placeholder="Masalan: Bonus" required>
                            </div>
                            <div class="input-box">
                                <label>Xabar matnini kiriting</label>
                                <input type="text" name="message" value="{{ old('message') }}"
                                    placeholder="Xabaringizni yozing..." required>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn-submit">Xabar yuklash</button>
                                <a href="{{ route('admin.users.index') }}" class="btn-cancel">Bekor qilish</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection