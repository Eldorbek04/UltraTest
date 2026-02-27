<nav class="sidebar">
    <a href="{{ route('admin.dashboard') }}" class="logo">
        <i class="fas fa-bolt"></i>
        <span>ULTRA<span style="color: #ff4d4d;">TEST</span></span>
    </a>
    
    
    <ul class="nav-links">
        
        <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-house"></i> <span>Bosh sahifa</span></a></li>
        <li><a href="{{ route('admin.testing.index') }}"><i class="fas fa-vial"></i> <span>Test ishlash</span></a></li>
        
                  {{--  FAQAT ADMIN UCHUN (To'liq boshqaruv) --}}
        @role('admin')
            <li><a href="{{ route('admin.category.index') }}"><i class="fas fa-tags"></i><span>Fanlar Kategoriyasi</span></a></li>
            <li><a href="{{ route('admin.test.index') }}"><i class="fas fa-plus-square"></i> <span>Test qo'shish</span></a></li>
            <li><a href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i> <span>Foydalanuvchi</span></a></li>
            <li><a href="{{ route('admin.paynet.index') }}"><i class="fas fa-credit-card"></i> <span>Pul kiritish</span></a></li>
            <li><a href="#"><i class="fas fa-id-card"></i> <span>Karta raqam sozlash</span></a></li>
            <li>
            <a href="{{ route('admin.hisobadmin.index') }}">
    <div class="nav-icon-container">
        <i class="fas fa-coins"></i>
        @php
            $pendingPaymentsCount = \App\Models\Hisob::where('status', 'pending')->count();
        @endphp
        
        @if($pendingPaymentsCount > 0)
            <span class="nav-badge" style="background: #ff4757; color: white; position: absolute; top: -5px; right: -5px; font-size: 10px; padding: 2px 6px; border-radius: 50%;">
                {{ $pendingPaymentsCount }}
            </span>
        @endif
    </div>
    <span>Hisob Toldirish</span>
</a>
        </li>
            <li><a href="{{ route('admin.faq.index') }}"><i class="fas fa-comments"></i> <span>Faq</span></a></li>
            <li><a href="{{ route('admin.settings.index') }}"><i class="fas fa-shuttle-van"></i> <span>Referal sozlash</span></a></li>
            <li><a href="{{ route('admin.admin.index') }}"><i class="fas fa-cog"></i> <span>Sozlamalar Adminlar</span></a></li>
        @endrole

        {{--  FAQAT TEACHER UCHUN (O'qituvchi mantiqi) --}}
        @role('teacher')
        <li><a href="{{ route('admin.test.index') }}"><i class="fas fa-plus-square"></i> <span>Test qo'shish</span></a></li>
        @endrole

        {{--  FAQAT TESTER UCHUN --}}
        @role('tester')
            <li><a href="{{ route('admin.test.index') }}"><i class="fas fa-plus-square"></i> <span>Test qo'shish</span></a></li>
        </ul>
        @endrole
        
        {{--  FOYDALANUVCHILAR UCHUN --}}
        <li><a href="#"><i class="fas fa-book"></i><span>Mustaqil ish Slayd</span></a></li>
        <li><a href="{{ route('admin.hisob.index') }}"><i class="fas fa-wallet"></i> <span>Xisob to'ldirish</span></a></li>
        <li><a href="{{ route('admin.support.index') }}"><i class="fas fa-headset"></i> <span>Qo'llab-quvvatlash</span></a></li>
        <li>
            <a href="{{ route('admin.message.index') }}">
                <div class="nav-icon-container">
                    <i class="fas fa-bell"></i>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="nav-badge">{{ auth()->user()->unreadNotifications->count() }}</span>
                    @endif
                </div>
                <span>Bildirishnomalar</span>
            </a>
        </li>
        <li style="margin-top: auto;">
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                style="color:rgb(218, 28, 28);">
                <i class="fas fa-sign-out-alt"></i> <span>Chiqish</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>

    {{-- PROFIL VA STATUS QISMI --}}
    <a href="{{ route('admin.profile.index') }}" class="user-profile">
        <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('image/images_kok.png') }}"
            alt="User Avatar" class="profile-avatar">
        <div class="user-info">
            <span class="user-name">{{ Auth::user()->name }}</span>
            <span class="user-status" style="color: greenyellow;">
                {{-- Admin, Teacher va Testerlar uchun Muddat ko'rinadi --}}
                @hasanyrole('admin|teacher|tester')
                    Muddatingiz: 
                    <b style="color: #fff;">
                        @if(auth()->user()->expires_at)
                            {{ auth()->user()->expires_at->format('d.m.Y') }}
                        @else
                            Cheksiz
                        @endif
                    </b>
                @else
                    {{-- Faqat oddiy studentlar uchun Balans ko'rinadi --}}
                    Hisobim: <b style="color: #fff;">{{ number_format(auth()->user()->balance, 0, '.', ' ') }}</b> so'm
                @endhasanyrole
            </span>
        </div>
    </a>
</nav>