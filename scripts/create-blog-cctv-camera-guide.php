<?php

/**
 * Blog: กล้อง วงจรปิด 2026
 * Source: SEO + AI Search Package (26 Oct 2026)
 *
 * Prices, warranty (1 year) and free LINE survey follow the CCTV service page.
 * Public-camera request steps follow cctv.bangkok.go.th.
 */

use App\Models\Blog;
use App\Models\Service;
use App\Support\BlogPageSchema;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$raw = <<<'HTML'
<p class="service-kicker"><span class="service-kicker-line"></span>ความรู้งานระบบ</p>

<div class="blog-meta">
  <span><i class="bi bi-flag-fill"></i> ทีมช่างระบบ บริษัท ธีรพงษ์ เซอร์วิส จำกัด</span>
  <span><i class="bi bi-geo-alt-fill"></i> กรุงเทพฯ นนทบุรี ปทุมธานี สมุทรปราการ</span>
  <span><i class="bi bi-calendar-check"></i> อัปเดตล่าสุด 26 ตุลาคม 2569</span>
</div>

<div class="lead">
  <p>กล้อง วงจรปิด ที่คนค้นหามีสองแบบ คือกล้องสาธารณะที่ดูสดได้ฟรีผ่านแอปของหน่วยงานรัฐ เช่น BMA Traffic และ Thailand Highway Traffic กับกล้องของตัวเองที่ติดบ้าน ร้าน หรือโรงงานเพื่อดูย้อนหลังได้ บทความนี้เขียนโดยทีมช่างของบริษัท ธีรพงษ์ เซอร์วิส จำกัด ผู้รับติดตั้ง กล้อง วงจรปิด กรุงเทพ นนทบุรี ปทุมธานี และสมุทรปราการ ประสบการณ์ติดตั้งมากกว่า 10 ปี ผลงานมากกว่า 200 โครงการ รวบรวมทั้งช่องทางดูกล้องฟรีและวิธีเลือกกล้องให้คุ้มงบ</p>
</div>

<h2>App ดูกล้อง วงจรปิด ก ทม มีอะไรบ้าง?</h2>
<div class="lead">
  <p>ดูกล้อง CCTV ออนไลน์ ก ทม ได้ฟรีจากแอปและเว็บของหน่วยงานรัฐ ไม่ต้องสมัครสมาชิก เหมาะใช้เช็กรถติดและน้ำท่วมก่อนออกจากบ้าน แอป BMA Traffic แสดงภาพกล้องเส้นทางหลักในพื้นที่วงแหวนรัชดาภิเษกชั้นใน ตามคำอธิบายแอปของสำนักการจราจรและขนส่ง</p>
</div>

<div class="table-responsive"><table class="table table-hover">
<thead>
<tr><th>ช่องทาง</th><th>เจ้าของ</th><th>ใช้ทำอะไร</th><th>ทางเข้า</th></tr>
</thead>
<tbody>
<tr><td>BMA Traffic</td><td>กรุงเทพมหานคร</td><td>ดูกล้องตามถนนและแยกสำคัญ</td><td><a href="https://cpudapp.bangkok.go.th/bmatraffic/" target="_blank" rel="noopener noreferrer">เว็บระบบกล้อง</a> และแอป iOS/Android</td></tr>
<tr><td>Longdo Traffic</td><td>Metamedia Technology</td><td>แผนที่รถติดพร้อมภาพกล้อง</td><td><a href="https://traffic.longdo.com" target="_blank" rel="noopener noreferrer">traffic.longdo.com</a> และแอป</td></tr>
<tr><td>iTIC Live</td><td>มูลนิธิ iTIC</td><td>กล้องและเหตุการณ์จราจรบนแผนที่</td><td><a href="https://live.iticfoundation.org" target="_blank" rel="noopener noreferrer">live.iticfoundation.org</a></td></tr>
<tr><td>Flood Bangkok</td><td>สำนักการระบายน้ำ กรุงเทพมหานคร</td><td>จุดน้ำท่วม เปิดดูกล้องจากแผนที่ได้</td><td>เว็บและแอป Flood Bangkok</td></tr>
<tr><td>EXAT Traffic</td><td>การทางพิเศษแห่งประเทศไทย</td><td>กล้องบนทางด่วนและช่องทางที่ปิด</td><td>แอปทางการ</td></tr>
</tbody>
</table></div>

