<!doctype html>
<html lang="id">
 <head><script src="/_sdk/telemetry_sdk.js"></script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard Klinik</title>
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <script src="https://cdn.jsdelivr.net/npm/lucide@0.263.0/dist/umd/lucide.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            canvas: '#F5F3EE',
            mint: '#96e6c2',
            'mint-dark': '#5ab88a',
            urgency: '#EA580C',
            success: '#ffaa29',
          }
        }
      }
    }
  </script>
  <style>
    body { font-family: 'DM Sans', sans-serif; }
    .glass { background: rgba(255,255,255,0.7); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
    .nav-link.active { background: linear-gradient(135deg, rgba(150,230,194,0.2), rgba(90,184,138,0.1)); color: #5ab88a; }
    .page { display: none; }
    .page.active { display: block; }
    .filter-tab.active { background: #5ab88a; color: #fff; }
    .queue-card { transition: all 0.3s ease; }
    .queue-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.06); }
    @keyframes fadeIn { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }
    .animate-in { animation: fadeIn 0.4s ease forwards; }
  </style>
  <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
  <script src="/_sdk/resizing_sdk.js" type="text/javascript"></script>
 </head>
 <body data-template-id="__page-root" class="min-h-screen"><!-- Sidebar -->
  <aside data-template-id="sidebar" class="canva-sidebar hidden lg:flex fixed left-0 top-0 bottom-0 w-64 flex-col p-6 z-40 border-r border-gray-100/50">
   <div class="mb-10">
    <h1 data-template-id="brand-title" class="canva-text text-xl font-bold"></h1>
    <p data-template-id="brand-subtitle" class="canva-text text-sm mt-1 opacity-60"></p>
   </div>
   <nav class="flex-1 space-y-1"><a href="#" data-nav="beranda" class="nav-link active flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all"> <i data-lucide="layout-dashboard" style="width:20px;height:20px"></i> <span data-template-id="nav-beranda" class="canva-text"></span> </a> <a href="#" data-nav="antrian" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 font-medium transition-all"> <i data-lucide="list-ordered" style="width:20px;height:20px"></i> <span data-template-id="nav-antrian" class="canva-text"></span> </a> <a href="#" data-nav="dokter" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 font-medium transition-all"> <i data-lucide="stethoscope" style="width:20px;height:20px"></i> <span data-template-id="nav-dokter" class="canva-text"></span> </a> <a href="#" data-nav="pengaturan" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-gray-50 font-medium transition-all"> <i data-lucide="settings" style="width:20px;height:20px"></i> <span data-template-id="nav-pengaturan" class="canva-text"></span> </a>
   </nav>
  </aside><!-- Main -->
  <main class="lg:ml-64 pb-24 lg:pb-8"><!-- Header -->
   <header class="sticky top-0 glass z-30 px-5 py-4 lg:px-8 lg:py-5 border-b border-white/30">
    <div class="flex items-center justify-between">
     <div>
      <h2 data-template-id="greeting" class="canva-text font-bold text-lg lg:text-2xl"></h2>
      <p data-template-id="date-label" class="canva-text text-sm opacity-50 mt-0.5"></p>
     </div><button class="w-10 h-10 rounded-full glass flex items-center justify-center border border-white/50 shadow-sm"> <i data-lucide="bell" style="width:18px;height:18px;color:#EA580C"></i> </button>
    </div>
   </header><!-- PAGE: Beranda -->
   <div id="page-beranda" class="page active px-5 lg:px-8 space-y-6 pt-6"><!-- Stats -->
    <section class="grid grid-cols-1 sm:grid-cols-3 gap-4">
     <div data-template-id="stat-pending" class="canva-card rounded-2xl p-5 border border-orange-100/60 shadow-sm queue-card">
      <div class="flex items-center justify-between mb-3">
       <div class="w-10 h-10 rounded-xl bg-urgency/10 flex items-center justify-center">
        <i data-lucide="clock" style="width:20px;height:20px;color:#EA580C"></i>
       </div><span class="text-2xl font-bold text-urgency">12</span>
      </div>
      <p data-template-id="stat-pending-label" class="canva-text text-sm font-medium"></p>
     </div>
     <div data-template-id="stat-active" class="canva-card rounded-2xl p-5 border border-emerald-100/60 shadow-sm queue-card">
      <div class="flex items-center justify-between mb-3">
       <div class="w-10 h-10 rounded-xl bg-mint/20 flex items-center justify-center">
        <i data-lucide="activity" style="width:20px;height:20px;color:#5ab88a"></i>
       </div><span class="text-2xl font-bold text-mint-dark">3</span>
      </div>
      <p data-template-id="stat-active-label" class="canva-text text-sm font-medium"></p>
     </div>
     <div data-template-id="stat-done" class="canva-card rounded-2xl p-5 border border-amber-100/60 shadow-sm queue-card">
      <div class="flex items-center justify-between mb-3">
       <div class="w-10 h-10 rounded-xl bg-success/10 flex items-center justify-center">
        <i data-lucide="check-circle" style="width:20px;height:20px;color:#ffaa29"></i>
       </div><span class="text-2xl font-bold text-success">27</span>
      </div>
      <p data-template-id="stat-done-label" class="canva-text text-sm font-medium"></p>
     </div>
    </section><!-- Doctors -->
    <section>
     <h3 data-template-id="doctors-heading" class="canva-text font-semibold mb-4"></h3>
     <div class="flex gap-4 overflow-x-auto pb-2 -mx-1 px-1 snap-x">
      <div class="min-w-[200px] snap-start bg-white/80 backdrop-blur rounded-2xl p-4 border border-white/60 shadow-sm queue-card"><img data-template-id="doc-1-avatar" class="canva-image w-12 h-12 rounded-full object-cover mb-3" loading="lazy">
       <p data-template-id="doc-1-name" class="canva-text font-semibold text-sm"></p>
       <p data-template-id="doc-1-poli" class="canva-text text-xs opacity-60 mt-0.5"></p>
       <div class="mt-3 flex items-center gap-1.5">
        <span class="w-2 h-2 rounded-full bg-mint animate-pulse"></span><span class="text-xs text-mint-dark font-medium">Aktif</span>
       </div>
      </div>
      <div class="min-w-[200px] snap-start bg-white/80 backdrop-blur rounded-2xl p-4 border border-white/60 shadow-sm queue-card"><img data-template-id="doc-2-avatar" class="canva-image w-12 h-12 rounded-full object-cover mb-3" loading="lazy">
       <p data-template-id="doc-2-name" class="canva-text font-semibold text-sm"></p>
       <p data-template-id="doc-2-poli" class="canva-text text-xs opacity-60 mt-0.5"></p>
       <div class="mt-3 flex items-center gap-1.5">
        <span class="w-2 h-2 rounded-full bg-mint animate-pulse"></span><span class="text-xs text-mint-dark font-medium">Aktif</span>
       </div>
      </div>
      <div class="min-w-[200px] snap-start bg-white/80 backdrop-blur rounded-2xl p-4 border border-white/60 shadow-sm queue-card"><img data-template-id="doc-3-avatar" class="canva-image w-12 h-12 rounded-full object-cover mb-3" loading="lazy">
       <p data-template-id="doc-3-name" class="canva-text font-semibold text-sm"></p>
       <p data-template-id="doc-3-poli" class="canva-text text-xs opacity-60 mt-0.5"></p>
       <div class="mt-3 flex items-center gap-1.5">
        <span class="w-2 h-2 rounded-full bg-urgency"></span><span class="text-xs text-gray-500 font-medium">Istirahat</span>
       </div>
      </div>
     </div>
    </section><!-- Bookings -->
    <section>
     <h3 data-template-id="bookings-heading" class="canva-text font-semibold mb-4"></h3>
     <div class="space-y-3">
      <div class="bg-white/80 backdrop-blur rounded-2xl p-4 border border-white/60 shadow-sm queue-card">
       <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
         <div class="w-10 h-10 rounded-full bg-gradient-to-br from-urgency/20 to-urgency/5 flex items-center justify-center text-urgency font-bold text-sm">
          A1
         </div>
         <div>
          <p data-template-id="booking-1-name" class="canva-text font-medium text-sm"></p>
          <p data-template-id="booking-1-poli" class="canva-text text-xs opacity-60"></p>
         </div>
        </div><button class="approve-btn px-4 py-2 bg-mint text-white text-xs font-semibold rounded-xl hover:bg-mint-dark transition-colors" data-template-id="approve-btn-1"></button>
       </div>
      </div>
      <div class="bg-white/80 backdrop-blur rounded-2xl p-4 border border-white/60 shadow-sm queue-card">
       <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
         <div class="w-10 h-10 rounded-full bg-gradient-to-br from-urgency/20 to-urgency/5 flex items-center justify-center text-urgency font-bold text-sm">
          A2
         </div>
         <div>
          <p data-template-id="booking-2-name" class="canva-text font-medium text-sm"></p>
          <p data-template-id="booking-2-poli" class="canva-text text-xs opacity-60"></p>
         </div>
        </div><button class="approve-btn px-4 py-2 bg-mint text-white text-xs font-semibold rounded-xl hover:bg-mint-dark transition-colors" data-template-id="approve-btn-2"></button>
       </div>
      </div>
      <div class="bg-white/80 backdrop-blur rounded-2xl p-4 border border-white/60 shadow-sm queue-card">
       <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
         <div class="w-10 h-10 rounded-full bg-gradient-to-br from-urgency/20 to-urgency/5 flex items-center justify-center text-urgency font-bold text-sm">
          A3
         </div>
         <div>
          <p data-template-id="booking-3-name" class="canva-text font-medium text-sm"></p>
          <p data-template-id="booking-3-poli" class="canva-text text-xs opacity-60"></p>
         </div>
        </div><button class="approve-btn px-4 py-2 bg-mint text-white text-xs font-semibold rounded-xl hover:bg-mint-dark transition-colors" data-template-id="approve-btn-3"></button>
       </div>
      </div>
     </div>
    </section>
   </div><!-- PAGE: Antrian -->
   <div id="page-antrian" class="page px-5 lg:px-8 space-y-6 pt-6"><!-- Current Queue Display -->
    <section class="text-center">
     <div data-template-id="queue-display-card" class="canva-card rounded-3xl p-8 border border-mint/30 shadow-lg bg-gradient-to-br from-white to-mint/5">
      <p data-template-id="queue-now-label" class="canva-text text-sm font-medium uppercase tracking-wider opacity-60 mb-2"></p>
      <div class="text-6xl font-bold text-mint-dark mb-1" id="current-queue-number">
       A-03
      </div>
      <p class="text-sm text-gray-500 mt-2" id="current-queue-patient">Dewi Lestari • Poli Obgyn</p><button id="call-next-btn" data-template-id="call-next-btn" class="canva-button mt-6 px-8 py-3 rounded-2xl font-semibold text-sm shadow-md hover:shadow-lg transition-all"></button>
     </div>
    </section><!-- Filter Tabs -->
    <section>
     <div class="flex gap-2 overflow-x-auto pb-2"><button class="filter-tab active px-4 py-2 rounded-xl text-xs font-semibold transition-all" data-filter="all" data-template-id="filter-all"></button> <button class="filter-tab px-4 py-2 rounded-xl text-xs font-semibold bg-gray-100 text-gray-600 transition-all" data-filter="waiting" data-template-id="filter-waiting"></button> <button class="filter-tab px-4 py-2 rounded-xl text-xs font-semibold bg-gray-100 text-gray-600 transition-all" data-filter="serving" data-template-id="filter-serving"></button> <button class="filter-tab px-4 py-2 rounded-xl text-xs font-semibold bg-gray-100 text-gray-600 transition-all" data-filter="done" data-template-id="filter-done"></button>
     </div>
    </section><!-- Queue List -->
    <section id="queue-list" class="space-y-3"><!-- Queue items rendered by JS -->
    </section>
   </div>
  </main><!-- Mobile Bottom Nav -->
  <nav class="lg:hidden fixed bottom-0 left-0 right-0 glass border-t border-white/40 px-6 py-3 z-50">
   <div class="flex justify-around items-center"><button data-nav="beranda" class="mob-nav flex flex-col items-center gap-1 text-mint-dark"> <i data-lucide="layout-dashboard" style="width:22px;height:22px"></i> <span class="text-[10px] font-medium">Beranda</span> </button> <button data-nav="antrian" class="mob-nav flex flex-col items-center gap-1 text-gray-400"> <i data-lucide="list-ordered" style="width:22px;height:22px"></i> <span class="text-[10px] font-medium">Antrian</span> </button> <button data-nav="dokter" class="mob-nav flex flex-col items-center gap-1 text-gray-400"> <i data-lucide="stethoscope" style="width:22px;height:22px"></i> <span class="text-[10px] font-medium">Dokter</span> </button> <button data-nav="pengaturan" class="mob-nav flex flex-col items-center gap-1 text-gray-400"> <i data-lucide="settings" style="width:22px;height:22px"></i> <span class="text-[10px] font-medium">Pengaturan</span> </button>
   </div>
  </nav>
  <script src="/_sdk/editing_sdk.js"></script>
  <script>
    lucide.createIcons();

    // Queue data
    const queueData = [
      { no: 'A-01', name: 'Aisyah Putri', poli: 'Poli Anak', doctor: 'dr. Andi', status: 'done' },
      { no: 'A-02', name: 'Rizky Ramadhan', poli: 'Poli THT', doctor: 'dr. Budi', status: 'done' },
      { no: 'A-03', name: 'Dewi Lestari', poli: 'Poli Obgyn', doctor: 'dr. Siti', status: 'serving' },
      { no: 'A-04', name: 'Ahmad Fauzi', poli: 'Poli Anak', doctor: 'dr. Andi', status: 'waiting' },
      { no: 'A-05', name: 'Sari Wulandari', poli: 'Poli THT', doctor: 'dr. Budi', status: 'waiting' },
      { no: 'A-06', name: 'Budi Santoso', poli: 'Poli Obgyn', doctor: 'dr. Siti', status: 'waiting' },
      { no: 'A-07', name: 'Rina Marlina', poli: 'Poli Anak', doctor: 'dr. Andi', status: 'waiting' },
    ];

    let currentFilter = 'all';

    function getStatusBadge(status) {
      const map = {
        waiting: '<span class="px-2 py-1 rounded-lg text-[10px] font-semibold bg-orange-100 text-urgency">Menunggu</span>',
        serving: '<span class="px-2 py-1 rounded-lg text-[10px] font-semibold bg-emerald-100 text-mint-dark">Dilayani</span>',
        done: '<span class="px-2 py-1 rounded-lg text-[10px] font-semibold bg-amber-100 text-amber-700">Selesai</span>',
      };
      return map[status];
    }

    function renderQueue() {
      const list = document.getElementById('queue-list');
      const filtered = currentFilter === 'all' ? queueData : queueData.filter(q => q.status === currentFilter);
      list.innerHTML = filtered.map((q, i) => `
        <div class="queue-card bg-white/80 backdrop-blur rounded-2xl p-4 border border-white/60 shadow-sm animate-in" style="animation-delay:${i * 60}ms">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-mint/20 to-mint/5 flex items-center justify-center font-bold text-sm text-mint-dark">${q.no}</div>
              <div>
                <p class="font-medium text-sm text-gray-900">${q.name}</p>
                <p class="text-xs text-gray-500">${q.poli} • ${q.doctor}</p>
              </div>
            </div>
            ${getStatusBadge(q.status)}
          </div>
        </div>
      `).join('');
    }

    // Filter tabs
    document.querySelectorAll('.filter-tab').forEach(tab => {
      tab.addEventListener('click', () => {
        document.querySelectorAll('.filter-tab').forEach(t => { t.classList.remove('active'); t.classList.add('bg-gray-100', 'text-gray-600'); });
        tab.classList.add('active'); tab.classList.remove('bg-gray-100', 'text-gray-600');
        currentFilter = tab.dataset.filter;
        renderQueue();
      });
    });

    // Call next
    document.getElementById('call-next-btn').addEventListener('click', () => {
      const serving = queueData.find(q => q.status === 'serving');
      if (serving) serving.status = 'done';
      const nextWaiting = queueData.find(q => q.status === 'waiting');
      if (nextWaiting) {
        nextWaiting.status = 'serving';
        document.getElementById('current-queue-number').textContent = nextWaiting.no;
        document.getElementById('current-queue-patient').textContent = `${nextWaiting.name} • ${nextWaiting.poli}`;
      }
      renderQueue();
    });

    // Navigation
    function switchPage(page) {
      document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
      const target = document.getElementById('page-' + page);
      if (target) {
        target.classList.add('active');
        if (page === 'antrian') renderQueue();
      }
      // Sidebar
      document.querySelectorAll('.nav-link').forEach(l => { l.classList.remove('active'); l.classList.add('text-gray-500'); });
      const activeLink = document.querySelector(`.nav-link[data-nav="${page}"]`);
      if (activeLink) { activeLink.classList.add('active'); activeLink.classList.remove('text-gray-500'); }
      // Mobile
      document.querySelectorAll('.mob-nav').forEach(b => { b.classList.remove('text-mint-dark'); b.classList.add('text-gray-400'); });
      const activeMob = document.querySelector(`.mob-nav[data-nav="${page}"]`);
      if (activeMob) { activeMob.classList.add('text-mint-dark'); activeMob.classList.remove('text-gray-400'); }
    }

    document.querySelectorAll('[data-nav]').forEach(el => {
      el.addEventListener('click', (e) => { e.preventDefault(); switchPage(el.dataset.nav); });
    });

    // Approve buttons
    document.querySelectorAll('.approve-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        this.textContent = '✓ Disetujui';
        this.classList.remove('bg-mint', 'hover:bg-mint-dark');
        this.classList.add('bg-amber-100', 'text-amber-700', 'cursor-default');
        this.disabled = true;
        this.closest('.queue-card').style.opacity = '0.6';
      });
    });
  </script>
 <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'a11bbcf0677361bc',t:'MTc4MjQ3MTkzOC4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>