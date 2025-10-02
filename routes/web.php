<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\{
    HomeController,
    MenuController,
    OptionController,
    PermissionController,
    RoleController,
    UserController,
};

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/register', function () {
    return redirect()->route('login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('apps')
    ->middleware(['auth'])
    ->group(function () {
        Route::controller(HomeController::class)->group(function () {
            Route::get('/', 'index')->name('home.index');
        });

        // MENU
        Route::controller(MenuController::class)->group(function () {
            Route::get('menus/status-change', 'statuschange')->name('menus.status-change');
            Route::delete('menus/deletes', 'deletes')->name('menus.deletes');
        });
        Route::resource('menus', MenuController::class);

        // USER
        Route::controller(UserController::class)->group(function () {
            Route::delete('users/deletes', 'deletes')->name('users.deletes');
        });
        Route::resource('users', UserController::class);

        // ROLE
        Route::resource('roles', RoleController::class);

        // PERMISSION
        Route::controller(PermissionController::class)->group(function () {
            Route::delete('permissions/model/{model}', 'deletes')->name('permissions.deletes');
        });
        Route::resource('permissions', PermissionController::class)
            ->except(['create', 'show', 'edit', 'update']);

        // OPTION
        Route::controller(OptionController::class)->group(function () {
            Route::get('options', 'index')->name('options.index');
            Route::post('options', 'store')->name('options.store');
        });
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Pastikan route ini berada di paling bawah file
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

require __DIR__ . '/auth.php';
