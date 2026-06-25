<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\LoginForm;
use App\Livewire\Auth\RegisterForm;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', LoginForm::class)->name('login');
    Route::get('/register', RegisterForm::class)->name('register');
});

Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// Patient Routes
Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', function () { return "Patient Dashboard"; })->name('dashboard');
    Route::get('/profiles/create', function () { return "Create Profile"; })->name('profiles.create');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () { return "Admin Dashboard"; })->name('dashboard');
});

// Doctor Routes
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', function () { return "Doctor Dashboard"; })->name('dashboard');
});
