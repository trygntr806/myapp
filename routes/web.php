<?php

/**
 * Author: Tri Wicaksono
 * Website: https://triwicaksono.com
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

// Redirect the root URL to the contacts index page
Route::get('/', function () {
    return redirect()->route('contacts.index');
});

// Define a resource route for the ContactController
// This automatically sets up standard routes for index, create, store, show, edit, update, and destroy actions
Route::resource('contacts', ContactController::class);