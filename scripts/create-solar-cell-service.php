<?php

/**
 * Create or refresh the solar-cell installation service in database.sqlite
 * and upload hero/content photos to the public image disk.
 */

use App\Models\Faq;
use App\Models\Service;
use App\Models\ServicePrice;
use App\Models\ServiceScope;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$tmp = storage_path('app/tmp-solar');
if (! is_dir($tmp) && ! mkdir($tmp, 0775, true) && ! is_dir($tmp)) {
    fwrite(STDERR, "Cannot create {$tmp}\n");
    exit(1);
}

$sources = [
    'hero' => 'https://images.pexels.com/photos/8853502/pexels-photo-8853502.jpeg?auto=compress&cs=tinysrgb&w=1800',
    'homes' => 'https://images.pexels.com/photos/9875682/pexels-photo-9875682.jpeg?auto=compress&cs=tinysrgb&w=1600',
    'inspect' => 'https://images.pexels.com/photos/4254167/pexels-photo-4254167.jpeg?auto=compress&cs=tinysrgb&w=1600',
    'metal' => 'https://images.unsplash.com/photo-1613665813446-82a78c468a1d?auto=format&fit=crop&w=1600&q=80',
];

foreach ($sources as $key => $url) {
    $dest = $tmp.DIRECTORY_SEPARATOR.$key.'.jpg';
    $binary = @file_get_contents($url);
    if ($binary === false || strlen($binary) < 10000) {
        fwrite(STDERR, "Download failed: {$key}\n");
        exit(1);
    }
    file_put_contents($dest, $binary);
    echo "downloaded {$key} ".strlen($binary)." bytes\n";
}

$heroPath = $tmp.DIRECTORY_SEPARATOR.'hero-portrait.jpg';
cropPortraitLeft($tmp.DIRECTORY_SEPARATOR.'hero.jpg', $heroPath);

$uploaded = [
    'hero' => uploadJpeg($heroPath, 'images/services/solar-cell-installation-hero.jpg'),
    'homes' => uploadJpeg($tmp.DIRECTORY_SEPARATOR.'homes.jpg', 'images/services/solar-cell-installation-homes.jpg'),
    'inspect' => uploadJpeg($tmp.DIRECTORY_SEPARATOR.'inspect.jpg', 'images/services/solar-cell-installation-inspect.jpg'),
    'metal' => uploadJpeg($tmp.DIRECTORY_SEPARATOR.'metal.jpg', 'images/services/solar-cell-installation-metal.jpg'),
];

$img = [];
foreach ($uploaded as $key => $path) {
    $img[$key] = Storage::disk('s3')->url($path).'?width=1400&format=webp&fit=cover';
    echo "{$key} {$img[$key]}\n";
}

$description = 'รับติดตั้งโซล่าเซลล์บนหลังคาบ้าน อาคารพาณิชย์ และหลังคาเมทัลชีทในกรุงเทพฯ และปริมณฑล ครอบคลุมสำรวจโครงสร้างหลังคา ออกแบบขนาดระบบ ติดตั้งแผง โครงยึด อินเวอร์เตอร์ และเชื่อมตู้ไฟ ระบบ On-Grid เริ่มต้นที่ 145,000 บาท ส่งรูปหลังคากับบิลค่าไฟประเมินผ่าน LINE ได้ฟรี';

$metaDes = 'รับติดตั้งโซล่าเซลล์บ้านและอาคาร กทม.และปริมณฑล เริ่มต้น 145,000 บาท ส่งรูปหลังคาประเมินผ่าน LINE โทร 061-563-9228';

$content = <<<HTML
<p class="service-kicker"><span class="service-kicker-line"></span>งานติดตั้งโซล่าเซลล์</p>

<h2>ติดตั้งโซล่าเซลล์บ้าน ครอบคลุมงานอะไรบ้าง?</h2>
<div class="lead">
  <p><strong>บริษัท ธีรพงษ์ เซอร์วิส จำกัด</strong> รับติดตั้งระบบโซล่าเซลล์บนหลังคาบ้าน อาคารพาณิชย์ และหลังคาเมทัลชีทในกรุงเทพฯ และปริมณฑล งานเริ่มจากรูปหลังคาและบิลค่าไฟ เพื่อเลือกขนาดระบบให้พอดีกับไฟที่ใช้ตอนกลางวัน แล้วติดตั้งแผง โครงยึด อินเวอร์เตอร์ เดินสาย และเชื่อมเข้าตู้ไฟของอาคาร</p>
