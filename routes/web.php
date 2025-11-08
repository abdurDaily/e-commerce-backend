<?php

use App\Http\Controllers\Backend\MyProfile\MyProfileController;
use App\Http\Controllers\Backend\RolePermission\RolePermissionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



//* BACKEND ROUTES 
Route::prefix('dashboard/')->name('dashboard.')->middleware(['auth', 'verified'])->group(function(){


    //* MY PROFILE ROUTES 
    Route::get('my-profile', [MyProfileController::class,'view'])->name('my.profile.view');
    Route::post('my-profile-info', [MyProfileController::class,'updateInfo'])->name('my.profile.update.info');
    Route::post('my-profile', [MyProfileController::class,'updatePassword'])->name('my.profile.update.password');
    Route::post('my-profile-image', [MyProfileController::class,'updateProfileImage'])->name('my.profile.update.profile.image');


    //* ROLE & PERMISSION ROUTES
    Route::prefix('role-permission/')->name('role.permission.')->group(function(){
        Route::get('create-role', [RolePermissionController::class,'createRole'])->name('create.role');
        Route::post('create-role', [RolePermissionController::class,'storeRole'])->name('store.role');
        Route::delete('delete-role/{id}', [RolePermissionController::class,'deleteRole'])->name('delete.role');
    });

});



//* FRONTEND ROUTES 

require __DIR__.'/auth.php';
