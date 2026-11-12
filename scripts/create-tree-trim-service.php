<?php

/**
 * Create service page "งานตัดแต่งต้นไม้" (/tree-trim) under earthwork category.
 * Contact phone on this page: 061-563-9228 (site default via CompanyPhone).
 */

use App\Models\Faq;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServicePrice;
use App\Models\ServiceScope;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$metaTitle = 'รับจ้างตัดแต่งต้นไม้ กรุงเทพฯ ปริมณฑล | ธีรพงษ์เซอร์วิส';
$metaDes = 'รับจ้างตัดแต่งต้นไม้ ตัดกิ่งใหญ่ ตัดแต่งทรงพุ่มและไม้พุ่ม ในกรุงเทพฯ และปริมณฑล ทีมงานพร้อมอุปกรณ์นิรภัย ประเมินราคาฟรี โทร 061-563-9228';
$h1 = 'รับจ้างตัดแต่งต้นไม้ ตัดกิ่งใหญ่ และจัดทรงพุ่ม กรุงเทพฯ และปริมณฑล';
$title = 'งานตัดแต่งต้นไม้';
$slug = 'tree-trim';
$schemaType = 'งานตัดแต่งต้นไม้';
$dur = '1–3 วัน';
$icon = 'bi-tree';
$img1 = 'https://pub-68154224aa0d447b83de9bf218e76277.r2.dev/images/services/tree-trim/tree-trim-01.webp';
$img2 = 'https://pub-68154224aa0d447b83de9bf218e76277.r2.dev/images/services/tree-trim/tree-trim-02.webp';

$description = 'บริการตัดแต่งต้นไม้โดย บริษัท ธีรพงษ์ เซอร์วิส จำกัด ครอบคลุมตัดแต่งทรงพุ่ม ตัดกิ่งใหญ่ ต้นสูงใกล้สายไฟ และไม้พุ่มแนวรั้ว ทีมงานใช้เครื่องมือและอุปกรณ์นิรภัยมาตรฐาน ให้บริการในกรุงเทพฯ และปริมณฑล ประเมินราคาหน้างานฟรี';

$imgCut = 'https://pub-68154224aa0d447b83de9bf218e76277.r2.dev/images/services/tree-trim/tree-trim-01.webp';
$imgCleanup = 'https://pub-68154224aa0d447b83de9bf218e76277.r2.dev/images/services/tree-trim/tree-trim-02.webp';
$imgHaul = 'https://pub-68154224aa0d447b83de9bf218e76277.r2.dev/images/services/tree-trim/tree-trim-03.webp';

$content = <<<HTML
<div class="blog-content">
<p class="service-kicker"><span class="service-kicker-line"></span>รายละเอียดบริการ</p>

<div class="blog-meta">
  <span><i class="bi bi-pencil-square"></i> โดย ทีมงาน บริษัท ธีรพงษ์ เซอร์วิส จำกัด</span>
  <span><i class="bi bi-calendar-check"></i> อัปเดตล่าสุด 14 ตุลาคม 2569</span>
</div>

<div class="lead">
  <p>งานตัดแต่งต้นไม้โดย บริษัท ธีรพงษ์ เซอร์วิส จำกัด คือบริการตัดแต่งทรงพุ่ม ตัดกิ่งใหญ่ ลดความสูง และจัดรูปทรงต้นไม้ในบ้าน สวน และพื้นที่โครงการ เพื่อความปลอดภัย ความสวยงาม และการระบายแสงลมที่ดีขึ้น ให้บริการในกรุงเทพฯ และปริมณฑล ประเมินราคาหน้างานฟรี</p>
</div>

