<?php

/**
 * Import English tree-cutting case study blog + portfolio (Nawamin 30).
 * Source: Tree Cutting Service Case Study — Indian Cork & Cassia (12 Nov 2026)
 */

use App\Models\Blog;
use App\Models\ImageUpload;
use App\Models\Portfolio;
use App\Models\Service;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

// Same CDN host as /blogs/big-tree-cutting-price (existing Thai post).
$cdnBase = 'https://pub-68154224aa0d447b83de9bf218e76277.r2.dev/';
$cdn = static function (string $path) use ($cdnBase): string {
    return $cdnBase.ltrim($path, '/');
};

$coverPath = 'images/blogs/big-tree-cutting-price/big-tree-01.webp';
$img = [
    'hero' => $cdn($coverPath),
    'before' => $cdn('images/blogs/big-tree-cutting-price/big-tree-02.webp'),
    'processing1' => $cdn('images/blogs/big-tree-cutting-price/processing-big-tree-cutting-01.webp'),
    'processing2' => $cdn('images/blogs/big-tree-cutting-price/processing-big-tree-cutting-02.webp'),
    'after' => $cdn('images/blogs/big-tree-cutting-price/after-root-removed.webp'),
];

$phone = '061-563-9228';
$phoneTel = '0615639228';

$raw = <<<HTML
<p class="service-kicker"><span class="service-kicker-line"></span>Tree cutting case study</p>

<div class="blog-meta">
  <span><i class="bi bi-flag-fill"></i> Theeraphong Service Co., Ltd.</span>
  <span><i class="bi bi-geo-alt-fill"></i> Bangkok, Nonthaburi, Pathum Thani, Samut Prakan, Samut Sakhon, Nakhon Pathom</span>
  <span><i class="bi bi-calendar-check"></i> Published 12 November 2026</span>
</div>

<div class="lead">
  <p>Our <strong>tree cutting service</strong> removed two 10–14 m trees, an Indian cork tree and a cassia tree, from inside a house compound on Soi Nawamin 30, Bangkok. A 6-person crew felled both trees in sections from the top down, lowered every log by rope past the roof and power lines, then dug out the roots. The whole job took 2 days, with no damage to the house or the wires.</p>
</div>

<figure class="blog-figure">
  <img src="{$img['hero']}" alt="Indian cork and cassia trees 10–14 m tall inside a house compound on Soi Nawamin 30, Bangkok, before tree felling and root removal" width="1200" height="800" loading="eager" fetchpriority="high" decoding="async" class="img-responsive">
  <figcaption>Before: two 10–14 m trees inside the compound on Soi Nawamin 30, Bangkok</figcaption>
</figure>

<h2>What was the problem with these two trees?</h2>
<p>The roots were the real problem. The owner had planted an Indian cork tree (<em>Millingtonia hortensis</em>, ต้นปีบ) and a cassia tree (ต้นคูณ) inside the compound years ago. Both had grown to roughly 10–14 m, and their roots were pushing up the brick garden border, making it sink and crack. The roots were also spreading toward the house structure.</p>

<p>The site made the job harder:</p>
<ul class="service-checklist">
  <li><i class="bi bi-check-circle-fill"></i><span>The trees stood close to the house, so neither could fall in one piece.</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span>Some branches touched overhead power lines.</span></li>
  <li><i class="bi bi-check-circle-fill"></i><span>An iron fence sat in the work zone.</span></li>
</ul>

<figure class="blog-figure">
  <img src="{$img['before']}" alt="Large tree growing close to a house with its roots pushing up the brick garden border, before our tree cutting service began" width="1200" height="800" loading="lazy" decoding="async" class="img-responsive">
  <figcaption>Before: tree beside the house, roots pushing the brick border</figcaption>
</figure>

<h2>When should a large tree be felled instead of trimmed?</h2>
<div class="lead">
  <p>Fell the tree when its roots are damaging a structure or it has outgrown the space; trim it when the only issue is canopy size. Tree trimming keeps the tree alive and costs less, but it does nothing about roots. In this case the roots were already cracking hardscape, so trimming would only have delayed the damage. We recommended tree felling plus root removal in one visit.</p>
</div>