<p>ระบบกล้องของกรุงเทพมหานครเชื่อมเข้าศูนย์บัญชาการแล้วกว่า 36,000 ตัว และมีเป้าหมายขยายไปราว 60,000 ตัว (<a href="https://www.dailynews.co.th/news/5634885/" target="_blank" rel="noopener noreferrer">เดลินิวส์</a>) แต่ไม่ใช่ทุกตัวที่เปิดให้ประชาชนดูผ่านแอป</p>

<h3>วิธีดูกล้อง CCTV ออนไลน์ ก ทม ผ่าน BMA Traffic</h3>
<ol>
  <li>ดาวน์โหลดแอป BMA Traffic หรือเปิด<a href="https://cpudapp.bangkok.go.th/bmatraffic/" target="_blank" rel="noopener noreferrer">เว็บระบบกล้องของสำนักการจราจรและขนส่ง</a></li>
  <li>เลือกเขตหรือถนนที่ต้องการ แล้วแตะไอคอนกล้องบนแผนที่</li>
  <li>ดูภาพสด และบันทึกจุดที่ใช้บ่อยไว้เป็นรายการโปรด</li>
</ol>

<h2>ดูกล้อง CCTV ทั่วประเทศ ได้ที่ไหน?</h2>
<div class="lead">
  <p>ดูกล้อง CCTV ทั่วประเทศ ได้จากแอป Thailand Highway Traffic ของกรมทางหลวง ที่เมนูกล้องจราจร ซึ่งแสดงไอคอนกล้องบนแผนที่ทางหลวง ส่วน Longdo Traffic ครอบคลุมถนนสายหลักบางสายนอกกรุงเทพฯ ด้วย สำหรับปริมณฑล บางเทศบาลมีระบบของตัวเอง เช่น เทศบาลนครปากเกร็ด เทศบาลนครนนทบุรี และเทศบาลนครรังสิต</p>
</div>
<ul class="service-checklist">
  <li><i class="bi bi-check-circle-fill"></i><span><strong>เดินทางไกลช่วงเทศกาล:</strong> Thailand Highway Traffic</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>ใช้ทางด่วน:</strong> EXAT Traffic</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span><strong>อยู่ปริมณฑล:</strong> ระบบกล้องของเทศบาลในพื้นที่ ร่วมกับ Longdo Traffic</span></li>
</ul>

<h2>กล้องสาธารณะกับ กล้อง วงจรปิด ที่บ้าน ต่างกันอย่างไร?</h2>
<div class="lead">
  <p>กล้องสาธารณะเหมาะดูสภาพถนนแบบสดเท่านั้น แต่ไม่ได้เล็งหน้าบ้านคุณ และขอภาพย้อนหลังได้ผ่านหน่วยงาน ขณะที่ กล้อง วงจรปิด ของตัวเองบันทึกต่อเนื่อง ย้อนดูได้จากมือถือ และใช้เป็นหลักฐานได้เมื่อเกิดเหตุในพื้นที่ของตัวเอง</p>
</div>

<figure class="blog-figure">
  <img src="https://pub-68154224aa0d447b83de9bf218e76277.r2.dev/images/services/cctv-installation-img1-eb587f48-2bb4-45e0-ba91-92f0b0b859c1-1784963960.webp" alt="กล้อง วงจรปิด แบบโดมติดเสาภายนอก สายสัญญาณยังไม่ได้เก็บในราง" width="1200" height="774" loading="lazy" decoding="async" class="img-responsive">
  <figcaption>กล้องโดมติดเสาภายนอกเหมาะกับถนนหรือลานโล่ง แต่สายที่พาดออกมานอกกล่องจะดูรกและเสื่อมเร็วกว่าสายที่เดินในราง</figcaption>
</figure>

