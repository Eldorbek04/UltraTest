@extends('layouts.admin')
@include('admin.sitebar')
@section('content')
    @section('title')
        Bildirishnomalar — Professional Panel
    @endsection

    <style>
        .delete-btn {
            background: rgba(255, 75, 92, 0.1);
            /* Shaffof qizil */
            border: 1px solid rgba(255, 75, 92, 0.2);
            color: #ff4b5c;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .delete-btn:hover {
            background: #ff4b5c;
            /* To'liq qizil */
            color: white;
            box-shadow: 0 0 10px rgba(255, 75, 92, 0.4);
            transform: scale(1.05);
        }

        .delete-btn i {
            font-size: 14px;
        }

        :root {
            --primary: #00d2ff;
            --unread-bg: rgba(0, 210, 255, 0.05);
            --border: rgba(255, 255, 255, 0.08);
        }

        /* Message Card System */
        .message-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .message-card {
            background: #1c1d26;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            display: flex;
            align-items: flex-start;
            gap: 20px;
            transition: 0.3s;
            cursor: pointer;
            position: relative;
        }

        .message-card:hover {
            border-color: var(--primary);
            transform: translateX(5px);
        }

        .message-card.unread {
            background: var(--unread-bg);
            border-left: 4px solid var(--primary);
        }



        .msg-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: var(--primary);
            flex-shrink: 0;
        }

        .msg-content {
            flex: 1;
        }

        .msg-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .msg-title {
            font-weight: 700;
            font-size: 1.1rem;
            color: #fff;
        }

        .msg-time {
            font-size: 0.85rem;
            color: #6c7293;
        }

        .msg-body {
            color: #a0a0a0;
            line-height: 1.5;
            font-size: 0.95rem;
        }

        /* Compose Button Styling */
    </style>


    <main class="content">
        <header class="header" style="margin-bottom: 30px;">
            <div>
                <h1>Bildirishnomalar</h1>
                <p style="color: #6c7293;">Umumiy koinadigan bildirishnomalar.</p>
            </div>
        </header>

        <div class="message-container">
            @forelse(auth()->user()->notifications as $notification)
                {{-- O'qilmagan bo'lsa 'unread' klassini qo'shadi --}}
                <div class="message-card {{ $notification->unread() ? 'unread' : '' }}">

                    <div class="msg-icon">
                        {{-- Notification klassida ko'rsatilgan ikonkani chiqaradi --}}
                        <i class="{{ $notification->data['icon'] ?? 'fas fa-bell' }}"></i>
                    </div>

                    <div class="msg-content">
                        <div class="msg-header">
                            <span class="msg-title">
                                @if(isset($notification->data['bonus']))
                                    Bonus Hisoblandi
                                @elseif(isset($notification->data['title']))
                                    {{ $notification->data['title'] }} {{-- Bu yerda 'Admin javobi' chiqadi --}}
                                @else
                                    Bildirishnoma
                                @endif
                            </span>
                            <div class="box">
                                <span class="msg-time"
                                    style="margin-right: 7px;">{{ $notification->created_at->diffForHumans() }}</span>
                                <form action="{{ route('admin.message.destroy', $notification->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn" onclick="return confirm('Ochirilsinmi?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <p class="msg-body">
                            {{ $notification->data['message'] }}
                            @if(isset($notification->data['bonus']))
                                <br><strong
                                    style="color: var(--primary);">+{{ number_format($notification->data['bonus'], 0, '.', ' ') }}
                                    so'm</strong>
                            @endif
                        </p>
                    </div>
                </div>
            @empty
                {{-- Agar xabarlar bo'lmasa --}}
                <div class="message-card" style="justify-content: center; opacity: 0.6;">
                    <p class="msg-body">Hozircha hech qanday bildirishnoma mavjud emas.</p>
                </div>
            @endforelse

            <!-- {{-- Sahifalash (Pagination) --}}
                    <div style="margin-top: 20px;">
                        {{ auth()->user()->notifications()->paginate(10)->links() }}
                    </div> -->
        </div>
    </main>
@endsection