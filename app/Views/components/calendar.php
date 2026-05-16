<?php
/**
 * Custom Calendar Component — shadcn-inspired
 *
 * Variabel yang dibutuhkan sebelum include:
 *   $calendarId       — string unik untuk ID (misal: 'create-booking')
 *   $calendarInitDate — nilai awal format Y-m-d (boleh kosong)
 *   $calendarMinDate  — batas tanggal minimum format Y-m-d (boleh kosong)
 *
 * Output:
 *   <input type="hidden" name="date" value="Y-m-d"> — siap dikirim ke form
 */

$calId      = $calendarId      ?? 'cal-' . uniqid();
$initDate   = $calendarInitDate ?? '';
$minDateStr = $calendarMinDate  ?? '';
?>

<style>
/* ── Calendar Styles ── */
#cal-popover-<?= $calId ?> {
    transform-origin: top left;
    transition: opacity 160ms cubic-bezier(0.16,1,0.3,1),
                transform 160ms cubic-bezier(0.16,1,0.3,1),
                visibility 0ms;
}
#cal-popover-<?= $calId ?>.cal-hidden {
    opacity: 0;
    transform: scale(0.96) translateY(-4px);
    visibility: hidden;
    pointer-events: none;
    transition: opacity 120ms ease,
                transform 120ms ease,
                visibility 0ms 120ms;
}
.cal-day-<?= $calId ?> {
    width: 34px; height: 34px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 400;
    cursor: pointer;
    transition: background 120ms, color 120ms;
    border: 1px solid transparent;
    position: relative;
}
.cal-day-<?= $calId ?>:hover:not(.cal-disabled-<?= $calId ?>):not(.cal-selected-<?= $calId ?>) {
    background: #f4f4f5;
    color: #09090b;
}
.cal-day-<?= $calId ?>.cal-today-<?= $calId ?>:not(.cal-selected-<?= $calId ?>) {
    border-color: #e4e4e7;
    font-weight: 500;
    color: #09090b;
}
.cal-day-<?= $calId ?>.cal-selected-<?= $calId ?> {
    background: #09090b;
    color: #fff;
    font-weight: 500;
}
.cal-day-<?= $calId ?>.cal-disabled-<?= $calId ?> {
    color: #d4d4d8;
    cursor: not-allowed;
}
.cal-day-<?= $calId ?>.cal-other-month-<?= $calId ?> {
    color: #a1a1aa;
}
.cal-nav-btn-<?= $calId ?> {
    width: 28px; height: 28px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 6px;
    cursor: pointer;
    border: 1px solid #e4e4e7;
    background: #fff;
    color: #3f3f46;
    transition: background 120ms, border-color 120ms;
}
.cal-nav-btn-<?= $calId ?>:hover {
    background: #f4f4f5;
    border-color: #d4d4d8;
}
</style>

<!-- Root: hanya sebagai anchor, tidak perlu position:relative -->
<div id="cal-root-<?= $calId ?>">

    <!-- Trigger Button -->
    <button type="button"
        id="cal-trigger-<?= $calId ?>"
        class="w-full h-9 flex items-center gap-2.5 px-3 rounded-lg text-sm border border-zinc-200 bg-white text-zinc-950 hover:border-zinc-300 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-600/10 transition-all"
        aria-haspopup="dialog"
        aria-expanded="false">
        <svg class="w-4 h-4 text-zinc-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
            <line x1="16" y1="2" x2="16" y2="6"/>
            <line x1="8" y1="2" x2="8" y2="6"/>
            <line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
        <span id="cal-label-<?= $calId ?>" class="flex-1 text-left text-zinc-400">Pilih tanggal</span>
    </button>

    <!-- Hidden input -->
    <input type="hidden" name="date" id="cal-value-<?= $calId ?>" value="<?= htmlspecialchars($initDate) ?>" required>
</div>

<!--
    Popover diletakkan di sini tapi akan di-teleport ke <body> oleh JS.
    Gunakan style inline agar tidak bergantung pada Tailwind saat di luar context.