<div class="table-responsive"><table class="table table-hover">
<thead>
<tr><th>Option</th><th>Best when</th><th>What it leaves</th><th>Starting price (THB)</th></tr>
</thead>
<tbody>
<tr><td>Tree trimming</td><td>Canopy too dense or touching the roof; tree is healthy</td><td>Living tree, smaller canopy</td><td>From 1,500 per tree</td></tr>
<tr><td>Tree felling only</td><td>Tree must go, roots are not near any structure</td><td>A stump about 30–50 cm high</td><td>From 5,000 (open area, 6–10 m)</td></tr>
<tr><td>Felling + root removal</td><td>Roots are pushing floors, paving or borders</td><td>Clear, usable ground</td><td>Felling price + from 2,500 per stump</td></tr>
</tbody>
</table></div>

<p>For canopy-only work, see our <a href="/tree-trim">tree trimming service</a>. For full removal with hauling, see <a href="/tree-removal">tree cutting service in Bangkok</a>.</p>

<h2>How do you cut a tall tree next to a house with no room to fall?</h2>
<div class="lead">
  <p>You take it down in sections, from the top down, and lower each piece by rope. This is called sectional felling. It takes 2–3 times longer than dropping a tree in an open area, but it is the only safe method when a house, roof or wires block the fall zone.</p>
</div>

<p>Our sequence on this job:</p>
<ol>
  <li><strong>Protect the site.</strong> We removed part of the iron fence first so falling pieces could not bend it.</li>
  <li><strong>Climb and plan the cut order.</strong> Climbers went up with harnesses and chainsaws and worked out which limbs to remove first.</li>
  <li><strong>Cut and lower in sections.</strong> Each branch and trunk section was tied off, cut, and lowered by rope to a ground crew.</li>
  <li><strong>Clear the wires first.</strong> Branches touching the power lines were removed early, under rope control, so nothing dropped onto the lines.</li>
  <li><strong>Reduce the trunk.</strong> Once the crown was gone, the trunk came down in short, controlled lengths.</li>
</ol>

<figure class="blog-figure">
  <img src="{$img['processing1']}" alt="Tree climber cutting a tall tree in sections from the top down next to a house" width="1200" height="800" loading="lazy" decoding="async" class="img-responsive">
  <figcaption>During: climber cutting from the top down</figcaption>
</figure>

<figure class="blog-figure">
  <img src="{$img['processing2']}" alt="Crew lowering a cut log by rope to keep it clear of the roof and overhead power lines during tree felling" width="1200" height="800" loading="lazy" decoding="async" class="img-responsive">
  <figcaption>During: logs lowered by rope away from the roof and wires</figcaption>
</figure>

<h2>Is it safe to cut a tree near power lines?</h2>
<div class="lead">
  <p>Yes, if the cut order is planned and every piece is rope-controlled. The risk comes from branches swinging or dropping onto the line. We map which limbs touch or overhang the wires, remove those first, and never let a piece free-fall in that zone. For lines that carry high voltage, the job may also need coordination with the electricity authority before cutting starts.</p>
</div>

<h2>Why dig out the roots after tree felling?</h2>
<div class="lead">
  <p>Because felling alone does not stop root damage. A cut tree usually leaves a 30–50 cm stump, and the roots below it can keep growing, rot, or leave voids under paving. Here the roots were already cracking the brick border and heading for the house, so we dug them out on day two. <a href="/tree-removal">Stump and root removal</a> usually takes one day and needs digging equipment sized to the stump.</p>
</div>

<figure class="blog-figure">
  <img src="{$img['after']}" alt="Cleared ground after the Indian cork and cassia tree roots were dug out and all debris hauled away" width="1200" height="800" loading="lazy" decoding="async" class="img-responsive">
  <figcaption>After: roots removed, area cleared</figcaption>
</figure>

<h2>How long did the whole job take?</h2>
<p>Two days in total, with a 6-person crew:</p>

<div class="table-responsive"><table class="table table-hover">
<thead>
<tr><th>Day</th><th>Work</th></tr>
</thead>
<tbody>
<tr><td>Day 1</td><td>Fence protection, climbing, sectional cutting of both trees, lowering logs</td></tr>
<tr><td>Day 2</td><td>Root removal, hauling all logs and debris, site clean-up and handover</td></tr>
</tbody>
</table></div>

<p>The equipment was climbing gear, chainsaws and ropes. No crane or basket lift was needed.</p>

<h2>What was the result?</h2>
<p>Both trees and their roots are gone, and the ground is ready to use again. There was no damage to the house, the fence or the power lines. The job was finished at the quoted price, with no extra charges added on site. All logs and debris were hauled away, so the owner had nothing to clean up.</p>