<figure class="blog-figure">
  <img src="{$imgCut}" alt="ช่างตัดแต่งต้นปาล์มสูงด้วยเลื่อยด้ามยาวบนนั่งร้าน พร้อมหมวกนิรภัย" width="1200" height="800" loading="lazy" decoding="async" class="img-responsive">
  <figcaption>ตัดแต่งต้นสูงใกล้อาคารด้วยนั่งร้านและอุปกรณ์นิรภัย ลดกิ่งแห้งและกิ่งเสี่ยงหัก</figcaption>
</figure>

<h2>งานตัดแต่งต้นไม้คืออะไร ต่างจากถางป่าอย่างไร</h2>
<p>งานตัดแต่งต้นไม้เน้นดูแลต้นไม้ที่มีอยู่แล้วให้ทรงพุ่มสมดุล กิ่งไม่เกะกะ และลดความเสี่ยงกิ่งหักทับบ้านหรือสายไฟ ต่างจากงาน<a href="/clearforest">ถางป่า เคลียร์พื้นที่</a>ที่มุ่งเปิดพื้นที่ใหม่โดยตัดและขุดตอออกจำนวนมาก หากต้องการเคลียร์ที่รกร้างทั้งแปลงควรใช้บริการถางป่า ส่วนบ้านและสวนที่ต้องการเก็บต้นไว้และจัดทรงให้สวย เหมาะกับงานตัดแต่งต้นไม้นี้</p>

<div class="blog-grid">
  <div class="blog-grid-col">
    <figure class="blog-figure">
      <img src="{$imgCleanup}" alt="กิ่งใบหลังตัดแต่งกองบนกระบะพร้อมเลื่อยโซ่และอุปกรณ์เก็บงาน" width="800" height="600" loading="lazy" decoding="async" class="img-responsive">
      <figcaption>เก็บกิ่งใบหลังตัดแต่ง พร้อมขนออกให้พื้นที่เรียบร้อย</figcaption>
    </figure>
  </div>
  <div class="blog-grid-col">
    <figure class="blog-figure">
      <img src="{$imgHaul}" alt="รถกระบะบรรทุกกิ่งไม้และใบไม้ออกจากหน้างาน" width="800" height="600" loading="lazy" decoding="async" class="img-responsive">
      <figcaption>ขนเศษกิ่งใบออกจากหน้างานหลังตัดแต่งเสร็จ</figcaption>
    </figure>
  </div>
</div>

<h2>บริการตัดแต่งต้นไม้ของเราครอบคลุมอะไรบ้าง</h2>
<p>เรารับงานตัดแต่งต้นไม้ทั้งบ้านพัก สวนหมู่บ้าน อาคารสำนักงาน และพื้นที่โครงการ โดยเลือกวิธีตัดตามชนิดไม้ ความสูง และระยะใกล้โครงสร้าง</p>

<div class="service-feature-grid">
  <div class="service-feature-card">
    <h3>ตัดแต่งทรงพุ่ม</h3>
    <p>จัดทรงพุ่มให้สมดุล ลดกิ่งแน่นเกินไป ช่วยให้ต้นไม้แข็งแรงและดูเรียบร้อยเหมาะกับสวนหน้าบ้านและในโครงการ</p>
  </div>
  <div class="service-feature-card">
    <h3>ตัดกิ่งใหญ่ / ต้นสูง</h3>
    <p>ตัดกิ่งที่โยงเข้าหาบ้าน หลังคา สายไฟ หรือถนน ด้วยอุปกรณ์นิรภัยและลำดับการตัดที่ควบคุมทิศทางกิ่งตก</p>
  </div>
  <div class="service-feature-card">
    <h3>ตัดแต่งไม้พุ่มและรั้วเขียว</h3>
    <p>ตัดแต่งไทร ชาดัด ไทรเกาหลี และแนวรั้วเขียวให้ได้ระดับและความหนาแน่นตามที่ต้องการ</p>
  </div>
  <div class="service-feature-card">
    <h3>เก็บกิ่งใบและขนเศษ</h3>
    <p>เก็บกิ่งใบหลังงาน บรรจุและขนออกให้เรียบร้อย หรือประสานต่อด้วย<a href="/shipment">ขนเศษวัสดุ</a>และ<a href="/truck">รถหกล้อ</a>เมื่องานมีปริมาณมาก</p>
  </div>
