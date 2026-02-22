<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Generator Jadwal Pelajaran</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<style>
:root {
  --bg: #f0f4ff;
  --surface: #ffffff;
  --surface2: #f7f9ff;
  --border: #d1d9f0;
  --text: #1a2340;
  --text2: #5a6a8a;
  --accent: #2563eb;
  --accent2: #1d4ed8;
  --accent-light: #dbeafe;
  --shadow: 0 4px 24px rgba(37,99,235,0.10);
  --radius: 16px;
  --radius-sm: 8px;
}
[data-theme="dark"] {
  --bg: #0f172a; --surface: #1e293b; --surface2: #162032;
  --border: #334155; --text: #e2e8f0; --text2: #94a3b8;
  --accent: #3b82f6; --accent2: #2563eb; --accent-light: #1e3a5f;
  --shadow: 0 4px 24px rgba(0,0,0,0.4);
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; transition: background 0.3s, color 0.3s; }

/* Header */
header {
  background: var(--surface); border-bottom: 1px solid var(--border);
  padding: 14px 24px; display: flex; align-items: center; justify-content: space-between;
  position: sticky; top: 0; z-index: 100; box-shadow: var(--shadow);
}
.logo { display: flex; align-items: center; gap: 12px; }
.logo-icon { width: 38px; height: 38px; background: var(--accent); border-radius: 10px; display: grid; place-items: center; font-size: 18px; }
.logo h1 { font-size: 1rem; font-weight: 800; color: var(--text); line-height: 1.2; }
.logo span { font-size: 0.7rem; color: var(--text2); font-weight: 500; display: block; }
.header-actions { display: flex; gap: 8px; }