<h2>How much does a tree cutting service cost in Bangkok?</h2>
<div class="lead">
  <p>Tree trimming starts from 1,500 THB per tree and tree felling from 5,000 THB, depending on height, position and access. These are 2026 starting prices; the final price is confirmed after we see the site.</p>
</div>

<div class="table-responsive"><table class="table table-hover">
<thead>
<tr><th>Job</th><th>Conditions</th><th>Starting price (THB)</th></tr>
</thead>
<tbody>
<tr><td>Tree trimming</td><td>Medium tree, dense canopy</td><td>From 1,500 per tree</td></tr>
<tr><td>Large branch / tall tree cutting</td><td>Near house, roof or power lines</td><td>From 3,500 per tree</td></tr>
<tr><td>Tree felling, open area</td><td>6–10 m, room to fall</td><td>From 5,000</td></tr>
<tr><td>Sectional felling</td><td>10–15 m, next to house, no fall space</td><td>From 10,000</td></tr>
<tr><td>Very large tree</td><td>Over 15 m or very wide trunk</td><td>Quoted after site survey</td></tr>
<tr><td>Stump and root removal</td><td>By stump size and machine access</td><td>From 2,500 per stump</td></tr>
<tr><td>Debris hauling</td><td>By truck trips</td><td>Included in the quote</td></tr>
</tbody>
</table></div>

<p>The main price drivers are height, trunk diameter, fall space, power lines, debris volume, and any special equipment. Cutting several trees in one visit lowers the cost per tree, because travel, truck and setup are shared. A site survey costs 1,500 THB and is deducted if you hire us; a photo estimate on LINE is free. Full breakdown: <a href="/blogs/big-tree-cutting-price">big tree cutting price guide</a>.</p>

<h2>Which areas does Theeraphong Service cover?</h2>
<p>Theeraphong Service Co., Ltd., a registered contractor based in Nonthaburi, provides tree cutting, tree trimming, tree felling and root removal in Bangkok, Nonthaburi, Pathum Thani, Samut Prakan, Samut Sakhon and Nakhon Pathom. We work Monday to Saturday, 8:00–18:00.</p>

<h2>Have a tree that needs to go?</h2>
<p>Send us 2–3 photos of the tree, showing the trunk, the house and any wires nearby, and we will reply with a preliminary price.</p>
<ul>
  <li><strong>LINE:</strong> @theeraphong</li>
  <li><strong>Phone:</strong> {$phone}</li>
  <li><strong>Website:</strong> www.theeraphong.com</li>
</ul>

<h2>Frequently asked questions</h2>
<div class="list-group">
  <div class="list-group-item">
    <h4>How much does a tree cutting service cost in Bangkok?</h4>
    <p>Tree trimming starts from 1,500 THB per tree. Tree felling starts from 5,000 THB for a 6–10 m tree in an open area, and from 10,000 THB for sectional felling of a 10–15 m tree next to a house. Stump and root removal starts from 2,500 THB per stump. The final price is confirmed after a site survey.</p>
  </div>
  <div class="list-group-item">
    <h4>What is the difference between tree trimming and tree felling?</h4>
    <p>Tree trimming removes branches to reduce the canopy and keeps the tree alive. Tree felling removes the whole tree down to a stump. Trimming is cheaper and suits healthy trees that are only too dense. Felling is the right choice when roots damage a structure or the tree has outgrown its space.</p>
  </div>
  <div class="list-group-item">
    <h4>Do I need to remove the roots after felling a tree?</h4>
    <p>Yes, if the roots are near a floor, paving, wall or brick border. Felling leaves a stump about 30–50 cm high, and the roots below can keep spreading or rot and leave voids. Root removal usually takes one extra day and starts from 2,500 THB per stump.</p>
  </div>
  <div class="list-group-item">
    <h4>How long does tree felling with root removal take?</h4>
    <p>A typical job with one or two large trees takes about 2 days: one day for cutting and one day for root removal and hauling. Our Soi Nawamin 30 job, with two 10–14 m trees next to a house, was finished in 2 days by a 6-person crew.</p>
  </div>
  <div class="list-group-item">
    <h4>Can you cut a tree that is touching power lines?</h4>
    <p>Yes. We plan the cut order, remove the branches touching or overhanging the wires first, and lower every piece by rope so nothing drops onto the line. For high-voltage lines, the work may need coordination with the electricity authority before cutting starts.</p>
  </div>
  <div class="list-group-item">
    <h4>Can I get a quote without a site visit?</h4>
    <p>Yes. Send 2–3 photos of the tree, its trunk and anything nearby, such as the house or wires, to LINE @theeraphong for a free preliminary price. A site survey costs 1,500 THB and is deducted from the job if you hire us.</p>
  </div>
