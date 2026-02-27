<?php

use App\Http\Controllers\Admin\AdminsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\HisobAdminController;
use App\Http\Controllers\Admin\HisobController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\TestingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\Admin\PaymentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Bosh sahifa
Route::get('/', [MainController::class, 'index'])->name('index');

// --------------------------------------------------------------------------
// ADMIN PANEL YO'LLARI (Faqat tizimga kirganlar uchun)
// --------------------------------------------------------------------------
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {

    // 1. ASOSIY BOSHQARUV (Hamma rollar uchun)
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('profile', ProfilController::class);
    Route::resource('message', MessageController::class);
    Route::resource('paynet', PaymentController::class);
    Route::resource('faq', FaqController::class);
    Route::resource('hisob', HisobController::class);
    
    // To'lovlarni tasdiqlash (HisobAdmin)
    Route::get('/payments-all', [HisobAdminController::class, 'index'])->name('hisobadmin.index');
    Route::post('/payments/approve/{id}', [HisobAdminController::class, 'approve'])->name('hisobadmin.approve');
    Route::post('/payments/reject/{id}', [HisobAdminController::class, 'reject'])->name('hisobadmin.reject');
    // Resource-ni maxsus routelardan keyin qo'yamiz
    Route::resource('hisobadmin', HisobAdminController::class)->except(['index']);

    Route::get('/support', [SupportController::class, 'index'])->name('support.index');
    Route::post('/support/send', [SupportController::class, 'store'])->name('support.send_message');
    Route::get('testing/terminate/{id}', [TestingController::class, 'terminate'])->name('testing.terminate');
    Route::get('/find-user', [PaymentController::class, 'findUser'])->name('findUser');


    // 2. TEST ISHLASH TIZIMI (Student va boshqalar uchun)
    Route::post('testing/purchase/{id}', [QuizController::class, 'purchase'])->name('testing.purchase');
    Route::get('testing', [TestingController::class, 'index'])->name('testing.index');
    Route::get('testing/{testing}', [TestingController::class, 'show'])->name('testing.show');
    Route::post('testing/next', [TestingController::class, 'nextStep'])->name('testing.next');
    Route::post('testing/save-answer', [TestingController::class, 'saveAnswer'])->name('testing.saveAnswer');
    Route::post('testing/submit', [TestingController::class, 'submit'])->name('testing.submit');


    // 3. FAQAT ADMINLAR UCHUN (Boshqaruv)
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class); 
        Route::resource('admin', AdminsController::class); 
        Route::resource('settings', SettingsController::class); 
        Route::post('users/{id}/toggle', [UserController::class, 'toggleStatus'])->name('users.toggle');
        Route::get('payments-list', [PaymentController::class, 'allPayments'])->name('payments.all');
    });


    // 4. ADMIN, TEACHER VA TESTER UCHUN (Kontent yaratish)
    Route::middleware(['role:admin|teacher|tester'])->group(function () {
        Route::resource('category', CategoryController::class); 
        Route::resource('test', QuizController::class); 
    });


    // 5. FAQAT STUDENTLAR UCHUN
    Route::middleware(['role:student'])->group(function () {
        Route::get('payment/{quiz_id}', [PaymentController::class, 'index'])->name('payment.index');
    });

});

// --------------------------------------------------------------------------
// TIZIMDAN CHIQISH
// --------------------------------------------------------------------------
Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout.get');

// Auth tizimi (Login, Register va h.k.)
require __DIR__ . '/auth.php';