<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\HomeAboutController;
use App\Http\Controllers\Backend\SliderController;
use App\Models\Multipic;
use Illuminate\Support\Facades\DB;
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
///frontend
Route::get('/', function () {
    $brands = DB::table('brands')->get();
    $abouts = DB::table('home_abouts')->first();
    $images = Multipic::all();
    return view('frontend.index', compact('brands','abouts','images'));
});
Route::get('/home', function () {
    echo " This is Home page ";
});


///Backend
Route::get('/admin/login', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('backend.index');
    })->name('dashboard');
});
Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

///Brand
Route::get('/brand/all', [BrandController::class, 'AllBrand'])->name('all.brand');
Route::post('/brand/add', [BrandController::class, 'StoreBrand'])->name('store.brand');
Route::get('/brand/edit/{id}', [BrandController::class, 'Edit']);
Route::post('/brand/update/{id}', [BrandController::class, 'Update']);
Route::get('/brand/delete/{id}', [BrandController::class, 'Delete']);

// Multi Image Route
Route::get('/multi/image', [BrandController::class, 'Multpic'])->name('multi.image');
Route::post('/multi/add', [BrandController::class, 'StoreImg'])->name('store.image');

// Home About All Route
Route::get('/home/About', [HomeAboutController::class, 'HomeAbout'])->name('home.about');
Route::get('/add/About', [HomeAboutController::class, 'AddAbout'])->name('add.about');
Route::post('/store/About', [HomeAboutController::class, 'StoreAbout'])->name('store.about');
Route::get('/about/edit/{id}', [HomeAboutController::class, 'EditAbout']);
Route::post('/update/homeabout/{id}', [HomeAboutController::class, 'UpdateAbout']);
Route::get('/about/delete/{id}', [HomeAboutController::class, 'DeleteAbout']);

// Admin ALL Route
Route::get('/home/slider', [SliderController::class, 'HomeSlider'])->name('home.slider');
Route::get('/add/slider', [SliderController::class, 'AddSlider'])->name('add.slider');
Route::post('/store/slider', [SliderController::class, 'StoreSlider'])->name('store.slider');
Route::get('/edit/slider/{id}', [SliderController::class, 'editSlider'])->name('edit.Slider');
Route::post('/store/slider/{id}', [SliderController::class, 'updateSlider'])->name('update.Slider');
Route::get('/delete/slider/{id}', [SliderController::class, 'deleteSlider'])->name('delete.Slider');
