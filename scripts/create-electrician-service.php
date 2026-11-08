<?php

/**
 * Create or refresh the electrician-near-me service in database.sqlite.
 * Uses real photos under images/services/electrician/.
 */

use App\Models\Faq;
use App\Models\Service;
use App\Models\ServicePrice;
use App\Models\ServiceScope;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$cdn = rtrim((string) env('AWS_URL'), '/').'/images/services/electrician';
$img = [
    'hero' => $cdn.'/electric-check.webp',
    'inspect' => $cdn.'/electric-check.webp',
    'panel' => $cdn.'/consumer-unit-installation.webp',
    'wiring' => $cdn.'/electric-wiring.webp',
    'building' => $cdn.'/electric-wiring-01.webp',
];
$uploaded = [
    'hero' => 'images/services/electrician/electric-check.webp',
    'inspect' => 'images/services/electrician/electric-check.webp',
    'panel' => 'images/services/electrician/consumer-unit-installation.webp',
    'wiring' => 'images/services/electrician/electric-wiring.webp',
    'building' => 'images/services/electrician/electric-wiring-01.webp',
];
foreach ($img as $key => $url) {
    echo "{$key} {$url}\n";
}

$phone = '061-563-9228';

$description = 'รับตรวจเช็กระบบไฟ ติดตั้งตู้ไฟและเครื่องตัดไฟรั่ว เดินสายเพิ่ม และแก้ไฟตก ไฟรั่ว เบรกเกอร์ตัด ในนนทบุรีและกรุงเทพฯ แจ้งราคาเป็นลายลักษณ์อักษรก่อนเริ่มงาน ส่งรูปปัญหาประเมินผ่าน LINE ได้ฟรี';

$metaDes = 'ช่างไฟใกล้ฉัน นนทบุรี-กรุงเทพฯ รับตรวจเช็กระบบไฟ ติดตั้งตู้ไฟ แก้ไฟตก ไฟรั่ว เบรกเกอร์ตัด แจ้งราคาก่อนเริ่มงาน โทร '.$phone;

$content = <<<HTML
<p class="service-kicker"><span class="service-kicker-line"></span>ช่างไฟฟ้าใกล้ฉัน</p>
<p class="text-muted">โดย ทีมช่างไฟฟ้า บริษัท ธีรพงษ์ เซอร์วิส จำกัด • อัปเดตล่าสุด 8 พฤศจิกายน 2569</p>

<div class="lead">
  <p>กำลังหาช่างไฟใกล้ฉันในนนทบุรีหรือกรุงเทพฯ? <strong>บริษัท ธีรพงษ์ เซอร์วิส จำกัด</strong> ให้บริการช่างไฟฟ้า 4 งาน คือ ตรวจเช็กระบบไฟ ติดตั้งอุปกรณ์ไฟฟ้า เดินสายไฟ และแก้ไขไฟตก ไฟรั่ว เบรกเกอร์ตัด ทั้งบ้านพักอาศัย คอนโด และอาคารพาณิชย์ ทุกงานแจ้งราคาเป็นลายลักษณ์อักษรก่อนเริ่ม ติดตั้งตามมาตรฐานการติดตั้งทางไฟฟ้า วสท. และทดสอบระบบก่อนส่งมอบ</p>
</div>

<h2>บริการช่างไฟฟ้าของเราครอบคลุมอะไรบ้าง?</h2>
<p>ช่างไฟฟ้าของธีรพงษ์ เซอร์วิส รับงาน 4 กลุ่มหลัก ได้แก่ ตรวจเช็ก ติดตั้ง เดินสายไฟ และแก้ไขปัญหาไฟฟ้า ครอบคลุมทั้งงานจุดเดียว เช่น เพิ่มปลั๊ก 1 จุด ไปจนถึงงานเดินสายเพิ่มในห้องต่อเติมหรือทั้งชั้นอาคาร</p>

<ul class="service-checklist service-checklist--grid">
  <li><i class="bi bi-check-circle-fill"></i><span><strong>ตรวจเช็ก:</strong> ตู้ไฟ เบรกเกอร์ สายไฟ เต้ารับ และระบบสายดิน</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>ติดตั้ง:</strong> ตู้คอนซูเมอร์ เครื่องตัดไฟรั่ว สายดิน เต้ารับ และจุดแอร์</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>เดินสาย:</strong> เดินลอยตีกิ๊บ ร้อยท่อ PVC/EMT หรือเดินซ่อนในฝ้าและผนัง</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>แก้ไข:</strong> ไฟตก ไฟกระพริบ ไฟดับบางจุด ไฟรั่ว และเบรกเกอร์ตัดบ่อย</span></li>
