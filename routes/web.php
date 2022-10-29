<?php

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('index');

    Route::group(['prefix' => 'register'], function (){
        Route::get('/', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])->name('register');
        Route::post('/', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);
    });
    Route::group(['prefix' => 'login'], function (){
        Route::get('/', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('/', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
    });
    Route::group(['as' => 'password.'], function (){
        Route::get('forgot-password', [\App\Http\Controllers\Auth\PasswordResetLinkController::class, 'create'])->name('request');
        Route::post('forgot-password', [\App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])->name('email');
        Route::get('reset-password/{token}', [\App\Http\Controllers\Auth\NewPasswordController::class, 'create'])->name('reset');
        Route::post('reset-password', [\App\Http\Controllers\Auth\NewPasswordController::class, 'store'])->name('update');
    });
});

Route::middleware(['auth'])->group(function (){
    Route::middleware(['verified'])->group(function (){
        Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function (){
            Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('index');
        });


        Route::resource('data', \App\Http\Controllers\DataController::class)->only(['index']);
        Route::group(['prefix' => 'data', 'as' => 'data.'], function (){
            Route::resource('farmer', \App\Http\Controllers\DataFarmerController::class)->only(['index', 'store', 'update', 'destroy']);
            Route::resource('car', \App\Http\Controllers\DataCarController::class)->only(['index', 'store', 'update', 'destroy']);
            Route::resource('driver', \App\Http\Controllers\DataDriverController::class)->only(['index', 'store', 'update', 'destroy']);
            Route::resource('loader', \App\Http\Controllers\DataLoaderController::class)->only(['index', 'store', 'update', 'destroy']);
            Route::resource('supervisor', \App\Http\Controllers\DataSupervisorController::class)->only(['index', 'store', 'update', 'destroy']);
        });

        Route::resource('transaction', \App\Http\Controllers\TransactionController::class)->only(['index']);
        Route::group(['prefix' => 'transaction', 'as' => 'transaction.'], function (){
            Route::resource('loan', \App\Http\Controllers\TransactionLoanController::class)->only(['index']);
            Route::group(['prefix' => 'loan', 'as' => 'loan.'], function (){
                Route::resource('farmer', \App\Http\Controllers\TransactionLoanFarmerController::class)->only(['index', 'store', 'show', 'edit', 'update']);
                Route::resource('driver', \App\Http\Controllers\TransactionLoanDriverController::class)->only(['index', 'store', 'show', 'edit', 'update']);
                Route::resource('loader', \App\Http\Controllers\TransactionLoanLoaderController::class)->only(['index', 'store', 'show', 'edit', 'update']);
                Route::resource('supervisor', \App\Http\Controllers\TransactionLoanSupervisorController::class)->only(['index', 'store', 'show', 'edit', 'update']);
            });

            Route::resource('trade', \App\Http\Controllers\TransactionTradeController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);

            Route::resource('invoice', \App\Http\Controllers\InvoiceController::class)->only(['index']);
            Route::group(['prefix' => 'invoice', 'as' => 'invoice.'], function (){
                Route::resource('farmer', \App\Http\Controllers\InvoiceFarmerController::class)->only(['index','store', 'show', 'edit', 'update']);
            });
        });

        Route::resource('config', \App\Http\Controllers\ConfigController::class)->only(['index']);
        Route::group(['prefix' => 'config', 'as' => 'config.'], function (){
            Route::resource('price', \App\Http\Controllers\ConfigPriceController::class)->only(['index', 'store']);
        });

        Route::resource('report', \App\Http\Controllers\ReportController::class)->only(['index']);
        Route::group(['prefix' => 'report', 'as' => 'report.'], function (){
            Route::group(['prefix' => 'invoice', 'as' => 'invoice.'], function () {
                Route::get('/', [\App\Http\Controllers\ReportInvoiceController::class, 'index'])->name('index');
                Route::resource('farmer', \App\Http\Controllers\ReportInvoiceFarmerController::class)->only(['index']);
            });
        });

        Route::resource('print', \App\Http\Controllers\PrintController::class)->only(['index']);
        Route::group(['prefix' => 'print', 'as' => 'print.'], function (){
            Route::resource('invoice', \App\Http\Controllers\PrintInvoiceController::class)->only(['index']);
            Route::group(['prefix' => 'invoice', 'as' => 'invoice.'], function (){
                Route::resource('farmer', \App\Http\Controllers\PrintInvoiceFarmerController::class)->only(['show']);
            });
            Route::group(['prefix' => 'report', 'as' => 'report.'], function (){

            });
        });

    });

    // Authenticate Route
    Route::group(['as' => 'verification.'], function (){
        Route::get('verify-email/', [\App\Http\Controllers\Auth\EmailVerificationPromptController::class, '__invoke'])->name('notice');
        Route::get('verify-email/{id}/{hash}', [\App\Http\Controllers\Auth\VerifyEmailController::class, '__invoke'])->middleware(['signed', 'throttle:6,1'])->name('verify');
        Route::post('email/verification-notification', [\App\Http\Controllers\Auth\EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('send');
    });

    Route::group(['prefix' => 'confirm-password'], function (){
        Route::get('/', [\App\Http\Controllers\Auth\ConfirmablePasswordController::class, 'show'])->name('password.confirm');
        Route::post('/', [\App\Http\Controllers\Auth\ConfirmablePasswordController::class, 'store']);
    });

    Route::post('logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