</div>

<h2>ตัดแต่งต้นไม้ราคาเท่าไหร่</h2>
<div class="lead">
  <p>ราคาตัดแต่งต้นไม้เริ่มต้นประมาณ 800 บาทต่อต้น สำหรับงานเล็กที่เข้าถึงง่าย ราคาจริงขึ้นกับความสูง จำนวนต้น ความยากของตำแหน่ง และปริมาณกิ่งที่ต้องขนออก โดยสรุปในใบเสนอราคาหลังสำรวจหน้างาน</p>
</div>

<div class="table-responsive"><table class="table table-bordered table-striped">
<thead><tr><th>ประเภทงาน</th><th>ราคาเริ่มต้น</th><th>หมายเหตุ</th></tr></thead>
<tbody>
<tr><td>ตัดแต่งต้นไม้ขนาดเล็ก</td><td>800 บาท/ต้น</td><td>สูงไม่เกินประมาณ 4 เมตร เข้าถึงง่าย</td></tr>
<tr><td>ตัดแต่งต้นไม้ขนาดกลาง</td><td>1,500 บาท/ต้น</td><td>ทรงพุ่มหนา หรือต้องใช้บันได/เชือก</td></tr>
<tr><td>ตัดกิ่งใหญ่ / ต้นสูง</td><td>3,500 บาท/ต้น</td><td>ใกล้บ้าน สายไฟ หรือพื้นที่จำกัด</td></tr>
<tr><td>ตัดแต่งไม้พุ่ม / รั้วเขียว</td><td>80 บาท/เมตร</td><td>ขึ้นกับความสูงและความหนาของพุ่ม</td></tr>
<tr><td>แพ็กเกจบ้าน / สวนทั้งแปลง</td><td>ตามประเมิน</td><td>หลายต้นในพื้นที่เดียว มักคุ้มกว่ารายต้น</td></tr>
</tbody>
</table></div>

<h3>ปัจจัยที่ทำให้ราคาต่างกัน</h3>
<ul class="service-checklist">
  <li><i class="bi bi-check-circle-fill"></i><span><strong>ความสูงและขนาดทรงพุ่ม</strong> ต้นสูงและพุ่มหนาใช้เวลาและอุปกรณ์มากกว่า</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>ตำแหน่งต้นไม้</strong> ใกล้สายไฟ หลังคา สระน้ำ หรือรั้วข้างบ้าน ต้องตัดอย่างระมัดระวัง</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>ปริมาณกิ่งที่ต้องขนออก</strong> งานที่มีเศษมากอาจรวมค่าขนทิ้งหรือต่อบริการขนเศษ</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>จำนวนต้นในแปลงเดียวกัน</strong> ตัดหลายต้นพร้อมกันมักได้ราคาต่อต้นที่คุ้มกว่า</span></li>
</ul>

<h2>ขั้นตอนรับงานตัดแต่งต้นไม้</h2>
<ol>
  <li><strong>ติดต่อและส่งรูป</strong> ส่งรูปต้นไม้ ความสูงโดยประมาณ และตำแหน่งใกล้บ้านหรือสายไฟทางโทรศัพท์หรือ LINE</li>
  <li><strong>ประเมินหน้างาน</strong> นัดสำรวจหรือประเมินจากรูป แจ้งขอบเขตงานและใบเสนอราคา (ไม่มีค่าใช้จ่าย)</li>
  <li><strong>นัดวันทำงาน</strong> ยืนยันวันเวลา พื้นที่จอดรถ และจุดทิ้งเศษกิ่งใบ</li>
  <li><strong>ตัดแต่งและเก็บงาน</strong> ทีมงานตัดตามแผน เก็บกิ่งใบ และส่งมอบพื้นที่ให้เรียบร้อย</li>
