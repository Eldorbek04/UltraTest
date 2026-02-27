@extends('layouts.admin')
@include('admin.sitebar')

@section('title')
    SHOW Foydalanuvchilar — Professional Panel
@endsection

@section('content')
    <style>
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .profile-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 25px;
            background: var(--card-bg);
            /* Yoki rgba(255, 255, 255, 0.05) */
            border-radius: 15px;
            border: 1px solid var(--border);
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .profile-header h2 {
            font-size: 20px;
            color: white;
            margin: 0;
            font-weight: 600;
        }

        .profile-header h2 span {
            color: var(--text-dim);
            font-weight: 400;
            font-size: 16px;
        }

        /* Qaytish tugmasi uchun maxsus stil */
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 18px;
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
            text-decoration: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .back-btn i {
            font-size: 13px;
        }

        .back-btn:hover {
            background: #3b82f6;
            color: white;
            transform: translateX(-5px);
            /* Chapga biroz siljiydi */
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
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
        <div class="profile-header">
            <h2>{{ $user->name }} — <span>Shaxsiy ma'lumotlar</span></h2>
            <a href="{{ route('admin.users.index') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Qaytish
            </a>
        </div>

        <section class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Ma'lumot turi</th>
                        <th>Qiymati</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Talaba:</strong></td>
                        <td>{{ $user->name }} (ID: #{{ $user->id }})</td>
                    </tr>
                    <tr>
                        <td><strong>Email / Tel:</strong></td>
                        <td>{{ $user->email }} / {{ $user->phone ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Asosiy Balans:</strong></td>
                        <td style="color: #fbbf24; font-weight: bold;">
                            {{ number_format($user->balance, 0, '.', ' ') }} UZS
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Pullik ishlagan testlari:</strong></td>
                        <td>{{ $user->purchases_count }} ta test sotib olingan</td>
                    </tr>
                    <tr>
                        <td><strong>Jami kirishlar soni:</strong></td>
                        <td>{{ $user->login_count ?? 0 }} marta</td>
                    </tr>
                    <tr>
                        <td><strong>O'rtacha natija:</strong></td>
                        <td style="color: #10b981; font-weight: bold;">
                            {{ round($user->results_avg_score) }}%
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td>
                            <span class="badge {{ $user->is_active ? 'free' : 'paid' }}">
                                {{ $user->is_active ? 'Faol' : 'Bloklangan' }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>
@endsection