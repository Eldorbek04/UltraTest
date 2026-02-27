@extends('layouts.admin')
@include('admin.sitebar')

@section('title')
    Foydalanuvchilar — Professional Panel
@endsection

@section('content')
    <style>
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--card-bg);
            padding: 20px;
            border-radius: 15px;
            border: 1px solid var(--border);
        }

        .stat-card h3 {
            color: var(--text-dim);
            font-size: 14px;
            margin-bottom: 10px;
        }

        .stat-card .value {
            font-size: 24px;
            font-weight: bold;
            color: white;
        }

        .badge.free {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            padding: 5px 10px;
            border-radius: 6px;
        }

        .badge.paid {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            padding: 5px 10px;
            border-radius: 6px;
        }

        .btn-compose {
            background: linear-gradient(135deg, #00d2ff, #3a7bd5);
            border: none;
            padding: 12px 25px;
            border-radius: 12px;
            color: #fff;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            text-align: center;
            justify-content: center;
            text-decoration: none;
        }

        .table-container {
            background: var(--card-bg);
            border-radius: 15px;
            border: 1px solid var(--border);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            padding: 20px;
            text-align: left;
            color: var(--text-dim);
            font-size: 13px;
            text-transform: uppercase;
            border-bottom: 1px solid var(--border);
        }

        td {
            padding: 15px 20px;
            color: white;
            font-size: 14px;
            border-bottom: 1px solid var(--border);
        }

        .pagination-wrapper {
            margin-top: 30px;
            display: flex;
            justify-content: center;
        }

        .pagination {
            display: flex;
            gap: 8px;
            list-style: none;
            padding: 0;
        }

        .pagination li a,
        .pagination li span {
            padding: 10px 16px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s;
        }

        .pagination li.active span {
            background: var(--accent);
            color: #000;
            font-weight: bold;
            border-color: var(--accent);
        }

        .pagination li a:hover {
            background: rgba(0, 210, 255, 0.2);
            border-color: var(--accent);
        }

        .pagination li.disabled span {
            color: #444;
            cursor: not-allowed;
        }

        /* Tugmalarning umumiy stili */
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 14px;
        }

        /* Faqat "Show" (View) tugmasi uchun ranglar */
        .view-btn {
            background-color: rgba(59, 130, 246, 0.1);
            /* Och ko'k fon */
            color: #3b82f6;
            /* Ko'k rangli icon */
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        /* Tugma ustiga borganda (Hover) */
        .view-btn:hover {
            background-color: #3b82f6;
            color: white;
            transform: translateY(-2px);
            /* Biroz yuqoriga ko'tariladi */
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
    </style>

    <main class="content">
        <header class="header">
            <h1>Foydalanuvchilar</h1>

            <form action="{{ route('admin.users.index') }}" method="GET" class="search-box"
                style="background: var(--card-bg); padding: 5px 15px; border-radius: 10px; border: 1px solid var(--border); display: flex; align-items: center;">
                <i class="fas fa-search" style="color: var(--text-dim)"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Qidirish..."
                    style="background: transparent; border: none; color: white; margin-left: 10px; outline: none; padding: 10px;">
                @if(request('search'))
                    <a href="{{ route('admin.users.index') }}" style="color: var(--text-dim); margin-left: 10px;"><i
                            class="fas fa-times"></i></a>
                @endif
            </form>
        </header>

        <div class="stats-container">
            <div class="stat-card">
                <h3>Umumiy foydalanuvchilar</h3>
                <div class="value">{{ $totalUsers }} ta</div>
            </div>
            <div class="stat-card">
                <h3>Ishlangan testlar</h3>
                <div class="value">{{ $totalTestsTaken }} marta</div>
            </div>
            <a href="{{ route('admin.users.create') }}" class="btn-compose">
                <i class="fas fa-paper-plane"></i> Bildirishnoma yuborish
            </a>
        </div>

        <section class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Talaba</th>
                        <th>Email</th>
                        <th>Telefon raqami</th>
                        <th>Kirishlar soni</th>
                        <th>Sotib olgan testlari</th>
                        <th>Holat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div
                                        style="width: 35px; height: 35px; background: #3b82f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; text-transform: uppercase;">
                                        {{ substr($user->name, 0, 2) }}
                                    </div>
                                    {{ $user->name }}
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? '+998 *** ** **' }}</td>
                            <td style="color: #10b981; font-weight: 500;">
                                {{ $user->login_count ?? 0 }} marta
                            </td>
                            <td style="color: #10b981; font-weight: 500;">
                                {{ $user->purchases_count }} ta
                            </td>
                            <td>
                                <a href="{{ route('admin.users.show', $user->id) }}" class="action-btn view-btn"
                                    title="Ko'rish">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <span class="badge {{ $user->is_active ? 'free' : 'paid' }}" style="margin-right: 5px;">
                                    {{ $user->is_active ? 'Active' : 'Blocked' }}
                                </span>

                                <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    <button type="submit" class="badge {{ $user->is_active ? 'paid' : 'free' }}"
                                        style="border: none; cursor: pointer; font-family: inherit; outline: none;">
                                        <i class="fas {{ $user->is_active ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                        {{ $user->is_active ? 'Bloklash' : 'Tiklash' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-dim);">Foydalanuvchi
                                topilmadi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pagination-wrapper">
                {{ $users->links('pagination::bootstrap-4') }}
            </div>
        </section>
    </main>
@endsection