</ol>

<h2>ทำไมต้องเลือกธีรพงษ์ เซอร์วิส</h2>
<ul class="service-checklist service-checklist--grid">
  <li><i class="bi bi-check-circle-fill"></i><span><strong>ทีมงานพร้อมอุปกรณ์นิรภัย</strong> ตัดกิ่งสูงและใกล้โครงสร้างอย่างเป็นระบบ</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>ประเมินราคาชัดเจนก่อนเริ่ม</strong> แจ้งขอบเขตและราคาหลังดูหน้างานหรือรูปจริง</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>เก็บงานเรียบร้อย</strong> เก็บกิ่งใบและทำความสะอาดพื้นที่โดยรอบหลังตัด</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>ต่อเนื่องกับงานดินได้</strong> หากต้องเคลียร์พื้นที่ต่อเนื่อง เชื่อมกับ<a href="/clearforest">ถางป่า</a> <a href="/landjustment">ปรับพื้นที่</a> หรือ<a href="/garden-plot">ขุดร่องสวน</a>ได้ในที่เดียว</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>เป็นนิติบุคคลจดทะเบียน</strong> มีสำนักงานที่ จ.นนทบุรี — อ่านเพิ่มที่<a href="/about-us">เกี่ยวกับ ธีรพงษ์ เซอร์วิส</a></span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>พื้นที่บริการหลัก</strong> กรุงเทพฯ นนทบุรี ปทุมธานี สมุทรปราการ สมุทรสาคร และนครปฐม</span></li>
</ul>

<div class="alert alert-info">
  <p><strong>หมายเหตุความปลอดภัย:</strong> ต้นไม้ที่พาดสายไฟหรือเสี่ยงล้มควรรีบประเมิน อย่าตัดเองหากกิ่งอยู่สูงหรือใกล้ระบบไฟฟ้า ให้ทีมงานที่มีอุปกรณ์และลำดับการตัดที่เหมาะสมดำเนินการแทน</p>
</div>

<h2>ติดต่อจ้างตัดแต่งต้นไม้</h2>
<p>ส่งรูปต้นไม้และรายละเอียดหน้างานมาให้ทีมงานประเมินเบื้องต้นได้โดยไม่มีค่าใช้จ่าย หรือโทรนัดสำรวจหน้างาน</p>
<ul>
  <li><strong>โทร:</strong> 061-563-9228</li>
  <li><strong>LINE Official:</strong> @theeraphong</li>
  <li><strong>สำนักงาน:</strong> 14 หมู่ 5 ต.บางกร่าง อ.เมืองนนทบุรี จ.นนทบุรี 11000</li>
  <li><strong>เวลาทำการ:</strong> จันทร์–เสาร์ 8:00–18:00 น.</li>
  <li><strong>พื้นที่ให้บริการ:</strong> กรุงเทพฯ และปริมณฑล</li>
</ul>
<p>ดู<a href="/galleries">คลังผลงาน</a> หรือ<a href="/contact-us">ติดต่อเรา</a>เพื่อนัดประเมินหน้างาน</p>
</div>
HTML;

