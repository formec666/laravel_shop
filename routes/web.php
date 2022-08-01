<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\UserController;
use App\Models\User;
use App\Models\Product;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (Request $request) {
    return view('shop',['products' => Product::latest()->filter(request(['tags', 'search']))->paginate(6)]);
});

Route::get('/hello', function(){
    return response('Hello World');
});

Route::get('/products/edit/{id}', [ProductsController::class, 'viewEdit'])->where('id', '[0-9]+');

Route::get('/products/add', [ProductsController::class, 'add'])->middleware('auth');

Route::put('/products/{product}', [ProductsController::class, 'edit']);

Route::get('/products/{id}', [ProductsController::class, 'viewSingle'])->where('id', '[0-9]+');

Route::delete('/products/{product}', [ProductsController::class, 'destroy'])->middleware('admin');

Route::post('/products', [ProductsController::class, 'store'])->middleware('admin');

Route::get('/register', [UserController::class, 'registerPage']);

Route::post('/createuser', [UserController::class, 'store']);

Route::get('/logout', [UserController::class, 'logOut'])->middleware('auth');

Route::get('/login', [UserController::class, 'loginPage'])->name('login')->middleware('guest');

Route::post('authenticate', [UserController::class, 'authenticate'])->middleware('guest');

Route::get('/cart/add', [CartController::class, 'add']);

Route::get('/cart/addSum', [CartController::class, 'addAndSum']);

Route::any('/cart/show', [CartController::class, 'show']);

Route::any('/cart/delete', [CartController::class, 'delete']);

Route::get('/order', [OrderController::class, 'show']);

Route::post('/order', [OrderController::class, 'store']);

Route::get('/order/users', [OrderController::class, 'users'])->middleware('auth');

Route::get('/admin', [AdminController::class, 'admin'])->middleware('admin');

Route::get('/admin/products', [AdminController::class, 'products'])->middleware('admin');

Route::get('admin/orders', [AdminController::class, 'ordersView'])->middleware('admin');

Route::get('admin/allOrders',[AdminController::class, 'orderJson'] )->middleware('admin');

Route::post('/admin/moveOrder',[AdminController::class, 'moveOrder'] )->middleware('admin');

Route::post('/admin/cart',[CartController::class, 'get'] )->middleware('admin');

Route::get('/admin/employees',[UserController::class, 'get'] )->middleware('admin');

Route::get('/admin/employees/create', [UserController::class, 'createEmployee'])->middleware('admin');

Route::get('/admin/employees/{id}', [UserController::class, 'editEmployee'])->middleware('admin');

Route::post('/admin/employees/{employee}', [UserController::class, 'saveEmployee'])->middleware('admin');

Route::post('/admin/employees', [UserController::class, 'storeEmployee'])->middleware('admin');

Route::get('/admin/archive', [OrderController::class, 'showArchive'])->middleware('admin');

Route::get('/admin/archive/{order}', [OrderController::class, 'activate'])->middleware('admin');

Route::get('/admin/storage', [StorageController::class, 'mainStorage'])->middleware('admin');

Route::get('/admin/storage/spaces', [StorageController::class, 'spaces'])->middleware('admin');

Route::get('/admin/storage/spaces/edit/{space}', [StorageController::class, 'editSpaces'])->middleware('admin');

Route::post('/admin/storage/spaces', [StorageController::class, 'storeSpace'])->middleware('admin');

Route::put('/admin/storage/spaces/edit/{space}', [StorageController::class, 'saveSpace'])->middleware('admin');

Route::get('/admin/storage/spaces/create', [StorageController::class, 'createSpace'])->middleware('admin');

Route::get('/admin/storage/add', [StorageController::class, 'createItem'])->middleware('admin');

Route::get('/admin/storage/items/{item}', [StorageController::class, 'showItem'])->middleware('admin');

Route::get('/admin/storage/stockup/{item}', [StorageController::class, 'viewStockupForm'])->middleware('admin');

Route::post('/admin/storage/stockup/{item}', [StorageController::class, 'saveStockUp'])->middleware('admin');

Route::post('/admin/storage/add', [StorageController::class, 'storeItem'])->middleware('admin');