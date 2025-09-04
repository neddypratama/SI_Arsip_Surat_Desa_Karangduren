<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Livewire\Volt\Volt;
use App\Http\Controllers\ArsipController;

Volt::route('/', 'index');                          // Home 
Volt::route('/users', 'users.index');               // User (list) 
Volt::route('/users/create', 'users.create');       // User (create) 
Volt::route('/users/{user}/edit', 'users.edit');    // User (edit) 

Volt::route('/surat', 'surat.index');               // surat (list) 
Volt::route('/surat/create', 'surat.create');       // surat (create) 
Volt::route('/surat/{arsip}/edit', 'surat.edit');    // User (edit) 
Volt::route('/surat/{arsip}', 'surat.show');


Route::get('/arsip/{arsip}/print', [ArsipController::class, 'print'])->name('arsip.print');


Volt::route('/kategori', 'kategori.index');               // kategori (list) 
Volt::route('/kategori/create', 'kategori.create');       // kategori (create) 
Volt::route('/kategori/{kategori}/edit', 'kategori.edit');    // kategori (edit) 


