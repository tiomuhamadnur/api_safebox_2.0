<?php

use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/transaksi/periksa', [TransaksiController::class, 'periksa']);