-->
<div id="cal-popover-<?= $calId ?>"
    class="cal-hidden"
    style="position:fixed; z-index:9999; width:280px; border-radius:12px;
           border:1px solid #e4e4e7; background:#fff;
           box-shadow:0 10px 38px -10px rgba(0,0,0,0.18), 0 4px 16px -4px rgba(0,0,0,0.08);
           padding:12px; top:0; left:0;"
    role="dialog" aria-modal="true" aria-label="Pilih tanggal">

    <!-- Header -->
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
        <button type="button" id="cal-prev-<?= $calId ?>" class="cal-nav-btn-<?= $calId ?>" aria-label="Bulan sebelumnya">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
        </button>
        <button type="button" id="cal-month-label-<?= $calId ?>"
            style="font-size:14px; font-weight:600; color:#18181b; padding:2px 8px; border-radius:6px; border:none; background:transparent; cursor:pointer;">
            &nbsp;
        </button>
        <button type="button" id="cal-next-<?= $calId ?>" class="cal-nav-btn-<?= $calId ?>" aria-label="Bulan berikutnya">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"/>
            </svg>
        </button>
    </div>

    <!-- Day-of-week header -->
    <div style="display:grid; grid-template-columns:repeat(7,1fr); margin-bottom:4px;">
        <?php foreach (['Min','Sen','Sel','Rab','Kam','Jum','Sab'] as $d): ?>
            <div style="display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:500; color:#a1a1aa; height:28px;"><?= $d ?></div>
        <?php endforeach; ?>
    </div>

    <!-- Day grid -->
    <div id="cal-grid-<?= $calId ?>" style="display:grid; grid-template-columns:repeat(7,1fr); gap:2px 0;"></div>

    <!-- Footer -->
    <div style="margin-top:10px; padding-top:10px; border-top:1px solid #f4f4f5; display:flex; justify-content:center;">
        <button type="button" id="cal-today-btn-<?= $calId ?>"
            style="font-size:12px; font-weight:500; color:#71717a; padding:4px 12px; border-radius:6px; border:none; background:transparent; cursor:pointer;">
            Hari Ini
        </button>
    </div>
</div>