</ul>

<h3>ตรวจเช็กระบบไฟฟ้า</h3>
<p>ตรวจสภาพตู้ไฟ เบรกเกอร์ สายไฟ เต้ารับ และระบบสายดิน วัดค่าความเป็นฉนวนของสาย วัดกระแสแต่ละวงจร และทดสอบเครื่องตัดไฟรั่ว เหมาะกับบ้านก่อนซื้อ-ขาย บ้านเก่าที่ไม่เคยตรวจ หรือบ้านที่ค่าไฟสูงผิดปกติ ช่างสรุปจุดเสี่ยงและแนวทางแก้ไขให้ก่อนเสนอราคา</p>

<figure>
  <img src="{$img['inspect']}" alt="ช่างไฟธีรพงษ์ เซอร์วิส ตรวจเช็กระบบไฟฟ้าและตู้ไฟในบ้าน" width="1400" height="875" loading="lazy" decoding="async" class="img-responsive">
  <figcaption>ตรวจเช็กระบบไฟฟ้าและตู้ไฟก่อนเสนอแนวทางแก้ไข</figcaption>
</figure>

<h3>ติดตั้งอุปกรณ์ไฟฟ้า</h3>
<p>ติดตั้งตู้คอนซูเมอร์ยูนิต เบรกเกอร์ เครื่องตัดไฟรั่ว (RCBO/RCD 30 mA) ระบบสายดินและหลักดิน เต้ารับ สวิตช์ โคมไฟ พัดลมเพดาน ปลั๊กสำหรับแอร์ และเครื่องทำน้ำอุ่น</p>

<figure>
  <img src="{$img['panel']}" alt="ติดตั้งตู้คอนซูเมอร์ยูนิตพร้อมเครื่องตัดไฟรั่ว โดยช่างไฟธีรพงษ์ เซอร์วิส" width="1400" height="875" loading="lazy" decoding="async" class="img-responsive">
  <figcaption>ติดตั้งตู้คอนซูเมอร์พร้อมเครื่องตัดไฟรั่ว และจัดสายในตู้ให้เป็นระเบียบ</figcaption>
</figure>

<h3>เดินสายไฟฟ้าใหม่และเดินสายเพิ่ม</h3>
<p>เดินสายเพิ่มสำหรับห้องต่อเติม ครัว หรือวงจรแอร์ และเดินสายไฟใหม่สำหรับบ้านเก่าหรือบ้านรีโนเวต เลือกได้ทั้งแบบเดินลอยตีกิ๊บ แบบร้อยท่อ PVC/EMT และแบบเดินซ่อนในฝ้า-ผนัง โดยคำนวณขนาดสายให้เหมาะกับโหลดจริงของแต่ละวงจร ดูราคาต่อจุดและงบทั้งหลังได้ที่หน้า <a href="/electrical-wiring">เดินสายไฟบ้านใหม่ ราคา 2569</a></p>

<figure>
  <img src="{$img['wiring']}" alt="งานเดินสายไฟฟ้าภายในบ้านโดยช่างไฟใกล้ฉัน ธีรพงษ์ เซอร์วิส" width="1400" height="875" loading="lazy" decoding="async" class="img-responsive">
  <figcaption>เดินสายไฟฟ้าภายในบ้าน จัดแนวสายและจุดต่อให้เรียบร้อย</figcaption>
</figure>

<h3>แก้ไขปัญหาไฟฟ้า</h3>
<p>หาสาเหตุและแก้ไขไฟตก ไฟกระพริบ ไฟดับบางจุด เบรกเกอร์ตัดบ่อย ไฟรั่ว ปลั๊กร้อนหรือมีรอยไหม้ และไฟฟ้าลัดวงจร ช่างไล่ตรวจทีละวงจรเพื่อหาต้นเหตุ ไม่ใช่แค่เปลี่ยนอุปกรณ์ทิ้ง</p>

