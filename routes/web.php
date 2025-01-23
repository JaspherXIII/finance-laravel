<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;

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

Route::get('/', function () {
    return view('auth.login');
});
Route::middleware(['middleware' => 'PreventBack'])->group(function () {
    Auth::routes();
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'isAdmin', 'PreventBack']], function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::get('settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('update-profile-info', [UserController::class, 'updateInfo'])->name('adminUpdateInfo');
    Route::post('change-profile-picture', [UserController::class, 'updatePicture'])->name('adminPictureUpdate');
    Route::post('change-password', [UserController::class, 'changePassword'])->name('adminChangePassword');

    Route::resource('reports', ReportController::class);
    Route::get('/financial-reports', [ReportController::class, 'financial'])->name('reports.financial');
    Route::get('/revenue-reports', [ReportController::class, 'revenue'])->name('reports.revenue');
    Route::get('/getFinancialReports', [ReportController::class, 'getFinancialReports'])->name('reports.getFinancialReports');
    Route::get('/getRevenueReports', [ReportController::class, 'getRevenueReports'])->name('reports.getRevenueReports');

    Route::resource('budget-planning', BudgetController::class);
    Route::get('/getBudgets', [BudgetController::class, 'getBudgets'])->name('budgets.getBudgets');

    Route::get('payrolls', [PayrollController::class, 'index'])->name('payrolls.index');

    Route::resource('accounts', UserController::class);
    Route::get('/getUsers', [UserController::class, 'getUsers'])->name('users.getUsers');

});


Route::group(['prefix' => 'user', 'middleware' => ['auth', 'isUser', 'PreventBack']], function () {
    Route::get('my-profile', [UserController::class, 'index'])->name('user.dashboard');
    Route::post('update-profile-info', [UserController::class, 'updateInfo'])->name('userUpdateInfo');
    Route::post('change-profile-picture', [UserController::class, 'updatePicture'])->name('userPictureUpdate');
    Route::post('change-password', [UserController::class, 'changePassword'])->name('userChangePassword');



});
