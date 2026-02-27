@extends('layouts.admin')
@include('admin.sitebar')

@section('title')
    Test Natijangiz — Professional Panel
@endsection

@section('content')
<style>
    .content { 
        margin-left: 260px; 
        background-color: #0f172a; 
        min-height: 100vh; 
        color: white; 
        padding: 0 !important; 
    }

    /* QOTIRILGAN PANEL - 1-savolni yopmasligi uchun top:0 va z-index */
    #top-result-area {
        position: sticky;
        margin-left: 20px;
        top: 0;
        z-index: 1001;
        background-color: #1e293b; 
        border-bottom: 3px solid #3b82f6;
        padding: 15px 0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }

    .header-container {
        max-width: 900px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 20px;
    }

    /* TAHLIL KONTEYNERI - Padding orqali 1-savolni pastga tushiramiz */
    .analysis-body {
        max-width: 900px;
        margin: 0 auto;
        padding: 50px 20px; /* 1-savol aniq ko'rinishi uchun */
    }

    .review-card { 
        background: rgba(255, 255, 255, 0.05); 
        border-radius: 15px; 
        padding: 25px; 
        margin-bottom: 30px; 
        border-left: 6px solid #3b82f6;
    }

    .option-box { 
        padding: 15px; 
        margin: 10px 0; 
        border-radius: 10px; 
        background: rgba(255, 255, 255, 0.03); 
        display: flex;
        justify-content: space-between;
        border: 1px solid rgba(255,255,255,0.1);
    }

    /* RANG STILLARI */
    .correct-opt { border-color: #10b981; background: rgba(16, 185, 129, 0.1) !important; }
    .wrong-opt { border-color: #ef4444; background: rgba(239, 68, 68, 0.1) !important; }

    .badge-label { font-size: 11px; font-weight: bold; padding: 5px 12px; border-radius: 6px; text-transform: uppercase; }
    .bg-correct { background: #10b981; color: white; }
    .bg-wrong { background: #ef4444; color: white; }
    .bg-user { background: #3b82f6; color: white; }

    .stat-value { font-size: 2.2rem; font-weight: 800; color: #3b82f6; line-height: 1; }
</style>

<main class="content">
    <div id="top-result-area">
    <div class="header-container">
    <div>
        <h2 style="margin:0; font-size: 1.5rem;">Natija: <span style="color:#3b82f6;">{{ $percentage }}%</span></h2>
        <small style="opacity: 0.7;">Ishlangan savollar: {{ $total }} tadan {{ $answeredCount }} tasi</small>
    </div>

    <a href="{{ route('admin.testing.index') }}" class="btn" style="background:#ef4444; color:white; padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:bold;">Testni yakunlash</a>
    <div style="text-align: center;">
        <div class="stat-value">{{ $correct }} / {{ $total }}</div>
        <div style="font-size: 0.8rem; opacity: 0.6; letter-spacing: 1px;">TO'G'RI JAVOB</div>
    </div>
    </div>
    </div>

    <div class="analysis-body">
    @foreach($questions as $q)
        @php
            $uAns = strtolower(trim($q->user_choice ?? ''));
            $rAns = strtolower(trim($q->correct_answer));
            $isCorrect = ($uAns === $rAns);
        @endphp

        <div class="review-card" style="border-left-color: {{ $uAns ? ($isCorrect ? '#10b981' : '#ef4444') : '#94a3b8' }}">
            <h4 style="margin-bottom: 20px;">
                {{ $loop->iteration }}. {!! $q->question_text !!}
            </h4>

            <div class="options-list">
                @foreach(['a', 'b', 'c', 'd'] as $choice)
                    @php 
                        $optField = 'option_' . $choice;
                        $optText = $q->$optField;
                        $isRight = (strtolower($choice) === $rAns);
                        $isUser = (strtolower($choice) === $uAns);
                    @endphp

                    @if($optText)
                        <div class="option-box {{ $isRight ? 'correct-opt' : '' }} {{ ($isUser && !$isRight) ? 'wrong-opt' : '' }}">
                            <span><strong>{{ strtoupper($choice) }})</strong> {!! $optText !!}</span>
                            
                            @if($isRight && $isUser)
                                <span class="badge-label bg-user">To'g'ri & Sizniki</span>
                            @elseif($isRight)
                                <span class="badge-label bg-correct">To'g'ri javob</span>
                            @elseif($isUser)
                                <span class="badge-label bg-wrong">Sizning xatoingiz</span>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endforeach
</div>
</main>
@endsection