<h2>ช่างไฟฟ้าภายในบ้าน กับ ช่างไฟฟ้าภายในอาคาร ต่างกันอย่างไร?</h2>
<p>ช่างไฟฟ้าภายในบ้านเน้นระบบไฟ 1 เฟส ตู้ไฟเดียว และงานที่ทำได้ในวันเดียว ส่วนช่างไฟฟ้าภายในอาคารต้องรับมือระบบ 3 เฟส ตู้ไฟหลายชั้น การเดินสายร้อยท่อตามแบบ และกฎของนิติบุคคล ธีรพงษ์ เซอร์วิส มีทีมรองรับทั้งสองแบบ งานเดินสายสัญญาณในอาคารดูได้ที่หน้า <a href="/outdoor-lan-cabling">เดินสาย LAN นอกอาคาร</a></p>

<div class="table-responsive"><table class="table table-hover">
<thead>
<tr><th>หัวข้อ</th><th>ช่างไฟฟ้าภายในบ้าน</th><th>ช่างไฟฟ้าภายในอาคาร</th></tr>
</thead>
<tbody>
<tr><td>ลักษณะงาน</td><td>บ้านเดี่ยว ทาวน์เฮาส์ ห้องต่อเติม</td><td>คอนโด ออฟฟิศ ร้านค้า อาคารพาณิชย์ โกดัง</td></tr>
<tr><td>ระบบไฟ</td><td>ส่วนใหญ่ 1 เฟส 230V</td><td>1 เฟส และ 3 เฟส 400V</td></tr>
<tr><td>รูปแบบเดินสาย</td><td>ตีกิ๊บ หรือร้อยท่อ PVC</td><td>ร้อยท่อ EMT/IMC, รางเดินสาย</td></tr>
<tr><td>งานที่พบบ่อย</td><td>เพิ่มปลั๊ก เปลี่ยนตู้ไฟ ติดสายดิน แก้ไฟรั่ว</td><td>ตู้ไฟย่อยรายชั้น วงจรแอร์ ระบบแสงสว่าง งานรีโนเวต</td></tr>
<tr><td>ระยะเวลาโดยประมาณ</td><td>2 ชั่วโมง – 5 วัน</td><td>1 วัน – หลายสัปดาห์ ตามแบบ</td></tr>
<tr><td>เอกสาร</td><td>ใบเสนอราคา</td><td>ใบเสนอราคา และประสานนิติบุคคลก่อนเข้างาน</td></tr>
</tbody>
</table></div>

<figure>
  <img src="{$img['building']}" alt="งานเดินสายไฟฟ้าภายในอาคารโดยทีมช่างไฟธีรพงษ์ เซอร์วิส" width="1400" height="875" loading="lazy" decoding="async" class="img-responsive">
  <figcaption>งานเดินสายไฟฟ้าภายในอาคารและพื้นที่พาณิชย์</figcaption>
</figure>

<h2>อาการแบบไหนที่ควรเรียกช่างไฟใกล้ฉันทันที?</h2>
<p>ถ้าพบอาการใดอาการหนึ่งต่อไปนี้ ควรปิดเบรกเกอร์วงจรนั้นและเรียกช่างไฟฟ้าโดยเร็ว เพราะเป็นสัญญาณของไฟรั่วหรือสายไฟร้อนเกิน ซึ่งเป็นต้นเหตุไฟไหม้บ้านที่พบบ่อย</p>
<ul class="service-checklist">
  <li><i class="bi bi-check-circle-fill"></i><span>ได้กลิ่นไหม้หรือกลิ่นพลาสติกละลายจากปลั๊ก สวิตช์ หรือตู้ไฟ</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span>เบรกเกอร์หรือเครื่องตัดไฟรั่วตัดซ้ำหลายครั้งในวันเดียว</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span>จับเครื่องใช้ไฟฟ้า ก๊อกน้ำ หรือโครงเหล็กแล้วรู้สึกชา</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span>ปลั๊กหรือฝาครอบสวิตช์มีรอยไหม้ ดำ หรือร้อนผิดปกติ</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span>ไฟกระพริบหรือไฟตกเมื่อเปิดแอร์หรือเครื่องทำน้ำอุ่น</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span>ค่าไฟสูงขึ้นผิดปกติ ทั้งที่การใช้งานเท่าเดิม</span></li>
