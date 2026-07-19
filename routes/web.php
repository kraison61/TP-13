<?php

use App\Http\Controllers\AboutUsController;
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