<div class="table-responsive"><table class="table table-hover">
<thead>
<tr><th>เรื่อง</th><th>กล้องสาธารณะ</th><th>กล้องของตัวเอง</th></tr>
</thead>
<tbody>
<tr><td>ค่าใช้จ่าย</td><td>ฟรี</td><td>เริ่มราว 10,000 บาท สำหรับชุด 2 ตัว</td></tr>
<tr><td>มุมกล้อง</td><td>ถนน แยก ทางด่วน</td><td>หน้าบ้าน ประตู ลานจอด จุดเสี่ยง</td></tr>
<tr><td>ดูย้อนหลัง</td><td>แจ้งความแล้วขอยื่นที่ cctv.bangkok.go.th ดูเองในแอปไม่ได้</td><td>ย้อนดูเองได้ตามขนาดฮาร์ดดิสก์ โดยทั่วไป 1–4 สัปดาห์</td></tr>
<tr><td>แจ้งเตือนเข้ามือถือ</td><td>ไม่มีสำหรับกล้องสาธารณะ</td><td>มี ในรุ่นที่ตรวจจับคนหรือรถ</td></tr>
</tbody>
</table></div>

<p>การขอภาพย้อนหลังจากกล้องของกรุงเทพมหานครทำได้ แต่ไม่ใช่การกดย้อนในแอป ขั้นตอนตามเว็บไซต์ <a href="https://cctv.bangkok.go.th/" target="_blank" rel="noopener noreferrer">cctv.bangkok.go.th</a> คือแจ้งความที่สถานีตำรวจท้องที่ เตรียมบันทึกประจำวันกับสำเนาบัตรประชาชนและวันเวลาของภาพ แล้วยื่นคำขอทางเว็บหรือ LINE @CCTVBANGKOK คำขอออนไลน์ภายใน 24 ชั่วโมงขอได้ไม่เกิน 6 กล้อง และเวลารวมไม่เกิน 3 ชั่วโมงต่อครั้ง หากต้องการไฟล์ยาวกว่านั้นหรือไฟล์ต้นฉบับ ให้ติดต่อศูนย์ CCTV ของกรุงเทพมหานคร</p>

<h2>กล้อง วงจรปิด ใช้ wifi บ้าน ดีไหม?</h2>
<div class="lead">
  <p>กล้อง วงจรปิด ใช้ wifi บ้าน เหมาะกับบ้านที่ติด 1–2 ตัวในตัวบ้าน เพราะติดตั้งง่ายและไม่ต้องเดินสายสัญญาณ แต่ถ้าติดภายนอกหรือมากกว่า 4 ตัว ระบบเดินสายเข้าเครื่องบันทึกเสถียรกว่า ภาพไม่หลุดเมื่อเน็ตบ้านล่ม และบันทึกต่อเนื่องได้ดีกว่า</p>
</div>

<figure class="blog-figure">
  <img src="https://pub-68154224aa0d447b83de9bf218e76277.r2.dev/images/services/cctv-installation-img2-cf62dc72-3fe3-4550-8d74-12ef65465498-1784963960.webp" alt="ช่างติดตั้ง กล้อง วงจรปิด แบบกระบอกที่มุมฝ้าภายในอาคาร" width="1200" height="811" loading="lazy" decoding="async" class="img-responsive">
  <figcaption>กล้องแบบกระบอกติดมุมฝ้าในตัวอาคาร ต้องมีจุดยึดแน่นและเก็บสายให้ไม่ห้อยออกจากตัวกล้อง</figcaption>
</figure>

<div class="table-responsive"><table class="table table-hover">
<thead>
<tr><th>เทียบ</th><th>กล้อง wifi</th><th>กล้องเดินสาย (DVR/NVR)</th></tr>
</thead>
<tbody>
<tr><td>จำนวนที่เหมาะ</td><td>1–2 ตัว</td><td>4–16 ตัวขึ้นไป</td></tr>
<tr><td>ความเสถียร</td><td>ขึ้นกับสัญญาณ wifi และระยะห่างจากเราเตอร์</td><td>สูง ไม่ขึ้นกับ wifi</td></tr>
<tr><td>การบันทึก</td><td>MicroSD หรือคลาวด์รายเดือน</td><td>ฮาร์ดดิสก์ 1–8TB ในเครื่องบันทึก</td></tr>
<tr><td>ไฟฟ้า</td><td>ต้องมีปลั๊กใกล้จุดติด</td><td>ใช้ไฟจากเครื่องบันทึกหรือ PoE ได้</td></tr>
<tr><td>เหมาะกับ</td><td>ห้องนั่งเล่น ดูเด็กหรือสัตว์เลี้ยง</td><td>รอบบ้าน ร้านค้า โรงงาน</td></tr>
</tbody>
</table></div>

