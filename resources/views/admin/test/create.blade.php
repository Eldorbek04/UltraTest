@extends('layouts.admin')
@include('admin.sitebar')

@section('title')
    Test yaratish — Professional Panel
@endsection

@section('content')
    <style>
        /* Asosiy fon va masofalar */
        .admin-form-wrapper {
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        .test-card-container {
            width: 100%;
            max-width: 900px;
            background: #161b22;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        }

        .test-card-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 40px;
            border-bottom: 1px solid #30363d;
            padding-bottom: 20px;
        }

        .header-icon {
            font-size: 40px;
            color: #58a6ff;
        }

        .header-text h2 {
            color: #f0f6fc;
            margin: 0;
            font-size: 24px;
        }

        .header-text p {
            color: #8b949e;
            margin: 5px 0 0 0;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .input-box {
            margin-bottom: 25px;
        }

        .input-box label {
            display: block;
            color: #c9d1d9;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .input-box input,
        .input-box select {
            width: 100%;
            padding: 12px 15px;
            background: #0d1117;
            border: 1px solid #30363d;
            border-radius: 10px;
            color: #f0f6fc;
            transition: 0.3s;
        }

        .input-box input:focus {
            border-color: #58a6ff;
            outline: none;
            box-shadow: 0 0 0 3px rgba(88, 166, 255, 0.1);
        }

        /* Fayl yuklash zonasi */
        .file-drop-area {
            position: relative;
            display: flex;
            align-items: center;
            padding: 25px;
            border: 2px dashed #30363d;
            border-radius: 12px;
            background: #0d1117;
            transition: 0.3s;
        }

        .file-drop-area.is-active {
            border-color: #4CAF50;
            background: rgba(76, 175, 80, 0.05);
        }

        .fake-btn {
            background: #21262d;
            border: 1px solid #30363d;
            padding: 8px 15px;
            border-radius: 6px;
            color: #c9d1d9;
            margin-right: 15px;
        }

        .file-input {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #30363d;
        }

        .btn-submit {
            background: #238636;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-submit:hover {
            background: #2ea043;
        }

        .btn-cancel {
            background: transparent;
            border: 1px solid #30363d;
            color: #8b949e;
            padding: 12px 30px;
            border-radius: 10px;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .btn-cancel:hover {
            background: #30363d;
            color: #fff;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <main class="content">
        <div class="admin-form-wrapper">
            <div class="test-card-container">
                <div class="test-card-header">
                    <div class="header-icon"><i class="fas fa-plus-circle"></i></div>
                    <div class="header-text">
                        <h2>Yangi test yaratish</h2>
                        <p>Tizimga yangi savollar to'plamini qo'shish uchun quyidagi shaklni to'ldiring.</p>
                    </div>
                </div>

                @if ($errors->any())
                    <div
                        style="background: rgba(248,81,73,0.1); border: 1px solid #f85149; color: #f85149; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                        <ul style="margin: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.test.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-grid">
                        <div class="form-column">
                            <div class="input-box">
                                <label>Fan yo'nalishi (Kategoriya)</label>
                                <select name="category_id" required>
                                    <option value="" disabled selected>Fanni tanlang</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-box">
                                <label>Test mavzusi</label>
                                <input type="text" name="title" value="{{ old('title') }}"
                                    placeholder="Masalan: Logarifmik tenglamalar" required>
                            </div>
                        </div>

                        <div class="form-column">
                            <div class="input-box">
                                <label>Test turi</label>
                                <select name="is_paid" id="testType" onchange="togglePrice(this.value)">
                                    <option value="0" {{ old('is_paid') == '0' ? 'selected' : '' }}>Tekin (Bepul)</option>
                                    <option value="1" {{ old('is_paid') == '1' ? 'selected' : '' }}>Pullik</option>
                                </select>
                            </div>

                            <div class="input-box" id="priceInputBox"
                                style="display: {{ old('is_paid') == '1' ? 'block' : 'none' }};">
                                <label>Test narxi (UZS)</label>
                                <input type="number" name="price" id="priceInput" value="{{ old('price', 0) }}"
                                    placeholder="Masalan: 5000">
                            </div>

                            <div class="input-box">
                                <label>Vaqt (daqiqa)</label>
                                <input type="number" name="duration" value="{{ old('duration') }}" placeholder="Masalan: 30"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div class="input-box">
                        <label>Test fayli (Excel)</label>
                        <div class="file-drop-area" id="fileDropArea">
                            <button type="button" class="fake-btn">Faylni tanlash</button>
                            <span id="fileName" style="color: #8b949e;">yoki faylni shu yerga tortib tashlang</span>
                            <input class="file-input" type="file" name="excel_file" id="fileInput" accept=".xlsx, .xls"
                                onchange="updateFileName(this)">
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.test.index') }}" class="btn-cancel">Bekor qilish</a>
                        <button type="submit" class="btn-submit">Testni yuklash</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script>
        // Pullik tanlansa narx inputini ko'rsatish
        function togglePrice(value) {
            const priceBox = document.getElementById('priceInputBox');
            const priceInput = document.getElementById('priceInput');
            if (value == "1") {
                priceBox.style.display = 'block';
            } else {
                priceBox.style.display = 'none';
                priceInput.value = 0;
            }
        }

        // Fayl tanlanganda nomini ko'rsatish
        function updateFileName(input) {
            const fileName = input.files[0].name;
            document.getElementById('fileName').textContent = fileName;
            document.getElementById('fileName').style.color = "#fff";
        }

        // Narxni ko'rsatish/yashirish
        function togglePrice(val) {
            const priceBox = document.getElementById('priceInputBox');
            const priceInput = priceBox.querySelector('input');
            if (val === 'free') {
                priceBox.style.display = 'none';
                priceInput.value = '0';
            } else {
                priceBox.style.display = 'block';
            }
        }

        // Sahifa yuklanganda narx holatini tekshirish (old() qiymati uchun)
        window.onload = function () {
            togglePrice(document.getElementById('testType').value);
        };

        // Fayl yuklash vizual effektlari
        const fileInput = document.getElementById('fileInput');
        const fileNameDisplay = document.getElementById('fileName');
        const fileDropArea = document.getElementById('fileDropArea');

        fileInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                fileNameDisplay.textContent = "Tanlangan: " + this.files[0].name;
                fileNameDisplay.style.color = "#4CAF50";
                fileDropArea.classList.add('is-active');
            }
        });

        fileInput.addEventListener('dragenter', () => fileDropArea.classList.add('is-active'));
        fileInput.addEventListener('dragleave', () => fileDropArea.classList.remove('is-active'));
        fileInput.addEventListener('drop', () => fileDropArea.classList.remove('is-active'));

        function togglePrice(value) {
            const priceBox = document.getElementById('priceInputBox');
            const priceInput = document.getElementById('priceInput');

            if (value == "1") {
                // Agar Pullik (1) tanlansa - ko'rsatish
                priceBox.style.display = 'block';
                priceInput.setAttribute('required', 'required'); // Narx kiritish majburiy bo'ladi
            } else {
                // Agar Tekin (0) tanlansa - yashirish
                priceBox.style.display = 'none';
                priceInput.removeAttribute('required'); // Narx majburiy emas
                priceInput.value = 0; // Qiymatni 0 qilib qo'yish
            }
        }

        // Fayl tanlanganda nomini ko'rsatish funksiyasi (bu ham kerak edi)
        function updateFileName(input) {
            const fileNameDisplay = document.getElementById('fileName');
            if (input.files && input.files[0]) {
                fileNameDisplay.textContent = input.files[0].name;
                fileNameDisplay.style.color = "#4a9eff"; // Fayl tanlansa rangini o'zgartirish
            }
        }
    </script>
@endsection