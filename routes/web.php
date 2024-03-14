<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LinkGenerationController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StoredProposalController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/proposals/step1', function () {
        return Auth::check() ? view('proposals.step1') : redirect()->route('login');
    })->name('proposals.step1');
    
});

/************************************************************************************************************************************/

/* Proposals Area */

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

/* Step 5 */
Route::get('/proposals/step5', [ProposalController::class, 'showStep5'])->name('proposals.step5');
Route::post('/proposals/step5', [ProposalController::class, 'storeStep5'])->name('proposals.storeStep5');

/* Step 6 */
Route::get('/proposals/step6', [ProposalController::class, 'showStep6'])->name('proposals.step6');
Route::post('/proposals/step6', [ProposalController::class, 'storeStep6'])->name('proposals.storeStep6');

/* Step 6 */
Route::get('/proposals/step7', [ProposalController::class, 'showStep7'])->name('proposals.step7');

/* Filter Products Route */
Route::get('/filter-products', [ProposalController::class, 'filterProducts'])->name('proposals.filterProducts');

/* Search Products In Proposal */
Route::get('/search-products', [ProposalController::class, 'searchProducts'])->name('proposals.searchProducts');

/* Edit Products */
Route::put('/update-product/{productId}', [ProposalController::class, 'updateProduct'])->name('proposals.updateProduct');


Route::get('/proposals/success', function () {
    return view('proposals.success');
})->name('proposals.success');


/************************************************************************************************************************************/

/* Services Page (Products) */

/* Services Index Page (This section is controlled by ServiceController.php */
Route::get('/services', [ServiceController::class, 'servicesIndex'])->name('servicesIndex');

/* Edit Products Route */
Route::get('/services/{product}/edit', [ServiceController::class, 'editProduct'])->name('services.edit');

/* Update Products Route */
Route::put('/services/{product}', [ServiceController::class, 'updateProduct'])->name('services.updateProduct');


// Route for showing the create product form
Route::get('/services/create', [ServiceController::class, 'createProduct'])->name('services.createProduct');
Route::post('/services/create', [ServiceController::class, 'storeProduct'])->name('services.storeProduct');

/* Search Products in Services Page */
Route::get('/search-services', [ServiceController::class, 'searchProducts'])->name('services.searchProducts');

/* Delete Product */
Route::delete('/services/{product}', [ServiceController::class, 'destroyProduct'])->name('services.destroyProduct');

/* Filter Products Route for Services */
Route::get('/filter-service-products', [ServiceController::class, 'filterProducts'])->name('services.filterProducts');

/**************************************************************************************************************************************/

/* CATEGORY AREA */

/* Categories Index Page (This section is controlled by CategoryController.php */
Route::get('/categories/index-category', [CategoryController::class, 'indexCategory'])->name('index-category');


/* CREATE CATEGORY AREA */
Route::get('/categories/create-category', [CategoryController::class, 'createCategory'])->name('categories.createCategory');
Route::post('/categories/create-category', [CategoryController::class, 'storeCategory'])->name('categories.storeCategory');

/* Edit Category */
Route::get('/categories/{category}/edit', [CategoryController::class, 'editCategory'])->name('categories.editCategory');

/* Update Categories Route */
Route::put('/categories/{category}', [CategoryController::class, 'updateCategory'])->name('categories.updateCategory');

/* Delete Category */
Route::delete('/categories/{category}', [CategoryController::class, 'destroyCategory'])->name('categories.destroyCategory');

/**************************************************************************************************************************************/

/* Client Area */

/* Client Index Page (This section is controlled by ClientController.php */
Route::get('/clients/index-client', [ClientController::class, 'indexClient'])->name('index-client');

/* CREATE CLIENT AREA */
Route::get('/clients/create-client', [ClientController::class, 'createClient'])->name('clients.createClient');
Route::post('/clients/create-client', [ClientController::class, 'storeClient'])->name('clients.storeClient');

/* Edit Client */
Route::get('/clients/{client}/edit', [ClientController::class, 'editClient'])->name('clients.editClient');

/* Update Clients Route */
Route::put('/clients/{client}', [ClientController::class, 'updateClient'])->name('clients.updateClient');

/* Delete Client */
Route::delete('/clients/{client}', [ClientController::class, 'destroyClient'])->name('clients.destroyClient');

/* Search Clients in Clients Page */
Route::get('/search-clients', [ClientController::class, 'searchClients'])->name('clients.searchClients');

/***************************************************************************************************************************************/


/* PDF AREA */
Route::get('/session-info-pdf', [PDFController::class, 'generatePDF'])->name('session.info.pdf');


/***************************************************************************************************************************************/

/* Link Generation Area */

// Route to generate the link
Route::get('/generate-link', [LinkGenerationController::class, 'generateLink'])->name('link.generate');

// Route for feedback
Route::post('/link-feedback', [LinkGenerationController::class, 'linkFeedback'])->name('link.feedback');


// Route to view the information from the link
Route::get('/view-link/{token}', [LinkGenerationController::class, 'viewLink'])->name('link.view');

/***************************************************************************************************************************************/

/* Stored Proposals Area */
Route::get('/storedProposals', [StoredProposalController::class, 'indexStoredProposals'])->name('storedProposals.storedProposalsIndex');


/* Search Proposals in Proposals Page */
Route::get('/search-proposals', [StoredProposalController::class, 'searchProposals'])->name('storedProposals.searchProposals');


/***************************************************************************************************************************************/


/* Save Draft Route */
Route::post('/proposals/save-draft', [ProposalController::class, 'saveDraft'])->name('proposals.saveDraft');

/* List Drafts Route */
Route::get('/proposals/drafts', [ProposalController::class, 'listDrafts'])->name('proposals.listDrafts');

/* Load Draft Route */
Route::get('/proposals/drafts/{draft}/summary', [ProposalController::class, 'viewDraftSummary'])->name('proposals.viewDraftSummary');







require __DIR__.'/auth.php';