<p>ถ้าจุดติดกล้อง wifi ยังไม่มีปลั๊ก ต้องเพิ่มจุดไฟก่อน งานนี้ทำคู่กับ<a href="/electrical-wiring">งานเดินสายไฟฟ้า</a>ได้ เคล็ดลับถ้าเลือกกล้อง wifi คือใช้คลื่น 2.4GHz ซึ่งทะลุผนังได้ดีกว่า วางกล้องไม่ไกลจากเราเตอร์เกินหนึ่งผนังปูน และตั้งรหัสผ่านใหม่แทนค่าจากโรงงานทุกครั้ง</p>

<h2>บ้าน ร้าน โรงงาน ต้องใช้ กล้อง วงจรปิด กี่ตัว ราคาเท่าไร?</h2>
<div class="lead">
  <p>บ้านทาวน์เฮาส์ใช้ 2–4 ตัว งบราว 10,000–25,000 บาทครบชุด ร้านค้าใช้ 4–8 ตัว และโรงงานใช้ 16 ตัวขึ้นไปโดยงบเริ่ม 80,000 บาท ราคานี้รวมกล้อง เครื่องบันทึก ฮาร์ดดิสก์ ค่าแรง และตั้งค่าแอปดูผ่านมือถือแล้ว ตัวเลขด้านล่างเป็นช่วงจากแพ็กเกจบนหน้าบริการ ราคาจริงคำนวณหลังดูหน้างาน</p>
</div>

<div class="table-responsive"><table class="table table-hover">
<thead>
<tr><th>ประเภทพื้นที่</th><th>จำนวนกล้องแนะนำ</th><th>งบประมาณครบชุด (บาท)</th><th>สเปกหลัก</th></tr>
</thead>
<tbody>
<tr><td>บ้าน/ทาวน์เฮาส์</td><td>2–4 ตัว</td><td>10,000–25,000</td><td>Full HD 2–4MP, ฮาร์ดดิสก์ 1–2TB</td></tr>
<tr><td>บ้านเดี่ยว 2 ชั้น</td><td>4–8 ตัว</td><td>15,000–50,000</td><td>4 ตัวอยู่ช่วง 15,000–25,000 และ 8 ตัวอยู่ช่วง 30,000–50,000</td></tr>
<tr><td>ร้านค้า/ร้านอาหาร</td><td>4–8 ตัว</td><td>25,000–60,000</td><td>ช่วงสรุปบนหน้าบริการ แพ็กเกจ 8 ตัวอยู่ที่ 30,000–50,000</td></tr>
<tr><td>ออฟฟิศ</td><td>8–16 ตัว</td><td>30,000 ขึ้นไป</td><td>8 ตัวอยู่ที่ 30,000–50,000 และ 16 ตัวเริ่ม 80,000</td></tr>
<tr><td>โรงงาน/คลังสินค้า</td><td>16 ตัวขึ้นไป</td><td>80,000 ขึ้นไป</td><td>กล้อง IP67, NVR, ฮาร์ดดิสก์ 8TB, ระบบ LAN</td></tr>
</tbody>
</table></div>

<p>ดูรายละเอียดแพ็กเกจทั้ง 4 แบบได้ที่หน้า <a href="/cctv-installation">รับติดตั้ง กล้อง วงจรปิด กรุงเทพ–ปริมณฑล ราคาโปร่งใส</a></p>

<h2>ติด กล้อง วงจรปิด กรุงเทพ และปริมณฑล ต้องระวังอะไรตามพื้นที่?</h2>
<div class="lead">
  <p>แต่ละพื้นที่มีโจทย์ต่างกัน ในเมืองต้องระวังมุมกล้องที่ล้ำเข้าบ้านข้างเคียง ส่วนโซนตะวันออกอย่างลาดกระบังและสมุทรปราการต้องรับมือน้ำท่วมขัง พื้นที่โล่ง และระยะสายที่ยาว การเลือกกล้องและวิธีเดินสายจึงต้องดูหน้างานจริงก่อนเสมอ</p>
</div>

