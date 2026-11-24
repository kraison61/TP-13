<?php

/**
 * Import junk-removal case study blog + portfolio (ถ.เลี่ยงเมืองนนทบุรี).
 * Source: wasted.md (24 พ.ย. 2569) + job photos 2026-11-24
 */

use App\Models\Blog;
use App\Models\ImageUpload;
use App\Models\Portfolio;
use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$cdnBase = 'https://pub-68154224aa0d447b83de9bf218e76277.r2.dev/';
$cdn = static function (string $path) use ($cdnBase): string {
    return $cdnBase.ltrim($path, '/');
};

$coverPath = 'images/blogs/blogscontent/junk-removal-nonthaburi-2026-11-24/before-01.webp';
$img = [
    'before' => $cdn($coverPath),
    'progress' => $cdn('images/blogs/blogscontent/junk-removal-nonthaburi-2026-11-24/in-progress-01.webp'),
    'after' => $cdn('images/blogs/blogscontent/junk-removal-nonthaburi-2026-11-24/After-01.webp'),
];

$phone = '061-563-9228';
$phoneTel = '0615639228';
$linePhone = '0627188847';

$raw = <<<HTML
<p class="service-kicker"><span class="service-kicker-line"></span>ผลงานขนขยะและเคลียร์ของเก่า</p>

<div class="blog-meta">
  <span><i class="bi bi-flag-fill"></i> ทีมงาน บริษัท ธีรพงษ์ เซอร์วิส จำกัด</span>
  <span><i class="bi bi-geo-alt-fill"></i> ถนนเลี่ยงเมืองนนทบุรี · นนทบุรี กรุงเทพฯ ปริมณฑล</span>
  <span><i class="bi bi-calendar-check"></i> อัปเดตล่าสุด 24 พฤศจิกายน 2569</span>
</div>

<div class="lead">
  <p>บริษัท ธีรพงษ์ เซอร์วิส จำกัด <strong>รับจ้างขนขยะไปทิ้ง</strong>ให้บ้านหลังหนึ่งริมถนนเลี่ยงเมืองนนทบุรี ที่มีของเก่าเก็บกองเต็มลานบ้านและโรงเก็บของ ทีมงานคัดแยก ขนขึ้นรถ นำไปทิ้งที่บ่อขยะที่ได้รับอนุญาต และเก็บกวาดให้จนลานบ้านกลับมาใช้งานได้ งานนี้ใช้รถกระบะต่อคอก รวม 3 เที่ยว ใช้เวลา 1 วัน เจ้าของบ้านไม่ต้องคัดแยกหรือยกเอง</p>
</div>

<div class="table-responsive"><table class="table table-hover">
<thead>
<tr><th>สรุปงาน</th><th>รายละเอียด</th></tr>
</thead>
<tbody>
<tr><td>พื้นที่</td><td>ถนนเลี่ยงเมืองนนทบุรี อ.เมืองนนทบุรี จ.นนทบุรี</td></tr>
<tr><td>ประเภทงาน</td><td>ขนของเก่าเก็บและขยะชิ้นใหญ่ไปทิ้ง</td></tr>
<tr><td>รถและเที่ยว</td><td>รถกระบะต่อคอก ขน 3 เที่ยว</td></tr>
<tr><td>ทีมงาน</td><td>2 คน</td></tr>
<tr><td>ระยะเวลา</td><td>1 วัน</td></tr>
<tr><td>ปลายทาง</td><td>บ่อขยะที่ได้รับอนุญาต · ของรีไซเคิลส่งร้านรับซื้อของเก่า</td></tr>
</tbody>
</table></div>

<figure class="blog-figure">
  <img src="{$img['before']}" alt="กองของเก่าเก็บในลานบ้าน ถ.เลี่ยงเมืองนนทบุรี มีอ่างอาบน้ำ เก้าอี้เหล็ก ถุงขยะ ก่อนขนไปทิ้ง" width="1200" height="800" loading="eager" fetchpriority="high" decoding="async" class="img-responsive">
  <figcaption>1. ก่อนทำงาน — กองของเก่าเก็บเต็มลานบ้าน ถ.เลี่ยงเมืองนนทบุรี</figcaption>
</figure>

