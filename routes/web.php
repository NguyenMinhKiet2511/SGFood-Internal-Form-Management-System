<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PasswordResetController;
use App\Models\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
//access homepage
Route::group(['prefix'=>''],function(){
    Route::get('/', [HomeController::class,'index'])->name('home.index');
});

//User login
Route::get('/user/login', [UserController::class,'login'])->name('login');
Route::post('/user/login', [UserController::class,'check_login']);

//User logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login'); 
})->name('logout');


//User Forget Password
Route::get('forgot-password', [PasswordResetController::class,'showForgotForm'])->name('password.request');
Route::post('forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [PasswordResetController::class, 'reset'])->name('password.update');

// // //User register
// Route::get('/user/register', [UserController::class,'register'])->name('user.register');
// Route::post('/user/register', [UserController::class,'check_register']);

// //access admin page if login
// Route::group(['prefix'=>'internal','middleware'=>'auth'],function(){
//     Route::get('/user', [UserController::class,'index'])->name('user.index');
//     Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    // Route::resources([
    //     'form'=>FormController::class,
        
    // ]);

   
// });

Route::group(['prefix' => 'user', 'middleware' => ['auth', 'check.user']], function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    // ... user route

    // route for creating and viewing form in MyForm
    Route::resources([
        'form'=>FormController::class, 
    ]);

    //route for handling assigned form
    Route::get('/assigned-forms', [UserController::class, 'assignedForms'])->name('user.assigned.forms');
    Route::post('/assigned-form/{id}/accept', [UserController::class, 'acceptForm'])->name('form.accept');
    Route::post('/assigned-form/{id}/reject', [UserController::class, 'rejectForm'])->name('form.reject');
    Route::post('/assigned-form/{id}/done', [UserController::class, 'markDone'])->name('form.done');
    Route::get('assigned-forms/{form}', [UserController::class, 'showAssigned'])->name('user.assigned.show');

});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'check.admin']], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    // ... admin route
    Route::post('/create-user', [AdminController::class, 'store'])->name('admin.create.user');
    Route::get('/edit-user/{id}', [AdminController::class, 'edit'])->name('admin.edit.user');
    Route::post('/update-user/{id}', [AdminController::class, 'updateUser'])->name('admin.update.user');
    Route::delete('/delete-user/{id}', [AdminController::class, 'destroy'])->name('admin.delete.user');

    Route::resource('admin', AdminController::class);
});


// Manager route
Route::group(['prefix' => 'manager', 'middleware' => ['auth', 'check.manager']], function () {
    Route::get('/index', [ManagerController::class, 'index'])->name('manager.index');
    Route::post('/forms/{form}/approve', [ManagerController::class, 'approve'])->name('manager.forms.approve');
    Route::post('/forms/{form}/deny', [ManagerController::class, 'deny'])->name('manager.forms.deny');
    
    Route::get('/forms/{form}',[ManagerController::class, 'show'])->name('manager.forms.show');
    
});

// Director route
Route::group(['prefix' => 'director', 'middleware' => ['auth', 'check.director']], function () {
    Route::get('/index', [DirectorController::class, 'index'])->name('director.index');
    Route::post('/forms/{form}/approve', [DirectorController::class, 'approve'])->name('director.forms.approve');
    Route::post('/forms/{form}/deny', [DirectorController::class, 'deny'])->name('director.forms.deny');
    
    Route::get('/forms/{form}',[DirectorController::class, 'show'])->name('director.forms.show');
    
});

Route::get('/notification/unread-count', function () {
    return response()->json([
        'count' => Auth::user()->unreadNotifications->count()
    ]);
})->middleware('auth');