<h3>กล้อง วงจรปิด กรุงเทพ: ทาวน์เฮาส์ ตึกแถว ซอยแคบ</h3>
<p>บ้านในเมืองมักมีหน้าบ้านกว้าง 4–6 เมตร ใช้กล้องเลนส์มุมกว้าง 2.8 มม. 1–2 ตัวก็ครอบคลุม ควรหันกล้องเข้าพื้นที่ของตัวเอง ไม่เล็งเข้าหน้าต่างเพื่อนบ้าน เพื่อเลี่ยงปัญหาความเป็นส่วนตัวตาม พ.ร.บ. คุ้มครองข้อมูลส่วนบุคคล และเดินสายในรางหรือท่อให้เรียบร้อยกับผนัง</p>

<h3>กล้อง วงจรปิด ลาดกระบัง: โกดัง หอพัก พื้นที่ใกล้นิคม</h3>
<p>ลาดกระบังมีทั้งนิคมอุตสาหกรรม โกดัง และหอพักใกล้สถานศึกษา พื้นที่โล่งและแสงน้อยตอนกลางคืน ควรใช้กล้องกันน้ำระดับ IP67 ที่มีอินฟราเรดหรือภาพสีกลางคืน ติดสูงจากพื้นอย่างน้อย 2.5–3 เมตร และยกเครื่องบันทึกให้พ้นระดับน้ำท่วมขัง</p>

<h3>กล้อง วงจรปิด สมุทรปราการ: โรงงานและนิคมอุตสาหกรรม</h3>
<p>โรงงานในบางพลี บางปู และบางบ่อ มักมีระยะจากกล้องถึงห้องควบคุมเกิน 100 เมตร ซึ่งเกินระยะสาย LAN ปกติ จึงต้องวางระบบสายสัญญาณภายนอกหรือไฟเบอร์ร่วมด้วย ทีมงานธีรพงษ์ เซอร์วิส รับงานโรงงานในสมุทรปราการเป็นประจำ และทำ<a href="/outdoor-lan-cabling">เดินสายแลนภายนอกอาคาร</a>ให้ได้ในงานเดียว งานโรงงานที่ต้องวางระบบสายสัญญาณทั้งอาคารสามารถดูแนวทางจาก<a href="https://boabuildtech.com/services/mechanical-and-electrical-work/network-cabling" target="_blank" rel="noopener noreferrer">งานระบบ IT Infrastructure และสายสัญญาณสำหรับโรงงาน</a>ของทีมในเครือได้</p>

<h2>ดูกล้องที่บ้านผ่านมือถือได้อย่างไร?</h2>
<div class="lead">
  <p>ดูกล้องที่บ้านผ่านมือถือได้ด้วยแอปของยี่ห้อกล้อง เช่น Hik-Connect ของ Hikvision, DMSS ของ Dahua หรือ EZView ของ UNV โดยต่อเครื่องบันทึกเข้าอินเทอร์เน็ตบ้าน แล้วสแกน QR Code ในแอป ใช้เวลาตั้งค่าไม่เกิน 10–15 นาที และดูได้ทุกที่ที่มีเน็ต</p>
</div>
<ol>
  <li>ต่อสาย LAN จากเครื่องบันทึกเข้าเราเตอร์ ส่วนกล้อง wifi เชื่อม wifi บ้านตรง</li>
  <li>ติดตั้งแอปตามยี่ห้อ: Hik-Connect, DMSS หรือ EZView</li>
  <li>สแกน QR Code ที่เครื่องบันทึกหรือตัวกล้อง</li>
  <li>ตั้งรหัสผ่านใหม่ และเปิดยืนยันตัวตน 2 ชั้นถ้ามี</li>
  <li>ตั้งแจ้งเตือนเฉพาะการตรวจจับคนหรือรถ เพื่อลดแจ้งเตือนเกินจำเป็น</li>
</ol>
<figure class="blog-figure">
  <img src="https://pub-68154224aa0d447b83de9bf218e76277.r2.dev/images/blogs/blogcctv-red-light-meaning-8905d3f9-a500-4b32-a0b9-022f75daea24-1785777476.webp" alt="กล้อง วงจรปิด ติดผนังในที่มืด มีแสงสีแดงจากไฟอินฟราเรด" width="1200" height="959" loading="lazy" decoding="async" class="img-responsive">
  <figcaption>แสงสีแดงรอบกล้องตอนกลางคืนมักมาจากไฟอินฟราเรด ไม่ได้แปลว่าเครื่องเสียทุกกรณี</figcaption>
