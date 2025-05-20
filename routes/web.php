<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\UserManagement\RoleController;
use App\Http\Controllers\UserManagement\UserController;
use App\Http\Controllers\UserManagement\HakAksesController;
use App\Http\Controllers\UserManagement\PermissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();

// Routes untuk guest (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
});

// Proses login
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// Routes yang hanya bisa diakses oleh user yang sudah login
Route::middleware(['auth'])->group(function () {
    // Routes untuk admin dan superadmin
    Route::middleware('role:admin|superadmin')->group(function () {
        Route::get('/Dashboard-Admin', function () {
            return view('backend.dashboard');
        });
    });

    // Routes yang hanya untuk role "user"
    Route::middleware('role:user')->group(function () {
        Route::get('/Home', function () {
            return view('frontend.home');
        });

        Route::get('/About', function () {
            return view('frontend.about');
        });

        // Route::get('/Shop', function () {
        //     return view('frontend.shop');
        // });
        Route::get('Checkout', [TransaksiController::class, 'checkout'])->name('checkout.index');
        Route::post('Checkout_proses', [TransaksiController::class, 'checkout_proses'])->name('checkout.proses');
        Route::post('Checkout_success', [TransaksiController::class, 'checkout_success'])->name('checkout.success');
        Route::get('Cart', [CartController::class, 'index'])->name('cart.index');
        Route::Post('Cart_Post', [CartController::class, 'cart_post'])->name('cart.post');
        Route::Post('Cart_Update', [CartController::class, 'cart_update'])->name('cart.update');
        Route::Post('Cart_Delete', [CartController::class, 'cart_delete'])->name('cart.delete');
        Route::get('Shop', [ShopController::class, 'index'])->name('shop.index');
        Route::get('Shop-Details/{kode_produk}', [ShopController::class, 'show_detail'])->name('show_detail.index');

        Route::get('/Blog', function () {
            return view('frontend.blog');
        });

        Route::get('/Blog-Detail', function () {
            return view('frontend.blog_detial');
        });

        Route::get('/Contact', function () {
            return view('frontend.contact');
        });

        // Route::get('/Cart', function () {
        //     return view('frontend.cart');
        // });

        // Route::get('/Checkout', function () {
        //     return view('frontend.checkout');
        // });

        Route::get('/Wisslist-Like', function () {
            return view('frontend.wisslist_like');
        });

        // Route::get('/Shop-Details', function () {
        //     return view('frontend.shop_detail');
        // });
    });

    // Logout route
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});


Route::prefix('UserManagement')->group(function () {
    Route::prefix('User')->group(function () {
        Route::get('index', [UserController::class, 'index'])->name('user.index');
        Route::get('create', [UserController::class, 'create'])->name('user.create');
        Route::get('edit', [UserController::class, 'edit'])->name('user.edit');
        Route::get('show', [UserController::class, 'show'])->name('user.show');
    });

    Route::prefix('Role')->group(function () {
        Route::get('index', [RoleController::class, 'index'])->name('role.index');
        Route::get('create', [RoleController::class, 'create'])->name('role.create');
        Route::get('edit', [RoleController::class, 'edit'])->name('role.edit');
        Route::get('show', [RoleController::class, 'show'])->name('role.show');
    });

    Route::prefix('Permission')->group(function () {
        Route::get('index', [PermissionController::class, 'index'])->name('permission.index');
        Route::get('create', [PermissionController::class, 'create'])->name('permission.create');
        Route::post('store', [PermissionController::class, 'store'])->name('permission.store');
        Route::get('edit/{id}', [PermissionController::class, 'edit'])->name('permission.edit');
        Route::get('show/{id}', [PermissionController::class, 'show'])->name('permission.show');
        Route::post('destroy', [PermissionController::class, 'destroy'])->name('permission.destroy');
        Route::put('update/{id}', [PermissionController::class, 'update'])->name('permission.update');

    });

    Route::prefix('Hakakses')->group(function () {
        Route::get('index', [HakAksesController::class, 'index'])->name('hakakses.index');
        Route::get('create', [HakAksesController::class, 'create'])->name('hakakses.create');
        Route::post('store', [HakAksesController::class, 'store'])->name('hakakses.store');
        Route::put('update/{id}', [HakAksesController::class, 'update'])->name('hakakses.update');
        Route::post('destroy', [HakAksesController::class, 'destroy'])->name('hakakses.destroy');
        Route::get('edit/{id}', [HakAksesController::class, 'edit'])->name('hakakses.edit');
        Route::get('show/{id}', [HakAksesController::class, 'show'])->name('hakakses.show');
    });
});


Route::prefix('Manajemen-Produk')->group(function () {

    Route::prefix('tag')->group(function () {
        Route::get('index', [TagController::class, 'index'])->name('tag.index');
        Route::get('create', [TagController::class, 'create'])->name('tag.create');
        Route::post('store', [TagController::class, 'store'])->name('tag.store');
        Route::put('update/{id}', [TagController::class, 'update'])->name('tag.update');
        Route::post('destroy', [TagController::class, 'destroy'])->name('tag.destroy');
        Route::get('edit/{id}', [TagController::class, 'edit'])->name('tag.edit');
        Route::get('show/{id}', [TagController::class, 'show'])->name('tag.show');
    });
    Route::prefix('kategori')->group(function () {
        Route::get('index', [KategoriController::class, 'index'])->name('kategori.index');
        Route::get('create', [KategoriController::class, 'create'])->name('kategori.create');
        Route::post('store', [KategoriController::class, 'store'])->name('kategori.store');
        Route::put('update/{id}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::post('destroy', [KategoriController::class, 'destroy'])->name('kategori.destroy');
        Route::get('edit/{id}', [KategoriController::class, 'edit'])->name('kategori.edit');
        Route::get('show/{id}', [KategoriController::class, 'show'])->name('kategori.show');
    });
    Route::prefix('produk')->group(function () {
        Route::get('index', [ProdukController::class, 'index'])->name('produk.index');
        Route::get('create', [ProdukController::class, 'create'])->name('produk.create');
        Route::post('store', [ProdukController::class, 'store'])->name('produk.store');
        Route::put('update/{id}', [ProdukController::class, 'update'])->name('produk.update');
        Route::post('destroy', [ProdukController::class, 'destroy'])->name('produk.destroy');
        Route::get('edit/{id}', [ProdukController::class, 'edit'])->name('produk.edit');
        Route::get('show/{id}', [ProdukController::class, 'show'])->name('produk.show');
    });
    Route::prefix('supplier')->group(function () {
        Route::get('index', [HakAksesController::class, 'index'])->name('supplier.index');
        Route::get('create', [HakAksesController::class, 'create'])->name('supplier.create');
        Route::post('store', [HakAksesController::class, 'store'])->name('supplier.store');
        Route::put('update/{id}', [HakAksesController::class, 'update'])->name('supplier.update');
        Route::post('destroy', [HakAksesController::class, 'destroy'])->name('supplier.destroy');
        Route::get('edit/{id}', [HakAksesController::class, 'edit'])->name('supplier.edit');
        Route::get('show/{id}', [HakAksesController::class, 'show'])->name('supplier.show');
    });
});
// Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
