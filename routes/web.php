<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProposalController;

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

Route::get('/', [UserController::class, "showHomepage"]);
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');

Route::post('/register', [UserController::class, "register"]);
Route::post('/login', [UserController::class, "login"]);
Route::post('/logout', [UserController::class, "logout"]);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/* Step 1 */
Route::get('/proposals/step1', [ProposalController::class, 'showStep1'])->name('proposals.step1');
Route::post('/proposals/step1', [ProposalController::class, 'storeStep1'])->name('proposals.storeStep1');

/* Step 2 */
Route::get('/proposals/step2', [ProposalController::class, 'showStep2'])->name('proposals.step2');
Route::post('/proposals/step2', [ProposalController::class, 'storeStep2'])->name('proposals.storeStep2');

/* Step 3 */
Route::get('/proposals/step3', [ProposalController::class, 'showStep3'])->name('proposals.step3');
Route::post('/proposals/step3', [ProposalController::class, 'storeStep3'])->name('proposals.storeStep3');

/* Step 4 */
Route::get('/proposals/step4', [ProposalController::class, 'showStep4'])->name('proposals.step4');
Route::post('/proposals/step4', [ProposalController::class, 'storeStep4'])->name('proposals.storeStep4');

/* Filter Products Route */
Route::get('/filter-products', [ProposalController::class, 'filterProducts'])->name('proposals.filterProducts');

/* Search Products */
Route::get('/search-products', [ProposalController::class, 'searchProducts'])->name('proposals.searchProducts');

/* Step 5 */
Route::get('/proposals/step5', [ProposalController::class, 'showStep5'])->name('proposals.step5');
Route::post('/proposals/step5', [ProposalController::class, 'storeStep5'])->name('proposals.storeStep5');




require __DIR__.'/auth.php';
