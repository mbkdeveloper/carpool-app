<?php
use App\Http\Controllers\Api\TrajetController;
use App\Http\Controllers\Api\UtilisateurController;
use App\Http\Controllers\Api\ConducteurController;
use App\Http\Controllers\Api\PassagerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public Routes
Route::get('/accueil', function () {
    return response()->json([
        'message' => 'Bienvenue sur l\'API Laravel!'
    ]);
});

Route::post('/login', [UtilisateurController::class, 'login'])->name('login');

Route::post('/register', [UtilisateurController::class, 'register']);

// Protected Routes (Requires Authentication)
Route::middleware('auth:sanctum')->group(function () {

    // Profile Routes
    Route::get('/profile', [UtilisateurController::class, 'showProfile']);
    Route::put('/profile', [UtilisateurController::class, 'updateProfile']);
    Route::delete('/profile', [UtilisateurController::class, 'deleteAccount']);

    // Trajet Routes
    Route::post('/trajets', [TrajetController::class, 'create']);
    Route::put('/trajets/{id}', [TrajetController::class, 'update']);
    Route::delete('/trajets/{id}', [TrajetController::class, 'delete']);
    Route::get('/trajets', [TrajetController::class, 'show']);

    // Conducteur Routes
    Route::post('/proposer-trajet', [ConducteurController::class, 'proposeTrajet']);
    Route::put('/modifier-trajet/{id}', [ConducteurController::class, 'modifyTrajet']);
    Route::delete('/annuler-trajet/{id}', [ConducteurController::class, 'cancelTrajet']);
    Route::get('/trajets-conducteur', [ConducteurController::class, 'showTrajets']);

    // Passager Routes
    Route::get('/rechercher-trajets', [PassagerController::class, 'searchTrajets']);
    Route::post('/reserver-trajet/{id}', [PassagerController::class, 'reserveTrajet']);
    Route::delete('/annuler-reservation/{id}', [PassagerController::class, 'cancelReservation']);
    Route::get('/reservations-passager', [PassagerController::class, 'showReservations']);
});