</ul>
<p>เบรกเกอร์ตัดบ่อยมักมาจากจุดต่อสายที่หลวม หรือการเปลี่ยนเบรกเกอร์ให้ใหญ่ขึ้นทั้งที่สายไฟรับโหลดไม่ไหว ซึ่งทำให้สายร้อนเกินพิกัด อ่านเพิ่มเรื่อง <a href="/blogs/short-circuit-house-fire">ไฟฟ้าลัดวงจร ต้นเหตุไฟไหม้บ้าน</a></p>

<h2>ค่าบริการช่างไฟฟ้าราคาเท่าไหร่?</h2>
<p>ค่าช่างไฟฟ้าขึ้นกับประเภทงาน จำนวนจุด ระยะสาย และยี่ห้ออุปกรณ์ งานเล็กเริ่มต้นหลักร้อยบาทต่อจุด ส่วนงานเดินสายใหม่ทั้งหลังคิดตามจำนวนจุด ธีรพงษ์ เซอร์วิส แยกค่าแรงและค่าอุปกรณ์ในใบเสนอราคาให้เห็นทุกรายการก่อนเริ่มงาน ตัวเลขด้านล่างเป็นชุดเดียวกับหน้า <a href="/electrical-wiring">เดินสายไฟบ้านใหม่ ราคา 2569</a></p>

<div class="table-responsive"><table class="table table-hover">
<thead>
<tr><th>รายการงาน</th><th>ราคา (บาท)</th><th>หมายเหตุ</th></tr>
</thead>
<tbody>
<tr><td>ออกสำรวจหน้างาน / หาสาเหตุปัญหาไฟ</td><td>{{price:ELEC-NEAR-SURVEY}}</td><td>หักคืนเมื่อจ้างงาน</td></tr>
<tr><td>เพิ่มเต้ารับ / สวิตช์ เดินลอย (ค่าแรง)</td><td>{{price:ELEC-NEAR-LABOR-SURFACE}}</td><td>เดินซ่อน จุดไฟ {{price:ELEC-NEAR-LABOR-LIGHT-HIDE}} จุดปลั๊ก {{price:ELEC-NEAR-LABOR-OUTLET-HIDE}}</td></tr>
<tr><td>จุดไฟแสงสว่าง + สวิตช์ รวมวัสดุ</td><td>{{price:ELEC-NEAR-MAT-LIGHT}}</td><td>ขึ้นกับระยะสาย</td></tr>
<tr><td>เต้ารับ 3 ขา รวมวัสดุ</td><td>{{price:ELEC-NEAR-MAT-OUTLET}}</td><td>ขึ้นกับระยะสาย</td></tr>
<tr><td>เพิ่มจุดแอร์ (ค่าแรง)</td><td>{{price:ELEC-NEAR-LABOR-AC}}</td><td>ไม่รวมสายและเบรกเกอร์</td></tr>
<tr><td>ติดตั้งสายดิน</td><td>{{price:ELEC-NEAR-GROUND-LABOR}}</td><td>ครบระบบรวมวัสดุ {{price:ELEC-NEAR-MAT-GROUND}}</td></tr>
<tr><td>ติดตั้งตู้ไฟหลัก (ค่าแรง)</td><td>{{price:ELEC-NEAR-PANEL-LABOR}}</td><td>ไม่รวมตัวตู้</td></tr>
<tr><td>ตู้คอนซูเมอร์ 10–14 ช่อง พร้อม RCD/RCBO</td><td>{{price:ELEC-NEAR-MAT-CU}}</td><td>รวมอุปกรณ์</td></tr>
<tr><td>เดินสายไฟใหม่ 1–10 จุด รวมวัสดุ</td><td>{{price:ELEC-NEAR-PKG}}</td><td>จุดที่ 11 ขึ้นไปดูที่หน้าเดินสายไฟ</td></tr>
</tbody>
</table></div>

<p><strong>ปัจจัยที่ทำให้ราคาเปลี่ยน:</strong> ความยาวสายและจำนวนจุด, เดินลอยหรือเดินซ่อน (เดินซ่อนต้องเจาะ-ซ่อมผนัง), ยี่ห้ออุปกรณ์, ความสูงฝ้าและการเข้าถึง, งานในอาคารที่จำกัดเวลาเข้า</p>

