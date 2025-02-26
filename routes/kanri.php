<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Kanri\DashboardController;
use App\Http\Controllers\Kanri\JunbanController;
use App\Http\Controllers\Kanri\YoyakuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Kanri\SiteSettingController;
use App\Http\Controllers\Kanri\LineController;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

Route::get('junban-uketsuke', [JunbanController::class, 'index'])->name('junban');
Route::get('junban-uketsuke-add', [JunbanController::class, 'index'])->name('junban-add');
Route::get('junban-uketsuke-status', [JunbanController::class, 'index'])->name('junban-status');

Route::get('qr-generate', function () {
    $code = md5(date('Y-m-d'));
    $url = 'https://liff.line.me/'.config('services.line.message.liffId_waiting').'/add?id='.$code;

    QrCode::size(300)->generate($url, public_path('qr/qrcode.svg'));
    $redirectUrl = 'https://waiting.aoi-ah9912.com/junban-ichiran/?id='.$code;
    // $redirectUrl = 'http://localhost:5173/junban-ichiran/?id='.$code;
    return redirect($redirectUrl);
})->name('junban-ichiran');


Route::get('/yoyaku', [DashboardController::class, 'yoyaku'])->name('yoyaku.dashboard');

Route::get('user', [RegisterController::class, 'index'])->name('user');
Route::get('user/create', [RegisterController::class, 'showRegistrationForm'])->name('user.create');
Route::post('user/store', [RegisterController::class, 'store'])->name('user.store');

Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
Route::put('password', [PasswordController::class, 'update'])->name('password.update');

Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

/*------
YoyakuController 
----*/
Route::get('yoyakuuser-by-yoyakubi/{yoyakubi}', [YoyakuController::class, 'index'])->name('yoyakuuser');
Route::get('yoyakuuser/change/{yoyakujikan}/{is_active}', [YoyakuController::class, 'yoyakujikan_change'])->name('yoyakujikan.change.status');
Route::get('yoyakuuser/bulk-change/{yoyakubi}/{is_active}', [YoyakuController::class, 'yoyakubi_change'])->name('yoyakubi.change.status');
Route::get('yoyakuuser/detail/{yoyakuuser}', [YoyakuController::class, 'detail'])->name('yoyakuuser.detail');
Route::get('yoyakuuser/edit/{yoyakuuser}', [YoyakuController::class, 'edit'])->name('yoyakuuser.edit');
Route::put('yoyakuuser/update/{yoyakuuser}', [YoyakuController::class, 'update'])->name('yoyakuuser.update');
Route::get('yoyakuuser/delete/{yoyakuuser}', [YoyakuController::class, 'delete'])->name('yoyakuuser.delete');
Route::delete('yoyakuuser/destroy/{yoyakuuser}', [YoyakuController::class, 'destroy'])->name('yoyakuuser.destroy');
Route::get('yoyakuuser/60days', [YoyakuController::class, 'sixty_days'])->name('60days');
Route::get('yoyakuuser/add/{yoyakubi}', [YoyakuController::class, 'add'])->name('yoyakuuser.add');
Route::post('yoyakuuser/confirm/{yoyakubi}', [YoyakuController::class, 'confirm'])->name('yoyakuuser.confirm');
Route::post('yoyakuuser/store/{yoyakubi}', [YoyakuController::class, 'store'])->name('yoyakuuser.store');


/*
* Site Setting Controller
**/
Route::get('site-setting', [SiteSettingController::class, 'index'])->name('site-setting');
Route::patch('site-setting/update', [SiteSettingController::class, 'update'])->name('site-setting.update');

Route::get('site-setting/yoyaku', [SiteSettingController::class, 'yoyaku'])->name('yoyaku-setting');


/**
 * copying server data 
 */
Route::get('/create_yoyakubi', [DashboardController::class, 'create_yoyakubi']);
Route::get('/create_yoyakujikan', [DashboardController::class, 'create_yoyakujikan']);
Route::get('/copy_data', [DashboardController::class, 'copy_data']);


Route::get('line-friends', [LineController::class, 'index'])->name('line-index');
