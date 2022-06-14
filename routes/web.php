<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ChangePass;
use App\Http\Controllers\Backend\ContactController;
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
Route::get('/about', function () {
    return view('about');
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

// Category Controller
Route::get('/category/all', [CategoryController::class, 'AllCat'])->name('all.category');
Route::post('/category/add', [CategoryController::class, 'AddCat'])->name('store.category');

Route::get('/category/edit/{id}', [CategoryController::class, 'Edit']);
Route::post('/category/update/{id}', [CategoryController::class, 'Update']);
Route::get('/softdelete/category/{id}', [CategoryController::class, 'SoftDelete']);

Route::get('/category/restore/{id}', [CategoryController::class, 'Restore']);
Route::get('/pdelete/category/{id}', [CategoryController::class, 'Pdelete']);


Route::get('/contactasd-asdf-asdfsad', [ContactController::class, 'index'])->name('ariyan');

//Portfolio Page Route
Route::get('/portfolio', [HomeAboutController::class, 'Portfolio'])->name('portfolio');




// Amdin Contact Page Route
Route::get('/admin/contact', [ContactController::class, 'AdminContact'])->name('admin.contact');
Route::get('/admin/add/contact', [ContactController::class, 'AdminAddContact'])->name('add.contact');
Route::post('/admin/store/contact', [ContactController::class, 'AdminStoreContact'])->name('store.contact');
Route::get('/admin/message', [ContactController::class, 'AdminMessage'])->name('admin.message');




/// Home Contact Page Route
Route::get('/contact', [ContactController::class, 'Contact'])->name('contact');
Route::post('/contact/form', [ContactController::class, 'ContactForm'])->name('contact.form');


/// Chanage Password and user Profile Route
Route::get('/user/password', [ChangePass::class, 'CPassword'])->name('change.password');
Route::post('/password/update', [ChangePass::class, 'UpdatePassword'])->name('password.update');

// User Profile
Route::get('/user/profile', [ChangePass::class, 'PUpdate'])->name('profile.update');
Route::post('/user/profile/update', [ChangePass::class, 'UpdateProfile'])->name('update.user.profile');


