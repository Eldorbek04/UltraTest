@extends('layouts.admin')
@include('admin.sitebar')

@section('title')
    Xisob to'ldirish — Professional Panel
@endsection

@section('content')
    <style>
        /* Asosiy fon va karta */
        .form-card {
            background: #1e272e;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            max-width: 550px;
            margin: 30px auto;
            color: #ffffff;
            font-family: 'Inter', sans-serif;
            border: 1px solid #2f3542;
        }

        .header-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .header-section h2 {
            color: #00d2ff;
            margin: 0;
            font-size: 26px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header-section p {
            color: #a4b0be;
            font-size: 14px;
            margin-top: 10px;
        }

        /* Inputlar */
        .input-group {
            margin-bottom: 25px;
        }

        .input-group label {
            display: block;
            font-weight: 500;
            color: #ced4da;
            margin-bottom: 10px;
            font-size: 15px;
        }

        .input-group input {
            width: 100%;
            padding: 14px 18px;
            background: #2f3542;
            border: 2px solid #3d4451;
            border-radius: 10px;
            font-size: 16px;
            color: #fff;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .input-group input:focus {
            outline: none;
            border-color: #00d2ff;
            background: #353b48;
            box-shadow: 0 0 10px rgba(0, 210, 255, 0.2);
        }

        .input-group input::placeholder {
            color: #747d8c;
        }

        /* Tugmalar */
        .button-wrapper {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-submit {
            flex: 2;
            background: linear-gradient(135deg, #00d2ff 0%, #3a7bd5 100%);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s, opacity 0.3s;
            text-transform: uppercase;
        }

        .btn-submit:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 210, 255, 0.4);
        }

        .btn-submit:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-cancel {
            flex: 1;
            background: #3d4451;
            color: #a4b0be;
            padding: 15px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            text-align: center;
            transition: background 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-cancel:hover {
            background: #4b5563;
            color: #fff;
        }
    </style>

    <div class="form-card">
        @if(session('success'))
            <div class="alert alert-success"
                style="background: rgba(0, 184, 148, 0.2); border: 1px solid #00b894; color: #00b894; padding: 15px; border-radius: 10px; margin-bottom: 20px; display: flex; justify-content: space-between;">
                {{ session('success') }}
                <span style="cursor:pointer" onclick="this.parentElement.style.display='none'">&times;</span>
            </div>
        @endif

        <div class="header-section">
            <h2>Xisob to'ldirish</h2>
            <p>Foydalanuvchi hisobini to'ldirish uchun summani kiriting.</p>
        </div>

        <form action="{{ route('admin.paynet.store') }}" method="POST" class="create-form">
            @csrf

            <div class="input-group">
                <label for="user_id">Foydalanuvchi ID raqami</label>
                <input type="number" id="user_id_input" name="user_id" value="{{ old('user_id') }}" placeholder="Masalan: 1"
                    required>

                <div id="user_name_display"
                    style="margin-top: 8px; font-weight: bold; color: #00d2ff; min-height: 20px; font-size: 14px;"></div>

                @error('user_id')
                    <div style="color:#ff4757; font-size:14px; margin-top:5px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-group">
                <label for="amount">To'lov summasi (so'mda)</label>
                <input type="number" id="amount" name="amount" value="{{ old('amount') }}" placeholder="Masalan: 50000"
                    required>
                @error('amount')
                    <div style="color:#ff4757; font-size:14px; margin-top:5px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="button-wrapper">
                <button type="submit" id="submit_btn" class="btn-submit">Hisobni To'ldirish</button>
                <a href="{{ route('admin.paynet.index') }}" class="btn-cancel">Bekor Qilish</a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('user_id_input').addEventListener('input', function () {
            let userId = this.value;
            let nameDisplay = document.getElementById('user_name_display');
            let submitBtn = document.getElementById('submit_btn');

            if (userId.length > 0) {
                nameDisplay.innerText = "Qidirilmoqda...";
                nameDisplay.style.color = "#ced4da";

                // Serverga AJAX so'rov
                fetch(`{{ route('admin.findUser') }}?user_id=${userId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            nameDisplay.innerHTML = `<i class="fas fa-check-circle"></i> Foydalanuvchi: ${data.name}`;
                            nameDisplay.style.color = "#00d2ff"; // Moviy neon
                            submitBtn.disabled = false;
                        } else {
                            nameDisplay.innerHTML = `<i class="fas fa-times-circle"></i> Foydalanuvchi topilmadi!`;
                            nameDisplay.style.color = "#ff4757"; // Qizil
                            submitBtn.disabled = true;
                        }
                    })
                    .catch(error => {
                        console.error('Xato:', error);
                    });
            } else {
                nameDisplay.innerText = "";
                submitBtn.disabled = false;
            }
        });
    </script>
@endsection