<h2>ขั้นตอนการทำงานของช่างไฟ ธีรพงษ์ เซอร์วิส</h2>
<div class="list-group">
  <div class="list-group-item"><h4>1. ส่งรูปหรือแจ้งอาการ</h4><p>โทรหรือส่ง LINE ช่างประเมินเบื้องต้นและแจ้งช่วงราคาภายในวันเดียวกัน</p></div>
  <div class="list-group-item"><h4>2. นัดตรวจหน้างาน</h4><p>ในนนทบุรีนัดได้ภายใน 1–2 วัน ตรวจวัดและหาสาเหตุจริง ใช้เวลาประมาณ 30–90 นาที</p></div>
  <div class="list-group-item"><h4>3. เสนอราคาเป็นลายลักษณ์อักษร</h4><p>แยกค่าแรง ค่าอุปกรณ์ และระยะเวลาทำงาน ลูกค้าอนุมัติก่อนเริ่ม</p></div>
  <div class="list-group-item"><h4>4. ลงมือทำงาน</h4><p>ปิดไฟเฉพาะวงจรที่ทำ เก็บงานเรียบร้อย งานจุดเล็กเสร็จในวันเดียว งานเดินสายทั้งหลังประมาณ 3–7 วัน</p></div>
  <div class="list-group-item"><h4>5. ทดสอบและส่งมอบ</h4><p>วัดค่าฉนวน ทดสอบเครื่องตัดไฟรั่ว ติดป้ายระบุวงจรในตู้ไฟ พร้อมเอกสารรับประกันฝีมือการติดตั้ง 1 ปี</p></div>
</div>

<h2>ช่างไฟ นนทบุรี ให้บริการพื้นที่ไหนบ้าง?</h2>
<p>ทีมช่างไฟฟ้าธีรพงษ์ เซอร์วิส มีสำนักงานอยู่ที่ ต.บางกร่าง อ.เมืองนนทบุรี จึงเข้าหน้างานในนนทบุรีได้เร็ว และให้บริการครอบคลุมกรุงเทพฯ และปริมณฑล</p>
<ul class="service-checklist">
  <li><i class="bi bi-check-circle-fill"></i><span><strong>นนทบุรี:</strong> อ.เมืองนนทบุรี, บางกรวย, บางใหญ่, บางบัวทอง, ปากเกร็ด, ไทรน้อย</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>กรุงเทพฯ:</strong> ทุกเขต — โซนที่เข้าถึงเร็วที่สุดคือ บางซื่อ จตุจักร หลักสี่ ดอนเมือง บางพลัด ตลิ่งชัน</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>ปริมณฑล:</strong> ปทุมธานี และสมุทรปราการ</span></li>
</ul>
<p>นนทบุรีอยู่ในเขตการไฟฟ้านครหลวง (กฟน.) งานที่เกี่ยวกับมิเตอร์ เช่น ขอเพิ่มขนาดมิเตอร์ หรือย้ายมิเตอร์ ต้องยื่นเรื่องที่ กฟน. ทีมจัดระบบภายในบ้านให้พร้อมก่อนการตรวจ</p>

<h2>ทำไมต้องเลือกช่างไฟฟ้าธีรพงษ์ เซอร์วิส?</h2>
<div class="service-feature-grid">
  <div class="service-feature-card"><h3>ราคาโปร่งใส</h3><p>ใบเสนอราคาแยกค่าแรงและค่าอุปกรณ์ทุกรายการ ไม่มีค่าใช้จ่ายเพิ่มที่ไม่ได้ตกลงก่อน</p></div>
  <div class="service-feature-card"><h3>ทำตามมาตรฐาน</h3><p>ติดตั้งตามมาตรฐานการติดตั้งทางไฟฟ้าสำหรับประเทศไทย (วสท.) ใช้สายและอุปกรณ์ที่มี มอก.</p></div>
  <div class="service-feature-card"><h3>ทดสอบก่อนส่งมอบ</h3><p>วัดค่าฉนวน ทดสอบสายดินและเครื่องตัดไฟรั่วก่อนส่งมอบ</p></div>
  <div class="service-feature-card"><h3>บริษัทจดทะเบียน</h3><p>บริษัท ธีรพงษ์ เซอร์วิส จำกัด 14 หมู่ 5 ต.บางกร่าง อ.เมืองนนทบุรี ออกใบกำกับภาษีได้</p></div>
  <div class="service-feature-card"><h3>รับประกัน 1 ปี</h3><p>รับประกันฝีมือการติดตั้งงานไฟฟ้านับจากวันส่งมอบ อุปกรณ์รับประกันตามเงื่อนไขผู้ผลิต</p></div>
  <div class="service-feature-card"><h3>งานระบบครบที่เดียว</h3><p>ประสบการณ์บริษัท 20+ ปี ทีมงาน 20+ คน ครบทั้งงานไฟฟ้า <a href="/cctv-installation">กล้องวงจรปิด</a> และ <a href="/solar-cell-installation">โซลาร์เซลล์</a></p></div>
