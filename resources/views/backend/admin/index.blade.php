
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}"/>
  <title>Admin — ธีรพงษ์การช่าง</title>
  <link rel="icon" href="{{ config('company.favicon') }}" type="image/png" sizes="180x180">
  <link rel="apple-touch-icon" href="{{ config('company.favicon') }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: { extend: {
        colors: {
          'navy-950':'#04111d','navy-900':'#071a2c','navy-800':'#0a2540','navy-700':'#0a3d62',
          'accent':'#0a3d62','hivis':'#ffc83a','ink':'#0f1722','ink2':'#36475a',
          'muted':'#6a7787','line':'#e3e7ee','surface':'#f6f8fb'
        },
        fontFamily: {
          sans:['"IBM Plex Sans Thai"','"IBM Plex Sans"','sans-serif'],
          mono:['"IBM Plex Mono"','"IBM Plex Sans"','monospace']
        }
      }}
    }
  </script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@300;400;500;600;700&family=IBM+Plex+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet"/>
  <style>
    *{box-sizing:border-box;margin:0;padding:0;}
    ::-webkit-scrollbar{width:4px;height:4px;}
    ::-webkit-scrollbar-track{background:transparent;}
    ::-webkit-scrollbar-thumb{background:#c5cdd6;border-radius:99px;}
    .nav-item{position:relative;}
    .nav-item.active{background:rgba(255,200,58,0.10);}
    .nav-item.active::before{content:'';position:absolute;left:0;top:5px;bottom:5px;width:3px;background:#ffc83a;border-radius:0 3px 3px 0;}
    .nav-item.active .ni{color:#ffc83a!important;}
    .nav-item.active .nl{color:#fff!important;}
    .clamp1{overflow:hidden;display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;}
    .clamp2{overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;}
    tr:hover td{background:#f9fafc;}
    .img-card:hover .img-overlay{opacity:1;}
    .img-overlay{opacity:0;transition:opacity .2s;}
    input,select,textarea{font-family:inherit;}
  </style>
</head>
<body class="bg-surface text-ink font-sans antialiased" style="height:100vh;overflow:hidden;">

<div style="display:flex;height:100vh;overflow:hidden;">

  <!-- ═══ SIDEBAR ═══ -->
  <aside style="width:220px;flex-shrink:0;background:#071a2c;display:flex;flex-direction:column;height:100%;overflow-y:auto;">
    <!-- Brand -->
    <a href="uploads/index.html" style="display:flex;align-items:center;gap:10px;padding:16px 16px 14px;border-bottom:1px solid rgba(255,255,255,.08);text-decoration:none;">
      <span style="position:relative;display:grid;place-items:center;width:34px;height:34px;border-radius:8px;background:#fff;color:#071a2c;font-weight:700;font-size:12px;font-family:monospace;flex-shrink:0;">TP
        <span style="position:absolute;width:6px;height:6px;background:#ffc83a;border-radius:2px;transform:translate(8px,8px);"></span>
      </span>
      <div>
        <div style="font-weight:700;color:#fff;font-size:13px;line-height:1.2;">ธีรพงษ์การช่าง</div>
        <div style="font-size:10px;color:rgba(255,255,255,.35);letter-spacing:.12em;font-family:monospace;">ADMIN</div>
      </div>
    </a>

    <!-- Nav -->
    <nav id="sideNav" style="flex:1;padding:10px 8px 8px;display:flex;flex-direction:column;gap:2px;"></nav>

    <!-- User -->
    <div style="padding:10px 8px;border-top:1px solid rgba(255,255,255,.08);">
      <div style="display:flex;align-items:center;gap:10px;padding:10px 10px;border-radius:12px;cursor:pointer;transition:background .15s;" onmouseover="this.style.background='rgba(255,255,255,.05)'" onmouseout="this.style.background='transparent'">
        <div style="width:32px;height:32px;border-radius:50%;background:#ffc83a;display:grid;place-items:center;color:#071a2c;font-weight:700;font-size:13px;flex-shrink:0;">T</div>
        <div style="flex:1;min-width:0;">
          <div style="color:#fff;font-size:13px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">Admin</div>
          <div style="color:rgba(255,255,255,.35);font-size:11px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">work@theeraphong.co.th</div>
        </div>
        <i class="bi bi-box-arrow-right" style="color:rgba(255,255,255,.25);font-size:14px;"></i>
      </div>
    </div>
  </aside>

  <!-- ═══ MAIN ═══ -->
  <div style="flex:1;display:flex;flex-direction:column;overflow:hidden;min-width:0;">

    <!-- Header -->
    <header style="height:54px;background:#fff;border-bottom:1px solid #e3e7ee;display:flex;align-items:center;padding:0 24px;gap:14px;flex-shrink:0;z-index:10;">
      <div style="flex:1;display:flex;align-items:center;gap:8px;">
        <span style="font-size:11px;color:#6a7787;font-weight:600;letter-spacing:.06em;text-transform:uppercase;" id="headerBread">—</span>
        <i class="bi bi-chevron-right" style="font-size:9px;color:#c5cdd6;"></i>
        <span id="headerTitle" style="font-size:15px;font-weight:700;color:#071a2c;"></span>
      </div>
      <div style="display:flex;align-items:center;gap:10px;">
        <div style="position:relative;">
          <i class="bi bi-search" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#6a7787;font-size:12px;pointer-events:none;"></i>
          <input id="searchInput" placeholder="ค้นหา..." oninput="handleSearch(this.value)"
            style="width:180px;border-radius:10px;background:#f6f8fb;border:1px solid #e3e7ee;padding:6px 12px 6px 30px;font-size:13px;outline:none;transition:border-color .15s;"
            onfocus="this.style.borderColor='#0a3d62'" onblur="this.style.borderColor='#e3e7ee'"/>
        </div>
        <button style="position:relative;width:34px;height:34px;display:grid;place-items:center;border-radius:10px;border:1px solid #e3e7ee;background:transparent;cursor:pointer;color:#6a7787;transition:all .15s;"
          onmouseover="this.style.borderColor='#0a3d62';this.style.color='#0a3d62'" onmouseout="this.style.borderColor='#e3e7ee';this.style.color='#6a7787'">
          <i class="bi bi-bell" style="font-size:14px;"></i>
          <span style="position:absolute;top:7px;right:7px;width:7px;height:7px;background:#ffc83a;border-radius:50%;border:2px solid #fff;"></span>
        </button>
        <div style="width:34px;height:34px;border-radius:50%;background:#ffc83a;display:grid;place-items:center;color:#071a2c;font-weight:700;font-size:13px;cursor:pointer;flex-shrink:0;">T</div>
      </div>
    </header>

    <!-- Content -->
    <main id="mainContent" style="flex:1;overflow-y:auto;"></main>
  </div>
</div>

<!-- ═══ EDIT / ADD MODAL ═══ -->
<div id="modalOverlay" style="display:none;position:fixed;inset:0;z-index:100;background:rgba(4,17,29,.65);backdrop-filter:blur(4px);align-items:center;justify-content:center;padding:16px;">
  <div id="modalBox" style="background:#fff;border-radius:20px;box-shadow:0 32px 80px rgba(4,17,29,.35);width:100%;max-width:460px;max-height:88vh;overflow-y:auto;"></div>
</div>

<!-- ═══ DELETE CONFIRM ═══ -->
<div id="confirmOverlay" style="display:none;position:fixed;inset:0;z-index:110;background:rgba(4,17,29,.65);backdrop-filter:blur(4px);align-items:center;justify-content:center;padding:16px;">
  <div style="background:#fff;border-radius:20px;box-shadow:0 32px 80px rgba(4,17,29,.35);width:100%;max-width:360px;padding:28px 28px 24px;">
    <div style="width:48px;height:48px;border-radius:50%;background:#fef2f2;display:grid;place-items:center;margin:0 auto 16px;">
      <i class="bi bi-trash3" style="color:#ef4444;font-size:20px;"></i>
    </div>
    <h3 style="text-align:center;font-weight:700;color:#071a2c;font-size:17px;margin-bottom:6px;">ยืนยันการลบ?</h3>
    <p id="confirmMsg" style="text-align:center;color:#6a7787;font-size:14px;"></p>
    <div style="display:flex;gap:10px;margin-top:22px;">
      <button onclick="closeConfirm()" style="flex:1;padding:11px;border-radius:12px;border:1px solid #e3e7ee;font-size:14px;font-weight:600;color:#36475a;cursor:pointer;background:#fff;transition:background .15s;" onmouseover="this.style.background='#f6f8fb'" onmouseout="this.style.background='#fff'">ยกเลิก</button>
      <button id="confirmOkBtn" style="flex:1;padding:11px;border-radius:12px;border:none;font-size:14px;font-weight:600;color:#fff;background:#ef4444;cursor:pointer;transition:background .15s;" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">ลบรายการ</button>
    </div>
  </div>
</div>

<!-- ═══ TOAST ═══ -->
<div id="toast" style="display:none;position:fixed;bottom:24px;right:24px;z-index:200;background:#071a2c;color:#fff;padding:12px 18px;border-radius:14px;font-size:14px;font-weight:500;box-shadow:0 8px 32px rgba(4,17,29,.35);display:flex;align-items:center;gap:8px;"></div>

<script>
/* ══════════════ DATA ══════════════ */
let DB = {
  services:[],
  categories:[],
  servicePrices:[],
  priceServices:[],
  priceTypes:{},
  blog:[
    {id:1,title:'กำแพงกันดินคืออะไร? เลือกแบบไหนดีสำหรับบ้านคุณ',        cat:'เทคนิคก่อสร้าง',author:'ธีรพงษ์', date:'2026-06-15',status:'published',views:1240},
    {id:2,title:'5 สัญญาณที่บอกว่ารั้วบ้านถึงเวลาซ่อมแซมแล้ว',              cat:'บำรุงรักษา',     author:'ทีมงาน',  date:'2026-06-01',status:'published',views:890},
    {id:3,title:'ลานคอนกรีตขัดมัน vs ลานปูอิฐ: เลือกแบบไหนดี?',            cat:'เปรียบเทียบ',   author:'วิศวกร',  date:'2026-05-20',status:'published',views:2100},
    {id:4,title:'วิธีป้องกันน้ำท่วมขังในที่ดิน ด้วยระบบระบายน้ำที่ถูกต้อง', cat:'เทคนิคก่อสร้าง',author:'วิศวกร',  date:'2026-05-10',status:'published',views:675},
    {id:5,title:'รีวิว: โครงการกำแพงกันดินบางบัวทอง 64 เมตร',               cat:'กรณีศึกษา',    author:'ธีรพงษ์', date:'2026-04-28',status:'published',views:432},
    {id:6,title:'เตรียมพื้นที่ก่อนสร้างบ้าน: ถมดิน บดอัด ระดับได้มาตรฐาน', cat:'เทคนิคก่อสร้าง',author:'ทีมงาน',  date:'2026-04-10',status:'draft',    views:0},
  ],
  images:[
    {id:1,name:'project-wall-bangbuathong.jpg',  size:'2.4 MB',date:'2026-06-15',tag:'กำแพงกันดิน',src:'1590725140246-20acdee442be'},
    {id:2,name:'project-fence-rachapreuk.jpg',   size:'1.8 MB',date:'2026-06-01',tag:'รั้วบ้าน',    src:'1558618666-fcd25c85cd64'},
    {id:3,name:'project-road-pathumthani.jpg',   size:'3.1 MB',date:'2026-05-20',tag:'ถนน',          src:'1518709268805-4e9042af9f23'},
    {id:4,name:'project-slab-nonthaburi.jpg',    size:'1.5 MB',date:'2026-05-10',tag:'ลานคอนกรีต',  src:'1604719312566-8912e9227c6a'},
    {id:5,name:'project-wall-bangyang.jpg',      size:'2.9 MB',date:'2026-04-28',tag:'กำแพงกันดิน',src:'1517089596392-fb9a9033e05b'},
    {id:6,name:'project-drain-ladkrabang.jpg',   size:'1.2 MB',date:'2026-04-15',tag:'ระบายน้ำ',    src:'1581094288338-2314dddb7ece'},
    {id:7,name:'hero-team.jpg',                  size:'4.2 MB',date:'2026-03-20',tag:'ทีมงาน',      src:'1503387762-592deb58ef4e'},
    {id:8,name:'project-fence-nawanakorn.jpg',   size:'2.0 MB',date:'2026-03-10',tag:'รั้วบ้าน',    src:'1486718448742-163732cd1544'},
  ],
  users:[
    {id:1,name:'ธีรพงษ์ รักษาดี',     email:'work@theeraphong.co.th',        role:'owner', status:'active',  lastLogin:'2026-07-01', period:'2008-01 – ปัจจุบัน'},
    {id:2,name:'สมชาย ภักดี',          email:'somchai@theeraphong.co.th',     role:'admin', status:'active',  lastLogin:'2026-06-30', period:'2019-06 – ปัจจุบัน'},
    {id:3,name:'ปรียา วงศ์เจริญ',      email:'priya@theeraphong.co.th',       role:'editor',status:'active',  lastLogin:'2026-06-28', period:'2022-03 – ปัจจุบัน'},
    {id:4,name:'กชกร เลิศมงคล',        email:'kotchakorn@theeraphong.co.th',  role:'viewer',status:'inactive',lastLogin:'2026-06-01', period:'2023-09 – 2026-05'},
  ],
  quotes:[
    {id:1,name:'คุณมานพ ใจดี',       phone:'081-234-5678',service:'กำแพงกันดิน',budget:'500k–1M',  date:'2026-07-01',status:'new'},
    {id:2,name:'คุณวีระชัย สุขใจ',   phone:'089-876-5432',service:'รั้วบ้าน',    budget:'100k–500k',date:'2026-06-30',status:'contacted'},
    {id:3,name:'คุณอุไรวรรณ ทองดี',  phone:'062-345-6789',service:'ลานคอนกรีต', budget:'<100k',    date:'2026-06-29',status:'quoted'},
    {id:4,name:'คุณสมชาย ภัคดี',     phone:'091-234-5678',service:'ถนน & ทางเข้า',budget:'1M–3M',  date:'2026-06-28',status:'won'},
    {id:5,name:'คุณกชกร เลิศมงคล',   phone:'083-456-7890',service:'ระบายน้ำ',   budget:'100k–500k',date:'2026-06-27',status:'contacted'},
  ]
};

/* ══════════════ NAV ══════════════ */
const NAV = [
  {id:'dashboard',icon:'bi-grid-1x2-fill',  label:'Dashboard',   bread:'Overview'},
  {id:'services', icon:'bi-bricks',          label:'Services',    bread:'Content'},
  {id:'prices',   icon:'bi-tag-fill',        label:'Service Prices',bread:'Content'},
  {id:'blog',     icon:'bi-newspaper',       label:'Blog Posts',  bread:'Content'},
  {id:'images',   icon:'bi-images',          label:'Images',      bread:'Media'},
  {id:'users',    icon:'bi-people-fill',     label:'Users',       bread:'Settings'},
];
let currentPage = 'dashboard';

function renderNav(){
  document.getElementById('sideNav').innerHTML = NAV.map(n=>`
    <button class="nav-item" onclick="navigate('${n.id}')"
      style="display:flex;align-items:center;gap:10px;width:100%;padding:10px 12px;border-radius:12px;border:none;background:transparent;cursor:pointer;text-align:left;transition:background .15s;"
      onmouseover="if(!this.classList.contains('active'))this.style.background='rgba(255,255,255,.05)'"
      onmouseout="if(!this.classList.contains('active'))this.style.background='transparent'">
      <i class="bi ${n.icon} ni" style="font-size:15px;color:rgba(255,255,255,.35);flex-shrink:0;width:18px;"></i>
      <span class="nl" style="font-size:13px;font-weight:500;color:rgba(255,255,255,.5);">${n.label}</span>
    </button>`).join('');
  document.querySelectorAll('.nav-item').forEach((el,i)=>{
    if(NAV[i].id===currentPage) el.classList.add('active');
    else el.classList.remove('active');
  });
}

function navigate(page){
  currentPage = page;
  const n = NAV.find(x=>x.id===page);
  document.getElementById('headerBread').textContent = n.bread;
  document.getElementById('headerTitle').textContent = n.label;
  document.getElementById('searchInput').value = '';
  renderNav();
  if(page === 'services'){
    loadServices()
      .then(() => ({dashboard:renderDashboard,services:renderServices,prices:renderPrices,
        blog:renderBlog,images:renderImages,users:renderUsers})[page]())
      .catch(err => { toast(err.message); });
    return;
  }
  if(page === 'prices'){
    loadServicePrices()
      .then(() => renderPrices())
      .catch(err => { toast(err.message); });
    return;
  }
  ({dashboard:renderDashboard,services:renderServices,prices:renderPrices,
    blog:renderBlog,images:renderImages,users:renderUsers})[page]();
}

function handleSearch(q){
  if(currentPage==='services') renderServices(q);
  else if(currentPage==='prices') loadServicePrices(q).then(() => renderPrices()).catch(err => toast(err.message));
  else if(currentPage==='blog') renderBlog(q);
  else if(currentPage==='users') renderUsers(q);
}

/* ══════════════ API ══════════════ */
const API = {
  services: @json(route('admin.api.services.index')),
  service: id => @json(url('/admin/api/services')) + '/' + id,
  servicePrices: @json(route('admin.api.service-prices.index')),
  servicePrice: id => @json(url('/admin/api/service-prices')) + '/' + id,
};

function csrfToken(){ return document.querySelector('meta[name="csrf-token"]').content; }

async function apiFetch(url, opts = {}){
  const res = await fetch(url, {
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken(),
      ...(opts.headers || {}),
    },
    ...opts,
  });
  const data = await res.json().catch(() => ({}));
  if(!res.ok){
    const msg = data.message || Object.values(data.errors || {}).flat().join(', ') || 'เกิดข้อผิดพลาด';
    throw new Error(msg);
  }
  return data;
}

async function loadServices(){
  const data = await apiFetch(API.services);
  DB.services = data.services;
  DB.categories = data.categories;
}

async function loadServicePrices(q = ''){
  const url = new URL(API.servicePrices, window.location.origin);
  if(q) url.searchParams.set('q', q);
  const data = await apiFetch(url);
  DB.servicePrices = data.prices;
  DB.priceServices = data.services;
  DB.priceTypes = data.price_types;
}

function pricePayload(d){
  return {
    service_id: Number(d.service_id),
    name: d.name,
    sku: d.sku || null,
    description: d.description || null,
    price_type: d.price_type || 'starting_at',
    price: d.price !== '' && d.price != null ? Number(d.price) : null,
    max_price: d.max_price !== '' && d.max_price != null ? Number(d.max_price) : null,
    unit: d.unit || null,
    sort_order: d.sort_order !== '' && d.sort_order != null ? Number(d.sort_order) : 0,
    is_active: (d.status || 'active') !== 'inactive',
  };
}

function serviceField(data = {}, list = null){
  const services = list || DB.priceServices || DB.services || [];
  const opts = services.map(s =>
    `<option value="${s.id}"${String(data.service_id) === String(s.id) ? ' selected' : ''}>${s.title || s.name}</option>`
  ).join('');
  const v = data.service_id || '';
  return `<select name="service_id" required style="width:100%;border-radius:10px;border:1px solid #e3e7ee;padding:9px 12px;font-size:14px;outline:none;font-family:inherit;background:#fff;">
    <option value="" disabled${v ? '' : ' selected'}>เลือกบริการ</option>${opts}
  </select>`;
}

function priceTypeField(data = {}){
  const types = DB.priceTypes || {};
  const v = data.price_type || 'starting_at';
  const opts = Object.entries(types).map(([k, label]) =>
    `<option value="${k}"${v === k ? ' selected' : ''}>${label}</option>`
  ).join('');
  return `<select name="price_type" required style="width:100%;border-radius:10px;border:1px solid #e3e7ee;padding:9px 12px;font-size:14px;outline:none;font-family:inherit;background:#fff;">${opts}</select>`;
}

function servicePayload(d, isEdit = false){
  const payload = {
    service_category_id: Number(d.service_category_id),
    title: d.name,
    slug: d.slug,
    h1: d.h1 || null,
    icon_name: d.icon || null,
    dur: d.dur || null,
    description: d.desc || null,
    content: d.content || null,
    meta_title: d.meta_title || null,
    meta_des: d.meta_des || null,
    img_1: d.img_1 || null,
    img_2: d.img_2 || null,
    is_active: (d.status || 'active') !== 'inactive',
  };
  return payload;
}

const SERVICE_FORM_FIELDS = [
  {n:'service_category_id', l:'หมวดหมู่', t:'cat', r:true},
  {n:'name', l:'ชื่อบริการ (title)', t:'text', r:true},
  {n:'slug', l:'Slug (EN)', t:'text', r:true, ph:'building-demolish'},
  {n:'h1', l:'H1 หน้าเว็บ', t:'text', ph:'หัวข้อแสดงบนหน้าบริการ'},
  {n:'icon', l:'Bootstrap Icon', t:'text', ph:'bi-bricks'},
  {n:'dur', l:'ระยะเวลา', t:'text', ph:'14–30 วัน'},
  {n:'desc', l:'คำอธิบายสั้น (description)', t:'area'},
  {n:'content', l:'เนื้อหา (HTML content)', t:'area-lg', ph:'<p>เนื้อหาหน้าบริการ...</p>'},
  {n:'meta_title', l:'Meta Title (SEO)', t:'text'},
  {n:'meta_des', l:'Meta Description (SEO)', t:'area'},
  {n:'img_1', l:'รูปหลัก (img_1)', t:'text', ph:'images/services/xxx.webp'},
  {n:'img_2', l:'รูปรอง (img_2)', t:'text'},
];

function categoryField(data = {}){
  const opts = (DB.categories || []).map(c =>
    `<option value="${c.id}"${String(data.service_category_id) === String(c.id) ? ' selected' : ''}>${c.name}</option>`
  ).join('');
  const v = data.service_category_id || '';
  return `<select name="service_category_id" required style="width:100%;border-radius:10px;border:1px solid #e3e7ee;padding:9px 12px;font-size:14px;outline:none;font-family:inherit;background:#fff;">
    <option value="" disabled${v ? '' : ' selected'}>เลือกหมวดหมู่</option>${opts}
  </select>`;
}

/* ══════════════ UTILS ══════════════ */
const STATUS_STYLE = {
  active:    'background:#ecfdf5;color:#065f46',
  published: 'background:#ecfdf5;color:#065f46',
  draft:     'background:#fffbeb;color:#92400e',
  inactive:  'background:#f3f4f6;color:#6b7280',
  new:       'background:#eff6ff;color:#1e40af',
  contacted: 'background:#fffbeb;color:#92400e',
  quoted:    'background:#f5f3ff;color:#5b21b6',
  won:       'background:#ecfdf5;color:#065f46',
};
const STATUS_LABEL = {active:'Active',published:'Published',draft:'Draft',inactive:'Inactive',new:'New',contacted:'Contacted',quoted:'Quoted',won:'Won'};
const ROLE_STYLE = {owner:'background:#071a2c;color:#ffc83a',admin:'background:#0a3d62;color:#fff',editor:'background:#e3e7ee;color:#36475a',viewer:'background:#f6f8fb;color:#6a7787;border:1px solid #e3e7ee'};
const ROLE_LABEL = {owner:'Owner',admin:'Admin',editor:'Editor',viewer:'Viewer'};

function pill(status){ return `<span style="display:inline-flex;align-items:center;padding:3px 10px;border-radius:99px;font-size:11px;font-weight:600;${STATUS_STYLE[status]||''}">${STATUS_LABEL[status]||status}</span>`; }
function role(r){ return `<span style="display:inline-flex;align-items:center;padding:3px 10px;border-radius:99px;font-size:11px;font-weight:600;${ROLE_STYLE[r]||''}">${ROLE_LABEL[r]||r}</span>`; }
function dot(status){ const c={active:'#10b981',published:'#10b981',inactive:'#9ca3af',new:'#3b82f6',contacted:'#f59e0b',quoted:'#8b5cf6',won:'#10b981',draft:'#f59e0b'}; return `<span style="display:inline-block;width:7px;height:7px;border-radius:50%;background:${c[status]||'#9ca3af'};margin-right:6px;"></span>`; }
function iconBox(cls,c='rgba(10,61,98,.08)',ic='#0a3d62'){ return `<span style="display:grid;place-items:center;width:36px;height:36px;border-radius:10px;background:${c};flex-shrink:0;"><i class="bi ${cls}" style="color:${ic};font-size:15px;"></i></span>`; }

function wrap(inner){ return `<div style="background:#fff;border-radius:16px;border:1px solid #e3e7ee;overflow:hidden;">${inner}</div>`; }

function actionBtn(icon, color, onclick){
  return `<button onclick="${onclick}" style="width:30px;height:30px;display:grid;place-items:center;border-radius:8px;border:1px solid #e3e7ee;background:#fff;cursor:pointer;color:#6a7787;transition:all .15s;"
    onmouseover="this.style.borderColor='${color}';this.style.color='${color}';this.style.background='${color}15'"
    onmouseout="this.style.borderColor='#e3e7ee';this.style.color='#6a7787';this.style.background='#fff'">
    <i class="bi ${icon}" style="font-size:12px;"></i></button>`;
}

function pageHdr(title,sub,btnLabel,btnFn){
  return `<div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:20px;">
    <div>
      <h2 style="font-size:20px;font-weight:700;color:#071a2c;">${title}</h2>
      ${sub?`<p style="font-size:13px;color:#6a7787;margin-top:2px;">${sub}</p>`:''}
    </div>
    ${btnLabel?`<button onclick="${btnFn}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 16px;border-radius:12px;border:none;background:#0a3d62;color:#fff;font-size:13px;font-weight:600;cursor:pointer;white-space:nowrap;transition:background .15s;font-family:inherit;" onmouseover="this.style.background='#071a2c'" onmouseout="this.style.background='#0a3d62'"><i class="bi bi-plus-lg"></i>${btnLabel}</button>`:''}
  </div>`;
}

function tHead(...cols){
  return `<thead><tr style="background:#f6f8fb;border-bottom:1px solid #e3e7ee;">${cols.map(c=>`<th style="padding:10px 16px;text-align:left;font-size:11px;font-weight:700;color:#6a7787;text-transform:uppercase;letter-spacing:.07em;white-space:nowrap;">${c}</th>`).join('')}</tr></thead>`;
}

/* ══════════════ DASHBOARD ══════════════ */
function renderDashboard(){
  const stats = [
    {icon:'bi-bricks',        val:DB.services.filter(s=>s.status==='active').length, label:'Active Services',    bg:'rgba(10,61,98,.07)', ic:'#0a3d62'},
    {icon:'bi-newspaper',     val:DB.blog.filter(b=>b.status==='published').length,  label:'Published Posts',   bg:'rgba(5,150,105,.07)',ic:'#059669'},
    {icon:'bi-images',        val:DB.images.length,                                  label:'Images',             bg:'rgba(124,58,237,.07)',ic:'#7c3aed'},
    {icon:'bi-envelope-open', val:DB.quotes.filter(q=>q.status==='new').length,      label:'New Quote Requests', bg:'rgba(217,119,6,.07)',ic:'#d97706'},
  ];

  const statCards = stats.map(s=>`
    <div style="background:#fff;border-radius:16px;border:1px solid #e3e7ee;padding:20px 20px 16px;cursor:pointer;transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 8px 32px rgba(7,26,44,.08)'" onmouseout="this.style.boxShadow='none'">
      <div style="width:40px;height:40px;border-radius:12px;background:${s.bg};display:grid;place-items:center;margin-bottom:14px;">
        <i class="bi ${s.icon}" style="font-size:18px;color:${s.ic};"></i>
      </div>
      <div style="font-size:28px;font-weight:700;color:#071a2c;font-family:monospace;line-height:1;">${s.val}</div>
      <div style="font-size:12px;color:#6a7787;margin-top:4px;">${s.label}</div>
    </div>`).join('');

  const quoteRows = DB.quotes.map(q=>`
    <tr>
      <td style="padding:12px 16px;">
        <div style="font-weight:600;font-size:14px;color:#071a2c;">${q.name}</div>
        <div style="font-size:12px;color:#6a7787;font-family:monospace;">${q.phone}</div>
      </td>
      <td style="padding:12px 16px;font-size:13px;color:#36475a;">${q.service}</td>
      <td style="padding:12px 16px;font-size:13px;color:#36475a;white-space:nowrap;">${q.budget}</td>
      <td style="padding:12px 16px;font-size:12px;color:#6a7787;font-family:monospace;white-space:nowrap;">${q.date}</td>
      <td style="padding:12px 16px;">${dot(q.status)}${pill(q.status)}</td>
    </tr>`).join('');

  const recentBlog = DB.blog.slice(0,4).map(b=>`
    <div style="display:flex;align-items:start;gap:10px;padding:10px 0;border-bottom:1px solid #f0f2f5;">
      ${iconBox('bi-file-earmark-text','#f6f8fb','#6a7787')}
      <div style="flex:1;min-width:0;">
        <div class="clamp1" style="font-size:13px;font-weight:500;color:#071a2c;line-height:1.4;">${b.title}</div>
        <div style="font-size:11px;color:#6a7787;margin-top:2px;">${b.cat} · ${b.date}</div>
      </div>
      ${pill(b.status)}
    </div>`).join('');

  document.getElementById('mainContent').innerHTML = `
    <div style="padding:24px;">
      <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">${statCards}</div>
      <div style="display:grid;grid-template-columns:1fr 320px;gap:14px;">
        ${wrap(`
          <div style="padding:14px 16px 12px;border-bottom:1px solid #e3e7ee;display:flex;align-items:center;justify-content:space-between;">
            <span style="font-weight:700;font-size:14px;color:#071a2c;">Recent Quote Requests</span>
            <span style="font-size:12px;color:#6a7787;">${DB.quotes.length} รายการ</span>
          </div>
          <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;min-width:560px;">
              ${tHead('ผู้ติดต่อ','บริการ','งบประมาณ','วันที่','สถานะ')}
              <tbody>${quoteRows}</tbody>
            </table>
          </div>`)}
        ${wrap(`
          <div style="padding:14px 16px 12px;border-bottom:1px solid #e3e7ee;">
            <span style="font-weight:700;font-size:14px;color:#071a2c;">Recent Blog Posts</span>
          </div>
          <div style="padding:0 16px 8px;">${recentBlog}</div>`)}
      </div>
    </div>`;
}

/* ══════════════ SERVICES ══════════════ */
function renderServices(q=''){
  const list = q ? DB.services.filter(s=>s.name.includes(q)||s.slug.includes(q)) : DB.services;
  const rows = list.map(s=>`
    <tr>
      <td style="padding:12px 16px;">
        <div style="display:flex;align-items:center;gap:10px;">
          ${iconBox(s.icon)}
          <div>
            <div style="font-weight:600;font-size:14px;color:#071a2c;">${s.name}</div>
            <div style="font-size:11px;color:#6a7787;font-family:monospace;">${s.slug}</div>
          </div>
        </div>
      </td>
      <td style="padding:12px 16px;max-width:200px;"><div class="clamp2" style="font-size:13px;color:#36475a;line-height:1.5;">${s.desc || '—'}</div></td>
      <td style="padding:12px 16px;text-align:center;">
        ${s.has_content
          ? '<span style="display:inline-flex;align-items:center;padding:3px 10px;border-radius:99px;font-size:11px;font-weight:600;background:#ecfdf5;color:#065f46;">มี content</span>'
          : '<span style="font-size:12px;color:#9ca3af;">—</span>'}
      </td>
      <td style="padding:12px 16px;font-size:12px;color:#6a7787;white-space:nowrap;">${s.category_name || '—'}</td>
      <td style="padding:12px 16px;font-size:13px;font-weight:600;color:#071a2c;font-family:monospace;white-space:nowrap;">${s.price}</td>
      <td style="padding:12px 16px;font-size:13px;color:#36475a;white-space:nowrap;">${s.dur}</td>
      <td style="padding:12px 16px;">${pill(s.status)}</td>
      <td style="padding:12px 16px;">
        <div style="display:flex;gap:6px;">
          ${actionBtn('bi-pencil','#3b82f6',`editService(${s.id})`)}
          ${actionBtn('bi-trash3','#ef4444',`deleteItem('services',${s.id},'${s.name}')`)}
        </div>
      </td>
    </tr>`).join('');

  document.getElementById('mainContent').innerHTML = `
    <div style="padding:24px;">
      ${pageHdr('Services',`${DB.services.length} รายการบริการ`,'+ เพิ่มบริการ','addService()')}
      <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:12px;padding:12px 16px;font-size:13px;color:#1e40af;display:flex;align-items:center;gap:8px;margin-bottom:20px;">
        <i class="bi bi-info-circle"></i>
        ราคาเริ่มต้นแสดงจากราคาต่ำสุดใน Service Prices — แก้ไขราคาได้ที่เมนู Service Prices
      </div>
      ${wrap(`<div style="overflow-x:auto;"><table style="width:100%;border-collapse:collapse;min-width:920px;">
        ${tHead('บริการ','คำอธิบาย','Content','หมวดหมู่','ราคาต่ำสุด','ระยะเวลา','สถานะ','Actions')}
        <tbody>${rows}</tbody>
      </table></div>`)}
    </div>`;
}

function addService(){
  openModal('Add Service',{},SERVICE_FORM_FIELDS, async d=>{
    try{
      const res = await apiFetch(API.services, {method:'POST', body:JSON.stringify(servicePayload(d))});
      DB.services.push(res.service);
      renderServices();
      toast(res.message);
    }catch(err){ toast(err.message); }
  }, {wide:true});
}
function editService(id){
  const s=DB.services.find(x=>x.id===id);
  openModal('Edit Service',s,[...SERVICE_FORM_FIELDS,{n:'status',l:'สถานะ',t:'sel',opts:['active','inactive']}], async d=>{
    try{
      const res = await apiFetch(API.service(id), {method:'PUT', body:JSON.stringify(servicePayload(d, true))});
      const idx = DB.services.findIndex(x=>x.id===id);
      if(idx >= 0) DB.services[idx] = res.service;
      renderServices();
      toast(res.message);
    }catch(err){ toast(err.message); }
  }, {wide:true});
}

/* ══════════════ SERVICE PRICES ══════════════ */
function renderPrices(){
  const rows = (DB.servicePrices || []).map(p=>`
    <tr>
      <td style="padding:12px 16px;">
        <div style="display:flex;align-items:center;gap:10px;">
          ${iconBox(p.service_icon)}
          <div>
            <div style="font-weight:600;font-size:14px;color:#071a2c;">${p.service_name}</div>
            <div style="font-size:11px;color:#6a7787;font-family:monospace;">${p.service_slug}</div>
          </div>
        </div>
      </td>
      <td style="padding:12px 16px;max-width:220px;">
        <div class="clamp1" style="font-weight:500;font-size:14px;color:#071a2c;">${p.name}</div>
        ${p.sku ? `<div style="font-size:11px;color:#6a7787;font-family:monospace;">${p.sku}</div>` : ''}
      </td>
      <td style="padding:12px 16px;font-size:14px;font-weight:700;color:#071a2c;font-family:monospace;white-space:nowrap;">${p.price_label}</td>
      <td style="padding:12px 16px;font-size:13px;color:#36475a;white-space:nowrap;">${p.unit ? 'บาท/'+p.unit : '—'}</td>
      <td style="padding:12px 16px;">
        <span style="background:#f6f8fb;border:1px solid #e3e7ee;color:#36475a;padding:3px 10px;border-radius:99px;font-size:11px;font-weight:500;white-space:nowrap;">${p.price_type_label}</span>
      </td>
      <td style="padding:12px 16px;font-size:13px;color:#6a7787;font-family:monospace;text-align:center;">${p.sort_order}</td>
      <td style="padding:12px 16px;">${pill(p.status)}</td>
      <td style="padding:12px 16px;">
        <div style="display:flex;gap:6px;">
          ${actionBtn('bi-pencil','#3b82f6',`editServicePrice(${p.id})`)}
          ${actionBtn('bi-trash3','#ef4444',`deleteItem('servicePrices',${p.id},'${String(p.name).replace(/'/g, "\\'")}')`)}
        </div>
      </td>
    </tr>`).join('');

  document.getElementById('mainContent').innerHTML = `
    <div style="padding:24px;">
      ${pageHdr('Service Prices',`${(DB.servicePrices || []).length} รายการราคา`,'+ เพิ่มราคา','addServicePrice()')}
      <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:12px;padding:12px 16px;font-size:13px;color:#92400e;display:flex;align-items:center;gap:8px;margin-bottom:20px;">
        <i class="bi bi-info-circle"></i>
        จัดการรายการราคาในตาราง service_prices — 1 บริการมีได้หลายราคา แสดงบนหน้ารายละเอียดบริการ
      </div>
      ${wrap(`<div style="overflow-x:auto;"><table style="width:100%;border-collapse:collapse;min-width:980px;">
        ${tHead('บริการ','รายการ','ราคา','หน่วย','ประเภท','ลำดับ','สถานะ','Actions')}
        <tbody>${rows || '<tr><td colspan="8" style="padding:24px;text-align:center;color:#6a7787;">ยังไม่มีรายการราคา</td></tr>'}</tbody>
      </table></div>`)}
    </div>`;
}

const PRICE_FORM_FIELDS = [
  {n:'service_id', l:'บริการ', t:'svc', r:true},
  {n:'name', l:'ชื่อรายการ', t:'text', r:true, ph:'ราคาเริ่มต้น'},
  {n:'sku', l:'SKU', t:'text', ph:'optional'},
  {n:'price_type', l:'ประเภทราคา', t:'ptype', r:true},
  {n:'price', l:'ราคา (ตัวเลข)', t:'number', ph:'2800'},
  {n:'max_price', l:'ราคาสูงสุด (ช่วงราคา)', t:'number', ph:'3200'},
  {n:'unit', l:'หน่วย', t:'text', ph:'ตร.ม.'},
  {n:'sort_order', l:'ลำดับ', t:'number', ph:'0'},
  {n:'status', l:'สถานะ', t:'sel', opts:['active','inactive']},
  {n:'description', l:'คำอธิบาย', t:'area'},
];

function addServicePrice(){
  openModal('Add Service Price',{},PRICE_FORM_FIELDS, async d=>{
    try{
      const res = await apiFetch(API.servicePrices, {method:'POST', body:JSON.stringify(pricePayload(d))});
      DB.servicePrices.push(res.price);
      renderPrices();
      toast(res.message);
    }catch(err){ toast(err.message); }
  });
}

function editServicePrice(id){
  const p = DB.servicePrices.find(x=>x.id===id);
  openModal(`Edit Price — ${p.name}`, p, PRICE_FORM_FIELDS, async d=>{
    try{
      const res = await apiFetch(API.servicePrice(id), {method:'PUT', body:JSON.stringify(pricePayload(d))});
      const idx = DB.servicePrices.findIndex(x=>x.id===id);
      if(idx >= 0) DB.servicePrices[idx] = res.price;
      renderPrices();
      toast(res.message);
    }catch(err){ toast(err.message); }
  });
}

/* ══════════════ BLOG ══════════════ */
function renderBlog(q=''){
  const list = q ? DB.blog.filter(b=>b.title.includes(q)||b.cat.includes(q)) : DB.blog;
  const rows = list.map(b=>`
    <tr>
      <td style="padding:12px 16px;max-width:300px;">
        <div class="clamp1" style="font-weight:500;font-size:14px;color:#071a2c;">${b.title}</div>
      </td>
      <td style="padding:12px 16px;">
        <span style="background:#f6f8fb;border:1px solid #e3e7ee;color:#36475a;padding:3px 10px;border-radius:99px;font-size:11px;font-weight:500;">${b.cat}</span>
      </td>
      <td style="padding:12px 16px;font-size:13px;color:#36475a;">${b.author}</td>
      <td style="padding:12px 16px;font-size:12px;color:#6a7787;font-family:monospace;white-space:nowrap;">${b.date}</td>
      <td style="padding:12px 16px;font-size:13px;color:#6a7787;font-family:monospace;">${b.views>0?b.views.toLocaleString():'—'}</td>
      <td style="padding:12px 16px;">${pill(b.status)}</td>
      <td style="padding:12px 16px;">
        <div style="display:flex;gap:6px;">
          ${actionBtn('bi-pencil','#3b82f6',`editBlog(${b.id})`)}
          ${actionBtn('bi-trash3','#ef4444',`deleteItem('blog',${b.id},'${b.title.substring(0,25).replace(/'/g,'')}...')`)}
        </div>
      </td>
    </tr>`).join('');

  document.getElementById('mainContent').innerHTML = `
    <div style="padding:24px;">
      ${pageHdr('Blog Posts',`${DB.blog.length} บทความ`,'+ เพิ่มบทความ','addBlog()')}
      ${wrap(`<div style="overflow-x:auto;"><table style="width:100%;border-collapse:collapse;min-width:820px;">
        ${tHead('หัวข้อ','หมวดหมู่','ผู้เขียน','วันที่','Views','สถานะ','Actions')}
        <tbody>${rows}</tbody>
      </table></div>`)}
    </div>`;
}

function addBlog(){
  openModal('Add Blog Post',{},[
    {n:'title', l:'หัวข้อบทความ', t:'text', r:true},
    {n:'cat',   l:'หมวดหมู่',     t:'text', r:true, ph:'เทคนิคก่อสร้าง'},
    {n:'author',l:'ผู้เขียน',      t:'text', r:true},
    {n:'date',  l:'วันที่',        t:'date', r:true},
    {n:'status',l:'สถานะ',         t:'sel',  opts:['draft','published']},
  ], d=>{ DB.blog.unshift({id:Date.now(),views:0,...d}); renderBlog(); toast('เพิ่มบทความเรียบร้อย'); });
}
function editBlog(id){
  const b=DB.blog.find(x=>x.id===id);
  openModal('Edit Blog Post',b,[
    {n:'title', l:'หัวข้อบทความ', t:'text', r:true},
    {n:'cat',   l:'หมวดหมู่',     t:'text', r:true},
    {n:'author',l:'ผู้เขียน',      t:'text', r:true},
    {n:'date',  l:'วันที่',        t:'date'},
    {n:'status',l:'สถานะ',         t:'sel',  opts:['draft','published']},
  ], d=>{ Object.assign(b,d); renderBlog(); toast('บันทึกเรียบร้อย'); });
}

/* ══════════════ IMAGES ══════════════ */
function renderImages(){
  const cards = DB.images.map(img=>`
    <div class="img-card" style="background:#fff;border-radius:14px;border:1px solid #e3e7ee;overflow:hidden;transition:box-shadow .2s;cursor:default;" onmouseover="this.style.boxShadow='0 8px 28px rgba(7,26,44,.1)'" onmouseout="this.style.boxShadow='none'">
      <div style="position:relative;aspect-ratio:16/10;overflow:hidden;">
        <img src="https://images.unsplash.com/photo-${img.src}?w=400&q=70&auto=format&fit=crop" alt="${img.name}" style="width:100%;height:100%;object-fit:cover;transition:transform .4s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'"/>
        <div class="img-overlay" style="position:absolute;inset:0;background:linear-gradient(to top,rgba(7,26,44,.7),transparent);display:flex;align-items:flex-end;justify-content:flex-end;padding:10px;">
          ${actionBtn('bi-trash3','#ef4444',`deleteItem('images',${img.id},'${img.name}')`)}
        </div>
      </div>
      <div style="padding:10px 12px;">
        <div class="clamp1" style="font-size:12px;font-weight:500;color:#071a2c;">${img.name}</div>
        <div style="display:flex;align-items:center;justify-content:space-between;margin-top:4px;">
          <span style="font-size:11px;color:#6a7787;">${img.size} · ${img.date}</span>
          <span style="background:#f6f8fb;border:1px solid #e3e7ee;color:#6a7787;padding:2px 8px;border-radius:99px;font-size:10px;font-weight:500;">${img.tag}</span>
        </div>
      </div>
    </div>`).join('');

  document.getElementById('mainContent').innerHTML = `
    <div style="padding:24px;">
      ${pageHdr('Images',`${DB.images.length} ไฟล์ในคลัง`,null,null)}
      <div style="border:2px dashed #e3e7ee;border-radius:16px;padding:32px 24px;text-align:center;margin-bottom:22px;cursor:pointer;transition:all .2s;" onmouseover="this.style.borderColor='#0a3d62';this.style.background='rgba(10,61,98,.02)'" onmouseout="this.style.borderColor='#e3e7ee';this.style.background='transparent'">
        <i class="bi bi-cloud-upload" style="font-size:28px;color:#6a7787;display:block;margin-bottom:8px;"></i>
        <div style="font-size:14px;font-weight:500;color:#36475a;">ลากไฟล์มาวางที่นี่ หรือ <span style="color:#0a3d62;font-weight:600;">คลิกเพื่อเลือกไฟล์</span></div>
        <div style="font-size:12px;color:#6a7787;margin-top:4px;">รองรับ JPG, PNG, WebP · ขนาดสูงสุด 10 MB</div>
      </div>
      <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;">${cards}</div>
    </div>`;
}

/* ══════════════ USERS ══════════════ */
function renderUsers(q=''){
  const list = q ? DB.users.filter(u=>u.name.includes(q)||u.email.includes(q)) : DB.users;
  const rows = list.map(u=>`
    <tr>
      <td style="padding:12px 16px;">
        <div style="display:flex;align-items:center;gap:10px;">
          <div style="width:34px;height:34px;border-radius:50%;background:#ffc83a;display:grid;place-items:center;color:#071a2c;font-weight:700;font-size:13px;flex-shrink:0;">${u.name.charAt(0)}</div>
          <div>
            <div style="font-weight:600;font-size:14px;color:#071a2c;">${u.name}</div>
            <div style="font-size:12px;color:#6a7787;">${u.email}</div>
          </div>
        </div>
      </td>
      <td style="padding:12px 16px;">${role(u.role)}</td>
      <td style="padding:12px 16px;">${dot(u.status)}${pill(u.status)}</td>
      <td style="padding:12px 16px;font-size:12px;color:#6a7787;font-family:monospace;white-space:nowrap;">${u.period||'—'}</td>
      <td style="padding:12px 16px;font-size:12px;color:#6a7787;font-family:monospace;white-space:nowrap;">${u.lastLogin}</td>
      <td style="padding:12px 16px;">
        <div style="display:flex;gap:6px;">
          ${actionBtn('bi-pencil','#3b82f6',`editUser(${u.id})`)}
          ${u.role!=='owner'?actionBtn('bi-trash3','#ef4444',`deleteItem('users',${u.id},'${u.name}')`):''}
        </div>
      </td>
    </tr>`).join('');

  document.getElementById('mainContent').innerHTML = `
    <div style="padding:24px;">
      ${pageHdr('Users',`${DB.users.length} ผู้ใช้งาน`,'+ เพิ่มผู้ใช้','addUser()')}
      ${wrap(`<div style="overflow-x:auto;"><table style="width:100%;border-collapse:collapse;min-width:600px;">
        ${tHead('ชื่อผู้ใช้','Role','สถานะ','Work Period','Last Login','Actions')}
        <tbody>${rows}</tbody>
      </table></div>`)}
    </div>`;
}

function addUser(){
  openModal('Add User',{},[
    {n:'name',  l:'ชื่อ-นามสกุล',t:'text', r:true},
    {n:'email', l:'Email',        t:'email',r:true},
    {n:'role',  l:'Role',         t:'sel',  opts:['admin','editor','viewer']},
    {n:'period',l:'Work Period',   t:'text', ph:'2025-01 – ปัจจุบัน'},
  ], d=>{ DB.users.push({id:Date.now(),status:'active',lastLogin:'—',...d}); renderUsers(); toast('เพิ่มผู้ใช้เรียบร้อย'); });
}
function editUser(id){
  const u=DB.users.find(x=>x.id===id);
  openModal('Edit User',u,[
    {n:'name',  l:'ชื่อ-นามสกุล',t:'text', r:true},
    {n:'email', l:'Email',        t:'email',r:true},
    {n:'role',  l:'Role',         t:'sel',  opts:['owner','admin','editor','viewer']},
    {n:'status',l:'สถานะ',         t:'sel',  opts:['active','inactive']},
    {n:'period',l:'Work Period',   t:'text', ph:'2025-01 – ปัจจุบัน'},
  ], d=>{ Object.assign(u,d); renderUsers(); toast('บันทึกเรียบร้อย'); });
}

/* ══════════════ MODAL ══════════════ */
let _modalCb = null;
function escAttr(s){ return String(s ?? '').replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;'); }
function escTextarea(s){ return String(s ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;'); }

function openModal(title, data, fields, onSave, opts = {}){
  _modalCb = onSave;
  document.getElementById('modalBox').style.maxWidth = opts.wide ? '720px' : '520px';
  const input = f=>{
    const v = (data&&data[f.n]!=null)?data[f.n]:'';
    const base = `name="${f.n}" ${f.r?'required':''} `;
    const sty = `style="width:100%;border-radius:10px;border:1px solid #e3e7ee;padding:9px 12px;font-size:14px;outline:none;font-family:inherit;transition:border-color .15s;"
      onfocus="this.style.borderColor='#0a3d62'" onblur="this.style.borderColor='#e3e7ee'"`;
    if(f.t==='area') return `<textarea ${base} rows="3" placeholder="${escAttr(f.ph||'')}" ${sty}>${escTextarea(v)}</textarea>`;
    if(f.t==='area-lg') return `<textarea ${base} rows="12" placeholder="${escAttr(f.ph||'')}" ${sty} style="width:100%;border-radius:10px;border:1px solid #e3e7ee;padding:9px 12px;font-size:13px;line-height:1.5;outline:none;font-family:monospace;transition:border-color .15s;resize:vertical;min-height:180px;"
      onfocus="this.style.borderColor='#0a3d62'" onblur="this.style.borderColor='#e3e7ee'">${escTextarea(v)}</textarea>`;
    if(f.t==='cat') return categoryField(data);
    if(f.t==='svc') return serviceField(data);
    if(f.t==='ptype') return priceTypeField(data);
    if(f.t==='sel') return `<select ${base} ${sty} style="width:100%;border-radius:10px;border:1px solid #e3e7ee;padding:9px 12px;font-size:14px;outline:none;font-family:inherit;background:#fff;">${(f.opts||[]).map(o=>`<option value="${o}"${v===o?' selected':''}>${o}</option>`).join('')}</select>`;
    return `<input type="${f.t}" ${base} value="${escAttr(v)}" placeholder="${escAttr(f.ph||'')}" ${sty}/>`;
  };
  document.getElementById('modalBox').innerHTML = `
    <div style="padding:20px 22px 16px;border-bottom:1px solid #e3e7ee;display:flex;align-items:center;justify-content:space-between;">
      <h3 style="font-weight:700;font-size:16px;color:#071a2c;">${title}</h3>
      <button onclick="closeModal()" style="width:30px;height:30px;display:grid;place-items:center;border-radius:8px;border:1px solid #e3e7ee;background:#fff;cursor:pointer;color:#6a7787;font-size:16px;" onmouseover="this.style.background='#f6f8fb'" onmouseout="this.style.background='#fff'">✕</button>
    </div>
    <form id="mForm" style="padding:20px 22px;display:flex;flex-direction:column;gap:14px;">
      ${fields.map(f=>`
        <div>
          <label style="display:block;font-size:12px;font-weight:600;color:#071a2c;margin-bottom:6px;text-transform:uppercase;letter-spacing:.05em;">${f.l}${f.r?'<span style="color:#ef4444;margin-left:2px;">*</span>':''}</label>
          ${input(f)}
        </div>`).join('')}
      <div style="display:flex;gap:10px;padding-top:4px;">
        <button type="button" onclick="closeModal()" style="flex:1;padding:10px;border-radius:12px;border:1px solid #e3e7ee;font-size:14px;font-weight:600;color:#36475a;background:#fff;cursor:pointer;font-family:inherit;transition:background .15s;" onmouseover="this.style.background='#f6f8fb'" onmouseout="this.style.background='#fff'">ยกเลิก</button>
        <button type="submit" style="flex:1;padding:10px;border-radius:12px;border:none;font-size:14px;font-weight:600;color:#fff;background:#0a3d62;cursor:pointer;font-family:inherit;transition:background .15s;" onmouseover="this.style.background='#071a2c'" onmouseout="this.style.background='#0a3d62'">บันทึก</button>
      </div>
    </form>`;
  document.getElementById('mForm').onsubmit = e=>{
    e.preventDefault();
    const d=Object.fromEntries(new FormData(e.target).entries());
    if(_modalCb) _modalCb(d);
    closeModal();
  };
  const ov=document.getElementById('modalOverlay');
  ov.style.display='flex'; ov.offsetHeight;
}
function closeModal(){ document.getElementById('modalOverlay').style.display='none'; _modalCb=null; }

/* ══════════════ DELETE ══════════════ */
function deleteItem(type,id,name){
  document.getElementById('confirmMsg').textContent = `"${name}" จะถูกลบออกอย่างถาวร`;
  const ov=document.getElementById('confirmOverlay');
  ov.style.display='flex'; ov.offsetHeight;
  document.getElementById('confirmOkBtn').onclick=async ()=>{
    if(type === 'services'){
      try{
        await apiFetch(API.service(id), {method:'DELETE'});
        DB.services = DB.services.filter(x=>x.id!==id);
        closeConfirm();
        navigate(currentPage);
        toast('ลบรายการเรียบร้อย','del');
      }catch(err){
        closeConfirm();
        toast(err.message);
      }
      return;
    }
    if(type === 'servicePrices'){
      try{
        await apiFetch(API.servicePrice(id), {method:'DELETE'});
        DB.servicePrices = DB.servicePrices.filter(x=>x.id!==id);
        closeConfirm();
        renderPrices();
        toast('ลบรายการเรียบร้อย','del');
      }catch(err){
        closeConfirm();
        toast(err.message);
      }
      return;
    }
    DB[type]=DB[type].filter(x=>x.id!==id);
    closeConfirm();
    navigate(currentPage);
    toast('ลบรายการเรียบร้อย','del');
  };
}
function closeConfirm(){ document.getElementById('confirmOverlay').style.display='none'; }

/* ══════════════ TOAST ══════════════ */
let _toastTimer;
function toast(msg,type='ok'){
  const el=document.getElementById('toast');
  el.innerHTML=`<i class="bi ${type==='del'?'bi-trash3':'bi-check-circle-fill'}" style="font-size:15px;${type==='del'?'color:#fca5a5':'color:#6ee7b7'}"></i>${msg}`;
  el.style.display='flex';
  clearTimeout(_toastTimer);
  _toastTimer=setTimeout(()=>el.style.display='none',2400);
}

/* ══════════════ CLOSE ON OVERLAY ══════════════ */
document.getElementById('modalOverlay').addEventListener('click',e=>{ if(e.target.id==='modalOverlay') closeModal(); });
document.getElementById('confirmOverlay').addEventListener('click',e=>{ if(e.target.id==='confirmOverlay') closeConfirm(); });

/* ══════════════ INIT ══════════════ */
renderNav();
loadServices()
  .then(() => navigate('dashboard'))
  .catch(() => navigate('dashboard'));
</script>
</body>
</html>
