@extends('layouts.admin')
@include('admin.sitebar')
@section('content')
    @section('title')
        Admin boshqaruv — Professional Panel
    @endsection

    <style>
        /* Jadval uchun maxsus scroll konteyneri */
        .admin-table-wrapper {
            max-height: 450px;
            /* Jadvalning balandligini cheklash */
            overflow-y: auto;
            /* Vertikal scroll */
            overflow-x: auto;
            /* Gorizontal scroll (kichik ekranlar uchun) */
            border-radius: 8px;
        }

        /* Scrollbar dizayni (Chrome va Edge uchun) */
        .admin-table-wrapper::-webkit-scrollbar {
            width: 6px;
        }

        .admin-table-wrapper::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .admin-table-wrapper::-webkit-scrollbar-thumb {
            background: var(--accent, #00d2ff);
            border-radius: 10px;
        }

        /* Jadval sarlavhasini qotirib qo'yish (Sticky header) */
        .admin-table thead th {
            position: sticky;
            top: 0;
            background: #1a1f2b;
            /* Fon rangini o'zingizning dizaynga moslang */
            z-index: 10;
            box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
        }

        :root {
            --bg: #0f1016;
            --card: #1c1d26;
            --accent: #00d2ff;
            --text: #ffffff;
            --text-dim: #a0a0a0;
            --border: rgba(255, 255, 255, 0.08);
            --success: #2ecc71;
            --warning: #f1c40f;
            --danger: #e74c3c;
        }

        body {
            color: var(--text);
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            display: flex;
        }

        .content {
            flex: 1;
            padding: 30px;
            margin-left: 260px;
        }

        /* Sidebar Mockup */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            border-right: 1px solid var(--border);
        }

        /* Modern Glass Cards */
        .glass-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        /* Admin Table */
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .admin-table th {
            text-align: left;
            padding: 15px;
            color: var(--text-dim);
            border-bottom: 2px solid var(--border);
            font-weight: 500;
        }

        .admin-table td {
            padding: 15px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-weight: bold;
        }

        /* Status Badges */
        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-super {
            background: rgba(69, 181, 206, 0.15);
            color: var(--accent);
        }

        .badge-mod {
            background: rgba(46, 204, 113, 0.15);
            color: var(--success);
        }

        .badge-expired {
            background: rgba(231, 76, 60, 0.15);
            color: var(--danger);
        }

        /* Control Forms */
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .input-box {
            background: #111217;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 12px;
            color: white;
            width: 100%;
            box-sizing: border-box;
        }

        .input-box:focus {
            border-color: var(--accent);
            outline: none;
        }

        .btn-primary {
            background: var(--accent);
            color: #000;
            border: none;
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 210, 255, 0.3);
        }

        .action-btn {
            background: none;
            border: none;
            color: var(--text-dim);
            cursor: pointer;
            font-size: 1.1rem;
            transition: 0.2s;
        }

        .action-btn:hover {
            color: var(--accent);
        }

        .content {
            margin-top: 50px;
        }
    </style>

    <main class="content">
        <header style="margin-bottom: 40px;">
            <h1><i class="fas fa-user-shield" style="color: var(--accent);"></i> Tizim Boshqaruvchilari</h1>
            <p style="color: var(--text-dim);">Adminlarni qo'shish, rollarni tahrirlash va kirish huquqlarini nazorat
                qilish.</p>
        </header>



        {{-- Xabarnomalar --}}
        @if(session('success'))
            <div
                style="background: rgba(46, 204, 113, 0.2); color: var(--success); padding: 15px; border-radius: 10px; margin-bottom: 20px; border: 1px solid var(--success);">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        {{-- Yangi Admin Qo'shish --}}
        <div class="glass-card">
            <h3 style="margin-top: 0;"><i class="fas fa-plus-circle"></i> Yangi Admin Ro'yxatdan O'tkazish</h3>
            <form action="{{ route('admin.admin.store') }}" method="POST">
                @csrf
                <div class="form-row">
                    <div>
                        <label style="display:block; margin-bottom:8px; color:var(--text-dim);">To'liq Ism</label>
                        <input type="text" name="name" class="input-box" placeholder="Masalan: Eldorbek Rayimjonov"
                            required>
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:8px; color:var(--text-dim);">Email Pochta</label>
                        <input type="email" name="email" class="input-box" placeholder="admin@ultra.uz" required>
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:8px; color:var(--text-dim);">Tizimdagi Roli</label>
                        <select name="role" class="input-box">
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row" style="margin-top: 15px;">
                    <div>
                        <label style="display:block; margin-bottom:8px; color:var(--text-dim);">Parol</label>
                        <input type="password" name="password" class="input-box" placeholder="********" required>
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:8px; color:var(--text-dim);">Ruxsat muddati</label>
                        <select name="duration" class="input-box">
                            <option value="unlimited">Cheksiz</option>
                            <option value="1">1 kunlik kirish</option>
                            <option value="30">30 kunlik kirish</option>
                            <option value="60">60 kunlik kirish</option>
                            <option value="90">90 kunlik kirish</option>
                            <option value="365">1 yillik kirish</option>
                        </select>
                    </div>
                    <div style="display: flex; align-items: flex-end;">
                        <button type="submit" class="btn-primary" style="width: 100%;">Adminni Saqlash</button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Mavjud Adminlar Jadvali --}}
        <div class="glass-card">
            <h3 style="margin-top: 0; margin-bottom: 20px;">
                <i class="fas fa-users-cog"></i> Mavjud Adminlar
            </h3>

            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Administrator</th>
                            <th>Roli</th>
                            <th>Faoliyat Muddati</th>
                            <th>Status</th>
                            <th>Amallar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins as $admin)
                            <tr>
                                <td>
                                    <div class="user-info">
                                        <div class="avatar"
                                            style="background: {{ $admin->hasRole('admin') ? '#e67e22' : '#00d2ff' }};">
                                            {{ strtoupper(substr($admin->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div style="font-weight: 600;">{{ $admin->name }}</div>
                                            <div style="font-size: 12px; color: var(--text-dim);">{{ $admin->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @foreach($admin->getRoleNames() as $role)
                                        <span class="badge {{ $role == 'admin' ? 'badge-super' : 'badge-mod' }}">
                                            {{ ucfirst($role) }}
                                        </span>
                                    @endforeach
                                </td>
                                <td>
                                    @if($admin->expires_at)
                                        <span style="font-size: 14px;">
                                            <i class="fas fa-calendar-alt" style="color: var(--accent); margin-right: 5px;"></i>
                                            {{ $admin->expires_at->format('d.m.Y') }}
                                        </span>
                                    @else
                                        <span style="color: #2ecc71;">
                                            <i class="fas fa-infinity" style="margin-right: 5px;"></i> Cheksiz
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($admin->expires_at && $admin->expires_at->isPast())
                                        <a href="{{ route('admin.admin.edit', $admin->id) }}" class="badge badge-expired"
                                            style="background: rgba(231, 76, 60, 0.1); color: #e74c3c; border: 1px solid #e74c3c;">
                                            <i class="fas fa-clock"></i> Muddati tugagan
                                        </a>
                                    @else
                                        <span style="color: var(--success); font-weight: 500;">
                                            <i class="fas fa-check-circle"></i> Faol
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; gap: 8px; align-items: center;">
                                        {{-- O'chirish formasi --}}
                                        <form action="{{ route('admin.admin.destroy', $admin->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn"
                                                style="color: #e74c3c; background: none; border: none; cursor: pointer;"
                                                onclick="return confirm('Haqiqatdan ham ushbu adminni oʻchirmoqchimisiz?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                        {{-- Bloklash formasi --}}
                                        <form action="{{ route('admin.users.toggle', $admin->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            <button type="submit" class="badge {{ $admin->is_active ? 'paid' : 'free' }}"
                                                style="border: none; cursor: pointer; font-family: inherit; outline: none;">
                                                <i class="fas {{ $admin->is_active ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                                {{ $admin->is_active ? 'Bloklash' : 'Tiklash' }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-dim);">
                                    <i class="fas fa-user-slash"
                                        style="display: block; font-size: 2rem; margin-bottom: 10px;"></i>
                                    Adminlar topilmadi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection