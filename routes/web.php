<?php

use App\Models\Pub;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

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
    $pubs = Pub::all();
    return view('welcome', compact("pubs"));
})->name("welcome");

Route::get('/shipping', function () {

    return view('ship');
})->name("shipping");


Route::get("/suivi", function (Request $request) {
    $ref = $request->get('ref');
    $shipment = Shipment::where('ref', $ref)->first();



    return view('suivi', compact("shipment"));
})->name("suivi");

Route::get('/dashboard', function () {
    // dd(getLineTransportMode(1));
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