</div>

<h2>ผลงานช่างไฟฟ้า</h2>
<p>ตัวอย่างงานตรวจเช็ก ติดตั้งตู้ไฟ และเดินสายไฟฟ้าของทีมเรา ดูงานเดินสายเพิ่มได้ที่หน้า <a href="/electrical-wiring">เดินสายไฟฟ้า</a> และ <a href="/galleries">คลังผลงาน</a></p>

<div class="well">
  <h3>เรียกช่างไฟใกล้ฉัน นนทบุรี — ขอใบเสนอราคาฟรี</h3>
  <p>มีปัญหาไฟฟ้าหรือต้องการติดตั้ง-เดินสายไฟ? ส่งรูปตู้ไฟหรือจุดที่มีปัญหาทาง LINE ให้ช่างประเมินเบื้องต้นฟรี แล้วนัดตรวจหน้างานในนนทบุรีและกรุงเทพฯ ได้ภายใน 1–2 วัน</p>
  <p>โทร {$phone} · LINE @theeraphong · สำนักงาน 14 หมู่ 5 ต.บางกร่าง อ.เมืองนนทบุรี จ.นนทบุรี 11000 · จันทร์–เสาร์ 8:00–18:00 น.</p>
  <p><a class="btn btn-primary" href="/contact-us">ขอใบเสนอราคางานไฟฟ้า</a></p>
</div>
HTML;

$faqs = [
    ['question' => 'เรียกช่างไฟใกล้ฉันในนนทบุรี ช่างจะมาถึงเร็วแค่ไหน?', 'answer' => 'โดยทั่วไปทีมช่างไฟฟ้าธีรพงษ์ เซอร์วิส นัดเข้าหน้างานในนนทบุรีได้ภายในวันเดียวกันหรือวันถัดไป ขึ้นกับคิวงานและระยะทาง หากเป็นเหตุเร่งด่วน เช่น ไฟช็อต มีกลิ่นไหม้ หรือไฟดับทั้งบ้าน ให้ปิดเมนเบรกเกอร์ก่อน แล้วโทร '.$phone.' เพื่อจัดคิวด่วน', 'sort_order' => 1],
    ['question' => 'ค่าตรวจเช็กระบบไฟฟ้าในบ้านเท่าไหร่?', 'answer' => 'ค่าออกสำรวจหน้างานและหาสาเหตุปัญหาไฟฟ้าเริ่มต้น 1,500 บาท ขึ้นกับขนาดบ้านและระยะทาง หากตกลงจ้างงานแก้ไขต่อ เราหักค่าสำรวจคืนจากค่างาน และแจ้งราคาเป็นลายลักษณ์อักษรก่อนเริ่มงานทุกครั้ง', 'sort_order' => 2],
    ['question' => 'เบรกเกอร์ตัดบ่อย เกิดจากอะไร?', 'answer' => 'เบรกเกอร์ตัดบ่อยมักเกิดจาก 3 สาเหตุ คือ ใช้ไฟเกินพิกัดของวงจร มีไฟรั่วลงดินจากสายหรืออุปกรณ์ที่ชำรุด หรือไฟฟ้าลัดวงจร ไม่ควรเปลี่ยนเบรกเกอร์ให้ใหญ่ขึ้นเพื่อแก้ปัญหา เพราะสายไฟอาจร้อนจนไหม้ได้ ช่างควรวัดกระแสและค่าความเป็นฉนวนเพื่อหาต้นเหตุก่อนแก้ไข', 'sort_order' => 3],
    ['question' => 'บ้านเก่าควรเดินสายไฟใหม่ทั้งหลังเมื่อไหร่?', 'answer' => 'บ้านที่ใช้สายไฟเดิมมานานกว่า 15–20 ปี ควรให้ช่างไฟฟ้าตรวจสภาพก่อนตัดสินใจ หากพบฉนวนสายกรอบแตก ปลั๊กร้อนหรือมีรอยไหม้ ไม่มีระบบสายดิน หรือวงจรเดิมรับเครื่องใช้ไฟฟ้าปัจจุบันไม่ไหว ควรเดินสายไฟใหม่ทั้งหลังพร้อมเปลี่ยนตู้ไฟเป็นแบบมีเครื่องตัดไฟรั่ว', 'sort_order' => 4],
    ['question' => 'ช่างไฟฟ้าภายในอาคาร รับงานคอนโด ออฟฟิศ และร้านค้าไหม?', 'answer' => 'รับครับ ทีมช่างไฟฟ้าภายในอาคารของเรารับงานคอนโด ออฟฟิศ ร้านค้า และอาคารพาณิชย์ ทั้งเดินสายไฟร้อยท่อ ติดตั้งตู้ไฟย่อย เพิ่มวงจรแอร์ และปรับปรุงระบบไฟสำหรับงานรีโนเวต โดยประสานนิติบุคคลเรื่องเวลาเข้างานและขออนุญาตก่อนเริ่มทุกครั้ง', 'sort_order' => 5],
    ['question' => 'งานช่างไฟฟ้ามีรับประกันไหม?', 'answer' => 'มีครับ งานติดตั้งและเดินสายไฟฟ้าของธีรพงษ์ เซอร์วิส รับประกันฝีมือการติดตั้ง 1 ปี หากเกิดปัญหาจากการติดตั้งในช่วงรับประกัน ทีมช่างเข้าแก้ไขให้โดยไม่คิดค่าแรง ส่วนอุปกรณ์ไฟฟ้ารับประกันตามเงื่อนไขของผู้ผลิตแต่ละยี่ห้อ', 'sort_order' => 6],
];

