<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\BlogController as BackendBlogController;
use App\Http\Controllers\Backend\ContactMessageController;
use App\Http\Controllers\Backend\ImageUploadController;
use App\Http\Controllers\Backend\ServiceCategoryController;
use App\Http\Controllers\Backend\ServiceController as BackendServiceController;
use App\Http\Controllers\Backend\ServicePriceController;
use App\Http\Controllers\Backend\ServiceProductController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\GalleryController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProjectController;
use App\Http\Controllers\Frontend\ServiceController;
use App\Http\Controllers\Frontend\SitemapController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\VoucherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Legacy SEO redirects (must register before current routes)
|--------------------------------------------------------------------------
*/
Route::redirect('/blog', '/blogs', 301);
Route::redirect('/about', '/about-us', 301);
Route::redirect('/portfolio', '/galleries', 301);
Route::redirect('/gallery', '/galleries', 301);
Route::redirect('/images/retaining-wall', '/retaining-wall', 301);
Route::redirect('/รับถมดิน', '/landfill', 301);

Route::get('/blog/{any}', function (string $any) {
    $decodedUrl = urldecode($any);

    $idMap = [
        17 => 'เขื่อนกันดิน-ไทรม้า19-EP1',
        18 => 'เขื่อนกันดิน-ไทรม้า19-EP2',
        19 => 'เขื่อนกันดิน-ไทรม้า19-EP3',
        20 => 'เขื่อนกันดิน-ไทรม้า19-EP4',
        21 => 'กำแพงกันดิน-ซอยบางกร่าง45-5-EP1',
        22 => 'เขื่อนกันดิน-ไทรม้า19-EP5',
        23 => 'สำรวจกำแพงกั้นดินพัง-สุพรรณบุรี',
        24 => 'เขื่อนกันดิน-ไทรม้า19-EP6',
        25 => 'กำแพงกันดิน-ซอยบางกร่าง45-5-EP2',
        26 => 'ขุดบ่อน้ำ-ปากน้ำกระโจมทอง',
        27 => 'กำแพงกันดิน-ซอยไทรม้า19-ส่งงาน',
        28 => 'เทพื้นปูน-ราคาต่อตารางเมตร-2567-รับเหมาเทพื้นคอนกรีต-มืออาชีพ',
        29 => 'เทปูน-1-คิว-ใช้ปูนกี่ถุง-คำนวณวัสดุและต้นทุนอย่างมืออาชีพ',
        30 => 'ถมที่ด้วยเศษวัสดุก่อสร้าง-ช่วยประหยัด-เสริมพื้นแข็งแรง-เหมาะกับงานสร้างกำแพงกันดิน',
    ];

    if (is_numeric($decodedUrl) && isset($idMap[(int) $decodedUrl])) {
        return redirect()->to('/blogs/'.$idMap[(int) $decodedUrl], 301);
    }

    if (Str::contains($decodedUrl, 'เขื่อนกันดินไทรม้า 19 EP.1')) {
        return redirect()->to('/blogs/เขื่อนกันดิน-ไทรม้า19-EP1', 301);
    }
    if (Str::contains($decodedUrl, 'เขื่อนกันดินไทรม้า 19 EP.2')) {
        return redirect()->to('/blogs/เขื่อนกันดิน-ไทรม้า19-EP2', 301);
    }
    if (Str::contains($decodedUrl, 'เขื่อนกันดินไทรม้า 19 EP.3')) {
        return redirect()->to('/blogs/เขื่อนกันดิน-ไทรม้า19-EP3', 301);
    }
    if (Str::contains($decodedUrl, 'เขื่อนกันดินไทรม้า 19 EP.6')) {
        return redirect()->to('/blogs/เขื่อนกันดิน-ไทรม้า19-EP6', 301);
    }
    if (Str::contains($decodedUrl, 'ถมที่ด้วยเศษวัสดุก่อสร้าง')) {
        return redirect()->to('/blogs/ถมที่ด้วยเศษวัสดุก่อสร้าง-ช่วยประหยัด-เสริมพื้นแข็งแรง-เหมาะกับงานสร้างกำแพงกันดิน', 301);
    }
    if (Str::contains($decodedUrl, 'เทปูน 1 คิว ใช้ปูนกี่ถุง? คำนวณวัสดุและต้นทุนอย่างมืออาชีพ')) {
        return redirect()->to('/blogs/เทปูน-1-คิว-ใช้ปูนกี่ถุง-คำนวณวัสดุและต้นทุนอย่างมืออาชีพ', 301);
    }
    if (Str::contains($decodedUrl, 'เทพื้นปูน')) {
        return redirect()->to('/blogs/เทพื้นปูน-ราคาต่อตารางเมตร-2567-รับเหมาเทพื้นคอนกรีต-มืออาชีพ', 301);
    }

    if ($decodedUrl !== '') {
        return redirect()->to('/blogs/'.$decodedUrl, 301);
    }

    return redirect('/blogs', 301);
})->where('any', '.*');