</div>

<ul class="service-checklist service-checklist--grid">
  <li><i class="bi bi-check-circle-fill"></i><span><strong>สำรวจหลังคา:</strong> ดูชนิดกระเบื้องหรือเมทัลชีท ทิศแดด เงาบัง และโครงที่รับน้ำหนักแผงได้</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>ออกแบบขนาดระบบ:</strong> On-Grid หรือ Hybrid ให้สอดคล้องกับหน่วยไฟที่ใช้ช่วงกลางวัน</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>ติดตั้งอุปกรณ์:</strong> แผง โครงยึด อินเวอร์เตอร์ และอุปกรณ์ป้องกันไฟฟ้า</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>เดินสายและเชื่อมตู้ไฟ:</strong> สายไฟตรง สายไฟสลับ และจุดต่อเข้าตู้ไฟเดิม</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>ตรวจสายดิน:</strong> ถ้าตู้ไฟเดิมยังไม่พร้อม จัดงาน<a href="/electrical-wiring">เดินสายไฟ</a>ให้ก่อนติดระบบ</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>ทดสอบก่อนส่งมอบ:</strong> ตรวจการผลิตไฟ และส่งผลทดสอบพร้อมรายการอุปกรณ์</span></li>
</ul>

<figure>
  <img src="{$img['homes']}" alt="หลังคาบ้านพักอาศัยที่ติดตั้งแผงโซล่าเซลล์เรียงเป็นแถวรับแสง" width="1400" height="900" loading="lazy" decoding="async" class="img-responsive">
  <figcaption>แผงบนหลังคาบ้านควรเรียงให้แต่ละแถวรับแสงเต็มผืน และไม่บังเงากันเอง</figcaption>
</figure>

<h2>On-Grid กับ Hybrid ต่างกันอย่างไร?</h2>
<div class="lead">
  <p>ระบบทั้งสองผลิตไฟจากแผงชุดเดียวกัน สิ่งที่ทำให้ราคาและประโยชน์ต่างกันคืออินเวอร์เตอร์และแบตเตอรี่ ไม่ใช่จำนวนแผงอย่างเดียว</p>
</div>
<div class="service-feature-grid">
  <div class="service-feature-card"><h3>On-Grid</h3><p>ผลิตไฟใช้เองตอนกลางวัน ส่วนที่เหลือส่งเข้าระบบของการไฟฟ้า เหมาะกับบ้านที่เปิดแอร์หรือเครื่องใช้ไฟช่วงมีแดด และไม่ต้องการไฟสำรองตอนกลางคืน</p></div>
  <div class="service-feature-card"><h3>Hybrid</h3><p>ต่อแบตเตอรี่เพื่อใช้ไฟต่อเมื่อการไฟฟ้าดับหรือหลังพระอาทิตย์ตก ราคาสูงกว่าระบบ On-Grid เพราะมีแบตเตอรี่และอินเวอร์เตอร์คนละแบบ</p></div>
  <div class="service-feature-card"><h3>เลือกขนาดจากหน่วยไฟกลางวัน</h3><p>บ้านที่ใช้ไฟเดือนละ 400–600 หน่วยมักเริ่มที่ 3 kW บ้านที่ใช้ 700–1,000 หน่วยมักเหมาะกับ 5 kW ขนาดใหญ่กว่านี้ใช้กับบ้านหรืออาคารที่เปิดโหลดกลางวันต่อเนื่อง</p></div>
  <div class="service-feature-card"><h3>ตู้ไฟต้องพร้อมก่อน</h3><p>ระบบโซล่าเซลล์เชื่อมเข้าตู้ไฟเดิม ถ้าตู้ยังเป็นคัตเอาต์ฟิวส์ หรือไม่มีสายดิน ควรจัดตู้ไฟและสายเมนก่อนติดตั้ง เพื่อให้เบรกเกอร์ตัดวงจรได้ถูกต้อง</p></div>
</div>

<h2>ราคาติดตั้งโซล่าเซลล์เริ่มต้นเท่าไหร่?</h2>
<p>ตารางด้านล่างเป็นราคาเริ่มต้นของระบบบนหลังคาที่โครงสร้างรับน้ำหนักได้ และระยะเดินสายไม่ยาวผิดปกติ ราคาจริงเปลี่ยนตามชนิดหลังคา จำนวนเฟส และสเปกแผงกับอินเวอร์เตอร์ ส่งรูปหลังคากับบิลค่าไฟประเมินเบื้องต้นผ่าน LINE ได้ฟรี หากให้ช่างลงสำรวจหน้างาน ค่าบริการเริ่มต้น 1,500 บาท และหักลดเมื่อว่าจ้าง</p>

