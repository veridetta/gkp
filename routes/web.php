<?php

use App\Http\Controllers\admin\CashflowController as AdminCashflowController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\PaymentController;
use App\Http\Controllers\admin\PengurusController;
use App\Http\Controllers\admin\PositionController;
use App\Http\Controllers\admin\ResidenceController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\pengurus\CashflowController;
use App\Http\Controllers\pengurus\CategoryController as PengurusCategoryController;
use App\Http\Controllers\pengurus\DashboardController as PengurusDashboardController;
use App\Http\Controllers\pengurus\PaymentController as PengurusPaymentController;
use App\Http\Controllers\pengurus\ResidenceController as PengurusResidenceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//generate password
Route::get('/generate-password', function () {
    return Hash::make('password');
});

Route::get('/dashboard', function () {
    //alihkan sesuai role
    if (Auth::user()->role == 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif (Auth::user()->role == 'pengurus') {
        return redirect()->route('pengurus.dashboard');
    }  else {
        return redirect()->route('login');
    }
})->middleware(['auth'])->name('dashboard');

Route::get('/profile', [Controller::class, 'profile'])->middleware(['auth'])->name('profile');

Route::post('/profile/{id}', [Controller::class, 'updateProfile'])->middleware(['auth'])->name('updateProfile');

Route::get('/checkRole', function () {
    if(Auth::check()){
        return redirect()->route('dashboard');
    }else{
        return redirect()->route('login');
    }
    if (Auth::user()->role == 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif (Auth::user()->role == 'pengurus') {
        return redirect()->route('pengurus.dashboard');
    } else {
        return redirect()->route('login');
    }
})->name('checkRole');

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('guest.home');
    })->name('home');

});

Route::middleware('checkRole:admin')->group(function () {
    //dashboard dari dashboard controller
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    //masukkan ke dalam group route prefix admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('payment', PaymentController::class);
        Route::post('payment/filter', [PaymentController::class, 'filter'])->name('payment.filter');
        //cetak
        Route::get('payment/print/{bulan}/{tahun}/{category_id}', [PaymentController::class, 'print'])->name('payment.print');
        //invoice pay
        Route::get('payment/pay/{bulan}/{tahun}/{category_id}/{residence_id}', [PaymentController::class, 'pay'])->name('payment.pay');
        Route::post('payment/pay/{bulan}/{tahun}/{category_id}/{residence_id}', [PaymentController::class, 'storePay'])->name('payment.storePay');
        //show payment
        Route::get('payment/payment/{id}', [PaymentController::class, 'showPayment'])->name('payment.showPayment');

        //download
        Route::get('payment/download/{bulan}/{tahun}/{category_id}', [PaymentController::class, 'download'])->name('payment.download');
        Route::resource('residence', ResidenceController::class);
        Route::resource('pengurus', PengurusController::class);
        Route::resource('category', CategoryController::class);
        Route::resource('cashflow', AdminCashflowController::class);
        //filter
        Route::post('cashflow/filter', [AdminCashflowController::class, 'filter'])->name('cashflow.filter');
        //cetak
        Route::get('cashflow/print/{month}/{year}', [AdminCashflowController::class, 'print'])->name('cashflow.print');
        //download
        Route::get('cashflow/download/{month}/{year}', [AdminCashflowController::class, 'download'])->name('cashflow.download');

        Route::resource('position', PositionController::class);
    });

});
Route::middleware('checkRole:pengurus')->group(function () {
    //masukkan ke dalam group route prefix admin
    Route::get('/pengurus/dashboard', [PengurusDashboardController::class, 'index'])->name('pengurus.dashboard');
    //masukkan ke dalam group route prefix admin
    Route::prefix('pengurus')->name('pengurus.')->group(function () {
        Route::resource('payment', PengurusPaymentController::class);
        Route::post('payment/filter', [PengurusPaymentController::class, 'filter'])->name('payment.filter');
        //cetak
        Route::get('payment/print/{bulan}/{tahun}/{category_id}', [PengurusPaymentController::class, 'print'])->name('payment.print');
        //invoice pay
        Route::get('payment/pay/{bulan}/{tahun}/{category_id}/{residence_id}', [PengurusPaymentController::class, 'pay'])->name('payment.pay');
        Route::post('payment/pay/{bulan}/{tahun}/{category_id}/{residence_id}', [PengurusPaymentController::class, 'storePay'])->name('payment.storePay');
        //show payment
        Route::get('payment/payment/{id}', [PengurusPaymentController::class, 'showPayment'])->name('payment.showPayment');
        //download
        Route::get('payment/download/{bulan}/{tahun}/{category_id}', [PengurusPaymentController::class, 'download'])->name('payment.download');
        Route::resource('residence', PengurusResidenceController::class);
        Route::resource('category', PengurusCategoryController::class);
        Route::resource('cashflow', CashflowController::class);
        //filter
        Route::post('cashflow/filter', [CashflowController::class, 'filter'])->name('cashflow.filter');
        //cetak
        Route::get('cashflow/print/{month}/{year}', [CashflowController::class, 'print'])->name('cashflow.print');
        //download
        Route::get('cashflow/download/{month}/{year}', [CashflowController::class, 'download'])->name('cashflow.download');
    });
});


Route::get('/buat', function () {
    $data = [
        [
            'name' => 'admin',
            'email' => 'admin@gkp.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ],
        // [
        //     'name' => 'pengurus',
        //     'email' => 'pengurus@gmail.com',
        //     'password' => Hash::make('password'),
        //     'role' => 'pengurus',
        // ]
    ];
    //insert bulk menggunakan eloquent
    \App\Models\User::insert($data);
    return 'berhasil';

})->name('buat');

require __DIR__ . '/auth.php';