<h2>หน้างานนี้มีของเก่าอะไรบ้าง และจัดการอย่างไร?</h2>
<p>หน้างานมีของปนกันกว่า 20 ชนิด ตั้งแต่อ่างอาบน้ำไปจนถึงขวดแก้ว บางส่วนวางใต้ต้นไม้จนมีใบไม้และเศษกิ่งทับ บางส่วนเป็นไม้และเหล็กที่ผุและขึ้นสนิมแล้ว ของที่ปนกันแบบนี้ต้องแยกก่อนขน ไม่อย่างนั้นจะจัดขึ้นรถได้น้อยและเสียเที่ยวรถเกินจำเป็น</p>

<div class="table-responsive"><table class="table table-hover">
<thead>
<tr><th>ประเภทของ</th><th>ตัวอย่างจากงานนี้</th><th>จัดการอย่างไร</th></tr>
</thead>
<tbody>
<tr><td>ของชิ้นใหญ่</td><td>อ่างอาบน้ำ ตู้เหล็ก ตอไม้ บานประตูไม้</td><td>ยกหลายคน หรือตัดแยกชิ้นที่หน้างาน แล้วนำไปทิ้ง</td></tr>
<tr><td>เหล็ก</td><td>โต๊ะและเก้าอี้เหล็ก เหล็กดัด บันไดเหล็ก จักรยานเก่า</td><td>แยกส่งร้านรับซื้อของเก่า</td></tr>
<tr><td>แก้วและพลาสติก</td><td>ขวดแก้ว ลังพลาสติก ตะกร้า โต๊ะพลาสติก</td><td>แยกส่งรีไซเคิลเท่าที่ทำได้ ที่เหลือทิ้ง</td></tr>
<tr><td>ยางและยานพาหนะ</td><td>ยางรถยนต์เก่า ล้อรถเข็น</td><td>แยกออกจากขยะทั่วไปก่อนนำไปทิ้ง</td></tr>
<tr><td>เครื่องใช้ไฟฟ้าเสีย</td><td>พัดลม สายไฟ กล่องเครื่องใช้ไฟฟ้า</td><td>แยกสายไฟและชิ้นส่วนโลหะออกก่อนทิ้ง</td></tr>
<tr><td>ไม้และวัสดุก่อสร้าง</td><td>ไม้เก่า แผ่นหลังคา กระเบื้อง เสาปูน</td><td>ขนไปทิ้งจุดรับเศษวัสดุ</td></tr>
<tr><td>ขยะทั่วไปและกิ่งไม้</td><td>ถุงขยะ กล่องกระดาษ ใบไม้ เศษกิ่ง</td><td>รวบใส่ถุง นำไปทิ้งบ่อขยะที่ได้รับอนุญาต</td></tr>
</tbody>
</table></div>

<h2>ทีมงานขนขยะออกจากบ้านอย่างไร</h2>
<p>งานนี้มี 5 ขั้น ตั้งแต่ประเมินราคาจากรูปจนส่งมอบพื้นที่ที่กวาดแล้ว</p>
<ol>
  <li><strong>ประเมินราคาจากรูป:</strong> เจ้าของบ้านส่งรูปกองของทาง LINE ทีมงานประเมินจำนวนเที่ยวรถและแจ้งราคาเหมาก่อนนัดวัน</li>
  <li><strong>คัดแยกที่หน้างาน:</strong> แยกเหล็ก ขวดแก้ว ยาง ไม้ และขยะทั่วไปออกจากกัน</li>
  <li><strong>รื้อและขนขึ้นรถ:</strong> ของชิ้นใหญ่ยกหลายคน ระวังไม่ให้กระแทกรั้ว ประตู และต้นไม้ในบ้าน</li>
  <li><strong>นำไปทิ้ง:</strong> ขยะทั่วไปไปที่บ่อขยะที่ได้รับอนุญาต ส่วนของรีไซเคิลส่งร้านรับซื้อของเก่า</li>
  <li><strong>เก็บกวาดและส่งมอบ:</strong> เก็บเศษเล็กเศษน้อย กวาดลาน แล้วถ่ายรูปหลังงานส่งให้เจ้าของบ้าน</li>
</ol>

