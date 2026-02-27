@extends('layouts.admin')
@include('admin.sitebar')

@section('title')
    Test jarayoni — Professional Panel
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('./assets/css/main.css') }}">

    @php
        $questions = $quiz->questions;
        $totalQuestions = $questions ? $questions->count() : 0;

        // Sessiyadagi step (1, 2, 3...) dan 1 ayiramiz, 
        // shunda massiv indeksi (0, 1, 2...) hosil bo'ladi
        $currentStepIndex = $step - 1;

        $currentQuestion = $questions ? $questions->get($currentStepIndex) : null;
    @endphp

    <style>
        .content {
            margin-left: 260px;
            background-color: #0f172a;
            min-height: 100vh;
            padding: 40px;
            color: white;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 30px;
            position: relative;
            overflow: hidden;
        }

        .quiz-title {
            font-size: 1.5rem;
            margin-bottom: 25px;
            line-height: 1.4;
            word-wrap: break-word;
        }

        .option {
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 10px;
            cursor: pointer;
            border: 1px solid transparent;
            transition: 0.3s;
            color: white;
            display: flex;
            align-items: center;
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding: 12px 25px;
            border-radius: 10px;
            text-decoration: none;
        }
    </style>

    <main class="content">
        <div class="container-fluid">
            @if($totalQuestions > 0 && $currentQuestion)
                <div style="display: flex; justify-content: space-between; margin-bottom: 20px; align-items: center;">
                    <span style="font-size: 1.1rem;">Savol: <b>{{ $step }}</b> / {{ $totalQuestions }}</span>
                    {{-- Taymer id --}}
                    <span id="timer" style="color: #fb7185; font-weight: bold; font-size: 1.3rem;">--:--</span>
                </div>

                <form id="quiz-form" action="{{ route('admin.testing.saveAnswer') }}" method="POST">
                    @csrf
                    <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
                    <input type="hidden" name="step" value="{{ $step }}">

                    <input type="hidden" name="question_id" value="{{ $currentQuestion->id }}">

                    <div class="glass-card">
                        <h2 class="quiz-title">{{ html_entity_decode($currentQuestion->question_text) }}</h2>

                        <div id="options-container">
                            @foreach(['a', 'b', 'c', 'd'] as $choice)
                                @php $field = 'option_' . $choice; @endphp
                                @if($currentQuestion->$field)
                                    <label style="display: block; width: 100%; cursor: pointer;">
                                        <input type="radio" name="answer" value="{{ $choice }}" style="display: none;"
                                            onchange="enableNext(this)">
                                        <div class="option">
                                            <b style="color: #3b82f6; margin-right: 15px;">{{ strtoupper($choice) }})</b>
                                            {{ $currentQuestion->$field }}
                                        </div>
                                    </label>
                                @endif
                            @endforeach
                        </div>

                        <div style="margin-top: 40px; display: flex; justify-content: space-between;">
                            <a href="{{ route('admin.testing.terminate', $quiz->id) }}" class="btn-secondary"
                                onclick="return confirm('Testni to\'xtatmoqchimisiz?')">
                                Chiqish
                            </a>
                            <button type="submit" class="btn-primary" id="next-btn" style="opacity: 0.5; pointer-events: none;">
                                {{ ($step + 1 < $totalQuestions) ? 'Keyingisi' : 'Yakunlash' }}
                            </button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </main>

    <script>
        // Serverdan kelgan qolgan vaqt (sekundda)
        // 1. O'zgaruvchilarni xavfsiz holatda yuklaymiz
        let timeLeft = parseInt("{{ $timeLeft }}") || 0;
        const timerElem = document.getElementById('timer');
        const quizForm = document.getElementById('quiz-form');

        function updateTimer() {
            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                timerElem.innerHTML = "0:00";

                // Vaqt tugaganda avtomatik submit qilish
                if (quizForm) {
                    // Submit metodiga yo'naltirish
                    let submitUrl = "{{ route('admin.testing.submit') }}";
                    quizForm.setAttribute('action', submitUrl);
                    quizForm.submit();
                }
                return;
            }

            let minutes = Math.floor(timeLeft / 60);
            let seconds = timeLeft % 60;

            // Taymerni formatlash
            timerElem.innerHTML = minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
            timeLeft--;
        }

        // Taymerni ishga tushirish
        if (timerElem) {
            updateTimer();
            const timerInterval = setInterval(updateTimer, 1000);
        }

        // Variant tanlanganda tugmani yoqish
        function enableNext(input) {
            const btn = document.getElementById('next-btn');
            btn.style.opacity = "1";
            btn.style.pointerEvents = "auto";

            document.querySelectorAll('.option').forEach(opt => {
                opt.style.background = "rgba(255, 255, 255, 0.05)";
                opt.style.borderColor = "transparent";
            });

            const div = input.nextElementSibling;
            div.style.background = "rgba(59, 130, 246, 0.2)";
            div.style.borderColor = "#3b82f6";
        }
    </script>
@endsection