<div class="table-responsive"><table class="table table-hover">
<thead>
<tr><th>ระบบ</th><th>ราคาเริ่มต้น (บาท)</th><th>เหมาะกับ</th></tr>
</thead>
<tbody>
<tr><td>On-Grid 3 kW 1 เฟส</td><td>{{price:SOLAR-ONG-3}}</td><td>บ้านที่ใช้ไฟเดือนละประมาณ 400–600 หน่วย</td></tr>
<tr><td>On-Grid 5 kW 1 เฟส</td><td>{{price:SOLAR-ONG-5-1P}}</td><td>บ้านเดี่ยวที่เปิดแอร์กลางวัน 1–2 เครื่อง</td></tr>
<tr><td>On-Grid 5 kW 3 เฟส</td><td>{{price:SOLAR-ONG-5-3P}}</td><td>บ้านหรืออาคารที่ใช้ไฟ 3 เฟส</td></tr>
<tr><td>Hybrid 5 kW 1 เฟส พร้อมแบตเตอรี่</td><td>{{price:SOLAR-HYB-5}}</td><td>ต้องการไฟสำรองเมื่อการไฟฟ้าดับ</td></tr>
<tr><td>On-Grid 10 kW 3 เฟส</td><td>{{price:SOLAR-ONG-10}}</td><td>บ้านหลังใหญ่ โฮมออฟฟิศ หรืออาคารที่ใช้ไฟกลางวันสูง</td></tr>
</tbody>
</table></div>

<p>ตัวเลขประหยัดค่าไฟในโฆษณาเป็นค่าเฉลี่ย ไม่ใช่ตัวเลขที่การันตีได้ทุกเดือน เพราะขึ้นกับพฤติกรรมใช้ไฟ เงาบนหลังคา และจำนวนวันที่แดดจัด อ่านวิธีเทียบใบเสนอราคาก่อนตัดสินใจได้ที่บทความ <a href="/blogs/home-solar-cell-price-guide">บ้านโซล่าเซลล์ ติดขนาดไหนดี</a> และ <a href="/blogs/solar-cell-installation-price">ราคาติดตั้งโซล่าเซลล์คิดจากอะไร</a></p>

<h2>ขั้นตอนติดตั้งกับธีรพงษ์ เซอร์วิส</h2>
<div class="list-group">
  <div class="list-group-item"><h4>1. ประเมินจากรูปหลังคาและบิลค่าไฟ</h4><p>ส่งรูปหลังคาทุกด้าน รูปตู้ไฟ และบิลค่าไฟ 1–2 เดือน ทีมงานประเมินขนาดระบบเบื้องต้นผ่าน LINE โดยไม่เก็บค่าใช้จ่าย</p></div>
  <div class="list-group-item"><h4>2. สำรวจโครงสร้างและตู้ไฟ</h4><p>ตรวจชนิดหลังคา แนวแป ระยะเดินสาย และพื้นที่วางอินเวอร์เตอร์ ถ้าโครงหลังคารับน้ำหนักไม่ได้ จะแยกรายการเสริมโครงสร้างออกจากราคาเริ่มต้น</p></div>
  <div class="list-group-item"><h4>3. ติดตั้งแผงและอุปกรณ์ไฟฟ้า</h4><p>ยึดโครงให้ได้แนว วางแผง ติดตั้งอินเวอร์เตอร์ในจุดที่ระบายความร้อนได้ เดินสายไฟตรงและไฟสลับแยกจากสายสื่อสาร</p></div>
  <div class="list-group-item"><h4>4. ทดสอบการผลิตไฟและส่งมอบ</h4><p>ตรวจแรงดัน การทำงานของอินเวอร์เตอร์ และจุดต่อตู้ไฟ แล้วส่งผลทดสอบพร้อมรายการอุปกรณ์ งานติดตั้งรับประกัน 2 ปี แผงและอินเวอร์เตอร์เป็นไปตามเงื่อนไขผู้ผลิตที่ระบุในใบเสนอราคา</p></div>
</div>