</div>

<div class="well">
  <h3>Need a tree cutting quote?</h3>
  <p>Send 2–3 photos of the tree, the house and any nearby wires. We reply with a preliminary price at no charge.</p>
  <p><strong>Theeraphong Service Co., Ltd.</strong> — tree cutting, tree trimming, tree felling and root removal in Bangkok and nearby provinces.</p>
  <div class="blog-cta-actions">
    <a class="btn btn-primary" href="tel:{$phoneTel}"><i class="bi bi-telephone-fill"></i> Call {$phone}</a>
    <a class="btn btn-info" href="https://lin.ee/Qq95f1b"><i class="bi bi-chat-dots-fill"></i> LINE @theeraphong</a>
    <a class="btn btn-default" href="/tree-removal">Tree cutting service</a>
    <a class="btn btn-default" href="/blogs/big-tree-cutting-price">Thai price guide</a>
  </div>
</div>
HTML;

$inner = trim($raw);
$transformed = str_starts_with($inner, '<div class="blog-content">')
    ? $inner
    : '<div class="blog-content">'.$inner.'</div>';

$title = 'Tree Cutting Service Case Study: Felling an Indian Cork and a Cassia Tree, With Full Root Removal';
$slug = 'tree-cutting-service-root-removal';
$description = 'Tree cutting service case study, Bangkok: two 10–14 m Indian cork and cassia trees felled near power lines and roots dug out in 2 days. Free LINE quote.';

$treeRemoval = Service::query()->where('slug', 'tree-removal')->first();
$treeTrim = Service::query()->where('slug', 'tree-trim')->first();
$serviceId = $treeRemoval?->id ?? $treeTrim?->id;

$blog = Blog::query()->updateOrCreate(
    ['slug' => $slug],
    [
        'title' => $title,
        'description' => $description,
        'content' => $transformed,
        'service_id' => $serviceId,
        'author' => 'Theeraphong Service Co., Ltd.',
        'geo' => Blog::DEFAULT_GEO,
        'cover_image' => $coverPath,
    ]
);

$blog->forceFill([
    'created_at' => '2026-11-12 10:00:00',
    'updated_at' => '2026-11-12 10:00:00',
])->saveQuietly();

ImageUpload::query()
    ->where('imageable_type', Blog::class)
    ->where('imageable_id', $blog->id)
    ->delete();

$imageUrls = [
    $img['hero'] => 'Indian cork and cassia trees 10–14 m tall, Soi Nawamin 30, before felling',
    $img['before'] => 'Tree close to house with roots pushing brick border',
    $img['processing1'] => 'Climber cutting tall tree in sections from the top down',
    $img['processing2'] => 'Crew lowering cut log by rope clear of roof and power lines',
    $img['after'] => 'Cleared ground after root removal and debris hauling',
];

foreach ($imageUrls as $url => $location) {
    ImageUpload::query()->create([
        'imageable_type' => Blog::class,
        'imageable_id' => $blog->id,
        'img_url' => $url,
        'location' => $location,
        'worked_date' => '2026-11-12 10:00:00',
    ]);
}

echo "Upserted blog #{$blog->id} slug={$blog->slug} (".strlen($transformed)." bytes)\n";
echo "cover_image={$blog->cover_image}\n";
echo 'images='.$blog->images()->count()."\n";
echo 'URL: '.route('blog.show', $blog->slug)."\n";

if (! $treeRemoval) {
    echo "SKIP portfolio: tree-removal service not found\n";
    exit(0);
}

$portfolioSlug = 'tree-nawamin-30-cork-cassia';
$portfolioContent = <<<HTML
<p>งานตัดต้นปีบและต้นคูณสูงประมาณ 10–14 เมตร ในตัวบ้าน ซอยนวมินทร์ 30 กรุงเทพฯ รากดันแนวอิฐตัวหนอนและลามเข้าหาโครงสร้างบ้าน กิ่งพาดสายไฟเล็กน้อย จึงล้มทั้งต้นไม่ได้</p>
<p>ทีมงาน 6 คน ถอดรั้วเหล็กบางส่วนออกก่อน ตัดจากยอดลงมาทีละท่อนแล้วหย่อนด้วยเชือก ขุดราก และขนเศษไม้ทิ้ง เสร็จภายใน 2 วัน ตัวบ้าน รั้ว และสายไฟไม่เสียหาย</p>
<p>อ่านรายละเอียดเคสนี้เป็นภาษาอังกฤษได้ที่ <a href="/blogs/tree-cutting-service-root-removal">tree cutting service case study</a> และดูตารางราคาภาษาไทยที่ <a href="/blogs/big-tree-cutting-price">ตัดต้นไม้ใหญ่ ราคา</a></p>
HTML;