</figure>
<p>ถ้ากล้องขึ้นไฟสีแดงหรือไฟกะพริบ อ่านความหมายของไฟแต่ละแบบที่บทความ <a href="/blogs/cctv-red-light-meaning">กล้อง วงจรปิด ขึ้นไฟสีแดง แก้ยังไง</a></p>

<h2>จากหน้างานจริง: ปัญหาที่เจอบ่อยหลังติด กล้อง วงจรปิด เอง</h2>
<div class="lead">
  <p>จากงานติดตั้งในกรุงเทพฯ และปริมณฑล รูปแบบที่เจอซ้ำเมื่อเจ้าของบ้านติดเองมี 4 แบบ หัวข้อนี้เล่าเป็นรูปแบบที่พบบ่อย ไม่ใช่ตัวเลขงบหรือระยะเวลาของงานใดงานหนึ่ง</p>
</div>
<ul class="service-checklist">
  <li><i class="bi bi-exclamation-triangle-fill"></i><span><strong>กล้อง wifi หลายตัวภาพหลุดตอนกลางคืน</strong> เพราะเราเตอร์อยู่คนละชั้นกับจุดติด ทางแก้คือย้ายมาเดินสายเข้าเครื่องบันทึก หรือเพิ่มจุดกระจายสัญญาณก่อนติดเพิ่ม</span></li>
  <li><i class="bi bi-exclamation-triangle-fill"></i><span><strong>สายพาดเกะกะ</strong> เพราะไม่ได้เดินในรางหรือท่อ เก็บสายทีหลังทำได้ แต่รื้อยากกว่าเดินให้จบตั้งแต่วันติดตั้ง</span></li>
  <li><i class="bi bi-exclamation-triangle-fill"></i><span><strong>กล้องหันย้อนแสง</strong> จนกลางวันเห็นแต่เงาคนเข้าประตู ต้องขยับมุมหรือเปลี่ยนจุดติดให้แสงอยู่ด้านหลังกล้อง</span></li>
  <li><i class="bi bi-exclamation-triangle-fill"></i><span><strong>ฮาร์ดดิสก์เต็มเร็ว</strong> เพราะตั้งบันทึกตลอดเวลาโดยไม่ใช้การบีบอัด H.265 การเปิดตรวจจับการเคลื่อนไหวช่วยยืดระยะเก็บภาพย้อนหลัง</span></li>
</ul>

<h2>ทำไมเลือกติด กล้อง วงจรปิด กับ ธีรพงษ์ เซอร์วิส?</h2>
<div class="lead">
  <p>บริษัท ธีรพงษ์ เซอร์วิส จำกัด ใช้ช่างประจำทีม ไม่จ้างช่วง แจ้งราคาครบชุดก่อนเริ่มงาน และส่งใบเสนอราคาภายใน 24 ชั่วโมง</p>
</div>
<ul class="service-checklist">
  <li><i class="bi bi-check-circle-fill"></i><span>ประเมินเบื้องต้นผ่าน LINE ฟรี และไม่มีค่าสำรวจหน้างาน</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span>เดินสายซ่อนในฝ้า ท่อ หรือราง ไม่พาดเกะกะ</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span>ตั้งค่าแอปดูผ่านมือถือให้พร้อมใช้ก่อนส่งมอบ</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span>ออกใบกำกับภาษีได้</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span>รับประกันงานติดตั้ง 1 ปี ทั้งอุปกรณ์และค่าแรง</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span>พื้นที่ให้บริการ: กรุงเทพฯ ทุกเขต นนทบุรี ปทุมธานี สมุทรปราการ</span></li>
</ul>

