<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriptionController;


Route::get('/', [SubscriptionController::class, 'showForm'])->name('subscription.form');
Route::post('subscription', [SubscriptionController::class, 'subscribe'])->name('subscription.subscribe');
Route::get('subscription/verify', [SubscriptionController::class, 'verify'])->name('subscription.verify');