<figure class="blog-figure">
  <img src="{$img['progress']}" alt="ทีมงานขนขยะขึ้นรถกระบะต่อคอก ถ่ายระหว่างทำงาน ถ.เลี่ยงเมืองนนทบุรี" width="900" height="1200" loading="lazy" decoding="async" class="img-responsive">
  <figcaption>2. ระหว่างทำงาน — ทีมงานจัดของขึ้นรถกระบะต่อคอกและคลุมตาข่ายให้แน่น</figcaption>
</figure>

<p>สิ่งที่เจอบ่อยในงานของเก่าเก็บคือ ของที่ตั้งทิ้งไว้นานมักมีไม้ผุ เหล็กคม และสัตว์อยู่ใต้กอง ทีมงานจึงใส่ถุงมือและรองเท้าหุ้มส้นทุกครั้ง และเริ่มรื้อจากด้านบนกองลงมาเพื่อกันของล้มทับ</p>

<h2>ผลลัพธ์หลังเคลียร์เสร็จ</h2>
<p>ลานบ้านที่เคยถูกของเก่าปิดอยู่ กลับมาเป็นพื้นที่โล่งใน 1 วัน ใช้รถรวม 3 เที่ยว พร้อมใช้งานต่อ</p>

<figure class="blog-figure">
  <img src="{$img['after']}" alt="ลานบ้านหลังเคลียร์ของเก่าเสร็จ พื้นที่โล่งพร้อมใช้งาน ถ.เลี่ยงเมืองนนทบุรี" width="1200" height="800" loading="lazy" decoding="async" class="img-responsive">
  <figcaption>3. หลังทำ — ลานบ้านโล่ง กวาดเรียบร้อย พร้อมใช้งานต่อ</figcaption>
</figure>

<div class="blog-grid">
  <div class="blog-grid-col">
    <figure class="blog-figure">
      <img src="{$img['before']}" alt="เปรียบเทียบก่อนขนขยะ กองของเก่าเต็มลานบ้าน นนทบุรี" width="1200" height="800" loading="lazy" decoding="async" class="img-responsive">
      <figcaption>ก่อน — กองของเก่าเต็มลาน</figcaption>
    </figure>
  </div>
  <div class="blog-grid-col">
    <figure class="blog-figure">
      <img src="{$img['after']}" alt="เปรียบเทียบหลังขนขยะ ลานบ้านโล่งพร้อมใช้งาน นนทบุรี" width="1200" height="800" loading="lazy" decoding="async" class="img-responsive">
      <figcaption>หลัง — พื้นที่โล่งพร้อมใช้งาน</figcaption>
    </figure>
  </div>
</div>

<blockquote>
  <p>“งานดีมาก สะอาด เรียบร้อย” — เจ้าของบ้าน ถ.เลี่ยงเมืองนนทบุรี</p>
</blockquote>

<h2>รับจ้างขนขยะไปทิ้งราคาเท่าไหร่?</h2>
<div class="lead">
  <p>ราคาคิดตามจำนวนเที่ยวรถเป็นหลัก แล้วปรับตามน้ำหนักของ ระยะเดินขน และงานรื้อที่ต้องทำเพิ่ม งานขนาดลานบ้านแบบงานนี้อยู่ที่ <strong>1,500 บาท</strong> ทีมงานแจ้งราคาเหมาก่อนเริ่มงานทุกครั้ง</p>
</div>

<div class="table-responsive"><table class="table table-hover">
<thead>
<tr><th>ปัจจัย</th><th>ทำให้ราคาต่ำ</th><th>ทำให้ราคาสูง</th></tr>
</thead>
<tbody>
<tr><td>ปริมาณของ</td><td>ไม่เกิน 1 เที่ยวรถ</td><td>หลายเที่ยว ต้องใช้รถใหญ่</td></tr>
<tr><td>ประเภทของ</td><td>ถุงขยะ ของเบา</td><td>อ่างอาบน้ำ ตู้เหล็ก ตอไม้ เศษปูน</td></tr>
<tr><td>การเข้าถึง</td><td>รถจอดติดกองได้</td><td>ต้องเดินขนไกล มีบันไดหรือซอยแคบ</td></tr>
<tr><td>งานเพิ่ม</td><td>ขนอย่างเดียว</td><td>รื้อโรงเก็บของ ตัดต้นไม้ ถอนตอ</td></tr>
<tr><td>ของที่ขายได้</td><td>มีเหล็กและขวดแก้วเยอะ</td><td>ส่วนใหญ่เป็นขยะที่ไม่มีมูลค่า</td></tr>
</tbody>
</table></div>

