<?php

use App\Http\Controllers\AccueilController;
use App\Http\Controllers\admin\BoutiquesController;
use App\Http\Controllers\admin\DomainsController;
use App\Http\Controllers\admin\MarquesController;
use App\Http\Controllers\admin\MaterielsController;
use App\Http\Controllers\admin\ModelesController;
use App\Http\Controllers\admin\SupportController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\ApercuController;
use App\Http\Controllers\boutique\CalendrierController;
use App\Http\Controllers\boutique\ClientController;
use App\Http\Controllers\boutique\ConfigurationController;
use App\Http\Controllers\boutique\DemandeController;
use App\Http\Controllers\boutique\IntegrationController;
use App\Http\Controllers\boutique\ProfileController;
use App\Http\Controllers\boutique\TiketsController;
use App\Http\Controllers\boutique\ProduitAdditionnelsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PannesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// =======================
// 1. Routes publiques
// =======================
Route::get('/', [AccueilController::class, 'index']);
Route::get('/tarif', [AccueilController::class, 'tarif']);
Route::get('/contact', [AccueilController::class, 'contact']);

// Aperçu boutique (exactement comme toi)
Route::prefix('apercu')->group(function () {
    Route::get('/{slug}', [ApercuController::class, 'showBoutique'])->name('apercu');
    Route::get('/materials/{boutique_id}', [ApercuController::class, 'GetBoutiqueMatriel']);
    Route::get('brands/{boutique_id}/{modele_id}', [ApercuController::class, 'GetBoutiqueMarque']);
    Route::get('products/{boutique_id}/{materiel_id}', [ApercuController::class, 'GetBoutiqueProducts']);
    Route::get('/models/{boutique_id}/{materiel_id}', [ApercuController::class, 'GetModelBoutique']);
    Route::get('/pannes/{boutique_id}/{modele_id}', [ApercuController::class, 'GetPannesModel']);
    Route::post('/submit/{boutiqueId}', [ApercuController::class, 'SendDataDemandes'])->where('boutiqueId', '[0-9]+')->name('apercu.submit');
    Route::post('/appointment-types', [ConfigurationController::class, 'ConfigurationSelonModeRequest']);
    Route::get('/existing', [ConfigurationController::class, 'getExistingConfiguration']);
    Route::delete('/reset', [ConfigurationController::class, 'resetConfiguration'])->name('configuration.reset');
    Route::get('/adresses/{boutique_id}', [ApercuController::class, 'GetBoutiqueAdresses'])->where('boutique_id', '[0-9]+')->name('apercu.adresses');
    Route::get('boutique/timeoff/{boutique_id}', [ApercuController::class, 'BoutiqueTimeDisponible'])->where('boutique_id', '[0-9]+')->name('apercu.BoutiqueTimeDisponible');
});

// =======================
// 2. Auth (tu l’as mis 2 fois → je remets 2 fois)
// =======================
Auth::routes();
Auth::routes(); // Oui, tu l’avais deux fois → je le remets identique

// =======================
// 3. Home (gardé exactement comme toi)
// =======================
Route::get('/home', [HomeController::class, 'index'])->middleware('auth', 'throttle:20,1')->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); // Tu l’avais deux fois → je garde

// =======================
// 4. Superadmin (100 % identique à ton code)
// =======================
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('boutiques/list', [BoutiquesController::class, 'index'])->name('boutiques.list');
    Route::get('boutiques/data', [AjaxController::class, 'getBoutiques'])->name('api.boutiques');
    Route::post('boutiques/store', [BoutiquesController::class, 'store'])->name('boutiques.store');
    Route::get('boutiques/{id}/edit', [BoutiquesController::class, 'edit'])->name('boutiques.edit');
    Route::put('boutiques/{id}', [BoutiquesController::class, 'update'])->name('boutiques.update');
    Route::delete('boutiques/{id}', [BoutiquesController::class, 'destroy'])->name('boutiques.destroy');
    Route::post('boutiques/{id}/login', [BoutiquesController::class, 'loginAsBoutique'])->name('boutiques.login');
    Route::post('boutiques/{id}/reset-config', [BoutiquesController::class, 'resetConfigBoutique'])->name('boutiques.reset-config');
    Route::post('/boutiques/{id}/toggle-status', [BoutiquesController::class, 'toggleStatus'])->name('boutiques.toggle-status');

    Route::resource('materiels', MaterielsController::class);
    Route::resource('marques', MarquesController::class);
    Route::resource('modeles', ModelesController::class);
    Route::resource('pannes', PannesController::class);
    Route::resource('tickets', SupportController::class);
    Route::resource('domains', DomainsController::class);
    Route::get('/api/getmateriels', [AjaxController::class, 'getMateriels'])->name('api.getMateriels');
    Route::get('/api/getmarques', [AjaxController::class, 'getMarques'])->name('api.getMarques');
    Route::get('/api/getmodeles', [AjaxController::class, 'getModeles'])->name('api.getModeles');
    Route::get('/api/getpannes', [AjaxController::class, 'getPannes'])->name('api.getPannes');
    Route::get('/api/getsupports', [AjaxController::class, 'getAdminTickets'])->name('api.getTickets');
    Route::get('/api/getapidomains', [AjaxController::class, 'getApiDomains'])->name('api.getDomains');
 
    Route::post('supports/message', [SupportController::class, 'storeMessage'])->name('support.message.store');
    Route::post('/support/{ticket}/close', [SupportController::class, 'close'])->name('support.close');
});

