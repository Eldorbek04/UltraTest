@extends('layouts.admin')
@include('admin.sitebar')

@section('title')
    Testni Tahrirlash — Professional Panel
@endsection

@section('content')
    <style>
        .admin-form-wrapper { display: flex; justify-content: center; padding: 20px; }
        .test-card-container { width: 100%; max-width: 900px; background: #161b22; border-radius: 20px; padding: 40px; box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4); }
        .test-card-header { display: flex; align-items: center; gap: 20px; margin-bottom: 40px; border-bottom: 1px solid #30363d; padding-bottom: 20px; }
        .header-icon { font-size: 40px; color: #e3b341; } /* Tahrirlash uchun sariq rang */
        .header-text h2 { color: #f0f6fc; margin: 0; font-size: 24px; }
        .header-text p { color: #8b949e; margin: 5px 0 0 0; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
        .input-box { margin-bottom: 25px; }
        .input-box label { display: block; color: #c9d1d9; margin-bottom: 10px; font-weight: 500; }
        .input-box input, .input-box select { width: 100%; padding: 12px 15px; background: #0d1117; border: 1px solid #30363d; border-radius: 10px; color: #f0f6fc; transition: 0.3s; }
        .input-box input:focus { border-color: #58a6ff; outline: none; }
        .file-drop-area { position: relative; display: flex; align-items: center; padding: 20px; border: 2px dashed #30363d; border-radius: 12px; background: #0d1117; }
        .fake-btn { background: #21262d; border: 1px solid #30363d; padding: 8px 15px; border-radius: 6px; color: #c9d1d9; margin-right: 15px; }
        .file-input { position: absolute; left: 0; top: 0; height: 100%; width: 100%; opacity: 0; cursor: pointer; }
        .form-actions { display: flex; justify-content: flex-end; gap: 15px; margin-top: 20px; padding-top: 20px; border-top: 1px solid #30363d; }
        .btn-submit { background: #238636; color: white; padding: 12px 30px; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; }
        .btn-cancel { background: transparent; border: 1px solid #30363d; color: #8b949e; padding: 12px 30px; border-radius: 10px; text-decoration: none; }
        @media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; } }
    </style>

    <main class="content">
        <div class="admin-form-wrapper">
            <div class="test-card-container">
                <div class="test-card-header">
                    <div class="header-icon"><i class="fas fa-edit"></i></div>
                    <div class="header-text">
                        <h2>Testni tahrirlash</h2>
                        <p>ID: #{{ $quiz->id }} - {{ $quiz->title }} ma'lumotlarini o'zgartirish.</p>
                    </div>
                </div>

                @if ($errors->any())
                    <div style="background: rgba(248,81,73,0.1); border: 1px solid #f85149; color: #f85149; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                        <ul style="margin: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.test.update', $quiz->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-grid">
                        <div class="form-column">
                            <div class="input-box">
                                <label>Fan yo'nalishi (Kategoriya)</label>
                                <select name="category_id" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $quiz->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-box">
                                <label>Test mavzusi</label>
                                <input type="text" name="title" value="{{ old('title', $quiz->title) }}" required>
                            </div>
                        </div>

                        <div class="form-column">
                            <div class="input-box">
                                <label>Test turi</label>
                                <select name="is_paid" id="testType" onchange="togglePrice(this.value)">
                                    <option value="0" {{ $quiz->is_paid == 0 ? 'selected' : '' }}>Tekin (Bepul)</option>
                                    <option value="1" {{ $quiz->is_paid == 1 ? 'selected' : '' }}>Pullik</option>
                                </select>
                            </div>

                            <div class="input-box" id="priceInputBox" style="display: {{ $quiz->is_paid == 1 ? 'block' : 'none' }};">
                                <label>Test narxi (UZS)</label>
                                <input type="number" name="price" id="priceInput" value="{{ old('price', $quiz->price) }}">
                            </div>

                            <div class="input-box">
                                <label>Vaqt (daqiqa)</label>
                                <input type="number" name="duration" value="{{ old('duration', $quiz->duration) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="input-box">
                        <label>Yangi Excel fayl (ixtiyoriy)</label>
                        <p style="color: #8b949e; font-size: 12px; margin-bottom: 5px;">Agar savollarni o'zgartirmoqchi bo'lsangiz, yangi fayl yuklang. Aks holda bo'sh qoldiring.</p>
                        <div class="file-drop-area" id="fileDropArea">
                            <button type="button" class="fake-btn">Faylni almashtirish</button>
                            <span id="fileName" style="color: #8b949e;">Hozirgi fayl: {{ basename($quiz->file) }}</span>
                            <input class="file-input" type="file" name="excel_file" id="fileInput" accept=".xlsx, .xls" onchange="updateFileName(this)">
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.test.index') }}" class="btn-cancel">Bekor qilish</a>
                        <button type="submit" class="btn-submit">O'zgarishlarni saqlash</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        function togglePrice(value) {
            const priceBox = document.getElementById('priceInputBox');
            const priceInput = document.getElementById('priceInput');
            if (value == "1") {
                priceBox.style.display = 'block';
                priceInput.setAttribute('required', 'required');
            } else {
                priceBox.style.display = 'none';
                priceInput.removeAttribute('required');
                priceInput.value = 0;
            }
        }

        function updateFileName(input) {
            const fileNameDisplay = document.getElementById('fileName');
            if (input.files && input.files[0]) {
                fileNameDisplay.textContent = "Yangi tanlangan: " + input.files[0].name;
                fileNameDisplay.style.color = "#4a9eff";
            }
        }

        // Sahifa yuklanganda narx holatini tekshirish
        window.onload = function() {
            togglePrice(document.getElementById('testType').value);
        };
    </script>
@endsection