<p>ดูขอบเขตบริการขนเศษและขยะเพิ่มได้ที่หน้า <a href="/shipment">รับจ้างขนเศษวัสดุก่อสร้าง</a></p>

<h2>ขยะอะไรที่ไม่รับขน?</h2>
<p>ขยะอันตรายต้องแยกออกจากขยะทั่วไป เช่น ถังแก๊ส สารเคมี ถังสี หลอดไฟ และแบตเตอรี่ เราไม่รับทิ้งขยะสารพิษและของอันตราย แจ้งทีมงานก่อนวันนัดถ้ามีของเหล่านี้ปนอยู่ในกอง</p>

<h2>มีคนรับจ้างขนขยะไปทิ้งใกล้ฉันในนนทบุรีไหม?</h2>
<p>มีครับ ธีรพงษ์ เซอร์วิสรับงานขนขยะและเคลียร์ของเก่าในนนทบุรี เช่น ถนนเลี่ยงเมืองนนทบุรี งามวงศ์วาน แคราย ติวานนท์ และรัตนาธิเบศร์ รวมถึง กรุงเทพฯ และปริมณฑล ส่งพิกัดหน้างานมาทาง LINE เพื่อเช็กวันว่าง นอกจากงานขนขยะ ทีมงานเดียวกันทำรั้ว กำแพงกันดิน และงานโยธาต่อได้ ถ้าเคลียร์พื้นที่เพื่อก่อสร้าง</p>

<h2>คำถามที่พบบ่อยเกี่ยวกับการรับจ้างขนขยะ</h2>
<div class="list-group">
  <div class="list-group-item">
    <h4>รับจ้างขนขยะไปทิ้งราคาเท่าไหร่?</h4>
    <p>ราคาคิดตามจำนวนเที่ยวรถเป็นหลัก แล้วปรับตามน้ำหนักของ ระยะเดินขนจากจุดกองถึงรถ และงานรื้อที่ต้องทำเพิ่ม งานของเก่าเก็บขนาดลานบ้านแบบงานนี้อยู่ที่ 1,500 บาท ส่งรูปกองของมาทาง LINE แล้วทีมงานแจ้งราคาเหมาก่อนเริ่มงาน ไม่มีค่าใช้จ่ายเพิ่มภายหลังถ้าปริมาณของไม่เปลี่ยน</p>
  </div>
  <div class="list-group-item">
    <h4>รับขนขยะชิ้นใหญ่ เช่น อ่างอาบน้ำ ตู้ โต๊ะเหล็ก ไหม?</h4>
    <p>รับครับ งานที่ถนนเลี่ยงเมืองนนทบุรีมีทั้งอ่างอาบน้ำ ตู้เหล็กเก่า โต๊ะและเก้าอี้เหล็ก ตอไม้ และบานประตูไม้ ทีมงานยกและขนขึ้นรถเองทั้งหมด ของที่ใหญ่เกินช่องประตูจะรื้อหรือตัดแยกชิ้นที่หน้างานก่อนขน เจ้าของบ้านไม่ต้องช่วยยก</p>
  </div>
  <div class="list-group-item">
    <h4>ต้องคัดแยกขยะเองก่อนไหม?</h4>
    <p>ไม่ต้องครับ ทีมงานคัดแยกให้ที่หน้างาน โดยแยกเหล็ก ขวดแก้ว ยางรถ ไม้ และขยะทั่วไปออกจากกัน การคัดแยกช่วยให้จัดของขึ้นรถได้แน่นขึ้น ใช้เที่ยวรถน้อยลง และแยกของที่ส่งรีไซเคิลได้ออกจากของที่ต้องทิ้ง สิ่งที่เจ้าของบ้านควรทำคือแยกของที่ยังจะเก็บไว้ออกมาก่อนวันนัด</p>
  </div>
  <div class="list-group-item">
    <h4>ขยะที่ขนออกไปเอาไปทิ้งที่ไหน?</h4>
    <p>ขยะทั่วไปนำไปทิ้งที่บ่อขยะที่ได้รับอนุญาต ส่วนเหล็ก ขวดแก้ว และของที่รีไซเคิลได้ส่งร้านรับซื้อของเก่า เราไม่ทิ้งตามที่รกร้าง ริมถนน หรือริมคลอง เพราะเจ้าของบ้านอาจถูกตามตัวและมีความผิดตามกฎหมายรักษาความสะอาด ขอดูรูปจุดทิ้งได้ทุกงาน</p>
  </div>
  <div class="list-group-item">
    <h4>มีคนรับจ้างขนขยะไปทิ้งใกล้ฉันในนนทบุรีไหม?</h4>
    <p>มีครับ บริษัท ธีรพงษ์ เซอร์วิส จำกัด รับงานขนขยะและเคลียร์ของเก่าในจังหวัดนนทบุรี เช่น ถนนเลี่ยงเมืองนนทบุรี งามวงศ์วาน แคราย ติวานนท์ และรัตนาธิเบศร์ รวมถึง กรุงเทพฯ และปริมณฑล ส่งพิกัดหน้างานทาง LINE {$linePhone} เพื่อเช็กวันว่างและประเมินราคา</p>
  </div>
