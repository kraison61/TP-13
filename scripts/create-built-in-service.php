<?php

/**
 * Create hub service page "บิ้วอิน" (/built-in) in database.sqlite
 * Source: built-in-service-page.md (11 ต.ค. 2569)
 *
 * Notes:
 * - Skips MOCK portfolio section until real cases exist
 * - Warranty follows confirmed real data in package: 1 ปี
 * - Why-choose bullet uses 1 ปี (not unresolved 6-month draft note)
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

$metaTitle = 'บิ้วอิน ออกแบบและผลิตเอง รับประกัน 1 ปี กทม. | ธีรพงษ์เซอร์วิส';
$metaDes = 'รับทำบิ้วอินห้องนอน ตู้เสื้อผ้า ชั้นวางทีวี ครัว และคอนโด ออกแบบและผลิตเองโดยธีรพงษ์ เซอร์วิส กรุงเทพฯ ปริมณฑล รับประกัน 1 ปี โทร 061-563-9228';
$h1 = 'รับทำบิ้วอิน ออกแบบและผลิตเองทุกชิ้น กรุงเทพฯ และปริมณฑล';
$title = 'บิ้วอิน';
$slug = 'built-in';
$schemaType = 'บิ้วอิน';
$dur = '30–45 วัน';
$icon = 'bi-door-open';
$imgBase = 'https://pub-68154224aa0d447b83de9bf218e76277.r2.dev/images/services/built-in';
$img1 = "{$imgBase}/491051_0.webp"; // ตู้เต็มผนัง ช่องไฟ LED
$img2 = "{$imgBase}/491052_0.webp"; // ผนังทีวี + ชั้นวาง
$imgHero = "{$imgBase}/491051_0.webp";
$imgTv = "{$imgBase}/491052_0.webp";
$imgBedroom = "{$imgBase}/491053_0.webp"; // โต๊ะเครื่องแป้ง + ตู้
$imgKitchen = "{$imgBase}/491056_0.webp"; // ครัว/เคาน์เตอร์
$imgShelf = "{$imgBase}/491058_0.webp"; // ชั้นลอยมุมห้อง
$imgLiving = "{$imgBase}/491060_0.webp"; // ผนังทีวี/ตู้เก็บของ
$imgWardrobe = "{$imgBase}/491062_0.webp"; // ตู้เสื้อผ้าเปิดบาน
$imgDrawer = "{$imgBase}/491064_0.webp"; // ลิ้นชัก/รางเลื่อน
$imgDining = "{$imgBase}/491068_0.webp"; // บิ้วอินโซนทานอาหาร
$imgCloset = "{$imgBase}/491070_0.webp"; // ภายในตู้เสื้อผ้า

$description = 'บิ้วอินโดย บริษัท ธีรพงษ์ เซอร์วิส จำกัด คือบริการออกแบบและผลิตเฟอร์นิเจอร์สั่งทำให้พอดีกับพื้นที่จริง ทั้งห้องนอน ตู้เสื้อผ้า ชั้นวางทีวี ครัว และคอนโด เราออกแบบและผลิตเองทุกขั้นตอน ให้บริการในกรุงเทพฯ และปริมณฑลเป็นหลัก รับประกันงาน 1 ปี และค่าสำรวจหน้างานเริ่มต้น 1,500 บาท นำมาหักเป็นส่วนลดได้เมื่อตกลงจ้าง';

$content = <<<HTML
<div class="blog-content">
<p class="service-kicker"><span class="service-kicker-line"></span>รายละเอียดบริการ</p>

<div class="blog-meta">
  <span><i class="bi bi-pencil-square"></i> โดย ทีมงาน บริษัท ธีรพงษ์ เซอร์วิส จำกัด</span>
  <span><i class="bi bi-calendar-check"></i> อัปเดตล่าสุด 14 ตุลาคม 2569</span>
</div>

<div class="lead">
  <p>บิ้วอินโดย บริษัท ธีรพงษ์ เซอร์วิส จำกัด คือบริการออกแบบและผลิตเฟอร์นิเจอร์สั่งทำให้พอดีกับพื้นที่จริง ทั้งห้องนอน ตู้เสื้อผ้า ชั้นวางทีวี ครัว และคอนโด เราออกแบบและผลิตเองทุกขั้นตอน ให้บริการในกรุงเทพฯ และปริมณฑลเป็นหลัก รับประกันงาน 1 ปี และค่าสำรวจหน้างานเริ่มต้น 1,500 บาท นำมาหักเป็นส่วนลดได้เมื่อตกลงจ้าง</p>
</div>

<figure class="blog-figure">
  <img src="{$imgHero}" alt="ตู้บิ้วอินเต็มผนังโทนเทาและลายไม้ พร้อมช่องไฟ LED" width="900" height="1200" loading="lazy" decoding="async" class="img-responsive">
  <figcaption>ตู้บิ้วอินเต็มความสูงถึงเพดาน พร้อมช่องไฟ LED และผิวลายไม้ ใช้พื้นที่เต็มผนังไม่มีช่องว่างสะสมฝุ่น</figcaption>
</figure>

<h2>บิ้วอินคืออะไร ต่างจากเฟอร์นิเจอร์ลอยตัวอย่างไร</h2>
<p>บิ้วอิน (Built-in) คือเฟอร์นิเจอร์ที่ออกแบบและผลิตตามขนาดพื้นที่จริง แล้วติดตั้งยึดกับผนัง พื้น หรือเพดาน จึงใช้พื้นที่ได้เต็มทุกมุมและไม่มีช่องว่างสะสมฝุ่น ต่างจากเฟอร์นิเจอร์ลอยตัวที่ผลิตขนาดมาตรฐานสำเร็จรูป ย้ายได้ แต่มักเหลือช่องว่างรอบตัวตู้</p>

<div class="table-responsive"><table class="table table-bordered table-striped">
<thead><tr><th>หัวข้อเปรียบเทียบ</th><th>บิ้วอิน</th><th>เฟอร์นิเจอร์ลอยตัว</th></tr></thead>
<tbody>
<tr><td>ขนาด</td><td>สั่งทำพอดีพื้นที่ รวมมุมเสา คาน และใต้บันได</td><td>ขนาดมาตรฐาน เลือกได้จำกัด</td></tr>
<tr><td>การใช้พื้นที่</td><td>เต็มความสูงถึงเพดาน ไม่มีช่องว่าง</td><td>มักเหลือช่องว่างด้านบนและด้านข้าง</td></tr>
<tr><td>การเคลื่อนย้าย</td><td>ย้ายไม่ได้หรือย้ายยาก</td><td>ย้ายตามได้เมื่อเปลี่ยนที่อยู่</td></tr>
<tr><td>ระยะเวลา</td><td>ต้องรอออกแบบและผลิต</td><td>ซื้อแล้วใช้ได้ทันที</td></tr>
<tr><td>งบประมาณ</td><td>สูงกว่า ขึ้นกับวัสดุและขนาด</td><td>ต่ำกว่าในขนาดใกล้เคียงกัน</td></tr>
<tr><td>เหมาะกับ</td><td>บ้านและคอนโดที่อยู่ระยะยาว พื้นที่จำกัดหรือรูปทรงไม่ปกติ</td><td>ห้องเช่า หรือผู้ที่ย้ายที่อยู่บ่อย</td></tr>
</tbody>
</table></div>

<h2>บริการบิ้วอินและตกแต่งภายในของเราครอบคลุมอะไรบ้าง</h2>
<p>เรารับงานบิ้วอินทั้งแบบชิ้นเดียวและงานตกแต่งภายในทั้งห้องหรือทั้งหลัง โดยออกแบบและผลิตเองทุกชิ้น งานที่ลูกค้าสั่งทำบ่อยมีดังนี้</p>

<div class="service-feature-grid">
  <div class="service-feature-card">
    <h3>บิ้วอินห้องนอน</h3>
    <p>ออกแบบห้องนอนทั้งชุดให้เข้ากันเป็นงานเดียว ได้แก่ หัวเตียง ตู้ข้างเตียง โต๊ะเครื่องแป้ง โต๊ะทำงาน และตู้เก็บของเหนือศีรษะ วางตำแหน่งปลั๊กและสวิตช์ให้ใช้งานจากเตียงได้สะดวกตั้งแต่ขั้นออกแบบ</p>
  </div>
  <div class="service-feature-card">
    <h3>บิ้วอินตู้เสื้อผ้า</h3>
    <p>ตู้เสื้อผ้าเต็มความสูงถึงเพดาน เลือกได้ทั้งบานเปิด บานเลื่อน และแบบวอล์กอินโคลเซ็ต จัดสัดส่วนราวแขวน ลิ้นชัก และชั้นพับผ้าตามจำนวนและประเภทเสื้อผ้าของผู้ใช้จริง</p>
  </div>
  <div class="service-feature-card">
    <h3>บิ้วอินชั้นวางทีวี</h3>
    <p>ชั้นวางทีวีและผนังตกแต่งหลังทีวี ซ่อนสายไฟ สายสัญญาณ และกล่องรับสัญญาณไว้ในตัวตู้ เผื่อช่องระบายความร้อนและเผื่อขนาดทีวีเครื่องใหม่ในอนาคต</p>
  </div>
  <div class="service-feature-card">
    <h3>บิ้วอินครัว</h3>
    <p>ชุดครัวบิ้วอินทั้งตู้ล่าง ตู้แขวน และไอส์แลนด์ วางผังตามลำดับเก็บ ล้าง เตรียม และปรุง เลือกวัสดุทนความชื้นในโซนอ่าง และเว้นช่องตามรุ่นเครื่องใช้ไฟฟ้า</p>
  </div>
</div>

<figure class="blog-figure">
  <img src="{$imgBedroom}" alt="บิ้วอินห้องนอนโต๊ะเครื่องแป้งพร้อมกระจกและตู้เก็บของลายไม้" width="1200" height="800" loading="lazy" decoding="async" class="img-responsive">
  <figcaption>บิ้วอินห้องนอนชุดเดียว ทั้งตู้เก็บของ โต๊ะเครื่องแป้ง และชั้นวางข้างกระจก</figcaption>
</figure>

<div class="blog-grid">
  <div class="blog-grid-col">
    <figure class="blog-figure">
      <img src="{$imgWardrobe}" alt="ตู้เสื้อผ้าบิ้วอินลายไม้เปิดบานเห็นชั้นวางด้านใน" width="800" height="1000" loading="lazy" decoding="async" class="img-responsive">
      <figcaption>ตู้เสื้อผ้าบิ้วอินลายไม้สูงถึงเพดาน เปิดบานเห็นชั้นวางและมุมโต๊ะแต่งหน้าในชุดเดียวกัน</figcaption>
    </figure>
  </div>
  <div class="blog-grid-col">
    <figure class="blog-figure">
      <img src="{$imgCloset}" alt="ภายในตู้เสื้อผ้าบิ้วอินจัดราวแขวนลิ้นชักและชั้นวาง" width="800" height="1000" loading="lazy" decoding="async" class="img-responsive">
      <figcaption>ภายในตู้เสื้อผ้าจัดสัดส่วนราวแขวน ลิ้นชัก และชั้นวางตามจำนวนเสื้อผ้าจริง</figcaption>
    </figure>
  </div>
</div>

<figure class="blog-figure">
  <img src="{$imgTv}" alt="ผนังทีวีบิ้วอินโทนขาวพร้อมชั้นวางเปิดและตู้เก็บของ" width="900" height="1200" loading="lazy" decoding="async" class="img-responsive">
  <figcaption>ผนังทีวีบิ้วอินพร้อมตู้เก็บของและชั้นวางเปิด ซ่อนสายไฟได้เรียบร้อย</figcaption>
</figure>

<figure class="blog-figure">
  <img src="{$imgKitchen}" alt="ชุดครัวบิ้วอินลายไม้พร้อมท็อปขาวมุมโค้ง" width="1200" height="900" loading="lazy" decoding="async" class="img-responsive">
  <figcaption>ชุดครัวและเคาน์เตอร์บิ้วอิน ท็อปขาวมุมโค้ง ปิดผิวลายไม้ให้เข้ากับพื้นที่จริง</figcaption>
</figure>

<h3>บิ้วอินคอนโดและพื้นที่จำกัด</h3>
<p>งานบิ้วอินคอนโดทั้งห้อง เน้นใช้พื้นที่จำกัดให้คุ้มที่สุด เช่น ตู้เก็บของเต็มผนัง เตียงมีลิ้นชัก และโต๊ะพับเก็บได้ ทีมงานประสานนิติบุคคลเรื่องเวลาเข้าทำงาน การขนของขึ้นลิฟต์ และเงินประกันความเสียหายตามระเบียบของแต่ละอาคาร</p>

<div class="blog-grid">
  <div class="blog-grid-col">
    <figure class="blog-figure">
      <img src="{$imgShelf}" alt="ชั้นวางลอยบิ้วอินลายไม้มุมห้อง" width="800" height="1000" loading="lazy" decoding="async" class="img-responsive">
      <figcaption>ชั้นวางลอยบิ้วอินมุมห้อง ใช้พื้นที่แคบให้คุ้มโดยไม่กินพื้นที่เดิน</figcaption>
    </figure>
  </div>
  <div class="blog-grid-col">
    <figure class="blog-figure">
      <img src="{$imgLiving}" alt="ผนังบิ้วอินห้องนั่งเล่นพร้อมชั้นวางไฟ LED" width="800" height="1000" loading="lazy" decoding="async" class="img-responsive">
      <figcaption>ผนังบิ้วอินห้องนั่งเล่น ตู้เก็บของเต็มผนังพร้อมชั้นวางและไฟ LED ในตัว</figcaption>
    </figure>
  </div>
</div>

<h3>งานบิ้วอินและตกแต่งภายในประเภทอื่น</h3>
<p>รับงานออฟฟิศ ร้านค้า เคาน์เตอร์ ตู้รองเท้า ชั้นหนังสือ มุมทานอาหาร ห้องทำงาน และงานตกแต่งภายในทั้งหลัง</p>

<figure class="blog-figure">
  <img src="{$imgDining}" alt="บิ้วอินโซนทานอาหารตู้เก็บของเต็มผนังพร้อมชั้นวางซุ้มโค้ง" width="1200" height="800" loading="lazy" decoding="async" class="img-responsive">
  <figcaption>บิ้วอินโซนทานอาหาร ตู้เก็บของเต็มผนังพร้อมช่องวางของและชั้นวางซุ้มโค้ง เชื่อมต่อครัวได้อย่างต่อเนื่อง</figcaption>
</figure>

<h2>บิ้วอินราคาเท่าไหร่</h2>
<div class="lead">
  <p>บิ้วอินราคาเริ่มต้นประมาณ 13,000 บาทต่อเมตร ขึ้นกับประเภทงาน วัสดุโครงตู้ วัสดุปิดผิว และอุปกรณ์ที่เลือก โดยคิดตามความยาวหน้าตู้เป็นเมตร ราคาที่แน่นอนจะระบุในใบเสนอราคาแยกรายการ หลังสำรวจหน้างานและสรุปแบบแล้ว</p>
</div>

<div class="table-responsive"><table class="table table-bordered table-striped">
<thead><tr><th>ประเภทงาน</th><th>ราคาเริ่มต้น</th><th>หมายเหตุ</th></tr></thead>
<tbody>
<tr><td>บิ้วอินชั้นวางทีวี</td><td>13,000 บาท/เมตร</td><td>ไม่รวมผนังตกแต่งหลังทีวี</td></tr>
<tr><td>บิ้วอินตู้เสื้อผ้า</td><td>31,000 บาท/เมตร</td><td>สูงไม่เกิน 2.6 เมตร บานเปิด</td></tr>
<tr><td>บิ้วอินครัว</td><td>16,500 บาท/เมตร</td><td>ไม่รวมท็อปและเครื่องใช้ไฟฟ้า</td></tr>
<tr><td>บิ้วอินห้องนอนทั้งห้อง</td><td>99,000–214,500 บาท/ห้อง</td><td>ขึ้นกับจำนวนชิ้นงาน</td></tr>
<tr><td>บิ้วอินคอนโด 1 ห้องนอน</td><td>165,000–385,000 บาท/ห้อง</td><td>พื้นที่ 30–35 ตร.ม.</td></tr>
</tbody>
</table></div>

<h3>ปัจจัยที่ทำให้ราคาบิ้วอินต่างกัน</h3>
<ul class="service-checklist">
  <li><i class="bi bi-check-circle-fill"></i><span><strong>วัสดุโครงตู้</strong> ไม้อัดราคาสูงกว่าพาร์ติเคิลบอร์ด แต่แข็งแรงและยึดสกรูได้ดีกว่า</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>วัสดุปิดผิว</strong> ผิวไฮกลอสและวีเนียร์ไม้จริงราคาสูงกว่าเมลามีนและลามิเนต</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>อุปกรณ์</strong> บานพับและรางลิ้นชักแบบปิดนุ่มนวล ไฟ LED ในตู้ และอุปกรณ์จัดเก็บพิเศษ</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>ความซับซ้อนของแบบ</strong> งานโค้ง งานเข้ามุมเสาและคาน และงานที่สูงเกินมาตรฐาน</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>สภาพหน้างาน</strong> งานคอนโดชั้นสูงหรืออาคารที่จำกัดเวลาทำงาน มีค่าขนย้ายและค่าอาจเพิ่ม</span></li>
</ul>

<p><strong>ค่าสำรวจหน้างาน</strong> เริ่มต้น 1,500 บาท ครอบคลุมการวัดพื้นที่จริงและให้คำปรึกษาเบื้องต้น เมื่อตกลงจ้าง ค่าสำรวจนี้นำมาหักเป็นส่วนลดจากค่างานได้</p>

<h2>วัสดุบิ้วอินมีอะไรให้เลือกบ้าง</h2>
<p>วัสดุบิ้วอินแบ่งเป็น 2 ส่วน คือ วัสดุโครงตู้ ได้แก่ พาร์ติเคิลบอร์ด MDF หรือ HMR และไม้อัด กับวัสดุปิดผิว ได้แก่ เมลามีน ลามิเนต ไฮกลอส และวีเนียร์ เราใช้วัสดุหลากหลายและแนะนำตามจุดใช้งานและงบประมาณของลูกค้า โดยระบุชนิดและความหนาไว้ในใบเสนอราคาทุกครั้ง</p>

<figure class="blog-figure">
  <img src="{$imgDrawer}" alt="ลิ้นชักบิ้วอินโทนเทาเปิดเห็นรางเลื่อนและท็อปขาว" width="1200" height="900" loading="lazy" decoding="async" class="img-responsive">
  <figcaption>ลิ้นชักและรางเลื่อนคุณภาพสูง พร้อมท็อปเรียบเนียน ช่วยให้งานบิ้วอินใช้งานนุ่มนวลและทนทาน</figcaption>
</figure>

<div class="table-responsive"><table class="table table-bordered table-striped">
<thead><tr><th>วัสดุโครงตู้</th><th>จุดเด่น</th><th>ข้อจำกัด</th><th>เหมาะกับ</th></tr></thead>
<tbody>
<tr><td>พาร์ติเคิลบอร์ด</td><td>ราคาประหยัด น้ำหนักเบา</td><td>ไม่ทนความชื้น รับน้ำหนักได้น้อยกว่า</td><td>ตู้ในห้องแห้ง งบจำกัด</td></tr>
<tr><td>MDF / HMR</td><td>ผิวเรียบ ทำสีและปิดผิวได้สวย โดย HMR ทนความชื้นกว่า MDF ทั่วไป</td><td>น้ำหนักมาก</td><td>บานตู้ และโครงตู้โซนชื้น เช่น ครัว</td></tr>
<tr><td>ไม้อัด (Plywood)</td><td>แข็งแรง ยึดสกรูแน่น ทนชื้นได้ดีกว่า</td><td>ราคาสูงกว่า</td><td>ตู้ครัว ตู้เสื้อผ้า และงานที่รับน้ำหนักมาก</td></tr>
</tbody>
</table></div>

<h2>ขั้นตอนทำบิ้วอินมีอะไรบ้าง ใช้เวลากี่วัน</h2>
<div class="lead">
  <p>งานบิ้วอินมี 6 ขั้นตอน ตั้งแต่ปรึกษาจนถึงส่งมอบ ใช้เวลารวมประมาณ 30–45 วัน สำหรับงาน 1 ห้อง โดยขั้นตอนที่ใช้เวลามากที่สุดคือการผลิตชิ้นงาน ส่วนการติดตั้งหน้างานใช้เวลาเพียงไม่กี่วัน</p>
</div>

<ol>
  <li><strong>ปรึกษาเบื้องต้น</strong> แจ้งความต้องการ ขนาดห้องโดยประมาณ และงบประมาณ ทางโทรศัพท์หรือ LINE (ไม่มีค่าใช้จ่าย)</li>
  <li><strong>สำรวจและวัดหน้างาน</strong> นัดวัดพื้นที่จริงภายใน 3 วัน ค่าสำรวจเริ่มต้น 1,500 บาท หักเป็นส่วนลดได้เมื่อตกลงจ้าง</li>
  <li><strong>ออกแบบและเสนอราคา</strong> ส่งแบบพร้อมใบเสนอราคาแยกรายการภายใน 5–7 วัน</li>
  <li><strong>ยืนยันแบบและทำสัญญา</strong> สรุปวัสดุ สี และอุปกรณ์ แบ่งชำระ 3 งวด คือ 50% เมื่อทำสัญญา 40% ก่อนติดตั้ง และ 10% เมื่อส่งมอบ</li>
  <li><strong>ผลิตชิ้นงาน</strong> ผลิตเองโดยทีมช่างของบริษัท ใช้เวลา 20–30 วัน</li>
  <li><strong>ติดตั้งและส่งมอบ</strong> ติดตั้งหน้างาน 2–5 วัน ตรวจรับงานร่วมกับลูกค้า และเริ่มนับระยะรับประกัน 1 ปี</li>
</ol>

<h2>ทำไมต้องเลือกธีรพงษ์ เซอร์วิส</h2>
<ul class="service-checklist service-checklist--grid">
  <li><i class="bi bi-check-circle-fill"></i><span><strong>ออกแบบและผลิตเอง</strong> ทีมที่ออกแบบและทีมที่ผลิตอยู่ในบริษัทเดียวกัน ลูกค้าคุยกับผู้รับผิดชอบงานโดยตรง ไม่ผ่านคนกลาง</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>ราคาแยกรายการ</strong> ใบเสนอราคาระบุวัสดุ ขนาด และอุปกรณ์ทุกรายการ ลูกค้ารู้ว่าจ่ายค่าอะไรก่อนเริ่มงาน</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>ค่าสำรวจไม่สูญเปล่า</strong> ค่าสำรวจหน้างานเริ่มต้น 1,500 บาท นำมาหักเป็นส่วนลดได้เมื่อตกลงจ้าง</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>รับประกันงาน 1 ปี</strong> นับจากวันส่งมอบ</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>มีทีมงานระบบไฟฟ้าในบริษัท</strong> งานไฟซ่อนในตู้ ปลั๊ก และสวิตช์ที่ต้องย้ายตามแบบบิ้วอิน ทำโดยทีม<a href="/electrical-wiring">เดินสายไฟฟ้า</a>ของบริษัทเอง</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>เป็นนิติบุคคลจดทะเบียน</strong> มีสำนักงานที่ จ.นนทบุรี ทำสัญญาเป็นลายลักษณ์อักษรทุกงาน — อ่านเพิ่มที่<a href="/about-us">เกี่ยวกับ ธีรพงษ์ เซอร์วิส</a></span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>ประสบการณ์ทำงาน</strong> มากกว่า 30 ปี</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>เฉลี่ยจำนวนงาน</strong> 20 งาน/ปี</span></li>
</ul>

<h2>ติดต่อปรึกษางานบิ้วอิน</h2>
<p>ส่งขนาดห้อง รูปถ่ายพื้นที่ และแบบที่ชอบมาให้ทีมงานประเมินเบื้องต้นได้โดยไม่มีค่าใช้จ่าย หรือโทรนัดสำรวจหน้างาน (ค่าสำรวจเริ่มต้น 1,500 บาท หักเป็นส่วนลดได้เมื่อตกลงจ้าง)</p>
<ul>
  <li><strong>โทร:</strong> 061-563-9228</li>
  <li><strong>LINE Official:</strong> @theeraphong</li>
  <li><strong>สำนักงาน:</strong> 14 หมู่ 5 ต.บางกร่าง อ.เมืองนนทบุรี จ.นนทบุรี 11000</li>
  <li><strong>เวลาทำการ:</strong> จันทร์–เสาร์ 8:00–18:00 น.</li>
  <li><strong>พื้นที่ให้บริการ:</strong> กรุงเทพฯ นนทบุรี ปทุมธานี สมุทรปราการ สมุทรสาคร และนครปฐม รับงานทั่วประเทศสำหรับโครงการมูลค่าสูง</li>
</ul>
<p>ดู<a href="/galleries">คลังผลงาน</a> หรือ<a href="/contact-us">ติดต่อเรา</a>เพื่อนัดสำรวจหน้างาน</p>
</div>
HTML;

$faqs = [
    [
        'question' => 'บิ้วอินราคาเมตรละเท่าไหร่',
        'answer' => 'บิ้วอินราคาเริ่มต้นประมาณ 13,000 บาทต่อเมตร โดยชั้นวางทีวีเริ่มต้นต่ำที่สุด ตู้เสื้อผ้าอยู่ระดับกลาง และครัวสูงที่สุดเพราะต้องใช้วัสดุทนความชื้น ราคาจริงขึ้นกับวัสดุโครงตู้ วัสดุปิดผิว อุปกรณ์ และความซับซ้อนของแบบ ซึ่งจะระบุในใบเสนอราคาแยกรายการ',
        'sort_order' => 1,
    ],
    [
        'question' => 'ทำบิ้วอินใช้เวลากี่วัน',
        'answer' => 'งานบิ้วอิน 1 ห้องใช้เวลารวมประมาณ 30–45 วัน แบ่งเป็นออกแบบและเสนอราคา 5–7 วัน ผลิตชิ้นงาน 20–30 วัน และติดตั้งหน้างาน 2–5 วัน งานทั้งหลังหรืองานที่มีรายละเอียดมากจะใช้เวลานานกว่านี้ โดยระบุกำหนดส่งมอบไว้ในสัญญา',
        'sort_order' => 2,
    ],
    [
        'question' => 'ค่าสำรวจหน้างานบิ้วอินเท่าไหร่',
        'answer' => 'ค่าสำรวจหน้างานบิ้วอินเริ่มต้น 1,500 บาท ครอบคลุมการวัดพื้นที่จริงและให้คำปรึกษาเบื้องต้น เมื่อลูกค้าตกลงจ้างงาน ค่าสำรวจนี้นำมาหักเป็นส่วนลดจากค่างานได้ ส่วนการปรึกษาเบื้องต้นทางโทรศัพท์หรือ LINE ไม่มีค่าใช้จ่าย',
        'sort_order' => 3,
    ],
    [
        'question' => 'บิ้วอินรับประกันกี่ปี',
        'answer' => 'งานบิ้วอินของ บริษัท ธีรพงษ์ เซอร์วิส จำกัด รับประกัน 1 ปี นับจากวันส่งมอบงาน หากพบปัญหาจากการผลิตหรือการติดตั้งภายในระยะรับประกัน แจ้งทีมงานได้ทางโทรศัพท์ 061-563-9228 เพื่อนัดเข้าตรวจสอบและแก้ไข',
        'sort_order' => 4,
    ],
    [
        'question' => 'บิ้วอินกับเฟอร์นิเจอร์ลอยตัว แบบไหนดีกว่า',
        'answer' => 'บิ้วอินเหมาะกับผู้ที่อยู่อาศัยระยะยาวและต้องการใช้พื้นที่เต็มทุกมุม เพราะสั่งทำพอดีกับห้องและสูงถึงเพดานได้ ส่วนเฟอร์นิเจอร์ลอยตัวเหมาะกับห้องเช่าหรือผู้ที่ย้ายที่อยู่บ่อย เพราะราคาต่ำกว่าและย้ายตามได้ หลายบ้านเลือกผสมกัน โดยทำบิ้วอินเฉพาะตู้เก็บของและครัว',
        'sort_order' => 5,
    ],
    [
        'question' => 'รับทำบิ้วอินต่างจังหวัดไหม',
        'answer' => 'เราให้บริการบิ้วอินในกรุงเทพฯ และปริมณฑลเป็นหลัก สำหรับต่างจังหวัด รับงานทั่วประเทศในกรณีที่เป็นโครงการมูลค่าสูง เช่น งานตกแต่งภายในทั้งหลังหรืองานโครงการ ลูกค้าต่างจังหวัดส่งแบบแปลนและรูปถ่ายพื้นที่มาให้ประเมินเบื้องต้นทาง LINE ได้ก่อน',
        'sort_order' => 6,
    ],
];

$prices = [
    [
        'sku' => 'BUILTIN-TV',
        'name' => 'บิ้วอินชั้นวางทีวี',
        'description' => 'ไม่รวมผนังตกแต่งหลังทีวี',
        'price_type' => 'starting_at',
        'price' => 13000,
        'max_price' => null,
        'unit' => 'เมตร',
        'sort_order' => 1,
    ],
    [
        'sku' => 'BUILTIN-WARDROBE',
        'name' => 'บิ้วอินตู้เสื้อผ้า',
        'description' => 'สูงไม่เกิน 2.6 เมตร บานเปิด',
        'price_type' => 'starting_at',
        'price' => 31000,
        'max_price' => null,
        'unit' => 'เมตร',
        'sort_order' => 2,
    ],
    [
        'sku' => 'BUILTIN-KITCHEN',
        'name' => 'บิ้วอินครัว',
        'description' => 'ไม่รวมท็อปและเครื่องใช้ไฟฟ้า',
        'price_type' => 'starting_at',
        'price' => 16500,
        'max_price' => null,
        'unit' => 'เมตร',
        'sort_order' => 3,
    ],
    [
        'sku' => 'BUILTIN-BEDROOM',
        'name' => 'บิ้วอินห้องนอนทั้งห้อง',
        'description' => 'ขึ้นกับจำนวนชิ้นงาน',
        'price_type' => 'range',
        'price' => 99000,
        'max_price' => 214500,
        'unit' => 'ห้อง',
        'sort_order' => 4,
    ],
    [
        'sku' => 'BUILTIN-CONDO',
        'name' => 'บิ้วอินคอนโด 1 ห้องนอน',
        'description' => 'พื้นที่ 30–35 ตร.ม.',
        'price_type' => 'range',
        'price' => 165000,
        'max_price' => 385000,
        'unit' => 'ห้อง',
        'sort_order' => 5,
    ],
    // ค่าสำรวจ 1,500 บาท อยู่ในเนื้อหา/FAQ แล้ว — ไม่ใส่ใน service_prices
    // เพื่อไม่ให้ activePrice แสดงเป็นราคาเริ่มต้นของบริการ
];

$scopes = [
    ['name' => 'บิ้วอินห้องนอน', 'group' => 'type'],
    ['name' => 'บิ้วอินตู้เสื้อผ้า', 'group' => 'type'],
    ['name' => 'บิ้วอินชั้นวางทีวี', 'group' => 'type'],
    ['name' => 'บิ้วอินครัว', 'group' => 'type'],
    ['name' => 'บิ้วอินคอนโด', 'group' => 'type'],
    ['name' => 'ออกแบบและผลิตเอง', 'group' => 'included'],
    ['name' => 'สำรวจและวัดหน้างาน', 'group' => 'included'],
    ['name' => 'ใบเสนอราคาแยกรายการ', 'group' => 'included'],
    ['name' => 'ติดตั้งและส่งมอบ', 'group' => 'included'],
    ['name' => 'รับประกันงาน 1 ปี', 'group' => 'warranty'],
];

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
        ['slug' => 'interior'],
        ['name' => 'ตกแต่งภายใน']
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