$prices = [
    ['sku' => 'ELEC-NEAR-MAT-LIGHT', 'name' => 'จุดไฟแสงสว่าง + สวิตช์ (รวมวัสดุ)', 'price_type' => 'range', 'price' => 700, 'max_price' => 1000, 'unit' => 'จุด', 'sort_order' => 1],
    ['sku' => 'ELEC-NEAR-MAT-OUTLET', 'name' => 'จุดปลั๊ก 3 รู มีสายดิน (รวมวัสดุ)', 'price_type' => 'range', 'price' => 900, 'max_price' => 2200, 'unit' => 'จุด', 'sort_order' => 2],
    ['sku' => 'ELEC-NEAR-SURVEY', 'name' => 'ค่าออกสำรวจหน้างาน (หักคืนเมื่อจ้างงาน)', 'price_type' => 'starting_at', 'price' => 1500, 'max_price' => null, 'unit' => 'ครั้ง', 'sort_order' => 3],
    ['sku' => 'ELEC-NEAR-GROUND-LABOR', 'name' => 'ติดตั้งสายดิน', 'price_type' => 'range', 'price' => 2000, 'max_price' => 3000, 'unit' => 'ชุด', 'sort_order' => 4],
    ['sku' => 'ELEC-NEAR-MAT-GROUND', 'name' => 'ชุดหลักดิน + สายดินครบระบบ (รวมวัสดุ)', 'price_type' => 'range', 'price' => 4000, 'max_price' => 6000, 'unit' => 'ชุด', 'sort_order' => 5],
    ['sku' => 'ELEC-NEAR-MAT-CU', 'name' => 'ตู้คอนซูเมอร์ 10–14 ช่อง พร้อม RCD/RCBO', 'price_type' => 'range', 'price' => 8500, 'max_price' => 16000, 'unit' => 'ชุด', 'sort_order' => 6],
    ['sku' => 'ELEC-NEAR-PKG', 'name' => 'เดินสายไฟใหม่ 1–10 จุด รวมวัสดุ', 'price_type' => 'fixed', 'price' => 20000, 'max_price' => null, 'unit' => 'แพ็กเกจ', 'sort_order' => 7],
    ['sku' => 'ELEC-NEAR-LABOR-SURFACE', 'name' => 'เพิ่มเต้ารับ / สวิตช์ เดินลอย — ค่าแรง', 'price_type' => 'range', 'price' => 250, 'max_price' => 450, 'unit' => 'จุด', 'sort_order' => 8],
    ['sku' => 'ELEC-NEAR-LABOR-LIGHT-HIDE', 'name' => 'จุดไฟแสงสว่าง + สวิตช์ เดินซ่อน — ค่าแรง', 'price_type' => 'range', 'price' => 600, 'max_price' => 900, 'unit' => 'จุด', 'sort_order' => 9],
    ['sku' => 'ELEC-NEAR-LABOR-OUTLET-HIDE', 'name' => 'จุดปลั๊กไฟ เดินซ่อน — ค่าแรง', 'price_type' => 'range', 'price' => 700, 'max_price' => 1000, 'unit' => 'จุด', 'sort_order' => 10],
    ['sku' => 'ELEC-NEAR-LABOR-AC', 'name' => 'เพิ่มจุดแอร์ — ค่าแรง', 'price_type' => 'range', 'price' => 800, 'max_price' => 1500, 'unit' => 'จุด', 'sort_order' => 11],
    ['sku' => 'ELEC-NEAR-PANEL-LABOR', 'name' => 'ติดตั้งตู้ไฟหลัก — ค่าแรง', 'price_type' => 'range', 'price' => 2500, 'max_price' => 4500, 'unit' => 'ตู้', 'sort_order' => 12],
];