<figure>
  <img src="{$img['inspect']}" alt="ช่างสวมหมวกนิรภัยตรวจแผงโซล่าเซลล์พร้อมบันทึกรายการก่อนส่งมอบ" width="1400" height="900" loading="lazy" decoding="async" class="img-responsive">
  <figcaption>ก่อนส่งมอบต้องตรวจแผง โครงยึด และจุดต่อไฟฟ้า โดยทีมงานสวมหมวกนิรภัยและอุปกรณ์ป้องกัน</figcaption>
</figure>

<h2>หลังคาแบบไหนติดตั้งได้ และต้องขออนุญาตไหม?</h2>
<ul class="service-checklist">
  <li><i class="bi bi-check-circle-fill"></i><span>กระเบื้องซีแพค ลอนคู่ และเมทัลชีทติดตั้งได้ เมื่อโครงหลังคาไม่ผุและรับน้ำหนักแผงได้</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span>ทิศใต้และทิศตะวันตกเฉียงใต้รับแดดได้ดีในประเทศไทย ทิศอื่นติดตั้งได้ แต่กำลังผลิตต่อวันจะน้อยลง</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span>เงาจากต้นไม้ แท็งก์น้ำ และอาคารข้างเคียงมีผลทั้งแถว ถ้าแผงต่ออนุกรมอยู่ในสตริงเดียวกัน</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span>ระบบที่เชื่อมกับการไฟฟ้าต้องยื่นเอกสารตามเงื่อนไขของการไฟฟ้านครหลวงหรือการไฟฟ้าส่วนภูมิภาค ทีมงานช่วยจัดเอกสารเมื่อหน้างานเข้าเงื่อนไข</span></li>
</ul>

<figure>
  <img src="{$img['metal']}" alt="แผงโซล่าเซลล์ติดตั้งบนหลังคาเมทัลชีทของอาคาร เรียงตามแนวหลังคา" width="1400" height="900" loading="lazy" decoding="async" class="img-responsive">
  <figcaption>หลังคาเมทัลชีทของอาคารและโกดังติดตั้งได้ เมื่อโครงเหล็กรับน้ำหนักและมีพื้นที่เดินสายลงตู้ไฟ</figcaption>
</figure>

<h2>สิ่งที่ระบุในใบเสนอราคาทุกครั้ง</h2>
<div class="service-feature-grid">
  <div class="service-feature-card"><h3>รายการอุปกรณ์</h3><p>จำนวนแผง กำลังวัตต์ ยี่ห้ออินเวอร์เตอร์ และขนาดแบตเตอรี่ถ้ามี เพื่อให้เทียบกับใบเสนอราคาเจ้าอื่นได้ในหน่วยเดียวกัน</p></div>
  <div class="service-feature-card"><h3>งานที่ยังไม่รวม</h3><p>การเสริมโครงหลังคา การเปลี่ยนตู้ไฟ และการเดินสายเมนใหม่ จะแยกบรรทัด ไม่ปนในราคาเริ่มต้นของระบบ</p></div>
  <div class="service-feature-card"><h3>การรับประกัน</h3><p>งานติดตั้ง 2 ปี ส่วนแผงและอินเวอร์เตอร์ระบุตามเงื่อนไขผู้ผลิตในใบเสนอราคา ไม่ใช้คำว่ารับประกันทั้งระบบ 25 ปีแทนงานติดตั้ง</p></div>
  <div class="service-feature-card"><h3>พื้นที่ให้บริการ</h3><p>กรุงเทพฯ นนทบุรี ปทุมธานี สมุทรปราการ และปริมณฑล นัดสำรวจหน้างานได้ในวันทำการ</p></div>
</div>

<div class="well">
  <h3>ส่งรูปหลังคามาประเมินขนาดระบบ</h3>
  <p>แนบบิลค่าไฟและรูปตู้ไฟมาด้วย ทีมงานตอบขนาดที่เหมาะและช่วงราคาเบื้องต้นก่อนนัดขึ้นหลังคา</p>
</div>
HTML;

