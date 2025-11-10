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
Route::prefix('dashboard/')->name('dashboard.')->middleware(['auth', 'verified'])->group(function () {



    //* MY PROFILE ROUTES 
    Route::get('my-profile', [MyProfileController::class, 'view'])->name('my.profile.view');
    Route::post('my-profile-info', [MyProfileController::class, 'profileInfo'])->name('my.profile.info');
    Route::post('my-profile-password', [MyProfileController::class, 'profilePassword'])->name('my.profile.password');
    Route::post('my-profile-image', [MyProfileController::class, 'profileImage'])->name('my.profile.image');


    //* ROLE & PERMISSION ROUTES
    Route::prefix('role-permission/')->name('role.permission.')->group(function () {
        //* USER CREATE 
        Route::get('create-user', [RolePermissionController::class, 'createUser'])->name('create.user');
        Route::post('create-user', [RolePermissionController::class, 'storeUser'])->name('store.user');

        Route::get('create-role', [RolePermissionController::class, 'createRole'])->name('create.role');
        Route::post('create-role', [RolePermissionController::class, 'storeRole'])->name('store.role');
        Route::delete('delete-role/{id}', [RolePermissionController::class, 'deleteRole'])->name('delete.role');
        Route::get('edit-role/{id}', [RolePermissionController::class, 'editRole'])->name('edit.role');
        Route::put('update-role/{id}', [RolePermissionController::class, 'updateRole'])->name('update.role');
    });
});



//* FRONTEND ROUTES 

require __DIR__ . '/auth.php';
