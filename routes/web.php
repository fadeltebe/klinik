<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\LoginForm;
use App\Livewire\Auth\RegisterForm;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route(Auth::user()->role . '.dashboard');
    }
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
    Route::get('/dashboard', \App\Livewire\Patient\Dashboard::class)->name('dashboard');
    Route::get('/profiles', \App\Livewire\Patient\ProfilePicker::class)->name('profiles.index');
    Route::get('/profiles/create', \App\Livewire\Patient\ProfileForm::class)->name('profiles.create');
    Route::get('/profiles/{profile}/edit', \App\Livewire\Patient\ProfileForm::class)->name('profiles.edit');
    Route::get('/book-appointment', \App\Livewire\Patient\BookAppointment::class)->name('book-appointment');
});

// Super Admin Routes
Route::middleware(['auth', 'role:super_admin'])->prefix('super-admin')->name('super_admin.')->group(function () {
    Route::get('/dashboard', \App\Livewire\SuperAdmin\Dashboard::class)->name('dashboard');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
    Route::get('/queue', \App\Livewire\Admin\QueueManager::class)->name('queue.index');
});

// Doctor Routes
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', \App\Livewire\Doctor\Dashboard::class)->name('dashboard');
});

// Apotek Routes
Route::middleware(['auth', 'role:apotek'])->prefix('apotek')->name('apotek.')->group(function () {
    Route::get('/dashboard', \App\Livewire\Apotek\Dashboard::class)->name('dashboard');
});