Route::redirect('/blog/เขื่อนกันดินไทรม้า 19 EP.2', '/blogs/เขื่อนกันดิน-ไทรม้า19-EP2', 301);
Route::redirect('/blog/เขื่อนกันดินไทรม้า 19 EP.3', '/blogs/เขื่อนกันดิน-ไทรม้า19-EP3', 301);
Route::redirect('/blog/เขื่อนกันดินไทรม้า 19 EP.6', '/blogs/เขื่อนกันดิน-ไทรม้า19-EP6', 301);
Route::redirect('/blog/ถมที่ด้วยเศษวัสดุก่อสร้าง ช่วยประหยัด เสริมพื้นแข็งแรง เหมาะกับงานสร้างกำแพงกันดิน', '/blogs/ถมที่ด้วยเศษวัสดุก่อสร้าง-ช่วยประหยัด-เสริมพื้นแข็งแรง-เหมาะกับงานสร้างกำแพงกันดิน', 301);
Route::redirect('/blog/เทพื้นปูน ราคาต่อ ตาราง เมตร 2567 | รับเหมาเทพื้นคอนกรีต มืออาชีพ', '/blogs/เทพื้นปูน-ราคาต่อตารางเมตร-2567-รับเหมาเทพื้นคอนกรีต-มืออาชีพ', 301);

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');

    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/categories', [ServiceCategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [ServiceCategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{serviceCategory}', [ServiceCategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{serviceCategory}', [ServiceCategoryController::class, 'destroy'])->name('categories.destroy');

        Route::get('/services', [BackendServiceController::class, 'index'])->name('services.index');
        Route::post('/services', [BackendServiceController::class, 'store'])->name('services.store');
        Route::put('/services/{service}', [BackendServiceController::class, 'update'])->name('services.update');
        Route::delete('/services/{service}', [BackendServiceController::class, 'destroy'])->name('services.destroy');

        Route::get('/service-prices', [ServicePriceController::class, 'index'])->name('service-prices.index');
        Route::post('/service-prices', [ServicePriceController::class, 'store'])->name('service-prices.store');
        Route::put('/service-prices/{servicePrice}', [ServicePriceController::class, 'update'])->name('service-prices.update');
        Route::delete('/service-prices/{servicePrice}', [ServicePriceController::class, 'destroy'])->name('service-prices.destroy');

        Route::get('/service-products', [ServiceProductController::class, 'index'])->name('service-products.index');
        Route::post('/service-products', [ServiceProductController::class, 'store'])->name('service-products.store');
        Route::put('/service-products/{serviceProduct}', [ServiceProductController::class, 'update'])->name('service-products.update');
        Route::delete('/service-products/{serviceProduct}', [ServiceProductController::class, 'destroy'])->name('service-products.destroy');

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::get('/contact-messages', [ContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::put('/contact-messages/{contactMessage}', [ContactMessageController::class, 'update'])->name('contact-messages.update');
        Route::delete('/contact-messages/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');

        Route::get('/blogs', [BackendBlogController::class, 'index'])->name('blogs.index');
        Route::post('/blogs', [BackendBlogController::class, 'store'])->name('blogs.store');
        Route::put('/blogs/{blog}', [BackendBlogController::class, 'update'])->name('blogs.update');
        Route::delete('/blogs/{blog}', [BackendBlogController::class, 'destroy'])->name('blogs.destroy');

        Route::get('/images', [ImageUploadController::class, 'index'])->name('images.index');
        Route::post('/images', [ImageUploadController::class, 'store'])->name('images.store');
        Route::put('/images/locations', [ImageUploadController::class, 'renameLocation'])->name('images.locations.update');
        Route::put('/images/{imageUpload}', [ImageUploadController::class, 'update'])->name('images.update');
        Route::delete('/images/{imageUpload}', [ImageUploadController::class, 'destroy'])->name('images.destroy');
    });
});

Route::get('/contact-us', [ContactController::class, 'index'])->name('contact-us');
Route::get('/about-us', [AboutUsController::class, 'index'])->name('about-us');

Route::prefix('projects')->name('frontend.projects.')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('index');
});

Route::prefix('blogs')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('blog.show');
});

Route::get('/portal', [PortalController::class, 'index'])->name('portal');

Route::post('/quote', [QuoteController::class, 'store'])->name('quote.store');
Route::post('/voucher/copy', [VoucherController::class, 'storeCopy'])->name('voucher.copy');

Route::get('/privacy', [PrivacyController::class, 'index'])->name('privacy');

Route::get('/terms', [TermsController::class, 'index'])->name('terms');

Route::prefix('services')->name('frontend.services.')->group(function () {
    Route::get('/', [ServiceController::class, 'index'])->name('index');
    Route::get('/calculate', [ServiceController::class, 'soilCalculate'])->name('calculate');
});
Route::prefix('galleries')->name('frontend.galleries.')->group(function () {
    Route::get('/', [GalleryController::class, 'index'])->name('index');
    Route::get('/{slug}', [GalleryController::class, 'show'])->name('show');
});

Route::get('/{slug}', [ServiceController::class, 'show'])->name('frontend.services.show');

Route::fallback(function (Request $request) {
    $fullUrl = urldecode($request->fullUrl());

    if (Str::contains($fullUrl, 'เทปูน') && Str::contains($fullUrl, '1 คิว') && Str::contains($fullUrl, 'คำนวณวัสดุ')) {
        return redirect()->to(
            'https://www.theeraphong.com/blogs/เทปูน-1-คิว-ใช้ปูนกี่ถุง-คำนวณวัสดุและต้นทุนอย่างมืออาชีพ',
            301
        );
    }

    abort(404);
});
