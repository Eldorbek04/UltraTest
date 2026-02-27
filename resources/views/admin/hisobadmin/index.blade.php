@extends('layouts.admin')
@include('admin.sitebar')
@section('content')
    @section('title')
        To'lovlarni boshqarish — Professional Panel
    @endsection

    <style>
        /* Asosiy konteyner kengligi */
        .page-container {
            padding: 20px;
            width: 100%;
            max-width: 1400px;
            /* Keng ekranlar uchun maksimal kenglik */
            margin: 0 auto;
        }

        .admin-card {
            background: #1c1d26;
            /* To'qroq va zamonaviy fon */
            border-radius: 16px;
            padding: 0;
            /* Ichki paddingni table uchun olib tashlaymiz */
            width: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.05);
            overflow: hidden;
            /* Border-radius kesilmasligi uchun */
        }

        .header-section {
            padding: 25px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-section h2 {
            margin: 0;
            font-size: 1.5rem;
            color: #fff;
            font-weight: 700;
        }

        /* Jadval uslubi */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            /* Mobil uchun gorizontal skroll */
        }

        .payment-table {
            width: 100%;
            border-collapse: collapse;
            color: #fff;
            min-width: 800px;
            /* Stolustu ko'rinishida siqilmasligi uchun */
        }

        .payment-table th {
            background: rgba(255, 255, 255, 0.02);
            text-align: left;
            color: #8a8d93;
            text-transform: uppercase;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 18px 25px;
        }

        .payment-table td {
            padding: 20px 25px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            vertical-align: middle;
        }

        .payment-table tr:hover {
            background: rgba(0, 210, 255, 0.02);
        }

        /* Foydalanuvchi ma'lumoti */
        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            background: #2d2e3b;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #00d2ff;
        }

        .user-name {
            font-weight: 600;
            color: #fff;
            font-size: 0.95rem;
        }

        .amount-badge {
            background: rgba(0, 210, 255, 0.1);
            color: #00d2ff;
            padding: 6px 14px;
            border-radius: 8px;
            font-weight: 700;
            display: inline-block;
            white-space: nowrap;
        }

        .receipt-preview {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            object-fit: cover;
            cursor: pointer;
            border: 2px solid rgba(255, 255, 255, 0.1);
            transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .receipt-preview:hover {
            transform: scale(1.15) rotate(2deg);
            border-color: #00d2ff;
            box-shadow: 0 5px 15px rgba(0, 210, 255, 0.3);
        }

        /* Tugmalar guruhi */
        .action-btns {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            padding: 10px 16px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.2s;
            white-space: nowrap;
        }

        .btn-approve {
            background: #10b981;
            color: white;
        }

        .btn-reject {
            background: #ef4444;
            color: white;
        }

        .btn-action:hover {
            filter: brightness(1.2);
            transform: translateY(-2px);
        }

        .btn-action:active {
            transform: translateY(0);
        }

        /* Media xabarnomalar (Responsive) */
        @media (max-width: 992px) {
            .page-container {
                padding: 10px;
            }

            .header-section {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .btn-action {
                padding: 8px 12px;
                font-size: 12px;
            }
        }

        /* Mobil uchun jadvalni karta ko'rinishiga o'tkazishni istamasangiz skroll qoladi, 
               aks holda quyidagi @media orqali kartaga aylantirish mumkin */
        @media (max-width: 768px) {

            .payment-table th,
            .payment-table td {
                padding: 15px;
            }

            .user-name {
                font-size: 0.85rem;
            }
        }

        /* Modal */
        #imageModal {
            display: none;
            position: fixed;
            z-index: 9999;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(5px);
            align-items: center;
            justify-content: center;
        }

        #modalImg {
            max-width: 95%;
            max-height: 90vh;
            border-radius: 12px;
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.5);
            transform: scale(0.9);
            transition: 0.3s;
        }
    </style>
    <main class="content">

        <div class="page-container">
            @if(session('success'))
                <div class="alert alert-success"
                    style="background: #064e3b; border: 1px solid #10b981; color: #10b981; padding: 15px; border-radius: 12px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
                    <div><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
                    <span style="cursor:pointer; font-size: 20px;"
                        onclick="this.parentElement.style.display='none'">&times;</span>
                </div>
            @endif

            <div class="admin-card">
                <div class="header-section">
                    <div>
                        <h2>Kutilayotgan to'lovlar</h2>
                        <p style="color: #6c7293; margin: 5px 0 0 0; font-size: 14px;">Yangi kelib tushgan to'lov cheklarini
                            tasdiqlang yoki rad eting.</p>
                    </div>
                    <div class="badge"
                        style="background: #00d2ff; color: #1c1d26; padding: 5px 12px; border-radius: 20px; font-weight: 800;">
                        {{ $payments->count() }} ta yangi
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="payment-table">
                        <thead>
                            <tr>
                                <th>Foydalanuvchi</th>
                                <th>Summa</th>
                                <th>Chek</th>
                                <th>Vaqt</th>
                                <th>Harakatlar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $payment)
                                <tr>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <span class="user-name">{{ $payment->user->name }}</span>
                                        </div>
                                    </td>
                                    <td><span class="amount-badge">{{ number_format($payment->many) }} so'm</span></td>
                                    <td>
                                        <img src="{{ asset($payment->image) }}" class="receipt-preview"
                                            onclick="showFullImage(this.src)" title="Kattalashtirish uchun bosing">
                                    </td>
                                    <td>
                                        <div style="font-size: 13px; color: #fff;">{{ $payment->created_at->format('H:i') }}
                                        </div>
                                        <div style="font-size: 11px; color: #6c7293;">
                                            {{ $payment->created_at->format('d.m.Y') }}</div>
                                    </td>
                                    <td>
                                        <div class="action-btns">
                                            <form action="{{ route('admin.hisobadmin.approve', $payment->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn-action btn-approve">
                                                    <i class="fas fa-check"></i> Tasdiqlash
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.hisobadmin.reject', $payment->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn-action btn-reject">
                                                    <i class="fas fa-times"></i> Rad etish
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="padding: 100px 0;">
                                        <div style="text-align: center; color: #6c7293;">
                                            <i class="fas fa-inbox"
                                                style="font-size: 48px; margin-bottom: 15px; opacity: 0.2;"></i>
                                            <p style="font-size: 16px;">Hozircha yangi to'lovlar mavjud emas</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="imageModal" onclick="closeModal()">
            <img id="modalImg">
        </div>
    </main>

    <script>
        function showFullImage(src) {
            const modal = document.getElementById('imageModal');
            const img = document.getElementById('modalImg');
            img.src = src;
            modal.style.display = 'flex';
            setTimeout(() => {
                img.style.transform = 'scale(1)';
            }, 50);
        }

        function closeModal() {
            const modal = document.getElementById('imageModal');
            const img = document.getElementById('modalImg');
            img.style.transform = 'scale(0.9)';
            setTimeout(() => {
                modal.style.display = 'none';
            }, 200);
        }

        // ESC tugmasi orqali yopish
        document.addEventListener('keydown', function (e) {
            if (e.key === "Escape") closeModal();
        });
    </script>
@endsection