<h2>คำถามที่พบบ่อย</h2>
<div class="list-group">
  <div class="list-group-item">
    <h4>ดูกล้อง CCTV ออนไลน์ ฟรีได้จริงไหม?</h4>
    <p>ได้จริง กล้องสาธารณะของกรุงเทพมหานคร กรมทางหลวง และการทางพิเศษ เปิดให้ดูภาพสดฟรีผ่านแอป BMA Traffic, Thailand Highway Traffic และ EXAT Traffic รวมถึงเว็บ Longdo Traffic โดยไม่ต้องสมัครสมาชิก แต่ดูได้เฉพาะภาพสดตามถนนและแยก ไม่สามารถย้อนดูหรือเลือกมุมกล้องเองได้</p>
  </div>
  <div class="list-group-item">
    <h4>ขอภาพย้อนหลังจากกล้อง กทม. ได้ไหม?</h4>
    <p>ขอได้ แต่ย้อนดูเองในแอปไม่ได้ ต้องแจ้งความที่สถานีตำรวจท้องที่เพื่อทำบันทึกประจำวัน แล้วเตรียมบันทึกประจำวัน สำเนาบัตรประชาชน และวันเวลาของภาพ จากนั้นยื่นคำขอที่เว็บไซต์ cctv.bangkok.go.th หรือ LINE @CCTVBANGKOK แล้วดาวน์โหลดเมื่อได้รับอนุมัติ คำขอออนไลน์ภายใน 24 ชั่วโมงขอได้ไม่เกิน 6 กล้อง และเวลารวมไม่เกิน 3 ชั่วโมงต่อครั้ง หากต้องการไฟล์ยาวกว่านั้นหรือไฟล์ต้นฉบับ ให้ติดต่อศูนย์ CCTV ของกรุงเทพมหานคร หากต้องการภาพย้อนหลังหน้าบ้านหรือร้านของตัวเองได้ทันที ควรติด กล้อง วงจรปิด ที่บันทึกลงเครื่องบันทึกของตัวเอง</p>
  </div>
  <div class="list-group-item">
    <h4>กล้อง วงจรปิด ใช้ wifi บ้าน ต้องใช้เน็ตแรงแค่ไหน?</h4>
    <p>กล้อง 2MP หนึ่งตัวใช้ความเร็วอัปโหลดราว 1–2 Mbps เมื่อเปิดดูสดผ่านมือถือ เน็ตบ้านทั่วไปจึงรองรับ 1–2 ตัวได้สบาย สิ่งที่สำคัญกว่าความเร็วคือความแรงสัญญาณ wifi ตรงจุดติดกล้อง ถ้ากล้องอยู่ห่างเราเตอร์เกินหนึ่งผนังปูน ควรเพิ่มตัวขยายสัญญาณหรือเปลี่ยนเป็นกล้องเดินสาย</p>
  </div>
  <div class="list-group-item">
    <h4>ติด กล้อง วงจรปิด บ้านทาวน์เฮาส์ ใช้เวลากี่วัน?</h4>
    <p>บ้านทาวน์เฮาส์ 2–4 ตัว โดยทั่วไปติดตั้งเสร็จภายใน 1 วัน รวมเดินสาย ตั้งค่าเครื่องบันทึก และตั้งค่าแอปดูผ่านมือถือ ส่วนร้านค้า 8 ตัวใช้ 1–2 วัน และโรงงาน 16 ตัวขึ้นไปขึ้นกับระยะเดินสาย หน้าบริการระบุระยะงาน 1–30 วันตามความซับซ้อนของหน้างาน</p>
  </div>
  <div class="list-group-item">
    <h4>ธีรพงษ์ เซอร์วิส รับติด กล้อง วงจรปิด สมุทรปราการ และลาดกระบังไหม?</h4>
    <p>รับ บริษัท ธีรพงษ์ เซอร์วิส จำกัด ให้บริการติดตั้ง กล้อง วงจรปิด ในกรุงเทพฯ ทุกเขตรวมถึงลาดกระบัง และปริมณฑล ได้แก่ นนทบุรี ปทุมธานี สมุทรปราการ รับทั้งบ้าน ร้านค้า และโรงงาน ประเมินเบื้องต้นผ่าน LINE @theeraphong ฟรี และไม่มีค่าสำรวจหน้างาน</p>
  </div>
</div>

<div class="well">
  <h3>อยากรู้ว่าบ้านคุณต้องใช้กล้องกี่ตัว?</h3>
  <p>ส่งรูปหน้าบ้านหรือแปลนคร่าว ๆ มาทาง LINE @theeraphong ทีมช่างจะแนะนำจุดติดและจำนวนกล้องให้ฟรี พร้อมราคาครบชุด โทร 061-563-9228 เปิดทำการจันทร์–เสาร์ 8:00–18:00 น.</p>
  <div class="blog-cta-actions">
    <a class="btn btn-primary" href="tel:0615639228"><i class="bi bi-telephone-fill"></i> โทร 061-563-9228</a>
    <a class="btn btn-info" href="https://lin.ee/Qq95f1b" target="_blank" rel="noopener noreferrer"><i class="bi bi-chat-dots-fill"></i> LINE @theeraphong</a>
    <a class="btn btn-default" href="/cctv-installation">ดูแพ็กเกจติดตั้ง กล้อง วงจรปิด</a>
  </div>