$faqs = [
    ['question' => 'ติดตั้งโซล่าเซลล์บ้าน ราคาเริ่มต้นเท่าไหร่?', 'answer' => 'ระบบ On-Grid 3 kW 1 เฟสเริ่มต้นที่ 145,000 บาท สำหรับหลังคาที่โครงสร้างรับน้ำหนักได้และระยะเดินสายไม่ยาวผิดปกติ ระบบ 5 kW และ 10 kW รวมถึง Hybrid ที่มีแบตเตอรี่มีราคาเริ่มต้นสูงขึ้นตามขนาดและอุปกรณ์ ราคาจริงยืนยันหลังดูรูปหลังคาหรือสำรวจหน้างาน', 'sort_order' => 1],
    ['question' => 'ควรเลือก On-Grid หรือ Hybrid?', 'answer' => 'เลือก On-Grid เมื่อต้องการใช้ไฟที่ผลิตได้ตอนกลางวันและไม่ต้องการไฟสำรอง เลือก Hybrid เมื่อต้องการแบตเตอรี่ไว้ใช้ตอนการไฟฟ้าดับหรือหลังพระอาทิตย์ตก Hybrid มีราคาสูงกว่าเพราะมีแบตเตอรี่และอินเวอร์เตอร์คนละแบบ', 'sort_order' => 2],
    ['question' => 'หลังคาบ้านแบบไหนติดตั้งโซล่าเซลล์ได้?', 'answer' => 'กระเบื้องซีแพค ลอนคู่ และเมทัลชีทติดตั้งได้ เมื่อโครงหลังคาไม่ผุและรับน้ำหนักแผงได้ ช่างจะตรวจทิศแดด เงาบัง และแนวแปก่อนเสนอราคา ถ้าต้องเสริมโครงสร้างจะแยกรายการออกจากราคาเริ่มต้นของระบบ', 'sort_order' => 3],
    ['question' => 'ติดตั้งโซล่าเซลล์ใช้เวลากี่วัน?', 'answer' => 'บ้านพักอาศัยทั่วไปใช้เวลาติดตั้งประมาณ 5–14 วัน หลังจากอุปกรณ์เข้าหน้างานและโครงหลังคาพร้อม ระยะจริงขึ้นกับขนาดระบบ ชนิดหลังคา และงานตู้ไฟที่ต้องจัดก่อนเชื่อมระบบ', 'sort_order' => 4],
    ['question' => 'ต้องขออนุญาตการไฟฟ้าไหม?', 'answer' => 'ระบบที่เชื่อมกับการไฟฟ้าต้องยื่นเอกสารตามเงื่อนไขของการไฟฟ้านครหลวงหรือการไฟฟ้าส่วนภูมิภาค ทีมงานช่วยจัดเอกสารเมื่อหน้างานเข้าเงื่อนไข และจะบอกตั้งแต่ใบเสนอราคาหากหลังคาหรือตู้ไฟยังไม่พร้อมยื่น', 'sort_order' => 5],
    ['question' => 'งานติดตั้งโซล่าเซลล์รับประกันกี่ปี?', 'answer' => 'งานติดตั้งรับประกัน 2 ปี แผงและอินเวอร์เตอร์เป็นไปตามเงื่อนไขผู้ผลิตที่ระบุในใบเสนอราคา การประหยัดค่าไฟขึ้นกับหน่วยไฟที่ใช้ตอนกลางวันและสภาพแดดแต่ละเดือน จึงไม่การันตีเป็นตัวเลขคงที่', 'sort_order' => 6],
];

$prices = [
    ['sku' => 'SOLAR-ONG-3', 'name' => 'ระบบ On-Grid 3 kW 1 เฟส', 'price_type' => 'starting_at', 'price' => 145000, 'max_price' => null, 'unit' => 'ระบบ', 'sort_order' => 1],
    ['sku' => 'SOLAR-ONG-5-1P', 'name' => 'ระบบ On-Grid 5 kW 1 เฟส', 'price_type' => 'starting_at', 'price' => 160000, 'max_price' => null, 'unit' => 'ระบบ', 'sort_order' => 2],
    ['sku' => 'SOLAR-ONG-5-3P', 'name' => 'ระบบ On-Grid 5 kW 3 เฟส', 'price_type' => 'starting_at', 'price' => 180000, 'max_price' => null, 'unit' => 'ระบบ', 'sort_order' => 3],
    ['sku' => 'SOLAR-HYB-5', 'name' => 'ระบบ Hybrid 5 kW 1 เฟส พร้อมแบตเตอรี่', 'price_type' => 'starting_at', 'price' => 250000, 'max_price' => null, 'unit' => 'ระบบ', 'sort_order' => 4],
    ['sku' => 'SOLAR-ONG-10', 'name' => 'ระบบ On-Grid 10 kW 3 เฟส', 'price_type' => 'starting_at', 'price' => 300000, 'max_price' => null, 'unit' => 'ระบบ', 'sort_order' => 5],
];