</div>

<div class="well">
  <h3>มีของเก่าเก็บอยากเคลียร์? ส่งรูปมาประเมินราคาฟรี</h3>
  <p>ถ่ายรูปกองของ 2–4 มุม ส่งมาพร้อมพิกัด แล้วทีมงานแจ้งจำนวนเที่ยวและราคาเหมา</p>
  <p><strong>บริษัท ธีรพงษ์ เซอร์วิส จำกัด</strong> — รับจ้างขนขยะ เคลียร์ของเก่า และงานโยธาครบวงจร พื้นที่ให้บริการ: นนทบุรี กรุงเทพฯ ปทุมธานี และปริมณฑล</p>
  <div class="blog-cta-actions">
    <a class="btn btn-primary" href="tel:{$phoneTel}"><i class="bi bi-telephone-fill"></i> โทร {$phone}</a>
    <a class="btn btn-info" href="https://lin.ee/Qq95f1b"><i class="bi bi-chat-dots-fill"></i> LINE {$linePhone}</a>
    <a class="btn btn-default" href="/shipment">ดูบริการขนเศษวัสดุก่อสร้าง</a>
  </div>
</div>

<p class="text-muted">เขียนโดยทีมงาน บริษัท ธีรพงษ์ เซอร์วิส จำกัด · อัปเดต 24 พฤศจิกายน 2569</p>
HTML;

$inner = trim($raw);
$transformed = str_starts_with($inner, '<div class="blog-content">')
    ? $inner
    : '<div class="blog-content">'.$inner.'</div>';

$title = 'ผลงานรับจ้างขนขยะไปทิ้ง: เคลียร์ของเก่าเก็บเต็มลานบ้าน ถนนเลี่ยงเมืองนนทบุรี';
$slug = 'junk-removal-nonthaburi';
$description = 'ผลงานรับจ้างขนขยะไปทิ้ง ถ.เลี่ยงเมืองนนทบุรี เคลียร์อ่างอาบน้ำ ตู้เหล็ก ยางรถ ไม้เก่า ขวดแก้ว คัดแยกให้ ทิ้งถูกที่ ส่งรูปทาง LINE ประเมินราคาฟรี';

$shipment = Service::query()->where('slug', 'shipment')->first();
$serviceId = $shipment?->id;

$blog = Blog::query()->updateOrCreate(
    ['slug' => $slug],
    [
        'title' => $title,
        'description' => $description,
        'content' => $transformed,
        'service_id' => $serviceId,
        'author' => 'ทีมงาน บริษัท ธีรพงษ์ เซอร์วิส จำกัด',
        'geo' => Blog::DEFAULT_GEO,
        'cover_image' => $img['before'],
    ]
);

$blog->forceFill([
    'created_at' => '2026-11-24 10:00:00',
    'updated_at' => '2026-11-24 16:00:00',
])->saveQuietly();