/* Buttons */
.btn { padding: 9px 18px; border-radius: var(--radius-sm); border: none; cursor: pointer; font-family: inherit; font-size: 0.85rem; font-weight: 600; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px; }
.btn-icon { padding: 9px 11px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: var(--surface2); cursor: pointer; font-size: 1rem; transition: all 0.2s; line-height: 1; }
.btn-icon:hover { background: var(--accent-light); border-color: var(--accent); }
.btn-primary { background: var(--accent); color: white; }
.btn-primary:hover { background: var(--accent2); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37,99,235,0.3); }
.btn-outline { background: transparent; color: var(--accent); border: 1.5px solid var(--accent); }
.btn-outline:hover { background: var(--accent-light); }
.btn-ghost { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
.btn-ghost:hover { background: var(--border); color: var(--text); }
.btn-success { background: #059669; color: white; }
.btn-success:hover { opacity: 0.88; }
.btn-warning { background: #d97706; color: white; }
.btn-warning:hover { opacity: 0.88; }
.btn-danger { background: #dc2626; color: white; }
.btn-danger:hover { opacity: 0.88; }

/* Main */
main { max-width: 960px; margin: 0 auto; padding: 28px 20px; }

/* Card */
.card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden; margin-bottom: 24px; }
.card-header { padding: 18px 24px 14px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 12px; }
.card-header-icon { font-size: 1.3rem; }
.card-header h2 { font-size: 0.95rem; font-weight: 700; }
.card-header p { font-size: 0.75rem; color: var(--text2); margin-top: 2px; }
.card-body { padding: 22px 24px; }

/* Form */
.form-row { display: grid; gap: 16px; margin-bottom: 18px; }
.form-row-2 { grid-template-columns: 1fr 1fr; }
.form-group { display: flex; flex-direction: column; gap: 6px; }
.form-label { font-size: 0.82rem; font-weight: 600; color: var(--text); }
.form-label .badge { display: inline-block; background: var(--accent-light); color: var(--accent); font-size: 0.67rem; padding: 2px 7px; border-radius: 100px; margin-left: 6px; font-weight: 700; }
input[type="text"], input[type="number"], select, textarea {
  padding: 10px 14px; background: var(--surface2); border: 1.5px solid var(--border);
  border-radius: var(--radius-sm); font-family: inherit; font-size: 0.85rem; color: var(--text);
  transition: border-color 0.2s, box-shadow 0.2s; width: 100%;
}
textarea { font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; resize: vertical; min-height: 150px; line-height: 1.7; }
input:focus, select:focus, textarea:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(37,99,235,0.12); }
textarea::placeholder, input::placeholder { color: var(--text2); opacity: 0.6; }

.counter-row { display: flex; gap: 10px; margin-bottom: 18px; flex-wrap: wrap; }
.counter-chip { background: var(--surface2); border: 1px solid var(--border); border-radius: 100px; padding: 5px 14px; font-size: 0.75rem; font-weight: 600; color: var(--text2); display: flex; align-items: center; gap: 5px; }
.counter-chip.ok { background: #d1fae5; color: #065f46; border-color: #a7f3d0; }
.counter-chip.warn { background: #fef3c7; color: #92400e; border-color: #fde68a; }
[data-theme="dark"] .counter-chip.ok { background: #064e3b; color: #6ee7b7; border-color: #065f46; }
[data-theme="dark"] .counter-chip.warn { background: #451a03; color: #fbbf24; border-color: #78350f; }

.form-actions { display: flex; gap: 10px; flex-wrap: wrap; }
.form-hint { font-size: 0.73rem; color: var(--text2); margin-top: 6px; }

/* Jam config */
.jam-config { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 10px; }
.jam-item { display: flex; flex-direction: column; gap: 4px; }
.jam-item label { font-size: 0.72rem; font-weight: 600; color: var(--text2); }
.jam-item input { padding: 7px 10px; font-size: 0.78rem; }

/* Output Section */
#output-section { display: none; }
.output-toolbar { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
.output-title h2 { font-size: 1.1rem; font-weight: 800; }
.output-title p { font-size: 0.75rem; color: var(--text2); margin-top: 3px; }
.export-btns { display: flex; gap: 8px; flex-wrap: wrap; }

/* Filter */
.filter-bar { display: flex; gap: 10px; margin-bottom: 16px; flex-wrap: wrap; }
.search-wrap { flex: 1; min-width: 180px; position: relative; }
.search-wrap input { padding-left: 36px; }
.search-icon { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); font-size: 0.85rem; color: var(--text2); pointer-events: none; }
.filter-select { min-width: 130px; cursor: pointer; }

/* ═══ THE SCHEDULE GRID TABLE ═══ */
#jadwal-print-area {
  background: white;
  padding: 18px 20px 14px;
  border-radius: var(--radius-sm);
  border: 1px solid var(--border);
  color: #111;
}
[data-theme="dark"] #jadwal-print-area { background: #1e293b; color: #e2e8f0; border-color: #334155; }

.jadwal-title-block { text-align: center; margin-bottom: 14px; }
.jadwal-main-title { font-size: 0.82rem; font-weight: 600; color: #333; margin-bottom: 3px; }
.jadwal-kelas-name { font-size: 1.6rem; font-weight: 800; color: #111; letter-spacing: 0.01em; }
[data-theme="dark"] .jadwal-main-title { color: #94a3b8; }
[data-theme="dark"] .jadwal-kelas-name { color: #e2e8f0; }

.sched-grid-wrap { overflow-x: auto; }
.sched-grid {
  width: 100%; border-collapse: collapse;
  font-size: 0.8rem; min-width: 700px;
  border: 2px solid #333;
}
[data-theme="dark"] .sched-grid { border-color: #475569; }
.sched-grid th, .sched-grid td {
  border: 1px solid #aaa;
  text-align: center;
  vertical-align: middle;
  padding: 0;
}
[data-theme="dark"] .sched-grid th, [data-theme="dark"] .sched-grid td { border-color: #475569; }

/* Header row (jam numbers) */
.sched-grid thead th {
  background: #f5f5f5;
  font-weight: 700;
  font-size: 0.82rem;
  padding: 8px 4px;
  color: #222;
  border: 1px solid #aaa;
}
[data-theme="dark"] .sched-grid thead th { background: #0f172a; color: #e2e8f0; border-color: #475569; }

/* Day column */
.col-hari {
  width: 72px; min-width: 72px;
  font-weight: 800;
  font-size: 0.9rem;
  background: #f9f9f9;
  padding: 10px 6px;
  color: #111;
  border-right: 2px solid #777 !important;
}
[data-theme="dark"] .col-hari { background: #1e293b; color: #e2e8f0; border-right-color: #475569 !important; }

/* Subject cell */
.cell-mapel {
  padding: 7px 6px;
  line-height: 1.35;
  font-size: 0.78rem;
}
.cell-mapel .mapel { font-weight: 700; font-size: 0.82rem; color: #111; display: block; }
.cell-mapel .guru { font-size: 0.7rem; color: #555; display: block; margin-top: 2px; font-style: italic; }
[data-theme="dark"] .cell-mapel .mapel { color: #e2e8f0; }
[data-theme="dark"] .cell-mapel .guru { color: #94a3b8; }

/* Special cells */
.cell-empty { background: #fafafa; }
.cell-gls { background: #fffde7; }
.cell-upcr { background: #e8f5e9; }
.cell-bk { background: #fce4ec; }
.cell-krida { background: #e3f2fd; }
[data-theme="dark"] .cell-gls { background: #2d2a0a; }
[data-theme="dark"] .cell-upcr { background: #0a2d18; }
[data-theme="dark"] .cell-bk { background: #2d0a15; }
[data-theme="dark"] .cell-krida { background: #0a1a2d; }

/* Time row */
.time-row td {
  font-size: 0.66rem; color: #888; background: #f9f9f9;
  padding: 3px 2px; border-top: none;
  font-family: 'JetBrains Mono', monospace;
}
[data-theme="dark"] .time-row td { background: #1e293b; color: #64748b; }

/* Footer */
.jadwal-footer {
  display: flex; justify-content: space-between; align-items: center;
  margin-top: 10px; font-size: 0.68rem; color: #888;
  padding: 0 2px;
}

/* Toast */
#toast {
  position: fixed; bottom: 24px; right: 24px;
  background: var(--text); color: var(--bg);
  padding: 11px 18px; border-radius: var(--radius-sm);
  font-size: 0.83rem; font-weight: 600;
  z-index: 9999; transform: translateY(80px); opacity: 0;
  transition: all 0.3s; pointer-events: none; max-width: 260px;
}
#toast.show { transform: translateY(0); opacity: 1; }

/* Modal overlay for class name input before download */
.modal-overlay {
  display: none; position: fixed; inset: 0;
  background: rgba(0,0,0,0.5); z-index: 500;
  align-items: center; justify-content: center;
}
.modal-overlay.open { display: flex; }
.modal-box {
  background: var(--surface); border-radius: var(--radius);
  padding: 28px; max-width: 420px; width: 90%;
  box-shadow: 0 20px 60px rgba(0,0,0,0.3);
  animation: popIn 0.25s ease;
}
@keyframes popIn { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }
.modal-box h3 { font-size: 1rem; font-weight: 800; margin-bottom: 6px; }
.modal-box p { font-size: 0.82rem; color: var(--text2); margin-bottom: 18px; }
.modal-input { width: 100%; margin-bottom: 16px; font-size: 1rem; font-weight: 600; text-align: center; padding: 12px; }
.modal-actions { display: flex; gap: 10px; justify-content: flex-end; }

/* Print */
@media print {
  body * { visibility: hidden; }
  #jadwal-print-area, #jadwal-print-area * { visibility: visible; }
  #jadwal-print-area { position: fixed; left: 0; top: 0; width: 100%; padding: 12px; }
  .sched-grid { font-size: 0.72rem; min-width: unset; }
}

/* Responsive */
@media (max-width: 640px) {
  .form-row-2 { grid-template-columns: 1fr; }
  .card-body { padding: 16px; }
  .export-btns .btn { font-size: 0.78rem; padding: 8px 12px; }
  .jadwal-kelas-name { font-size: 1.2rem; }
}
</style>
</head>
<body>

<header>
  <div class="logo">
    <div class="logo-icon">📅</div>
    <div>
      <h1>Jadwal Pelajaran</h1>
      <span>Generator Jadwal Format Grid</span>
    </div>
  </div>
  <div class="header-actions">
    <button class="btn-icon" id="theme-toggle" title="Dark mode">🌙</button>
    <button class="btn-icon" onclick="window.print()" title="Cetak">🖨️</button>
  </div>
</header>

<main>
  <!-- Step 1: Info Kelas -->
  <div class="card" id="step1-card">
    <div class="card-header">
      <span class="card-header-icon">🏫</span>
      <div><h2>Informasi Jadwal</h2><p>Isi identitas sekolah dan kelas</p></div>
    </div>
    <div class="card-body">
      <div class="form-row form-row-2">
        <div class="form-group">
          <label class="form-label">Nama Sekolah</label>
          <input type="text" id="nama-sekolah" placeholder="Contoh: SMP Negeri 1 Semarang" value="SMP Negeri 1 Semarang">
        </div>
        <div class="form-group">
          <label class="form-label">Nama Kelas</label>
          <input type="text" id="nama-kelas" placeholder="Contoh: VII E, XI TJKT 3, XII IPA 1" value="VII E">
        </div>
      </div>
      <div class="form-row form-row-2">
        <div class="form-group">
          <label class="form-label">Semester & Tahun Pelajaran</label>
          <input type="text" id="semester" placeholder="Contoh: Semester 1 Tahun 2024/2025" value="Semester 1 Tahun Pelajaran 2024/2025">
        </div>
        <div class="form-group">
          <label class="form-label">Tanggal Mulai</label>
          <input type="text" id="tgl-mulai" placeholder="Contoh: Mulai 15 Juli 2024" value="Mulai 15 Juli 2024">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Jumlah Jam per Hari <span class="badge">Senin–Kamis</span></label>
          <input type="number" id="jam-per-hari" value="10" min="6" max="12" style="max-width:120px;">
          <p class="form-hint">Jumat otomatis menggunakan sisa kode setelah Senin–Kamis.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Step 2: Jam & Waktu (opsional) -->
  <div class="card" id="step2-card">
    <div class="card-header">
      <span class="card-header-icon">⏰</span>
      <div><h2>Waktu Jam Pelajaran</h2><p>Opsional — isi waktu tiap jam untuk ditampilkan di jadwal</p></div>
    </div>
    <div class="card-body">
      <div class="jam-config" id="jam-config-wrap"></div>
      <p class="form-hint" style="margin-top:12px;">💡 Kosongkan jika tidak ingin menampilkan waktu.</p>
    </div>
  </div>

  <!-- Step 3: Input Kode -->
  <div class="card" id="step3-card">
    <div class="card-header">
      <span class="card-header-icon">📝</span>
      <div><h2>Input Kode Guru</h2><p>Masukkan kode guru sesuai urutan jam pelajaran</p></div>
    </div>
    <div class="card-body">
      <div class="form-group" style="margin-bottom:16px;">
        <label class="form-label">Kode Guru <span class="badge">Minimal 41 kode</span></label>
        <textarea id="kodes" placeholder="Pisah spasi/koma. Contoh:&#10;Upcr D4 D4 T3 T3 Mat G1 J1 J1 H1&#10;GLS GLS BI BI BK Seni Seni IF IF IF&#10;..."></textarea>
        <p class="form-hint">Senin–Kamis: <strong id="hint-jam">10</strong> kode/hari · Jumat: sisanya</p>
      </div>
      <div class="counter-row" id="counter-row" style="display:none">
        <div class="counter-chip" id="chip-total">📊 0 kode</div>
        <div class="counter-chip" id="chip-seninkamis">Senin–Kamis: 0/40</div>
        <div class="counter-chip" id="chip-jumat">Jumat: 0</div>
        <div class="counter-chip" id="chip-status">⏳</div>
      </div>
      <div class="form-actions">
        <button class="btn btn-primary" onclick="generateJadwal()">✨ Buat Jadwal</button>
        <button class="btn btn-ghost" onclick="clearForm()">🗑️ Reset</button>
        <button class="btn btn-outline" onclick="loadContoh()">📋 Contoh Data</button>
      </div>
    </div>
  </div>

  <!-- Output -->
  <div id="output-section">
    <div class="output-toolbar">
      <div class="output-title">
        <h2 id="out-kelas-title"></h2>
        <p id="out-subtitle"></p>
      </div>
      <div class="export-btns">
        <button class="btn btn-ghost" onclick="showInputSection()">✏️ Edit</button>
        <button class="btn btn-success" onclick="downloadCSV()">📊 CSV</button>
        <button class="btn btn-warning" onclick="downloadJPG()">🖼️ JPG</button>
        <button class="btn btn-danger" onclick="downloadPDF()">📄 PDF</button>
      </div>
    </div>

    <div class="filter-bar">
      <div class="search-wrap">
        <span class="search-icon">🔍</span>
        <input type="text" id="search-input" placeholder="Cari mapel, guru, kode..." oninput="renderGrid()">
      </div>
      <select class="filter-select" id="filter-hari" onchange="renderGrid()">
        <option value="">Semua Hari</option>
        <option>Senin</option><option>Selasa</option><option>Rabu</option>
        <option>Kamis</option><option>Jumat</option>
      </select>
    </div>

    <!-- The printable grid area -->
    <div id="jadwal-print-area">
      <div class="jadwal-title-block">
        <div class="jadwal-main-title" id="print-main-title"></div>
        <div class="jadwal-kelas-name" id="print-kelas-name"></div>
      </div>
      <div class="sched-grid-wrap">
        <table class="sched-grid" id="sched-grid-table"></table>
      </div>
      <div class="jadwal-footer">
        <span id="footer-left"></span>
        <span id="footer-right">Generated by Jadwal Sekolah App</span>
      </div>
    </div>
  </div>
</main>




<div id="toast"></div>

<script>
const kodeGuru = {
  "A1": { nama: "Dra. Siti Rahayu", mapel: "PA. Islam" },
  "A2": { nama: "Dwi Sidik Purnomo", mapel: "PA. Islam" },
  "A3": { nama: "Akhmad Affandi", mapel: "PA. Islam" },
  "A4": { nama: "Drs. Adnan", mapel: "PA. Islam" },
  "A5": { nama: "Retno Wiranti", mapel: "PA. Islam" },
  "A7": { nama: "Wahyudi", mapel: "PA. Islam" },
  "A8": { nama: "Mozes Gilang P.", mapel: "PA. Kristen" },
  "A9": { nama: "Sardi", mapel: "PA. Hindu" },
  "A10": { nama: "Veronika Elisa", mapel: "PA. Katholik" },
  "R1": { nama: "Wahyuni, S.Pd.", mapel: "Pend. Pancasila" },
  "R2": { nama: "Harini Widyastuti", mapel: "Pend. Pancasila" },
  "R3": { nama: "Warsito, S.Pd.", mapel: "Pend. Pancasila" },
  "R4": { nama: "Anida Nihayati", mapel: "Pend. Pancasila" },
  "D1": { nama: "Kurniadi Wilapa", mapel: "Bahasa Indonesia" },
  "D2": { nama: "Widya Ajeng Pemila", mapel: "Bahasa Indonesia" },
  "D3": { nama: "Heri Santoso", mapel: "Bahasa Indonesia" },
  "D4": { nama: "Agus Slamet Zuari", mapel: "Bahasa Indonesia" },
  "D5": { nama: "Febrianita S.A.", mapel: "Bahasa Indonesia" },
  "D6": { nama: "Siti Rohayati", mapel: "Bahasa Indonesia" },
  "J1": { nama: "Aminuddin Aziz", mapel: "Penjasorkes" },
  "J2": { nama: "Eko Winanto", mapel: "Penjasorkes" },
  "S1": { nama: "Dwi Mulyati", mapel: "Sejarah" },
  "S2": { nama: "Ninik Sudaryanti", mapel: "Sejarah" },
  "Y1": { nama: "Arif Hakim D.", mapel: "Seni Budaya" },
  "Y2": { nama: "Sidiq Jefry H.", mapel: "Seni Budaya" },
  "T1": { nama: "Bekti Yahrini", mapel: "Matematika" },
  "T2": { nama: "Sukandar, S.Pd.", mapel: "Matematika" },
  "T3": { nama: "Guru Matematika", mapel: "Matematika" },
  "T4": { nama: "Wikantiasno", mapel: "Matematika" },
  "T5": { nama: "Ika Wulandari", mapel: "Matematika" },
  "T6": { nama: "Drs. Paryoko", mapel: "Matematika" },
  "T7": { nama: "Krisdwindartatik", mapel: "Matematika" },
  "G1": { nama: "Yeni Widiyaswati", mapel: "Bahasa Inggris" },
  "G2": { nama: "Arief Imanudin", mapel: "Bahasa Inggris" },
  "G3": { nama: "Feryanto Estu N.", mapel: "Bahasa Inggris" },
  "G4": { nama: "Nastiani Murti", mapel: "Bahasa Inggris" },
  "G5": { nama: "Sutini, S.Pd.", mapel: "Bahasa Inggris" },
  "G6": { nama: "Reni, S.Pd.", mapel: "Bahasa Inggris" },
  "G7": { nama: "Murni Dwi Astuti", mapel: "Bahasa Inggris" },
  "F1": { nama: "Agus Riyanto", mapel: "Projek IPAS" },
  "C1": { nama: "Sri Winartini", mapel: "Projek IPAS" },
  "C2": { nama: "Rahma Nursitha", mapel: "Projek IPAS" },
  "C3": { nama: "Nurbiandari", mapel: "Projek IPAS" },
  "H1": { nama: "Sri Winarti", mapel: "Kewirausahaan" },
  "H2": { nama: "Jazuri, S.Pd.", mapel: "Kewirausahaan" },
  "H3": { nama: "Desti Indriyani", mapel: "Kewirausahaan" },
  "BK1": { nama: "Sri Sukartini", mapel: "Bimb. Konseling" },
  "BK3": { nama: "Indra Krisna", mapel: "Bimb. Konseling" },
  "BK4": { nama: "Hardiyanto", mapel: "Bimb. Konseling" },
  "BK5": { nama: "Ngatijan, S.Pd.", mapel: "Bimb. Konseling" },
  "BK6": { nama: "Suci Rahmawati", mapel: "Bimb. Konseling" },
  "BK7": { nama: "Vivi Astriati", mapel: "Bimb. Konseling" },
  "BK8": { nama: "Ahmad Ali M.", mapel: "Bimb. Konseling" },
  "IF1": { nama: "Ninik Sulistyowati", mapel: "Informatika" },
  "W1": { nama: "Heryani Retno H.", mapel: "Bahasa Jawa" },
  "W2": { nama: "Aji Saputra", mapel: "Bahasa Jawa" },
  // Special non-guru codes
  "GLS": { nama: "", mapel: "GLS" },
  "UPCR": { nama: "", mapel: "Upacara" },
  "Upcr": { nama: "", mapel: "Upacara" },
  "KRIDA": { nama: "", mapel: "Krida" },
  "Krida": { nama: "", mapel: "Krida" },
  "BK": { nama: "", mapel: "BK" },
  "-": { nama: "", mapel: "" },
};

const HARI = ['Senin','Selasa','Rabu','Kamis','Jumat'];
let scheduleData = [];
let pendingDownloadType = null;

// ── Dark mode ──
document.getElementById('theme-toggle').onclick = () => {
  const html = document.documentElement;
  const isDark = html.getAttribute('data-theme') === 'dark';
  html.setAttribute('data-theme', isDark ? 'light' : 'dark');
  document.getElementById('theme-toggle').textContent = isDark ? '🌙' : '☀️';
};

// ── Jam config builder ──
function buildJamConfig() {
  const n = parseInt(document.getElementById('jam-per-hari').value) || 10;
  document.getElementById('hint-jam').textContent = n;
  const wrap = document.getElementById('jam-config-wrap');
  wrap.innerHTML = '';
  const defaults = [
    '07.00–07.45','07.45–08.30','08.30–09.15','09.15–10.00',
    '10.00–10.45','10.45–11.30','11.30–12.15','12.15–13.00',
    '13.00–13.45','13.45–14.30','14.30–15.15','15.15–16.00'
  ];
  for (let i = 0; i < n; i++) {
    wrap.innerHTML += `<div class="jam-item">
      <label>Jam ke-${i+1}</label>
      <input type="text" class="jam-time" id="jt-${i+1}" placeholder="${defaults[i]||''}" value="${defaults[i]||''}">
    </div>`;
  }
}
buildJamConfig();
document.getElementById('jam-per-hari').addEventListener('input', buildJamConfig);

// ── Counter ──
document.getElementById('kodes').addEventListener('input', function() {
  const kodes = this.value.trim().split(/[\s,]+/).filter(Boolean);
  const n = kodes.length;
  const jamPerHari = parseInt(document.getElementById('jam-per-hari').value)||10;
  const need = jamPerHari * 4;
  const row = document.getElementById('counter-row');
  row.style.display = 'flex';
  document.getElementById('chip-total').textContent = `📊 ${n} kode`;
  document.getElementById('chip-seninkamis').textContent = `Sen–Kam: ${Math.min(n, need)}/${need}`;
  const jumat = Math.max(0, n - need);
  document.getElementById('chip-jumat').textContent = `Jumat: ${jumat}`;
  const s = document.getElementById('chip-status');
  if (n >= need + 1) { s.textContent = '✅ Cukup'; s.className = 'counter-chip ok'; }
  else { s.textContent = `⚠️ Kurang ${(need+1)-n}`; s.className = 'counter-chip warn'; }
});

// ── Generate ──
function generateJadwal() {
  const input = document.getElementById('kodes').value.trim();
  const kodes = input.split(/[\s,]+/).filter(Boolean);
  const jamPerHari = parseInt(document.getElementById('jam-per-hari').value)||10;
  const need = jamPerHari * 4;

  if (kodes.length < need + 1) {
    showToast(`⚠️ Minimal ${need+1} kode (${jamPerHari}/hari × 4 hari + Jumat)!`);
    return;
  }

  // Collect jam times
  const jamTimes = [];
  for (let i = 1; i <= jamPerHari; i++) {
    const el = document.getElementById(`jt-${i}`);
    jamTimes.push(el ? el.value.trim() : '');
  }

  scheduleData = [];
  let idx = 0;
  for (let h = 0; h < 4; h++) {
    scheduleData.push({ hari: HARI[h], kodes: kodes.slice(idx, idx + jamPerHari) });
    idx += jamPerHari;
  }
  scheduleData.push({ hari: 'Jumat', kodes: kodes.slice(idx) });

  window._jamTimes = jamTimes;
  window._jamPerHari = jamPerHari;

  renderGrid();
  updatePrintHeader();

  document.getElementById('output-section').style.display = 'block';
  document.getElementById('output-section').scrollIntoView({ behavior: 'smooth' });
  showToast('✅ Jadwal berhasil dibuat!');
}

function updatePrintHeader() {
  const kelas = document.getElementById('nama-kelas').value || 'Kelas';
  const sekolah = document.getElementById('nama-sekolah').value || '';
  const semester = document.getElementById('semester').value || '';
  const tgl = document.getElementById('tgl-mulai').value || '';
  const combinedTitle = [sekolah, semester, tgl].filter(Boolean).join(' · ');
  document.getElementById('print-main-title').textContent = `Jadwal KBM ${combinedTitle}`;
  document.getElementById('print-kelas-name').textContent = kelas;
  document.getElementById('out-kelas-title').textContent = `Jadwal Kelas ${kelas}`;
  document.getElementById('out-subtitle').textContent = combinedTitle;
  const now = new Date();
  document.getElementById('footer-left').textContent = `Timetable generated: ${now.toLocaleDateString('id-ID')}`;
  document.getElementById('footer-right').textContent = kelas;
}

function renderGrid() {
  const jamPerHari = window._jamPerHari || 10;
  const jamTimes = window._jamTimes || [];
  const q = (document.getElementById('search-input')?.value||'').toLowerCase();
  const hariFilter = document.getElementById('filter-hari')?.value||'';
  const displayHari = hariFilter ? scheduleData.filter(d=>d.hari===hariFilter) : scheduleData;

  // Build table
  let html = '<thead><tr>';
  html += `<th style="width:72px">Hari</th>`;
  for (let i = 1; i <= jamPerHari; i++) html += `<th>${i}</th>`;
  html += '</tr></thead>';

  html += '<tbody>';

  displayHari.forEach(dayData => {
    // Parse into merged cells
    const cells = [];
    let j = 0;
    const dk = dayData.kodes;
    while (j < dk.length) {
      const kode = dk[j];
      let span = 1;
      while (j + span < dk.length && dk[j+span] === kode) span++;
      const info = kodeGuru[kode] || { mapel: kode, nama: '' };
      cells.push({ kode, mapel: info.mapel, nama: info.nama, span, jamStart: j+1 });
      j += span;
    }

    // Apply search highlight / filter
    const rowVisible = !q || cells.some(c =>
      c.mapel.toLowerCase().includes(q) || c.nama.toLowerCase().includes(q) || c.kode.toLowerCase().includes(q)
    );
    if (!rowVisible) return;

    html += `<tr>`;
    html += `<td class="col-hari">${dayData.hari}</td>`;

    // Fill up to jamPerHari columns
    let col = 1;
    cells.forEach(cell => {
      // Gap before this cell
      while (col < cell.jamStart) {
        html += `<td class="cell-mapel cell-empty"></td>`;
        col++;
      }
      const highlight = q && (cell.mapel.toLowerCase().includes(q)||cell.nama.toLowerCase().includes(q)||cell.kode.toLowerCase().includes(q));
      const specialClass = getSpecialClass(cell.kode);
      const highlightStyle = highlight ? 'background:#fef9c3;' : '';
      html += `<td class="cell-mapel ${specialClass}" colspan="${cell.span}" style="${highlightStyle}">
        <span class="mapel">${cell.mapel}</span>
        ${cell.nama ? `<span class="guru">${cell.nama}</span>` : ''}
      </td>`;
      col += cell.span;
    });
    // Remaining empty cells
    while (col <= jamPerHari) {
      html += `<td class="cell-mapel cell-empty"></td>`;
      col++;
    }
    html += `</tr>`;

    // Time sub-row if any time defined
    const hasTime = jamTimes.some(t=>t);
    if (hasTime) {
      html += `<tr class="time-row"><td></td>`;
      for (let i=0;i<jamPerHari;i++) html += `<td>${jamTimes[i]||''}</td>`;
      html += `</tr>`;
    }
  });

  html += '</tbody>';
  document.getElementById('sched-grid-table').innerHTML = html;
}

function getSpecialClass(kode) {
  const k = kode.toLowerCase();
  if (k === 'gls') return 'cell-gls';
  if (k === 'upcr' || k === 'upacara') return 'cell-upcr';
  if (k === 'bk') return 'cell-bk';
  if (k === 'krida') return 'cell-krida';
  return '';
}

// ── Modal for download ── (DIHAPUS - tidak pakai modal lagi)

function downloadJPG() {
  showToast('🖼️ Membuat gambar...');
  setTimeout(() => {
    const canvas = buildCanvas();
    canvas.toBlob(blob => {
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = `Jadwal-${document.getElementById('nama-kelas').value||'Kelas'}.jpg`;
      a.click();
      URL.revokeObjectURL(url);
      showToast('✅ JPG berhasil diunduh!');
    }, 'image/jpeg', 0.97);
  }, 100);
}

function downloadPDF() {
  showToast('📄 Membuat PDF...');
  setTimeout(() => {
    const canvas = buildCanvas();
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF('l', 'mm', 'a4');
    const pgW = pdf.internal.pageSize.getWidth();
    const pgH = pdf.internal.pageSize.getHeight();
    const ratio = Math.min((pgW - 20) / canvas.width, (pgH - 20) / canvas.height);
    const w = canvas.width * ratio;
    const h = canvas.height * ratio;
    const x = (pgW - w) / 2;
    const y = (pgH - h) / 2;
    pdf.addImage(canvas.toDataURL('image/jpeg', 0.97), 'JPEG', x, y, w, h);
    pdf.save(`Jadwal-${document.getElementById('nama-kelas').value||'Kelas'}.pdf`);
    showToast('✅ PDF berhasil diunduh!');
  }, 100);
}

// ── Build canvas — 4:3 ratio, matches preview visually ──
function buildCanvas() {
  const jamPerHari = window._jamPerHari || 10;
  const jamTimes   = window._jamTimes  || [];
  const kelas   = document.getElementById('nama-kelas').value   || 'Kelas';
  const sekolah = document.getElementById('nama-sekolah').value || '';
  const semester= document.getElementById('semester').value     || '';
  const tgl     = document.getElementById('tgl-mulai').value    || '';
  const now     = new Date();
  const hasTime = jamTimes.some(t => t);
  const nDays   = scheduleData.length; // 5

  // ── Fixed 4:3 canvas size (1600 × 1200 logical px, ×2 for sharpness) ──
  const CW = 1600, CH = 1200, SCALE = 2;
  const canvas = document.createElement('canvas');
  canvas.width  = CW * SCALE;
  canvas.height = CH * SCALE;
  const ctx = canvas.getContext('2d');
  ctx.scale(SCALE, SCALE);

  // ── Colours matching the preview ──
  const C = {
    bg:        '#ffffff',
    titleSub:  '#555555',
    titleMain: '#111111',
    thBg:      '#e8f0fe',   // blue-ish header like preview
    thText:    '#1a73e8',
    thBorder:  '#c5d3f5',
    hariiBg:   '#f5f5f5',
    hariiText: '#111111',
    hariiRightBorder: '#888888',
    cellBg:    '#ffffff',
    cellBorder:'#c8c8c8',
    mapelText: '#111111',
    guruText:  '#555555',
    emptyBg:   '#fafafa',
    timeBg:    '#f5f5f5',
    timeText:  '#888888',
    footerText:'#aaaaaa',
    outerBorder:'#333333',
    // special cell backgrounds (same as CSS)
    gls:   '#fffde7',
    upcr:  '#e8f5e9',
    upacara:'#e8f5e9',
    bk:    '#fce4ec',
    krida: '#e3f2fd',
  };

  const PAD      = 28;   // outer padding
  const TITLE_H  = 80;   // height of title block
  const FOOTER_H = 28;

  // Work out table area
  const tableX = PAD;
  const tableY = TITLE_H;
  const tableW = CW - PAD * 2;
  const tableH = CH - TITLE_H - FOOTER_H - PAD;

  // Column widths — hari col fixed, rest split evenly
  const HARI_W  = Math.round(tableW * 0.09);  // ~9% for day name
  const jamColW = Math.round((tableW - HARI_W) / jamPerHari);

  // Row heights — header row + optional time row + data rows
  const HEADER_H  = 34;
  const TIME_H    = hasTime ? 20 : 0;
  const dataAreaH = tableH - HEADER_H - TIME_H;
  const ROW_H     = Math.round(dataAreaH / nDays);

  // ── White background ──
  ctx.fillStyle = C.bg;
  ctx.fillRect(0, 0, CW, CH);

  // ── Title block ──
  const titleStr = ['Jadwal KBM', sekolah, semester, tgl].filter(Boolean).join('  ·  ');
  ctx.textAlign    = 'center';
  ctx.textBaseline = 'alphabetic';
  ctx.font         = '15px Arial';
  ctx.fillStyle    = C.titleSub;
  ctx.fillText(titleStr, CW / 2, PAD + 20);

  ctx.font      = 'bold 38px Arial';
  ctx.fillStyle = C.titleMain;
  ctx.fillText(kelas, CW / 2, PAD + 66);

  // ── Helpers ──
  function rect(x, y, w, h, fill, strokeColor, strokeW) {
    ctx.fillStyle = fill;
    ctx.fillRect(x, y, w, h);
    if (strokeColor) {
      ctx.strokeStyle = strokeColor;
      ctx.lineWidth   = strokeW || 1;
      ctx.strokeRect(x + (strokeW||1)/2, y + (strokeW||1)/2, w - (strokeW||1), h - (strokeW||1));
    }
  }

  function text(str, cx, cy, maxW, font, color, align) {
    ctx.font         = font;
    ctx.fillStyle    = color;
    ctx.textAlign    = align || 'center';
    ctx.textBaseline = 'middle';
    // Truncate if needed
    let s = String(str);
    while (ctx.measureText(s).width > maxW - 6 && s.length > 2) s = s.slice(0, -1);
    ctx.fillText(s, cx, cy);
  }

  // ── Header row (jam numbers) ──
  let hx = tableX, hy = tableY;
  rect(hx, hy, HARI_W, HEADER_H, C.thBg, C.thBorder);
  text('Hari', hx + HARI_W/2, hy + HEADER_H/2, HARI_W, 'bold 15px Arial', C.thText);
  for (let i = 0; i < jamPerHari; i++) {
    const cx = tableX + HARI_W + i * jamColW;
    rect(cx, hy, jamColW, HEADER_H, C.thBg, C.thBorder);
    text(`${i+1}`, cx + jamColW/2, hy + HEADER_H/2, jamColW, 'bold 16px Arial', C.thText);
  }

  // ── Time sub-row ──
  let curY = tableY + HEADER_H;
  if (hasTime) {
    rect(tableX, curY, HARI_W, TIME_H, C.timeBg, C.cellBorder, 0.5);
    for (let i = 0; i < jamPerHari; i++) {
      const cx = tableX + HARI_W + i * jamColW;
      rect(cx, curY, jamColW, TIME_H, C.timeBg, C.cellBorder, 0.5);
      text(jamTimes[i]||'', cx + jamColW/2, curY + TIME_H/2, jamColW, '11px monospace', C.timeText);
    }
    curY += TIME_H;
  }

  // ── Data rows ──
  const BG_SPECIAL = { gls:C.gls, upcr:C.upcr, upacara:C.upacara, bk:C.bk, krida:C.krida };

  scheduleData.forEach((dayData, di) => {
    const rowY = curY + di * ROW_H;

    // Alternating row bg (even rows very slightly tinted, like preview hover)
    const rowBase = di % 2 === 1 ? '#f9fbff' : '#ffffff';

    // Parse merged cells for this row
    const cells = [];
    let j = 0;
    const dk = dayData.kodes;
    while (j < dk.length) {
      const kode = dk[j];
      let span = 1;
      while (j + span < dk.length && dk[j+span] === kode) span++;
      const info = kodeGuru[kode] || { mapel: kode, nama: '' };
      cells.push({ kode, mapel: info.mapel, nama: info.nama, span, start: j });
      j += span;
    }

    // Day label
    rect(tableX, rowY, HARI_W, ROW_H, C.hariiBg, C.cellBorder);
    // Thick right border for hari col
    ctx.strokeStyle = C.hariiRightBorder;
    ctx.lineWidth   = 2;
    ctx.beginPath();
    ctx.moveTo(tableX + HARI_W, rowY);
    ctx.lineTo(tableX + HARI_W, rowY + ROW_H);
    ctx.stroke();
    text(dayData.hari, tableX + HARI_W/2, rowY + ROW_H/2, HARI_W, 'bold 16px Arial', C.hariiText);

    // Subject cells
    let col = 0;
    cells.forEach(cell => {
      while (col < cell.start) {
        rect(tableX + HARI_W + col*jamColW, rowY, jamColW, ROW_H, C.emptyBg, C.cellBorder, 0.7);
        col++;
      }
      const cx  = tableX + HARI_W + col * jamColW;
      const cw  = jamColW * cell.span;
      const bg  = BG_SPECIAL[cell.kode.toLowerCase()] || rowBase;
      rect(cx, rowY, cw, ROW_H, bg, C.cellBorder);

      const centerX = cx + cw / 2;
      if (cell.nama) {
        // mapel (upper portion) + guru (lower)
        text(cell.mapel, centerX, rowY + ROW_H * 0.36, cw, 'bold 15px Arial', C.mapelText);
        text(cell.nama,  centerX, rowY + ROW_H * 0.68, cw, 'italic 12px Arial', C.guruText);
      } else {
        text(cell.mapel, centerX, rowY + ROW_H * 0.5, cw, 'bold 15px Arial', C.mapelText);
      }
      col += cell.span;
    });

    // Remaining empty cells
    while (col < jamPerHari) {
      rect(tableX + HARI_W + col*jamColW, rowY, jamColW, ROW_H, C.emptyBg, C.cellBorder, 0.7);
      col++;
    }
  });

  // ── Outer table border ──
  const tableBottom = curY + nDays * ROW_H;
  ctx.strokeStyle = C.outerBorder;
  ctx.lineWidth   = 2;
  ctx.strokeRect(tableX + 1, tableY + 1, tableW - 2, tableBottom - tableY - 2);

  // ── Footer ──
  const footerY = tableBottom + 10;
  ctx.font         = '13px Arial';
  ctx.fillStyle    = C.footerText;
  ctx.textBaseline = 'middle';
  ctx.textAlign    = 'left';
  ctx.fillText(`Timetable generated: ${now.toLocaleDateString('id-ID')}`, PAD, footerY + FOOTER_H/2);
  ctx.textAlign = 'right';
  ctx.fillText(kelas, CW - PAD, footerY + FOOTER_H/2);

  return canvas;
}

function downloadCSV() {
  const kelas = document.getElementById('nama-kelas').value||'Kelas';
  let csv = `Jadwal Kelas ${kelas}\n`;
  csv += 'Hari,Jam ke-,Kode,Mata Pelajaran,Guru\n';
  scheduleData.forEach(d => {
    let j=0; const dk=d.kodes;
    while(j<dk.length){
      const kode=dk[j]; let span=1;
      while(j+span<dk.length&&dk[j+span]===kode)span++;
      const info=kodeGuru[kode]||{mapel:kode,nama:''};
      const jam=span>1?`${j+1}-${j+span}`:`${j+1}`;
      csv+=`"${d.hari}","${jam}","${kode}","${info.mapel}","${info.nama}"\n`;
      j+=span;
    }
  });
  const blob=new Blob([csv],{type:'text/csv;charset=utf-8;'});
  const a=document.createElement('a'); a.href=URL.createObjectURL(blob);
  a.download=`Jadwal-${kelas}.csv`; a.click();
  showToast('📊 CSV berhasil diunduh!');
}

function showInputSection() {
  document.getElementById('output-section').style.display='none';
  document.getElementById('step1-card').scrollIntoView({behavior:'smooth'});
}

function clearForm() {
  document.getElementById('kodes').value='';
  document.getElementById('counter-row').style.display='none';
}

function loadContoh() {
  document.getElementById('nama-kelas').value = 'VII E';
  document.getElementById('nama-sekolah').value = 'SMP Negeri 1 Semarang';
  document.getElementById('semester').value = 'Semester 1 Tahun Pelajaran 2022/2023';
  document.getElementById('tgl-mulai').value = 'Mulai 18 Juli 2022';
  document.getElementById('jam-per-hari').value = 10;
  buildJamConfig();
  document.getElementById('kodes').value =
    'Upcr D4 D4 T3 T3 G1 G1 J1 J1 H1 ' +
    'GLS GLS G2 G2 BK Y1 Y1 IF1 IF1 IF1 ' +
    'GLS GLS J2 J2 J2 C2 C2 C2 A1 A1 ' +
    'D4 D4 D4 T3 S1 S1 T3 T3 G1 G1 ' +
    'Krida Krida Krida W1 W1 W1 R1 R1 R1';
  document.getElementById('kodes').dispatchEvent(new Event('input'));
  showToast('📋 Contoh data VII E dimuat!');
}

// ── Toast ──
let toastTimer;
function showToast(msg) {
  const t = document.getElementById('toast');
  t.textContent = msg; t.classList.add('show');
  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => t.classList.remove('show'), 2800);
}
</script>
</body>
</html>