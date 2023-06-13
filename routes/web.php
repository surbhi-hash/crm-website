<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ReportingController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CustominvoiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    #return view('dashboard');
    return redirect('/dashboard');
});



Route::get('/', [UserController::class, 'index'])->name('home')->middleware(['auth:sanctum', 'verified']);

#Route::get('/{id}', [UserController::class, 'index'])->name('home')->middleware(['auth:sanctum', 'verified']);

Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard')->middleware(['auth:sanctum', 'verified']);
Route::get('/users', [UserController::class, 'create'])->name('users')->middleware(['auth:sanctum', 'verified']);
Route::get('/users-add', [UserController::class, 'useradd'])->name('users-add')->middleware(['auth:sanctum', 'verified']);
Route::post('/users-store', [UserController::class, 'store'])->name('users-store')->middleware(['auth:sanctum', 'verified']);
Route::post('/update-notes', [UserController::class, 'notes'])->name('update-notes')->middleware(['auth:sanctum', 'verified']);

#Customer Management
Route::get('/customers-list', [UserController::class, 'customers'])->name('customers')->middleware(['auth:sanctum', 'verified']);
Route::get('/customers-list/{id}', [UserController::class, 'customersService'])->name('customersService')->middleware(['auth:sanctum', 'verified']);

Route::get('/interaction-list', [UserController::class, 'interaction'])->name('interaction')->middleware(['auth:sanctum', 'verified']);
Route::get('/leads', [UserController::class, 'leads'])->name('leads')->middleware(['auth:sanctum', 'verified']);
Route::get('/email', [UserController::class, 'email'])->name('email')->middleware(['auth:sanctum', 'verified']);
Route::post('/sendemail', [UserController::class, 'sendemail'])->name('sendemail')->middleware(['auth:sanctum', 'verified']);


Route::get('/upcoming-invoice', [UserController::class, 'upcomingInvoice'])->name('upcomingInvoice')->middleware(['auth:sanctum', 'verified']);
Route::get('/invoice/{id}', [UserController::class, 'invoiceshow'])->name('invoiceshow')->middleware(['auth:sanctum', 'verified']);
Route::get('/extra-services/{id}', [UserController::class, 'extraDelete'])->name('extra-service-delete')->middleware(['auth:sanctum', 'verified']);
Route::post('/invoice-store', [UserController::class, 'invoicestore'])->name('invoice-store')->middleware(['auth:sanctum', 'verified']);
Route::post('/invoice-generate', [UserController::class, 'generatePDF'])->name('invoice-generate')->middleware(['auth:sanctum', 'verified']);
Route::post('/create-invoice', [UserController::class, 'createInvoice'])->name('createInvoice')->middleware(['auth:sanctum', 'verified']);

############################################################################################################################



Route::any('/interaction/show/{id}', [InteractionController::class, 'show'])->name('interaction.show')->middleware(['auth:sanctum', 'verified']);
Route::any('/interaction/add/{id}', [InteractionController::class, 'add'])->name('interaction.add')->middleware(['auth:sanctum', 'verified']);
Route::any('/interaction/view/{id}', [InteractionController::class, 'view'])->name('interaction.view')->middleware(['auth:sanctum', 'verified']);



Route::any('/leads-list', [InteractionController::class, 'list'])->name('leads.list')->middleware(['auth:sanctum', 'verified']);

Route::any('/invoice-list', [InteractionController::class, 'invoice'])->name('invoice.list')->middleware(['auth:sanctum', 'verified']);

Route::any('/billing-list', [BillingController::class, 'billing'])->name('billing.list')->middleware(['auth:sanctum', 'verified']);

Route::any('/report/list', [ReportingController::class, 'index'])->name('report.list')->middleware(['auth:sanctum', 'verified']);
Route::any('/service/add', [InvoiceController::class, 'index'])->name('service.add')->middleware(['auth:sanctum', 'verified']);



Route::get('generate-pdf', [UserController::class, 'generatePDF'])->middleware(['auth:sanctum', 'verified']);

#Custom Invoice

Route::any('/custom/invoice/list', [CustominvoiceController::class, 'customInvoiceList'])->name('custom.invoice')->middleware(['auth:sanctum', 'verified']);
Route::any('/custom/invoice/add', [CustominvoiceController::class, 'customInvoiceadd'])->name('custom.invoice.add')->middleware(['auth:sanctum', 'verified']);
Route::any('/custom/invoice/post', [CustominvoiceController::class, 'custom_customer_store'])->name('custom.invoice.store')->middleware(['auth:sanctum', 'verified']);
Route::get('/custominvoice/{id}', [CustominvoiceController::class, 'custominvoiceshow'])->name('custominvoiceshow')->middleware(['auth:sanctum', 'verified']);
Route::post('/custominvoice-generate', [CustominvoiceController::class, 'generatecustomPDF'])->name('custominvoice-generate')->middleware(['auth:sanctum', 'verified']);