// =======================
// 5. Boutique (100 % identique)
// =======================
Route::middleware(['auth', 'role:boutique'])->prefix('boutique')->name('boutique.')->group(function () {
    Route::get('configuration', [ConfigurationController::class, 'index'])->name('configuration');
    Route::get('/demandes/data', [AjaxController::class, 'getApiDemande'])->name('demandes.data');
    Route::resource('demandes', DemandeController::class);
    Route::resource('produit-additionnels', ProduitAdditionnelsController::class);
    Route::get('/edit', [ProfileController::class, 'index'])->name('edit');
    Route::post('/update', [ProfileController::class, 'update'])->name('update');
    Route::post('/schedule/update', [ProfileController::class, 'updateSchedule'])->name('schedule.update');
    Route::post('/password/update', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::post('/send/email/demande/{id}', [DemandeController::class, 'SendAndUpdateData'])->name('sendEmailClient');
    Route::get('calendrier', [CalendrierController::class, 'index'])->name('calendrier');
    Route::get('/api/events/', [CalendrierController::class, 'getdataCalender'])->name('events.index');
    Route::get('/integration', [IntegrationController::class, 'index'])->name('integration');
    Route::get('/clients', [ClientController::class, 'index'])->name('clients');
    Route::delete('/client/destroy/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
    Route::post('/domain', [IntegrationController::class, 'storeORupdate'])->name('integration.store');
    
    Route::get('/tikets', [TiketsController::class, 'index'])->name('tikets');
    Route::get('/tikets/data', [AjaxController::class, 'getApiTickets'])->name('apigettickets');
    Route::get('/produit-addit/data', [AjaxController::class, 'getApiProduitAdditionnels'])->name('apigetproduitadditionnels');
    Route::post('/tikets/store', [TiketsController::class, 'store'])->name('tickets.store');
    Route::put('/tikets/update/{id}', [TiketsController::class, 'update'])->name('tickets.update');
    Route::get('/tikets/{id}', [TiketsController::class, 'show'])->name('tikets.show');
    Route::delete('/tikets/destroy/{id}', [TiketsController::class, 'destroy'])->name('tickets.destroy');
    Route::get('/clients/data', [AjaxController::class, 'getApiClient'])->name('getApiClient');
    Route::post('/dayoff/store', [CalendrierController::class, 'storeDayoff'])->name('dayoff.store');
    Route::post('/dayoff/check', [CalendrierController::class, 'checkDayoff'])->name('dayoff.check');
    Route::post('/dayoff/destroy', [CalendrierController::class, 'destroyDayoff'])->name('dayoff.destroy');
});

// =======================
// 6. Configuration (exactement comme toi, avec ajout de POST / pour matcher le frontend axios.post("/configuration"))
// =======================
Route::prefix('configuration')->group(function () {
    Route::get('/materials', [ConfigurationController::class, 'getMaterials']);
    Route::get('/brands/{material}', [ConfigurationController::class, 'brands']);
    Route::get('/models/{brand}', [ConfigurationController::class, 'models']);
    Route::get('/pannes/{brand}/{modele}', [ConfigurationController::class, 'getPannesEtTypes']);
    Route::post('/', [ConfigurationController::class, 'configurationSelonModeRequest']); // Ajout pour matcher axios.post("/configuration") du frontend
    Route::post('/appointment-types', [ConfigurationController::class, 'ConfigurationSelonModeRequest']);
    Route::get('/existing', [ConfigurationController::class, 'getExistingConfiguration'])->name('configuration.existing');
    Route::post('/rendez-vous/save-step1', [ConfigurationController::class, 'ConfigurationRendezVousStep1']);
    Route::delete('/reset', [ConfigurationController::class, 'resetConfiguration']);
});

// =======================
// 7. Langue (inchangé)
// =======================
Route::get('lang/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'fr'])) {
        abort(400);
    }
    session(['locale' => $locale]);
    return redirect()->back();
})->name('changeLang');