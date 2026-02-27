<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ULTRATEST | Kelajak Ta'limi</title>
    <meta name="description"
        content="ULTRA TEST - Bilimingizni zamonaviy AI testlar orqali sinab ko'ring. Dasturlash, tillar va aniq fanlar bo'yicha professional testlar.">
    <meta name="keywords" content="test, online test, dasturlash, uzbekistan test, ai test, bilim sinash">
    <meta name="author" content="Ultra Test Team">

    <meta property="og:title" content="ULTRA TEST — Bilimingizni onlayn sinang">
    <meta property="og:description" content="Dasturlash va boshqa fanlardan eng qiziqarli testlar to'plami.">
    <meta property="og:image" content="./img/og-preview.jpg">
    <meta property="og:type" content="website">

    <meta name="theme-color" content="#38bdf8" />

    <link rel="stylesheet" href="{{ asset('./assets/css/front.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">ULTRA<span>TEST</span></div>
        <ul class="nav-links">
            <li><a href="#features">Imkoniyatlar</a></li>
            <li><a href="#tests">Testlar</a></li>
            <li><a href="#about">Biz haqimizda</a></li>
        </ul>
        <div class="nav-btns">
            <a href="{{ route('login') }}" class="btn-signup">Kirish</a>
            <a href="{{ route('register') }}" class="btn-signup">Boshlash</a>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-content">
            <div class="badge">YANGI AVLOD PLATFORMASI</div>
            <h1>Bilimingizni <span>Ultra</span> darajaga olib chiqing</h1>
            <p>Eng zamonaviy testlar, real vaqt rejimidagi natijalar va professional tahlillar – hammasi bitta platformada.</p>
            <div class="hero-actions">
                <a href="{{ route('register') }}" class="btn-primary">Bepul boshlash</a>
                <button class="btn-secondary"><i class="fas fa-play"></i> Videoni ko'rish</button>
            </div>
        </div>
        <div class="hero-visual">
            <div class="glass-card">
                <div class="card-header">
                    <div class="dot red"></div><div class="dot yellow"></div><div class="dot green"></div>
                </div>
                <div class="card-body">
                    <div class="skeleton-line"></div>
                    <div class="skeleton-line short"></div>
                    <div class="skeleton-btn"></div>
                </div>
            </div>
            <div class="glow-orb"></div>
        </div>
    </section>

    <section class="stats" id="features">
        <div class="stat-box">
            <h3>10K+</h3>
            <p>Faol talabalar</p>
        </div>
        <div class="stat-box">
            <h3>500+</h3>
            <p>Murakkab testlar</p>
        </div>
        <div class="stat-box">
            <h3>300+</h3>
            <p>Malaka toifa testlari</p>
        </div>
        <div class="stat-box">
            <h3>98%</h3>
            <p>Ijobiy natija</p>
        </div>
    </section>

    <section class="test-categories" id="tests">
        <h2 class="section-title">Ommabop <span>Yo'nalishlar</span></h2>
        <div class="category-grid">
            <div class="cat-card">
                <div class="cat-icon"><i class="fab fa-js"></i></div>
                <h4>JavaScript Deep Dive</h4>
                <p>25 ta professional savol • 30 daqiqa</p>
                <div class="card-footer">
                    <span class="price">Bepul</span>
                    <button class="btn-sm free">Boshlash</button>
                </div>
            </div>
            <div class="cat-card pro">
                <div class="cat-icon"><i class="fab fa-python"></i></div>
                <h4>Python Fundamentals</h4>
                <p>20 ta standart savol • 25 daqiqa</p>
                <div class="card-footer">
                    <span class="price">PRO</span>
                    <button class="btn-sm gold free">Sotib olish</button>
                </div>
            </div>
            <div class="cat-card">
                <div class="cat-icon"><i class="fas fa-language"></i></div>
                <h4>English Grammar</h4>
                <p>40 ta savol • 15 daqiqa</p>
                <div class="card-footer">
                    <span class="price">Bepul</span>
                    <button class="btn-sm free">Boshlash</button>
                </div>
            </div>
        </div>
    </section>

    <section class="dashboard-preview">
        <div class="dash-text">
            <h2>Natijalaringizni <span>chuqur tahlil</span> qiling</h2>
            <ul class="feat-list">
                <li><i class="fas fa-check-circle"></i> Xatolaringiz ustida ishlash</li>
                <li><i class="fas fa-chart-line"></i> Oylik o'sish grafigi</li>
                <li><i class="fas fa-users"></i> Umumiy reytingdagi o'rningiz</li>
            </ul>
        </div>
        <div class="dash-visual">
            <div class="mini-chart">
                <div class="bar" style="height: 60%"></div>
                <div class="bar" style="height: 85%"></div>
                <div class="bar" style="height: 45%"></div>
                <div class="bar" style="height: 95%"></div>
            </div>
        </div>
    </section>

    <section class="pricing" id="pricing">
        <div class="price-card">
            <h4>Oddiy</h4>
            <div class="amount">$0<span>/oy</span></div>
            <ul>
                <li>Cheklangan testlar</li>
                <li>Kunlik 5 ta urinish</li>
                <li>Reklama bor</li>
            </ul>
            <button class="btn-price free">Hozir boshlash</button>
        </div>
        <div class="price-card featured">
            <div class="popular">POPULAR</div>
            <h4>ULTRA PRO</h4>
            <div class="amount">$9.99<span>/oy</span></div>
            <ul>
                <li>Barcha testlarga ruxsat</li>
                <li>Cheksiz urinishlar</li>
                <li>Shaxsiy mentor maslahati</li>
                <li>Reklamasiz interfeys</li>
            </ul>
            <button class="btn-price primary free">Pro-ga o'tish</button>
        </div>
    </section>

    <section class="founder-section">
        <div class="founder-container">
            <div class="founder-image">
                <img src="./rasm.png" alt="Founder">
                <div class="founder-glow"></div>
            </div>
            <div class="founder-info">
                <div class="badge">ASOSCHI</div>
                <h2>Kelajakni <span>birgalikda</span> quramiz</h2>
                <p>"ULTRATEST nafaqat testlar to'plami, balki har bir inson o'z salohiyatini kashf qilishi uchun yaratilgan intellektual ekotizimdir. Bizning maqsadimiz — ta'limni hamma uchun ochiq va qiziqarli qilish."</p>
                <div class="founder-meta">
                    <strong>Rayimjonov Eldorbek</strong>
                    <span>Senior Full-stack Developer & UI/UX Designer</span>
                </div>
            </div>
        </div>
    </section>

    <footer class="main-footer">
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="logo">ULTRA<span>TEST</span></div>
                <p>O'zbekistondagi eng innovatsion onlayn test platformasi. Bilimingizni biz bilan charxlang.</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-telegram"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            
            <div class="footer-links">
                <h4>Platforma</h4>
                <ul>
                    <li><a href="#">Bosh sahifa</a></li>
                    <li><a href="#">Kurslar</a></li>
                    <li><a href="#">Reyting</a></li>
                    <li><a href="#">Yordam</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h4>Hujjatlar</h4>
                <ul>
                    <li><a href="#">Foydalanish shartlari</a></li>
                    <li><a href="#">Maxfiylik siyosati</a></li>
                    <li><a href="#">Ommaviy oferta</a></li>
                </ul>
            </div>

            <div class="footer-newsletter">
                <h4>Yangiliklardan xabardor bo'ling</h4>
                <div class="subscribe-box">
                    <input type="email" placeholder="Emailingizni kiriting">
                    <button>OK</button>
                </div>
                <li style="margin-top: 17px;" >
                    <a style="color: #fff; font-size: 14px; ; " href="tel:+998979090219"> <b style="font-size: 17px; margin-right: 5px" >Support:</b>  +998 97 909 02 19</a>
                </li>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 ULTRATEST Platform. Barcha huquqlar himoyalangan.</p>
        </div>
    </footer>
    <script>
    document.querySelectorAll('.free').forEach(function (el) {
        el.addEventListener('click', function () {
            window.location.href = "{{ route('register') }}";
        });
    });
</script>
</body>
</html>