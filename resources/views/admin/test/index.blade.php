@extends('layouts.admin')
@include('admin.sitebar')
@section('content')
    @section('title')
        Test Boshqaruv — Professional Panel
    @endsection

    <style>
        .search-input {
            width: 300px;
            padding: 10px 14px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #444;
            background: #0f172a;
            color: #fff;
            font-size: 15px;
            outline: none;
        }

        .search-input::placeholder {
            color: #94a3b8;
        }

        .search-input:focus {
            border-color: #38bdf8;
            box-shadow: 0 0 0 2px rgba(56, 189, 248, .3);
        }

        /* Modern Glassmorphism & UI Improvements */
        :root {
            --card-bg: #1c1d26;
            --accent: #00d2ff;
            --danger: #ff4d4d;
            --success: #00ff88;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        /* Sidebar Improvement */
        .sidebar {
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Table Design Update */
        .table-container {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        table {
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        thead th {
            color: #6c7293;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            padding-bottom: 20px;
            border: none;
        }

        tbody tr {
            background: rgba(255, 255, 255, 0.02);
            transition: transform 0.2s, background 0.2s;
        }

        tbody tr:hover {
            transform: scale(1.01);
            background: rgba(255, 255, 255, 0.05);
        }

        tbody td {
            padding: 20px;
            border: none;
        }

        tbody td:first-child {
            border-radius: 12px 0 0 12px;
        }

        tbody td:last-child {
            border-radius: 0 12px 12px 0;
        }

        /* Icon Wrapper */
        .cat-icon-wrapper {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, rgba(0, 210, 255, 0.2), rgba(0, 210, 255, 0.05));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            border: 1px solid rgba(0, 210, 255, 0.1);
        }

        /* Slug Style */
        .slug-badge {
            background: rgba(255, 255, 255, 0.05);
            padding: 5px 12px;
            border-radius: 6px;
            font-family: 'Courier New', monospace;
            font-size: 0.85rem;
            color: var(--accent);
        }

        /* Modal Enhancement */
        .modal-overlay {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(8px);
        }

        .modal-content {
            background: #16171f;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            transform: translateY(0);
            animation: modalIn 0.3s ease-out;
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .custom-input,
        .custom-select {
            width: 100%;
            padding: 14px;
            background: #0f1016;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: white;
            transition: border-color 0.3s;
        }

        .custom-input:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 210, 255, 0.1);
        }

        .btn-save {
            background: linear-gradient(135deg, #00d2ff, #0072ff);
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            color: white;
            cursor: pointer;
            transition: opacity 0.3s;
        }

        .btn-save:hover {
            opacity: 0.9;
        }

        .btn-icon {
            width: 35px;
            height: 35px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 4px;
            transition: all 0.2s;
        }

        .btn-edit {
            background: rgba(0, 210, 255, 0.1);
            color: var(--accent);
        }

        .btn-delete {
            background: rgba(255, 77, 77, 0.1);
            color: var(--danger);
        }

        .btn-edit:hover {
            background: var(--accent);
            color: #000;
        }

        .btn-delete:hover {
            background: var(--danger);
            color: #fff;
        }
        /*  */
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

        .pagination li a, .pagination li span {
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
    </style>

<main class="content">
        <header class="header" style="margin-bottom: 40px;">
            <div>
                <h1 style="font-size: 1.8rem; font-weight: 700;">Testlar Boshqaruvi</h1>
                <p style="color: #6c7293; margin-top: 5px;">Testlarni umumiy boshqaruv paneli.</p>
            </div>
            <input type="search" id="searchInput" placeholder="Qidirish..." class="search-input">
            <a href="{{ asset('namuna/Namuna Test ( Web dasturlash ) tuzish.xlsx') }}" class="btn-add"
                style="padding: 12px 24px; border-radius: 12px; background: var(--success); border: none; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; color: #000; text-decoration: none;">
                Namunani ko'rish
            </a>
            <a href="{{ route('admin.test.create') }}" class="btn-add"
                style="padding: 12px 24px; border-radius: 12px; background: var(--accent); border: none; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; color: #000; text-decoration: none;">
                <i class="fas fa-plus-circle"></i> Yangi Test qo'shish
            </a>
        </header>

        <section class="table-container">
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th>Test mavzusi</th>
                        <th>Kategory</th>
                        <th>Narxi</th>
                        <th>Vaqti</th>
                        <th>Qo'shilgan vaqt</th>
                        <th>Muallif</th>
                        <th style="text-align: right; padding-right: 30px;">Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quizzes as $tests)
                        <tr>
                            <td class="search-item">
                                <b style="color: #fbbf24;">{{ $tests->title }}</b>
                            </td>
                            <td>{{ $tests->category->name ?? 'Kategoriya yo‘q' }}</td>
                            <td>{{ $tests->price }}</td>
                            <td>{{ $tests->duration }}</td>
                            <td>{{ $tests->created_at->format('Y-m-d H:i') }}</td>
                            <td><small>{{ $tests->user->name ?? 'Noma\'lum' }}</small></td>
                            <td class="actions" style="text-align: right;">
                                <a href="{{ route('admin.test.edit', $tests->id) }}" class="btn-icon btn-edit">
                                    <i class="fas fa-pen-nib"></i>
                                </a>
                                <form style="display:inline" action="{{ route('admin.test.destroy', $tests->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-icon btn-delete" onclick="return confirm('O‘chirishni hohlaysizmi?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="pagination-wrapper">
                {{ $quizzes->links('pagination::bootstrap-4') }}
            </div>
        </section>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const searchInput = document.getElementById('searchInput');

            searchInput.addEventListener('keyup', function () {
                const value = this.value.toLowerCase();
                const rows = document.querySelectorAll('tbody tr');

                rows.forEach(row => {
                    const text = row.querySelector('.search-item')
                        .textContent
                        .toLowerCase();

                    row.style.display = text.includes(value) ? '' : 'none';
                });
            });

        });
    </script>
@endsection