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
            Route::get('/test', [\App\Http\Controllers\HomeController::class, 'test']);
            Route::group(['prefix'=> 'trade', 'as' => 'trade.'], function (){
                Route::post('/create', [\App\Http\Controllers\DashboardController::class, 'trade_create'])->name('create');
                Route::post('/factory', [\App\Http\Controllers\DashboardController::class, 'trade_factory'])->name('factory');
                Route::post('/update', [\App\Http\Controllers\DashboardController::class, 'trade_update'])->name('update');
                Route::post('/reset', [\App\Http\Controllers\DashboardController::class, 'trade_reset'])->name('reset');

            });
        });

        Route::resource('profile', \App\Http\Controllers\Profile\ProfileController::class)->only('index', 'update');
        Route::group(['prefix' => 'profile', 'as' => 'profile.'], function (){
            Route::patch('{user}/password', [\App\Http\Controllers\Profile\ProfileController::class, 'password'])->name('password');
        });

        Route::resource('data', \App\Http\Controllers\Data\DataController::class)->only(['index']);
        Route::group(['prefix' => 'data', 'as' => 'data.'], function (){
            Route::resource('farmer', \App\Http\Controllers\Data\DataFarmerController::class)->only(['index', 'store', 'update', 'destroy']);
            Route::resource('car', \App\Http\Controllers\Data\DataCarController::class)->only(['index', 'store', 'update', 'destroy']);
            Route::resource('driver', \App\Http\Controllers\Data\DataDriverController::class)->only(['index', 'store', 'update', 'destroy']);
            Route::resource('loader', \App\Http\Controllers\Data\DataLoaderController::class)->only(['index', 'store', 'update', 'destroy']);
            Route::resource('supervisor', \App\Http\Controllers\Data\DataSupervisorController::class)->only(['index', 'store', 'update', 'destroy']);
        });

        Route::resource('transaction', \App\Http\Controllers\Transaction\TransactionController::class)->only(['index']);
        Route::group(['prefix' => 'transaction', 'as' => 'transaction.'], function (){
            Route::resource('loan', \App\Http\Controllers\Transaction\Loan\TransactionLoanController::class)->only(['index']);
            Route::group(['prefix' => 'loan', 'as' => 'loan.'], function (){
                Route::resource('farmer', \App\Http\Controllers\Transaction\Loan\TransactionLoanFarmerController::class)->only(['index', 'store', 'show', 'edit', 'update']);
                Route::resource('driver', \App\Http\Controllers\Transaction\Loan\TransactionLoanDriverController::class)->only(['index', 'store', 'show', 'edit', 'update']);
                Route::resource('loader', \App\Http\Controllers\Transaction\Loan\TransactionLoanLoaderController::class)->only(['index', 'store', 'show', 'edit', 'update']);
                Route::resource('supervisor', \App\Http\Controllers\Transaction\Loan\TransactionLoanSupervisorController::class)->only(['index', 'store', 'show', 'edit', 'update']);
            });

            Route::resource('cost', \App\Http\Controllers\Transaction\Cost\Car\TransactionCostCarController::class)->only(['index', 'store', 'show', 'edit', 'update']);
            Route::resource('trade', \App\Http\Controllers\Transaction\Trade\TransactionTradeController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
            Route::group(['prefix' => 'trade', 'as' => 'trade.'], function (){
                Route::delete('{trade}/delete', [\App\Http\Controllers\Transaction\Trade\TransactionTradeController::class, 'deleted'])->name('delete');
                Route::get('{trade}/farmer', [\App\Http\Controllers\Transaction\Trade\TransactionTradeController::class, 'trade_edit'])->name('farmer');
                Route::patch('{trade}/farmer', [\App\Http\Controllers\Transaction\Trade\TransactionTradeController::class, 'trade_update']);
            });
            Route::resource('factory', \App\Http\Controllers\Transaction\Trade\TransactionTradeFactoryController::class)->only(['index', 'show', 'update', 'destroy']);

            Route::resource('invoice', \App\Http\Controllers\Transaction\Invoice\TransactionInvoiceController::class)->only(['index']);
            Route::group(['prefix' => 'invoice', 'as' => 'invoice.'], function (){
                Route::resource('farmer', \App\Http\Controllers\Transaction\Invoice\TransactionInvoiceFarmerController::class)->only(['index','store', 'show', 'edit', 'update']);
                Route::resource('driver', \App\Http\Controllers\Transaction\Invoice\TransactionInvoiceDriverController::class)->only(['index', 'show', 'update']);
                Route::resource('car', \App\Http\Controllers\Transaction\Invoice\TransactionInvoiceCarController::class)->only(['index', 'show', 'update']);
                Route::resource('loader', \App\Http\Controllers\Transaction\Invoice\TransactionInvoiceLoaderController::class)->only(['index', 'show', 'update']);
                Route::resource('supervisor', \App\Http\Controllers\Transaction\Invoice\TransactionInvoiceSupervisorController::class)->only(['index', 'show', 'update']);

            });
        });

        Route::resource('config', \App\Http\Controllers\Config\ConfigController::class)->only(['index']);
        Route::group(['prefix' => 'config', 'as' => 'config.'], function (){
            Route::resource('price', \App\Http\Controllers\Config\ConfigPriceController::class)->only(['index', 'store']);
        });

        Route::resource('report', \App\Http\Controllers\Report\ReportController::class)->only(['index']);
        Route::group(['prefix' => 'report', 'as' => 'report.'], function (){

            Route::resource('invoice', \App\Http\Controllers\Report\Invoice\ReportInvoiceController::class)->only(['index']);
            Route::group(['prefix' => 'invoice', 'as' => 'invoice.'], function () {
                Route::resource('loan', \App\Http\Controllers\Report\Invoice\ReportInvoiceLoanController::class)->only(['index']);
            });
            Route::group(['prefix' => 'income', 'as' => 'income.'], function (){
                Route::match(['get', 'post'],'/', [\App\Http\Controllers\Report\Income\ReportIncomeController::class, 'index'])->name('index');
            });

            Route::group(['prefix' => 'expense', 'as' => 'expense.'], function (){
                Route::match(['get', 'post'],'/', [\App\Http\Controllers\Report\Expense\ReportExpenseController::class, 'index'])->name('index');
            });

            Route::group(['prefix' => 'trade', 'as' => 'trade.'], function (){
                Route::match(['get', 'post'],'/', [\App\Http\Controllers\Report\Trade\ReportTradeController::class, 'index'])->name('index');
            });
            Route::group(['prefix' => 'loan', 'as' => 'loan.'], function (){
                Route::get('/', [\App\Http\Controllers\Report\Loan\ReportLoanController::class, 'index'])->name('index');
                Route::get('details', [\App\Http\Controllers\Report\Loan\ReportLoanController::class, 'details'])->name('details');
            });
        });

        Route::resource('print', \App\Http\Controllers\Prints\PrintController::class)->only(['index']);
        Route::group(['prefix' => 'print', 'as' => 'print.'], function (){
            Route::resource('invoice', \App\Http\Controllers\Prints\Invoice\PrintInvoiceController::class)->only(['index']);
            Route::group(['prefix' => 'invoice', 'as' => 'invoice.'], function (){
                Route::resource('farmer', \App\Http\Controllers\Prints\Invoice\PrintInvoiceFarmerController::class)->only(['show']);
                Route::resource('driver', \App\Http\Controllers\Prints\Invoice\PrintInvoiceDriverController::class)->only(['show']);
                Route::resource('car', \App\Http\Controllers\Prints\Invoice\PrintInvoiceCarController::class)->only(['show']);
                Route::resource('loader', \App\Http\Controllers\Prints\Invoice\PrintInvoiceLoaderController::class)->only(['show']);
                Route::resource('supervisor', \App\Http\Controllers\Prints\Invoice\PrintInvoiceSupervisorController::class)->only(['show']);

                Route::resource('loan', \App\Http\Controllers\Prints\Invoice\Loan\PrintInvoiceLoanController::class)->only(['show']);
            });
            Route::group(['prefix' => 'expense', 'as' => 'expense.'], function () {
                Route::get('/', [\App\Http\Controllers\Prints\Expense\PrintExpenseController::class, 'index'])->name('index');
            });
            Route::group(['prefix' => 'income', 'as' => 'income.'], function () {
                Route::get('/', [\App\Http\Controllers\Prints\Income\PrintIncomeController::class, 'index'])->name('index');
            });

            Route::group(['prefix' => 'loan', 'as' => 'loan.'], function () {
                Route::get('/', [\App\Http\Controllers\Prints\Loan\PrintLoanController::class, 'index'])->name('index');
                Route::get('details', [\App\Http\Controllers\Report\Loan\ReportLoanController::class, 'details'])->name('details');
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