ImageUpload::query()
    ->where('imageable_type', Blog::class)
    ->where('imageable_id', $blog->id)
    ->delete();

foreach ([$img['before'], $img['progress'], $img['after']] as $url) {
    ImageUpload::query()->create([
        'imageable_type' => Blog::class,
        'imageable_id' => $blog->id,
        'img_url' => $url,
        'location' => null,
        'worked_date' => '2026-11-24 10:00:00',
    ]);
}

echo "Upserted blog #{$blog->id} slug={$blog->slug} (".strlen($transformed)." bytes)\n";
echo "cover_image={$blog->cover_image}\n";
echo 'images='.$blog->images()->count()."\n";
echo 'URL: '.route('blog.show', $blog->slug)."\n";

if (! $shipment) {
    echo "SKIP portfolio: shipment service not found\n";
    exit(0);
}

$portfolioSlug = 'junk-removal-nonthaburi-bypass';
$portfolioContent = <<<HTML
<p>งานรับจ้างขนขยะไปทิ้งและเคลียร์ของเก่าเก็บ ริมถนนเลี่ยงเมืองนนทบุรี ของปนกันหลายชนิด ทั้งอ่างอาบน้ำ ตู้เหล็ก ยางรถ ไม้เก่า และถุงขยะ กองเต็มลานบ้าน</p>
<p>ทีมงาน 2 คน คัดแยก ขนด้วยรถกระบะต่อคอก รวม 3 เที่ยว นำไปทิ้งบ่อขยะที่ได้รับอนุญาต และกวาดลานส่งมอบภายใน 1 วัน</p>
<p>อ่านรายละเอียดเคสนี้ได้ที่ <a href="/blogs/junk-removal-nonthaburi">ผลงานรับจ้างขนขยะไปทิ้ง นนทบุรี</a></p>
HTML;

$portfolio = Portfolio::query()->updateOrCreate(
    ['slug' => $portfolioSlug],
    [
        'service_id' => $shipment->id,
        'title' => 'ขนขยะเคลียร์ของเก่า ถ.เลี่ยงเมืองนนทบุรี',
        'location' => 'ถนนเลี่ยงเมืองนนทบุรี — นนทบุรี',
        'project_length' => null,
        'content' => $portfolioContent,
        'cover_image' => $img['before'],
        'completion_date' => '2026-11-24',
    ]
);

ImageUpload::query()
    ->where('imageable_type', Portfolio::class)
    ->where('imageable_id', $portfolio->id)
    ->delete();

$galleryLocation = 'ขนขยะ ถ.เลี่ยงเมืองนนทบุรี';
foreach ([$img['before'], $img['progress'], $img['after']] as $url) {
    ImageUpload::query()->create([
        'imageable_type' => Portfolio::class,
        'imageable_id' => $portfolio->id,
        'img_url' => $url,
        'location' => $galleryLocation,
        'worked_date' => '2026-11-24 10:00:00',
    ]);
}

echo "Upserted portfolio #{$portfolio->id} slug={$portfolio->slug}\n";
echo 'portfolio images='.$portfolio->images()->count()."\n";
echo "service={$shipment->slug} #{$shipment->id}\n";

if (is_string($shipment->content) && ! str_contains($shipment->content, '/blogs/junk-removal-nonthaburi')) {
    $needle = 'ส่งรูปกองเศษมาทาง LINE แล้วรู้ราคาภายในวันเดียว';
    $linkHtml = '<p>ดูผลงานจริง: <a href="/blogs/junk-removal-nonthaburi">ขนขยะเคลียร์ของเก่า ถ.เลี่ยงเมืองนนทบุรี</a></p>';
    if (str_contains($shipment->content, $needle)) {
        $patched = str_replace($needle, $linkHtml.$needle, $shipment->content, $count);
        if ($count > 0) {
            $shipment->forceFill(['content' => $patched])->saveQuietly();
            echo "Linked service #{$shipment->id} → junk-removal blog\n";
        } else {
            echo "WARN: could not patch shipment cross-link\n";
        }
    } else {
        echo "WARN: shipment CTA marker not found\n";
    }
}
