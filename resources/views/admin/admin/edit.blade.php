@extends('layouts.admin')
@include('admin.sitebar')
@section('content')
    @section('title')
        Admin edit — Professional Panel
    @endsection

    <style>
        /* Sizning mavjud stillaringiz shu yerda qoladi */
        :root {
            --bg: #0f1016;
            --card: #1c1d26;
            --accent: #00d2ff;
            --text: #ffffff;
            --text-dim: #a0a0a0;
            --border: rgba(255, 255, 255, 0.08);
            --success: #2ecc71;
        }
        .content { flex: 1; padding: 30px; margin-left: 260px; margin-top: 50px; }
        .glass-card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 24px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); }
        .form-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 20px; }
        .input-box { background: #111217; border: 1px solid var(--border); border-radius: 10px; padding: 12px; color: white; width: 100%; box-sizing: border-box; }
        .btn-primary { background: var(--accent); color: #000; border: none; padding: 12px 25px; border-radius: 10px; font-weight: bold; cursor: pointer; }
    </style>

    <main class="content">
        <header style="margin-bottom: 40px;">
            <h1><i class="fas fa-user-edit" style="color: var(--accent);"></i> Adminni tahrirlash</h1>
            <p style="color: var(--text-dim);">{{ $admin->name }} ma'lumotlarini yangilash.</p>
        </header>

        <div class="glass-card">
            <h3 style="margin-top: 0;"><i class="fas fa-pen"></i> Ma'lumotlarni o'zgartirish</h3>
            
            {{-- ACTION QISMI: Routega ID berilishi va METHOD 'PUT' bo'lishi shart --}}
            <form action="{{ route('admin.admin.update', $admin->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div>
                        <label style="display:block; margin-bottom:8px; color:var(--text-dim);">To'liq Ism</label>
                        <input type="text" name="name" class="input-box" value="{{ $admin->name }}" required>
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:8px; color:var(--text-dim);">Email Pochta</label>
                        <input type="email" name="email" class="input-box" value="{{ $admin->email }}" required>
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:8px; color:var(--text-dim);">Tizimdagi Roli</label>
                        <select name="role" class="input-box">
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ $admin->hasRole($role->name) ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row" style="margin-top: 15px;">
                    <div>
                        <label style="display:block; margin-bottom:8px; color:var(--text-dim);">Yangi Parol (ixtiyoriy)</label>
                        <input type="password" name="password" class="input-box" placeholder="O'zgartirmaslik uchun bo'sh qoldiring">
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:8px; color:var(--text-dim);">Amal qilish muddati</label>
                        <select name="duration" class="input-box">
                            <option value="unlimited">Cheksiz</option>
                            <option value="1">1 kunlik kirish</option>
                            <option value="30">30 kunlik kirish</option>
                            <option value="60">60 kunlik kirish</option>
                            <option value="90">90 kunlik kirish</option>
                            <option value="365">1 yillik kirish</option>
                        </select>
                    </div>
                    <div style="display: flex; align-items: flex-end; gap: 10px;">
                        <button type="submit" class="btn-primary" style="flex: 1;">Yangilash</button>
                        <a href="{{ route('admin.admin.index') }}" style="text-decoration: none; background: #333; color: white; padding: 12px 20px; border-radius: 10px; font-weight: bold;">Bekor qilish</a>
                    </div>
                </div>
            </form>
        </div>
    </main>
@endsection