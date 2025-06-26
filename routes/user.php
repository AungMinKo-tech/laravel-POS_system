<?php

use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'user' , 'middleware' => 'userMiddleware'], function () {

    Route::get('home', [UserController::class, 'userHome'])->name('user#Home');
    Route::get('product/details/{id}',[UserController::class, 'productDetails'])->name('user#productDetails');

    Route::post('comment',[UserController::class, 'comment'])->name('user#comment');
    Route::get('comment/delete/{id}',[UserController::class, 'commentDelete'])->name('user#commentDelete');

    Route::post('rating',[UserController::class, 'rating'])->name('user#rating');

    Route::get('cart',[UserController::class, 'cart'])->name('user#cart');
    Route::post('addToCart',[UserController::class, 'addToCart'])->name('user#addToCart');
    Route::get('cartDelete',[UserController::class, 'cartDelete'])->name('user#cartDelete');

    Route::get('paymentPage',[UserController::class, 'paymentPage'])->name('user#paymentPage');

    Route::get('tempStorage',[UserController::class, 'tempStorage'])->name('user#tempStorage');

    Route::post('order',[UserController::class, 'order'])->name('user#order');

    Route::get('ordeList',[UserController::class, 'orderList'])->name('user#orderList');

    Route::get('contactPage',[UserController::class, 'contactPage'])->name('user#contactPage');
    Route::post('contact',[UserController::class, 'contact'])->name('user#contact');

    Route::group(['prefix' => 'profile'], function(){
        Route::get('edit', [ProfileController::class, 'editProfile'])->name('profile#edit');
        Route::post('update', [ProfileController::class, 'updateProfile'])->name('profile#update');
        Route::get('passwordChangePage',[ProfileController::class, 'passwordChangePage'])->name('profile#passwordChangePage');
        Route::post('passwordChange',[ProfileController::class, 'passwordChange'])->name('profile#passwordChange');

    });

});