</div>
HTML;

$inner = trim($raw);
$transformed = str_starts_with($inner, '<div class="blog-content">')
    ? $inner
    : '<div class="blog-content">'.$inner.'</div>';

if (str_contains($transformed, 'กล้องวงจรปิด')) {
    fwrite(STDERR, "Glued keyword found in blog HTML\n");
    exit(1);
}

$title = 'กล้อง วงจรปิด 2026: ดูกล้องสาธารณะออนไลน์ฟรี และเลือกกล้องติดบ้านให้ใช้ได้จริง';
$slug = 'cctv-camera-guide';
$description = 'กล้อง วงจรปิด ดูออนไลน์ได้ที่ไหน? รวมแอปดูกล้องสาธารณะ ก ทม และทั่วประเทศ พร้อมวิธีเลือกกล้องติดบ้าน ร้าน โรงงาน ประเมินหน้างานฟรีทาง LINE @theeraphong';

$metaTitle = 'กล้อง วงจรปิด 2026: ดูกล้อง CCTV ออนไลน์ ก ทม + วิธีติดที่บ้าน';
echo 'meta title chars='.mb_strlen($metaTitle)."\n";
echo 'description chars='.mb_strlen($description)."\n";

$service = Service::query()->where('slug', 'cctv-installation')->firstOrFail();

$blog = Blog::query()->updateOrCreate(
    ['slug' => $slug],
    [
        'title' => $title,
        'description' => $description,
        'content' => $transformed,
        'service_id' => $service->id,
        'author' => 'ทีมช่างระบบ บริษัท ธีรพงษ์ เซอร์วิส จำกัด',
        'geo' => Blog::DEFAULT_GEO,
        'cover_image' => 'https://pub-68154224aa0d447b83de9bf218e76277.r2.dev/images/services/cctv-installation-img2-cf62dc72-3fe3-4550-8d74-12ef65465498-1784963960.webp',
    ]
);

$blog->forceFill([
    'created_at' => '2026-10-26 09:00:00',
    'updated_at' => '2026-10-26 09:00:00',
])->saveQuietly();

$serviceHtml = (string) $service->content;
$serviceHtml = str_replace('062-718-8847', '061-563-9228', $serviceHtml);
$link = '<p>ช่องทางดูกล้องสาธารณะออนไลน์และวิธีเลือกจำนวนกล้องติดบ้าน อ่านได้ในบทความ <a href="/blogs/cctv-camera-guide">กล้อง วงจรปิด 2026</a></p>';
if (! str_contains($serviceHtml, '/blogs/cctv-camera-guide')) {
    $needle = 'รวมถึงการรับการแจ้งเตือนเมื่อตรวจจับความเคลื่อนไหว</p>';
    if (! str_contains($serviceHtml, $needle)) {
        fwrite(STDERR, "Service content anchor for backlink was not found\n");
        exit(1);
    }
    $serviceHtml = str_replace($needle, 'รวมถึงการรับการแจ้งเตือนเมื่อตรวจจับความเคลื่อนไหว</p>'.$link, $serviceHtml);
}
$service->content = $serviceHtml;
$service->meta_des = str_replace('062-718-8847', '061-563-9228', (string) $service->meta_des);
$service->save();

$blog->load('service.category');
$graph = BlogPageSchema::graph($blog);
$faq = collect($graph['@graph'])->firstWhere('@type', 'FAQPage');
foreach ($faq['mainEntity'] as $item) {
    $question = $item['name'];
    $answer = $item['acceptedAnswer']['text'];
    if (! str_contains($transformed, $question) || ! str_contains($transformed, $answer)) {
        fwrite(STDERR, "FAQ mismatch: {$question}\n");
        exit(1);
    }
}

echo "Upserted blog #{$blog->id} slug={$blog->slug} (".strlen($transformed)." bytes)\n";
echo 'URL: '.route('blog.show', $blog->slug)."\n";
echo "service phone in meta={$service->meta_des}\n";
