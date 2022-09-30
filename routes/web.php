<?php

use App\Models\User;
use App\Models\Product;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RecipeController;
use App\Models\Item;
use App\Models\Recipe;
use Illuminate\Support\Facades\Redirect;

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
    $products=Product::latest()->filter(request(['tags', 'search']))->paginate(6);
    foreach($products as $product){
        $product['available']=StorageController::getTotal($product->item);
    }
    //dd($product);
    return view('shop',['products' => $products]);
});

Route::get('/hello', function(){
    dd(Item::find(3)->pivotedRecipes);
    return response('Hello World');
});

Route::get('/products/counter', function (Request $request) {
    return response()->json(['products'=>Product::all()]);
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

Route::get('/admin/storage/writeoff/{item}', [StorageController::class, 'writeOff'])->middleware('admin');

Route::post('/admin/storage/writeoff/{item}', [StorageController::class, 'remove'])->middleware('admin');

Route::get('/admin/expenses', [ExpenseController::class, 'view'])->middleware('admin');

Route::get('/admin/expenses/filters', [ExpenseController::class, 'filters'])->middleware('admin');

Route::post('/admin/expenses/api', [ExpenseController::class, 'get'])->middleware('admin');

Route::post('/admin/expenses/update/{expense}', [ExpenseController::class, 'update'])->middleware('admin');

Route::get('/show-pdf/{id}', function($id) {
    $url = Storage::url($id);
    return redirect($url);});

Route::get('/admin/counter', [CounterController::class, 'show'])->middleware('admin');

Route::post('/admin/counter', [CounterController::class, 'storeCheck'])->middleware('admin');

Route::get('/admin/checks', [CounterController::class, 'checks'])->middleware('admin');

Route::get('/admin/fabrication', [RecipeController::class, 'showAll'])->middleware('admin');

Route::get('/admin/fabrication/new', [RecipeController::class, 'new'])->middleware('admin');

Route::get('/admin/fabrication/{item}', [RecipeController::class, 'showItem'])->middleware('admin');

Route::get('/admin/fabrication/move/{item}', [RecipeController::class, 'move'])->middleware('admin');

Route::post('/admin/fabrication/{item}', [RecipeController::class, 'fabricate'])->middleware('admin');

Route::post('/admin/fabrication/', [RecipeController::class, 'store'])->middleware('admin');

Route::get('/admin/fabrication/edit/{item}', [RecipeController::class, 'editation'])->middleware('admin');

Route::delete('/admin/fabrication/edit/{recipe}', [RecipeController::class, function(Recipe $recipe){
    $recipe->delete();
    return Redirect::back()->with('message', 'previdlo receptu odstraněno');
}])->middleware('admin');