<script>
(function() {
    const ID        = <?= json_encode($calId) ?>;
    const MIN_DATE  = <?= json_encode($minDateStr) ?>;
    const INIT_VAL  = <?= json_encode($initDate) ?>;

    const MONTHS_ID = ['Januari','Februari','Maret','April','Mei','Juni',
                       'Juli','Agustus','September','Oktober','November','Desember'];

    const today    = new Date(); today.setHours(0,0,0,0);
    const minDate  = MIN_DATE ? parseYMD(MIN_DATE) : null;
    let viewYear   = today.getFullYear();
    let viewMonth  = today.getMonth();
    let selected   = INIT_VAL ? parseYMD(INIT_VAL) : null;

    const root     = document.getElementById('cal-root-'        + ID);
    const trigger  = document.getElementById('cal-trigger-'     + ID);
    const popover  = document.getElementById('cal-popover-'     + ID);
    const label    = document.getElementById('cal-label-'       + ID);
    const hidden   = document.getElementById('cal-value-'       + ID);
    const grid     = document.getElementById('cal-grid-'        + ID);
    const monthLbl = document.getElementById('cal-month-label-' + ID);
    const prevBtn  = document.getElementById('cal-prev-'        + ID);
    const nextBtn  = document.getElementById('cal-next-'        + ID);
    const todayBtn = document.getElementById('cal-today-btn-'   + ID);

    /* ── Teleport ke <body> supaya bebas dari overflow:hidden ── */
    document.body.appendChild(popover);

    /* ── Helpers ── */
    function parseYMD(s) {
        const p = s.split('-');
        const d = new Date(+p[0], +p[1]-1, +p[2]);
        d.setHours(0,0,0,0);
        return d;
    }
    function fmtYMD(d) {
        return d.getFullYear() + '-' +
               String(d.getMonth()+1).padStart(2,'0') + '-' +
               String(d.getDate()).padStart(2,'0');
    }
    function fmtDisplay(d) {
        return d.getDate() + ' ' + MONTHS_ID[d.getMonth()] + ' ' + d.getFullYear();
    }
    function sameDay(a, b) {
        return a && b &&
               a.getFullYear() === b.getFullYear() &&
               a.getMonth()    === b.getMonth()    &&
               a.getDate()     === b.getDate();
    }
    function isDisabled(d) {
        return minDate ? d < minDate : false;
    }

    /* ── Posisikan popover tepat di bawah trigger ── */
    function positionPopover() {
        const POPOVER_W = 280;
        const POPOVER_H = 340;
        const GAP       = 6;
        const MARGIN    = 8; // jarak minimal dari tepi layar

        /* getBoundingClientRect sudah dalam koordinat viewport (cocok untuk position:fixed) */
        const r = trigger.getBoundingClientRect();

        /* Vertikal */
        let top;
        const spaceBelow = window.innerHeight - r.bottom - MARGIN;
        if (spaceBelow >= POPOVER_H) {
            top = r.bottom + GAP;          // tampil ke bawah
        } else {
            top = r.top - POPOVER_H - GAP; // tampil ke atas
            if (top < MARGIN) top = MARGIN;
        }

        /* Horizontal: rata-kiri dengan trigger, pastikan tidak keluar layar */
        let left = r.left;
        if (left + POPOVER_W > window.innerWidth - MARGIN) {
            left = window.innerWidth - POPOVER_W - MARGIN;
        }
        if (left < MARGIN) left = MARGIN;

        popover.style.top  = top  + 'px';
        popover.style.left = left + 'px';
    }

    /* ── Render Grid ── */
    function renderGrid() {
        monthLbl.textContent = MONTHS_ID[viewMonth] + ' ' + viewYear;
        grid.innerHTML = '';

        const firstDay    = new Date(viewYear, viewMonth, 1).getDay();
        const daysInMonth = new Date(viewYear, viewMonth + 1, 0).getDate();
        const daysInPrev  = new Date(viewYear, viewMonth, 0).getDate();
        const cells = [];

        for (let i = firstDay - 1; i >= 0; i--) {
            cells.push({ date: new Date(viewYear, viewMonth - 1, daysInPrev - i), otherMonth: true });
        }
        for (let i = 1; i <= daysInMonth; i++) {
            cells.push({ date: new Date(viewYear, viewMonth, i), otherMonth: false });
        }
        let next = 1;
        while (cells.length < 42) {
            cells.push({ date: new Date(viewYear, viewMonth + 1, next++), otherMonth: true });
        }
        if (cells.length === 42 && cells.slice(35).every(c => c.otherMonth)) {
            cells.splice(35);
        }

        cells.forEach(({ date, otherMonth }) => {
            const btn = document.createElement('button');
            btn.type  = 'button';
            const cls = ['cal-day-' + ID];
            if (otherMonth)                       cls.push('cal-other-month-' + ID);
            if (sameDay(date, today) && !otherMonth) cls.push('cal-today-'   + ID);
            if (sameDay(date, selected))           cls.push('cal-selected-'   + ID);

            const disabled = isDisabled(date);
            if (disabled) { cls.push('cal-disabled-' + ID); btn.disabled = true; }

            btn.className   = cls.join(' ');
            btn.textContent = date.getDate();
            btn.setAttribute('aria-label', fmtDisplay(date));

            if (!disabled) btn.addEventListener('click', () => selectDate(date));
            grid.appendChild(btn);
        });
    }

    /* ── Select date ── */
    function selectDate(d) {
        selected          = d;
        hidden.value      = fmtYMD(d);
        label.textContent = fmtDisplay(d);
        label.classList.remove('text-zinc-400');
        label.classList.add('text-zinc-950');
        renderGrid();
        closePopover();
        hidden.dispatchEvent(new Event('change', { bubbles: true }));
    }

    /* ── Open / Close ── */
    let isOpen = false;

    function openPopover() {
        if (selected) { viewYear = selected.getFullYear(); viewMonth = selected.getMonth(); }
        renderGrid();
        positionPopover();   // hitung koordinat sebelum tampil
        popover.classList.remove('cal-hidden');
        trigger.setAttribute('aria-expanded', 'true');
        isOpen = true;
        setTimeout(() => prevBtn.focus(), 50);
    }

    function closePopover() {
        popover.classList.add('cal-hidden');
        trigger.setAttribute('aria-expanded', 'false');
        isOpen = false;
        trigger.focus();
    }

    /* ── Nav ── */
    function prevMonth() {
        if (--viewMonth < 0) { viewMonth = 11; viewYear--; }
        renderGrid();
    }
    function nextMonth() {
        if (++viewMonth > 11) { viewMonth = 0; viewYear++; }
        renderGrid();
    }

    /* ── Event listeners ── */
    trigger.addEventListener('click',  e => { e.stopPropagation(); isOpen ? closePopover() : openPopover(); });
    prevBtn.addEventListener('click',  e => { e.stopPropagation(); prevMonth(); });
    nextBtn.addEventListener('click',  e => { e.stopPropagation(); nextMonth(); });
    todayBtn.addEventListener('click', e => {
        e.stopPropagation();
        if (!isDisabled(today)) selectDate(today);
        else { viewYear = today.getFullYear(); viewMonth = today.getMonth(); renderGrid(); }
    });

    /* Tutup saat klik di luar */
    document.addEventListener('click', e => {
        if (isOpen && !root.contains(e.target) && !popover.contains(e.target)) {
            closePopover();
        }
    });

    /* Re-posisi saat scroll/resize (capture phase agar dapat semua scroll) */
    window.addEventListener('scroll', () => { if (isOpen) positionPopover(); }, true);
    window.addEventListener('resize', () => { if (isOpen) positionPopover(); });

    /* Keyboard */
    popover.addEventListener('keydown', e => {
        if (e.key === 'Escape') { e.preventDefault(); closePopover(); }
    });

    /* ── Init ── */
    if (selected) {
        label.textContent = fmtDisplay(selected);
        label.classList.remove('text-zinc-400');
        label.classList.add('text-zinc-950');
        viewYear  = selected.getFullYear();
        viewMonth = selected.getMonth();
    }
    renderGrid();

})();
</script>