$scopes = [
    'สำรวจหลังคา ทิศแดด และเงาบัง',
    'ออกแบบขนาดระบบ On-Grid หรือ Hybrid',
    'ติดตั้งแผงและโครงยึด',
    'ติดตั้งอินเวอร์เตอร์และอุปกรณ์ป้องกัน',
    'เดินสายไฟตรงและไฟสลับ',
    'เชื่อมระบบเข้าตู้ไฟเดิม',
    'ทดสอบการผลิตไฟก่อนส่งมอบ',
    'รับประกันงานติดตั้ง 2 ปี',
];

if (mb_strlen($metaDes) > 255) {
    fwrite(STDERR, 'meta_des too long: '.mb_strlen($metaDes)."\n");
    exit(1);
}

DB::transaction(function () use ($description, $metaDes, $content, $faqs, $prices, $scopes, $uploaded) {
    $service = Service::query()->firstOrNew(['slug' => 'solar-cell-installation']);
    $service->fill([
        'service_category_id' => 6,
        'title' => 'ติดตั้งโซล่าเซลล์',
        'slug' => 'solar-cell-installation',
        'meta_title' => 'ติดตั้งโซล่าเซลล์บ้าน ราคาเริ่มต้น ปี 2569',
        'meta_des' => $metaDes,
        'description' => $description,
        'h1' => 'ติดตั้งโซล่าเซลล์บนหลังคาบ้านและอาคาร',
        'content' => $content,
        'schema_type' => 'ติดตั้งระบบโซล่าเซลล์สำหรับบ้านและอาคาร',
        'is_active' => true,
        'icon_name' => 'bi-sun-fill',
        'dur' => '5–14 วัน',
        'img_1' => $uploaded['hero'],
        'img_2' => $uploaded['metal'],
        'rating_value' => 5,
        'review_count' => 0,
    ]);
    $service->save();

    Faq::query()->where('service_id', $service->id)->delete();
    foreach ($faqs as $faq) {
        Faq::create([
            'service_id' => $service->id,
            'question' => $faq['question'],
            'answer' => $faq['answer'],
            'sort_order' => $faq['sort_order'],
            'is_active' => true,
        ]);
    }

    ServicePrice::query()->where('service_id', $service->id)->delete();
    foreach ($prices as $row) {
        ServicePrice::create([
            'service_id' => $service->id,
            'sku' => $row['sku'],
            'name' => $row['name'],
            'price_type' => $row['price_type'],
            'price' => $row['price'],
            'max_price' => $row['max_price'],
            'unit' => $row['unit'],
            'price_currency' => 'THB',
            'sort_order' => $row['sort_order'],
            'is_active' => true,
        ]);
    }

    ServiceScope::query()->where('service_id', $service->id)->delete();
    foreach ($scopes as $index => $name) {
        ServiceScope::create([
            'service_id' => $service->id,
            'name' => $name,
            'group' => 'included',
            'sort_order' => $index + 1,
            'is_active' => true,
        ]);
    }

    echo "OK service #{$service->id} solar-cell-installation\n";
});

function cropPortraitLeft(string $source, string $dest): void
{
    $image = imagecreatefromjpeg($source);
    if ($image === false) {
        fwrite(STDERR, "Cannot read hero image\n");
        exit(1);
    }

    $width = imagesx($image);
    $height = imagesy($image);
    $targetWidth = (int) round($height * 4 / 5);

    if ($targetWidth > $width) {
        $targetWidth = $width;
        $targetHeight = (int) round($width * 5 / 4);
        $cropX = 0;
        $cropY = (int) max(0, round(($height - $targetHeight) / 2));
    } else {
    $targetHeight = $height;
    $cropX = (int) round(($width - $targetWidth) * 0.38);
    $cropY = 0;
    }

    $portrait = imagecrop($image, [
        'x' => $cropX,
        'y' => $cropY,
        'width' => $targetWidth,
        'height' => $targetHeight,
    ]);

    if ($portrait === false) {
        fwrite(STDERR, "Hero crop failed\n");
        exit(1);
    }

    imagejpeg($portrait, $dest, 86);
    imagedestroy($portrait);
    imagedestroy($image);
}

function uploadJpeg(string $file, string $path): string
{
    $ok = Storage::disk('s3')->put($path, file_get_contents($file), [
        'ContentType' => 'image/jpeg',
    ]);

    if ($ok !== true) {
        fwrite(STDERR, "Upload failed: {$path}\n");
        exit(1);
    }

    return $path;
}
