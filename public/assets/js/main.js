document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('test-search');
    
    // Qidiruv maydoniga yozilganda ishlaydi
    searchInput.addEventListener('input', (e) => {
        const term = e.target.value.toLowerCase(); // Kichik harfga o'tkazamiz
        const testCards = document.querySelectorAll('.test-grid .glass-card'); // Hamma test kartalarini olamiz

        testCards.forEach(card => {
            // Karta ichidagi sarlavha (H3) matnini olamiz
            const title = card.querySelector('h3').innerText.toLowerCase();
            
            // Agar sarlavhada qidirilayotgan so'z bo'lsa ko'rsatamiz, bo'lmasa yashiramiz
            if (title.includes(term)) {
                card.style.display = "flex"; // Oldingi flex holatiga qaytarish
                card.style.animation = "fadeIn 0.3s ease";
            } else {
                card.style.display = "none";
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('test-search');
    const badge = id => document.getElementById(id);
    
    searchInput.addEventListener('input', (e) => {
        const term = e.target.value.toLowerCase();
        const testCards = document.querySelectorAll('.test-grid .glass-card');
        let foundCount = 0;

        testCards.forEach(card => {
            const title = card.querySelector('h3').innerText.toLowerCase();
            if (title.includes(term)) {
                card.style.display = "flex";
                card.style.animation = "fadeInUp 0.4s ease forwards";
                foundCount++;
            } else {
                card.style.display = "none";
            }
        });

        // Search Badge yangilash
        badge('search-badge').innerText = term === "" ? "Barchasi" : `Topildi: ${foundCount}`;
        badge('search-badge').style.background = foundCount > 0 ? "rgba(56, 189, 248, 0.2)" : "rgba(251, 113, 133, 0.2)";
    });
});

const translations = {
    uz: {
        welcome: "Salom! Bilimingizni",
        with_test: "bilan sinang.",
        search_placeholder: "Fanlarni qidirish...",
        start_btn: "Boshlash",
        questions: "savol",
        minutes: "daqiqa",
        pro_test: "Professional daraja"
    },
    ru: {
        welcome: "Привет! Проверьте знания с",
        with_test: "",
        search_placeholder: "Поиск предметов...",
        start_btn: "Начать",
        questions: "вопросов",
        minutes: "минут",
        pro_test: "Профессиональный уровень"
    },
    en: {
        welcome: "Hello! Test your knowledge with",
        with_test: "",
        search_placeholder: "Search subjects...",
        start_btn: "Start",
        questions: "questions",
        minutes: "minutes",
        pro_test: "Professional level"
    }
};

function changeLang(lang) {
    // 1. Aktiv tugmani o'zgartirish
    document.querySelectorAll('.lang-btn').forEach(btn => btn.classList.remove('active'));
    document.getElementById(`btn-${lang}`).classList.add('active');

    // 2. Matnlarni yangilash
    document.querySelectorAll('[data-i18n]').forEach(el => {
        const key = el.getAttribute('data-i18n');
        el.innerText = translations[lang][key];
    });

    // 3. Placeholderlarni yangilash
    const searchInput = document.getElementById('test-search');
    if(searchInput) searchInput.placeholder = translations[lang].search_placeholder;

    // Tilni brauzer xotirasiga saqlab qo'yish (Backend uchun tayyorgarlik)
    localStorage.setItem('selectedLang', lang);
}

// Sahifa yuklanganda oxirgi tanlangan tilni tiklash
document.addEventListener('DOMContentLoaded', () => {
    const savedLang = localStorage.getItem('selectedLang') || 'uz';
    changeLang(savedLang);
});

document.addEventListener('DOMContentLoaded', () => {
    const grid = document.getElementById('test-grid');
    
    // 1. Barcha kartochkalarni massivga (Array) yig'ib olamiz
    const cards = Array.from(grid.children);

    // 2. Fisher-Yates shuffle algoritmi (eng mukammal aralashtirish)
    for (let i = cards.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        // O'rinlarini almashtirish
        grid.appendChild(cards[j]); 
        // JavaScript appendChild() orqali elementni o'chirib, oxiriga qo'shadi, 
        // bu esa tabiiy ravishda o'rinlarni o'zgartiradi
    }
});

let selectedAnswer = null;

function selectOption(element) {
    // Avvalgi tanlangan klassni olib tashlash
    const allOptions = document.querySelectorAll('.option');
    allOptions.forEach(opt => opt.classList.remove('active'));

    // Yangi tanlanganga klass qo'shish
    element.classList.add('active');
    selectedAnswer = element.innerText;

    // "Keyingisi" tugmasini aktivlashtirish
    const nextBtn = document.getElementById('next-btn');
    nextBtn.style.opacity = "1";
    nextBtn.style.pointer_events = "auto";
    nextBtn.style.pointerEvents = "auto";
}

function checkAndNext() {
    if (selectedAnswer) {
        console.log("Tanlangan javob:", selectedAnswer);
        // Bu yerda natijani saqlash yoki keyingi savolga o'tish kodi bo'ladi
        window.location.href = 'result.html';
    }
}

function checkAndexit() {
        // Bu yerda natijani saqlash yoki keyingi savolga o'tish kodi bo'ladi
        window.location.href = 'index.html';
}

function downloadPDF() {
    const element = document.getElementById('capture-area');
    const btns = document.querySelector('.btn-group');
    
    btns.style.visibility = 'hidden'; // PDF-da tugmalar chiqmasligi uchun

    const opt = {
        margin: 0.3,
        filename: 'UltraTest_Tahlil.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, backgroundColor: '#0f172a' },
        jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
    };

    html2pdf().set(opt).from(element).save().then(() => {
        btns.style.visibility = 'visible';
    });
}

// knopka uchun

document.addEventListener("DOMContentLoaded", function () {

    const currentPath = window.location.pathname.replace(/\/$/, '');
    const navLinks = document.querySelectorAll('.nav-links a');

    navLinks.forEach(link => {
        link.classList.remove('active');

        const href = link.getAttribute('href');
        if (!href || href === '#') return;

        // href ni pathname ga aylantiramiz
        const linkPath = new URL(href, window.location.origin)
            .pathname
            .replace(/\/$/, '');

        // ✅ FAQAT ANIQ MATCH YOKI CHILD ROUTE
        if (
            currentPath === linkPath ||
            currentPath.startsWith(linkPath + '/')
        ) {
            link.classList.add('active');
        }
    });
});


// message

function updateNotifications(count) {
    const badge = document.querySelector('.notification-badge');
    if (count > 0) {
        badge.textContent = count;
        badge.style.display = 'flex';
    } else {
        badge.style.display = 'none';
    }
}

// Sinov uchun: 5 ta xabar bor deb belgilash
updateNotifications(5);

document.addEventListener('DOMContentLoaded', function () {
    const alertBox = document.querySelector('.alert');

    if (alertBox) {
        const closeBtn = alertBox.querySelector('.close');

        closeBtn.addEventListener('click', function () {
            alertBox.classList.add('hide');
            setTimeout(() => alertBox.remove(), 400);
        });

        // 4 soniyadan keyin avtomatik yopilishi
        setTimeout(() => {
            if (alertBox) {
                alertBox.classList.add('hide');
                setTimeout(() => alertBox.remove(), 400);
            }
        }, 4000);
    }
});