$portfolio = Portfolio::query()->updateOrCreate(
    ['slug' => $portfolioSlug],
    [
        'service_id' => $treeRemoval->id,
        'title' => 'ตัดต้นปีบและต้นคูณ ขุดราก ซ.นวมินทร์ 30',
        'location' => 'ซอยนวมินทร์ 30 — กรุงเทพฯ',
        'project_length' => null,
        'content' => $portfolioContent,
        'cover_image' => $img['hero'],
        'completion_date' => '2026-11-07',
    ]
);

ImageUpload::query()
    ->where('imageable_type', Portfolio::class)
    ->where('imageable_id', $portfolio->id)
    ->delete();

$portfolioImages = [
    $img['hero'] => 'ก่อนตัด: ต้นปีบและต้นคูณในตัวบ้าน ซ.นวมินทร์ 30',
    $img['before'] => 'ต้นไม้ชิดบ้าน รากดันแนวอิฐตัวหนอน',
    $img['processing1'] => 'ระหว่างตัด: ปีนตัดจากยอดลงมาทีละท่อน',
    $img['processing2'] => 'ระหว่างตัด: หย่อนท่อนไม้ด้วยเชือก หลบสายไฟและหลังคา',
    $img['after'] => 'หลังขุดรากและขนทิ้ง พื้นที่พร้อมใช้งานต่อ',
];

foreach ($portfolioImages as $url => $location) {
    ImageUpload::query()->create([
        'imageable_type' => Portfolio::class,
        'imageable_id' => $portfolio->id,
        'img_url' => $url,
        'location' => $location,
        'worked_date' => '2026-11-07 10:00:00',
    ]);
}

echo "Upserted portfolio #{$portfolio->id} slug={$portfolio->slug}\n";
echo 'portfolio images='.$portfolio->images()->count()."\n";
echo "service={$treeRemoval->slug} #{$treeRemoval->id}\n";

// Cross-link from Thai price guide → English case study
$thaiBlog = Blog::query()->where('slug', 'big-tree-cutting-price')->first();
if ($thaiBlog && is_string($thaiBlog->content) && ! str_contains($thaiBlog->content, '/blogs/tree-cutting-service-root-removal')) {
    $patched = str_replace(
        'ราคาตามใบเสนอราคาโดยไม่มีค่าใช้จ่ายเพิ่ม</td></tr>
</tbody>
</table></div>',
        'ราคาตามใบเสนอราคาโดยไม่มีค่าใช้จ่ายเพิ่ม</td></tr>
</tbody>
</table></div>

<p>อ่านเคสนี้เป็นภาษาอังกฤษได้ที่ <a href="/blogs/tree-cutting-service-root-removal">tree cutting service case study</a></p>',
        $thaiBlog->content,
        $count
    );

    if ($count > 0) {
        $thaiBlog->forceFill(['content' => $patched])->saveQuietly();
        echo "Linked Thai blog #{$thaiBlog->id} → English case study\n";
    } else {
        echo "WARN: could not patch Thai blog cross-link\n";
    }
}

// Cross-link from tree-removal service → English case study
if (is_string($treeRemoval->content) && ! str_contains($treeRemoval->content, '/blogs/tree-cutting-service-root-removal')) {
    $patchedService = str_replace(
        'ตัวบ้านและสายไฟไม่เสียหาย</p>',
        'ตัวบ้านและสายไฟไม่เสียหาย อ่านรายละเอียดเคสนี้เป็นภาษาอังกฤษได้ที่ <a href="/blogs/tree-cutting-service-root-removal">tree cutting service case study</a></p>',
        $treeRemoval->content,
        $svcCount
    );

    if ($svcCount > 0) {
        $treeRemoval->forceFill(['content' => $patchedService])->saveQuietly();
        echo "Linked service #{$treeRemoval->id} → English case study\n";
    } else {
        echo "WARN: could not patch tree-removal cross-link\n";
    }
}