$scopes = [
    'ตรวจเช็กระบบไฟฟ้า',
    'ติดตั้งตู้ไฟและเครื่องตัดไฟรั่ว',
    'ติดตั้งสายดิน',
    'เพิ่มเต้ารับ สวิตช์ และจุดแอร์',
    'เดินสายไฟใหม่และเดินสายเพิ่ม',
    'แก้ไขไฟตก ไฟรั่ว เบรกเกอร์ตัด',
    'ทดสอบระบบก่อนส่งมอบ',
    'รับประกันฝีมือการติดตั้ง 1 ปี',
];

if (mb_strlen($metaDes) > 255) {
    fwrite(STDERR, 'meta_des too long: '.mb_strlen($metaDes)."\n");
    exit(1);
}

DB::transaction(function () use ($description, $metaDes, $content, $faqs, $prices, $scopes, $uploaded) {
    $service = Service::query()->firstOrNew(['slug' => 'electrician-near-me']);
    $service->fill([
        'service_category_id' => 6,
        'title' => 'ช่างไฟฟ้า',
        'slug' => 'electrician-near-me',
        'meta_title' => 'ช่างไฟใกล้ฉัน นนทบุรี ตรวจ ติดตั้ง เดินสายไฟ | ธีรพงษ์ เซอร์วิส',
        'meta_des' => $metaDes,
        'description' => $description,
        'h1' => 'ช่างไฟใกล้ฉัน นนทบุรี — ตรวจเช็ก ติดตั้ง เดินสายไฟ และแก้ไขระบบไฟฟ้าบ้านและอาคาร',
        'content' => $content,
        'schema_type' => 'ช่างไฟฟ้า',
        'is_active' => true,
        'icon_name' => 'bi-lightbulb',
        'dur' => '2 ชม.–7 วัน',
        'img_1' => $uploaded['hero'],
        'img_2' => $uploaded['panel'],
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

    $wiring = Service::query()->where('slug', 'electrical-wiring')->first();
    if ($wiring && is_string($wiring->content) && ! str_contains($wiring->content, '/electrician-near-me')) {
        $wiring->content .= '<p>มีปัญหาไฟในบ้านเดิม เช่น ไฟตก ไฟรั่ว หรือเบรกเกอร์ตัด? เรียก<a href="/electrician-near-me">ช่างไฟใกล้ฉัน นนทบุรี</a> ให้ตรวจหาสาเหตุก่อนตัดสินใจเดินสายใหม่ทั้งหลัง</p>';
        $wiring->save();
        echo "linked from electrical-wiring\n";
    }

    echo "OK service #{$service->id} electrician-near-me\n";
    echo 'meta_title '.mb_strlen($service->meta_title)."\n";
    echo 'meta_des '.mb_strlen($metaDes)."\n";
});