$faqs = [
    [
        'question' => 'ตัดแต่งต้นไม้ราคาเท่าไหร่',
        'answer' => 'ราคาเริ่มต้นประมาณ 800 บาทต่อต้นสำหรับงานเล็กที่เข้าถึงง่าย ต้นขนาดกลางเริ่มราว 1,500 บาท และงานตัดกิ่งใหญ่หรือต้นสูงเริ่มราว 3,500 บาท ราคาจริงขึ้นกับความสูง ตำแหน่ง และปริมาณกิ่งที่ต้องขนออก ซึ่งจะสรุปหลังประเมินหน้างาน',
        'sort_order' => 1,
    ],
    [
        'question' => 'ตัดแต่งต้นไม้ใช้เวลากี่วัน',
        'answer' => 'งานบ้านทั่วไปมักใช้เวลา 1–3 วัน ขึ้นกับจำนวนต้น ความสูง และปริมาณกิ่งที่ต้องขนออก งานหลายต้นในแปลงเดียวกันอาจนัดเป็นรอบเพื่อให้พื้นที่พร้อมใช้งานเร็วที่สุด',
        'sort_order' => 2,
    ],
    [
        'question' => 'ตัดแต่งต้นไม้กับถางป่าต่างกันอย่างไร',
        'answer' => 'ตัดแต่งต้นไม้เน้นเก็บต้นไว้และจัดทรงให้สวย ปลอดภัย ส่วนถางป่าคือการเคลียร์พื้นที่โดยตัดและขุดตอออกเพื่อเตรียมก่อสร้างหรือเกษตร หากต้องการเปิดพื้นที่ใหม่ทั้งแปลงควรใช้บริการถางป่า',
        'sort_order' => 3,
    ],
    [
        'question' => 'รับตัดต้นไม้ใกล้สายไฟไหม',
        'answer' => 'รับประเมินและตัดกิ่งที่ใกล้สายไฟหรือโครงสร้าง โดยใช้ลำดับการตัดและอุปกรณ์นิรภัยที่เหมาะสม กรณีเสี่ยงสูงทีมงานจะแจ้งขอบเขตงานและวิธีทำงานให้ชัดเจนก่อนเริ่ม',
        'sort_order' => 4,
    ],
    [
        'question' => 'ต้องขนกิ่งใบออกเองไหม',
        'answer' => 'โดยปกติทีมงานเก็บกิ่งใบหลังตัดให้เรียบร้อย และสามารถรวมค่าขนทิ้งในใบเสนอราคาได้ งานที่มีปริมาณเศษมากอาจต่อด้วยบริการขนเศษวัสดุหรือรถหกล้อ',
        'sort_order' => 5,
    ],
    [
        'question' => 'รับงานตัดแต่งต้นไม้ต่างจังหวัดไหม',
        'answer' => 'ให้บริการหลักในกรุงเทพฯ และปริมณฑล สำหรับต่างจังหวัดรับพิจารณาตามขนาดงานและระยะทาง ลูกค้าส่งรูปและตำแหน่งมาประเมินเบื้องต้นทาง LINE หรือโทร 061-563-9228 ได้ก่อน',
        'sort_order' => 6,
    ],
];

$prices = [
    [
        'sku' => 'TREE-SMALL',
        'name' => 'ตัดแต่งต้นไม้ขนาดเล็ก',
        'description' => 'สูงไม่เกินประมาณ 4 เมตร เข้าถึงง่าย',
        'price_type' => 'starting_at',
        'price' => 800,
        'max_price' => null,
        'unit' => 'ต้น',
        'sort_order' => 1,
    ],
    [
        'sku' => 'TREE-MEDIUM',
        'name' => 'ตัดแต่งต้นไม้ขนาดกลาง',
        'description' => 'ทรงพุ่มหนา หรือต้องใช้บันได/เชือก',
        'price_type' => 'starting_at',
        'price' => 1500,
        'max_price' => null,
        'unit' => 'ต้น',
        'sort_order' => 2,
    ],
    [
        'sku' => 'TREE-LARGE',
        'name' => 'ตัดกิ่งใหญ่ / ต้นสูง',
        'description' => 'ใกล้บ้าน สายไฟ หรือพื้นที่จำกัด',
        'price_type' => 'starting_at',
        'price' => 3500,
        'max_price' => null,
        'unit' => 'ต้น',
        'sort_order' => 3,
    ],
    // ตัดแต่งไม้พุ่ม 80 บาท/เมตร อยู่ในตารางเนื้อหาแล้ว — ไม่ใส่ใน service_prices
    // เพื่อไม่ให้ activePrice แสดงเป็นราคาเริ่มต้นของบริการ
];

