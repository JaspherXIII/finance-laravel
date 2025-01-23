<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DeductionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DeliveryreceiptController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DiscrepancyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PicklistController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReceivestockController;
use App\Http\Controllers\ReturnlistController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TimesheetController;

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

    Route::resource('departments', DepartmentController::class);
    Route::get('/getDepartments', [DepartmentController::class, 'getDepartments'])->name('departments.getDepartments');

    Route::resource('jobs', JobController::class);
    Route::get('/getJobs', [JobController::class, 'getJobs'])->name('jobs.getJobs');

    Route::resource('employees', EmployeeController::class);
    Route::get('/getEmployees', [EmployeeController::class, 'getEmployees'])->name('employees.getEmployees');
    Route::get('archived-employees', [EmployeeController::class, 'achived'])->name('employees.achived');
    Route::get('/getArchivedEmployees', [EmployeeController::class, 'getArchivedEmployees'])->name('employees.getArchivedEmployees');

    Route::resource('certificates', CertificateController::class);
    Route::get('/getCertificates', [CertificateController::class, 'getCertificates'])->name('certificates.getCertificates');
    Route::post('/certificates/approve/{id}', [CertificateController::class, 'approve'])->name('certificates.approve');
    Route::post('/certificates/reject/{id}', [CertificateController::class, 'reject'])->name('certificates.reject');

    Route::resource('time-tracking', TimesheetController::class);
    Route::get('/getTimesheets', [TimesheetController::class, 'getTimesheets'])->name('time-tracking.getTimesheets');

    Route::resource('time-discrepancy', DiscrepancyController::class);
    Route::get('/getDiscrepancies', [DiscrepancyController::class, 'getDiscrepancies'])->name('time-discrepancy.getDiscrepancies');
    Route::post('/time-discrepancy/approve/{id}', [DiscrepancyController::class, 'approve'])->name('time-discrepancy.approve');
    Route::post('/time-discrepancy/reject/{id}', [DiscrepancyController::class, 'reject'])->name('time-discrepancy.reject');

    Route::resource('leaves', LeaveController::class);
    Route::get('/getLeaves', [LeaveController::class, 'getLeaves'])->name('leaves.getLeaves');
    Route::post('/leaves/approve/{id}', [LeaveController::class, 'approve'])->name('leaves.approve');
    Route::post('/leaves/reject/{id}', [LeaveController::class, 'reject'])->name('leaves.reject');

    Route::resource('deductions', DeductionController::class);
    Route::get('/getDeductions', [DeductionController::class, 'getDeductions'])->name('deductions.getDeductions');

    Route::resource('payrolls', PayrollController::class);
    Route::get('/getPayrolls', [PayrollController::class, 'getPayrolls'])->name('payrolls.getPayrolls');
});


Route::group(['prefix' => 'user', 'middleware' => ['auth', 'isUser', 'PreventBack']], function () {
    Route::get('my-profile', [UserController::class, 'index'])->name('user.dashboard');
    Route::post('update-profile-info', [UserController::class, 'updateInfo'])->name('userUpdateInfo');
    Route::post('change-profile-picture', [UserController::class, 'updatePicture'])->name('userPictureUpdate');
    Route::post('change-password', [UserController::class, 'changePassword'])->name('userChangePassword');

    Route::resource('certificates', CertificateController::class, [
        'names' => [
            'index' => 'user.certificates',
        ],
    ]);


    Route::get('/getUserCertificates', [CertificateController::class, 'getUserCertificates'])->name('user.getUserCertificates');

    Route::resource('time-sheet', TimesheetController::class, [
        'names' => [
            'index' => 'user.time-sheet',
        ],
    ]);
    Route::get('/getUserTimesheets', [TimesheetController::class, 'getUserTimesheets'])->name('user.getUserTimesheets');

    Route::resource('time-discrepancy', DiscrepancyController::class, [
        'names' => [
            'index' => 'user.time-discrepancy',
        ],
    ]);
    Route::get('/getUserDiscrepancies', [DiscrepancyController::class, 'getUserDiscrepancies'])->name('user.getUserDiscrepancies');

    Route::resource('leaves', LeaveController::class, [
        'names' => [
            'index' => 'user.leaves',
        ],
    ]);
    Route::get('/getUserLeaves', [LeaveController::class, 'getUserLeaves'])->name('user.getUserLeaves');

    Route::get('payslip', [PayrollController::class, 'payslip'])->name('user.payslip');

    Route::resource('empPayroll', PayrollController::class);
    Route::get('/getUserEmpPayroll', [PayrollController::class, 'getUserEmpPayroll'])->name('user.getUserEmpPayroll');
    Route::get('view-payslip', [PayrollController::class, 'viewPayslip'])->name('user.viewPayslip');


});
