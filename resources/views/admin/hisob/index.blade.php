@extends('layouts.admin')
@include('admin.sitebar')

@section('title')
    Xisob to'ldirish — Professional Panel
@endsection

@section('content')
    <style>
        /* Asosiy konteynerni markazlash */
        .page-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            width: 100%;
        }

        /* Karta ma'lumotlari bloki */
        .card-details-box {
            background: rgba(0, 210, 255, 0.05);
            border: 1px dashed #00d2ff;
            border-radius: 12px;
            padding: 20px;
            width: 100%;
            max-width: 550px;
            margin-bottom: 20px;
            /* Forma bilan oradagi masofa */
            color: #fff;
            font-family: 'Inter', sans-serif;
            box-sizing: border-box;
        }

        .card-header-mini {
            font-size: 12px;
            color: #a4b0be;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .card-num-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #2f3542;
            padding: 12px 18px;
            border-radius: 8px;
            margin-bottom: 8px;
            border: 1px solid #3d4451;
        }

        .card-num-wrapper span {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 2px;
            color: #00d2ff;
        }

        .copy-btn {
            background: transparent;
            border: none;
            color: #a4b0be;
            cursor: pointer;
            font-size: 18px;
            transition: 0.3s;
        }

        .copy-btn:hover {
            color: #00d2ff;
            transform: scale(1.1);
        }

        .card-holder-name {
            font-size: 14px;
            font-weight: 600;
            padding-left: 5px;
            color: #ced4da;
        }

        /* Forma kartasi */
        .form-card {
            background: #1e272e;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 550px;
            color: #ffffff;
            font-family: 'Inter', sans-serif;
            border: 1px solid #2f3542;
            box-sizing: border-box;
        }

        .header-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .header-section h2 {
            color: #00d2ff;
            margin: 0;
            font-size: 22px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

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

        /* Custom File Upload */
        .custom-file-upload {
            position: relative;
            width: 100%;
        }

        .custom-file-upload input[type="file"] {
            display: none;
        }

        .custom-file-upload label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            background: #2f3542;
            border: 2px dashed #3a7bd5;
            padding: 15px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #a4b0be;
            font-size: 15px;
            margin-bottom: 0;
        }

        .custom-file-upload label:hover {
            background: #353b48;
            border-color: #00d2ff;
            color: #fff;
        }

        .custom-file-upload label.file-selected {
            border-style: solid;
            background: rgba(0, 210, 255, 0.05);
            color: #00d2ff;
        }

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
            cursor: pointer;
            transition: 0.3s;
            text-transform: uppercase;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 210, 255, 0.4);
        }

        .btn-cancel {
            flex: 1;
            background: #3d4451;
            color: #a4b0be;
            padding: 15px;
            border-radius: 10px;
            text-decoration: none;
            text-align: center;
            font-weight: 600;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .error-text {
            color: #ff4757;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        /* Media Queries - Mobil qurilmalar uchun moslashuvchanlik */
        @media (max-width: 600px) {
            .page-container {
                padding: 10px;
                /* Chetki masofani kamaytiramiz */
            }

            .form-card {
                padding: 25px 20px;
                /* Ichki bo'shliqni kichraytiramiz */
            }

            .card-num-wrapper span {
                font-size: 16px;
                /* Karta raqamini kichikroq qilamiz */
                letter-spacing: 1px;
            }

            .header-section h2 {
                font-size: 18px;
                /* Sarlavhani kichraytiramiz */
            }

            .button-wrapper {
                flex-direction: column;
                /* Tugmalarni ustma-ust qilamiz */
                gap: 10px;
            }

            .btn-submit,
            .btn-cancel {
                width: 100%;
                /* Tugmalar to'liq kenglikda bo'ladi */
                padding: 12px;
            }

            .custom-file-upload label {
                font-size: 13px;
                /* Fayl yuklash yozuvini kichraytiramiz */
                padding: 12px;
            }
        }

        /* Juda kichik ekranlar uchun (iPhone SE va h.k.) */
        @media (max-width: 380px) {
            .card-num-wrapper span {
                font-size: 14px;
            }

            .card-header-mini {
                font-size: 10px;
            }
        }
    </style>

    <div class="page-container">
        <div class="card-details-box">
            <div class="card-header-mini">
                <i class="fas fa-university"></i>
                <span>To'lov uchun karta ma'lumotlari</span>
            </div>
            <div class="card-main-info">
                <div class="card-num-wrapper">
                    <span id="cardNumber">8600 1234 5678 9010</span>
                    <button type="button" class="copy-btn" onclick="copyCard()" title="Nusxa olish">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
                <div class="card-holder-name">RAYIMJONOV ELDORBEK</div>
            </div>
        </div>

        <div class="form-card">
            @if(session('success'))
                <div class="alert alert-success"
                    style="background: rgba(0, 184, 148, 0.2); border: 1px solid #00b894; color: #00b894; padding: 15px; border-radius: 10px; margin-bottom: 20px; display: flex; justify-content: space-between;">
                    {{ session('success') }}
                    <span style="cursor:pointer" onclick="this.parentElement.style.display='none'">&times;</span>
                </div>
            @endif

            <div class="header-section">
                <h2>Xisobingizni to'ldiring</h2>
            </div>

            <form action="{{ route('admin.hisob.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="input-group">
                    <label for="many">To'lov summasi (so'mda)</label>
                    <input type="number" id="many" name="many" value="{{ old('many') }}" placeholder="Masalan: 50000"
                        required>
                    @error('many')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group">
                    <label>To'lov chekini yuklang</label>
                    <div class="custom-file-upload">
                        <input type="file" id="image" name="image" accept="image/*" required
                            onchange="updateFileName(this)">
                        <label for="image">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span id="file-name-display">Chek rasmini tanlang</span>
                        </label>
                    </div>
                    @error('image')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="button-wrapper">
                    <button type="submit" class="btn-submit">Hisobni To'ldirish</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn-cancel">Bekor Qilish</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            const fileNameDisplay = document.getElementById('file-name-display');
            const label = input.parentElement.querySelector('label');

            if (input.files && input.files.length > 0) {
                fileNameDisplay.textContent = input.files[0].name;
                label.classList.add('file-selected');
            } else {
                fileNameDisplay.textContent = "Chek rasmini tanlang";
                label.classList.remove('file-selected');
            }
        }

        function copyCard() {
            const cardNum = document.getElementById("cardNumber").innerText;
            const cleanNum = cardNum.replace(/\s/g, '');

            navigator.clipboard.writeText(cleanNum).then(() => {
                alert("Karta raqami nusxalandi: " + cardNum);
            }).catch(err => {
                console.error('Xatolik:', err);
            });
        }
    </script>
@endsection