$scopes = config('frontend.service_scopes.tree-trim', [
    ['name' => 'สำรวจต้นไม้และประเมินความเสี่ยง', 'group' => 'included'],
    ['name' => 'ตัดแต่งทรงพุ่มและกิ่งก้าน', 'group' => 'type'],
    ['name' => 'ตัดกิ่งใหญ่ / ต้นสูงใกล้สายไฟ', 'group' => 'type'],
    ['name' => 'ตัดแต่งไม้พุ่มและแนวรั้วเขียว', 'group' => 'type'],
    ['name' => 'เก็บกิ่งใบและขนเศษออก', 'group' => 'included'],
    ['name' => 'ทีมงานพร้อมอุปกรณ์นิรภัย', 'group' => 'included'],
    ['name' => 'ประเมินราคาหน้างานฟรี', 'group' => 'included'],
    ['name' => 'บริการครอบคลุม กทม. และปริมณฑล', 'group' => 'included'],
]);

DB::transaction(function () use (
    $title,
    $slug,
    $metaTitle,
    $metaDes,
    $h1,
    $description,
    $content,
    $schemaType,
    $dur,
    $icon,
    $img1,
    $img2,
    $faqs,
    $prices,
    $scopes
) {
    $category = ServiceCategory::query()->firstOrCreate(
        ['slug' => 'earthwork'],
        ['name' => 'งานดินและเตรียมพื้นที่']
    );

    $service = Service::query()->updateOrCreate(
        ['slug' => $slug],
        [
            'service_category_id' => $category->id,
            'title' => $title,
            'meta_title' => $metaTitle,
            'meta_des' => $metaDes,
            'h1' => $h1,
            'description' => $description,
            'content' => $content,
            'schema_type' => $schemaType,
            'is_active' => true,
            'icon_name' => $icon,
            'dur' => $dur,
            'img_1' => $img1,
            'img_2' => $img2,
            'rating_value' => 5,
            'review_count' => 0,
        ]
    );

    Faq::query()->where('service_id', $service->id)->delete();
    foreach ($faqs as $faq) {
        Faq::query()->create([
            'service_id' => $service->id,
            'question' => $faq['question'],
            'answer' => $faq['answer'],
            'sort_order' => $faq['sort_order'],
            'is_active' => true,
        ]);
    }

    ServicePrice::query()->where('service_id', $service->id)->delete();
    foreach ($prices as $row) {
        ServicePrice::query()->create([
            'service_id' => $service->id,
            'sku' => $row['sku'],
            'name' => $row['name'],
            'description' => $row['description'],
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
    foreach ($scopes as $index => $scope) {
        ServiceScope::query()->create([
            'service_id' => $service->id,
            'name' => $scope['name'],
            'group' => $scope['group'],
            'sort_order' => $index + 1,
            'is_active' => true,
        ]);
    }

    echo "OK service #{$service->id} {$service->slug}\n";
    echo "category #{$category->id} {$category->slug}\n";
});

$service = Service::query()->where('slug', $slug)->with(['faqs', 'prices', 'scopes', 'category'])->firstOrFail();

echo 'meta_title len='.mb_strlen((string) $service->meta_title)."\n";
echo 'meta_des len='.mb_strlen((string) $service->meta_des)."\n";
echo 'content len='.strlen((string) $service->content)."\n";
echo 'faqs='.$service->faqs->count()."\n";
echo 'prices='.$service->prices->count()."\n";
echo 'scopes='.$service->scopes->count()."\n";
echo 'activePrice='.($service->activePrice?->name ?? 'none').' '.$service->activePrice?->price.'/'.$service->activePrice?->unit."\n";
echo 'phone='.\App\Support\CompanyPhone::forService($service)['phone_formatted']."\n";
echo 'img_count='.substr_count((string) $service->content, '<img ')."\n";
