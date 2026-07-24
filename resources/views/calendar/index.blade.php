<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Kalender Akademik / Kegiatan Ormawa
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"
                x-data="calendarApp({{ $events->toJson() }})"
                x-init="init()">

                <!-- Header Kontrol Kalender -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <button @click="prevMonth()" type="button"
                                class="p-2 rounded-md border border-gray-300 text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <h3 class="text-lg font-semibold text-gray-800 w-48 text-center" x-text="monthLabel"></h3>
                            <button @click="nextMonth()" type="button"
                                class="p-2 rounded-md border border-gray-300 text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                            <button @click="goToday()" type="button"
                                class="ml-2 px-3 py-1.5 text-xs font-semibold rounded-md border border-blue-200 bg-blue-50 text-blue-700 hover:bg-blue-100 transition">
                                Hari Ini
                            </button>
                        </div>

                        <!-- Legenda Indikator Warna -->
                        <div class="flex items-center gap-4 text-xs text-gray-600">
                            <div class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-green-500 inline-block"></span>
                                Kegiatan Terjadwal / Berjalan / Selesai
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-red-500 inline-block"></span>
                                Kegiatan Dibatalkan
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grid Kalender -->
                <div class="p-4 sm:p-6">
                    <div class="grid grid-cols-7 gap-px bg-gray-200 border border-gray-200 rounded-t-md overflow-hidden text-center">
                        <template x-for="day in ['Min','Sen','Sel','Rab','Kam','Jum','Sab']" :key="day">
                            <div class="bg-gray-50 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider" x-text="day"></div>
                        </template>
                    </div>

                    <div class="grid grid-cols-7 gap-px bg-gray-200 border border-t-0 border-gray-200 rounded-b-md overflow-hidden">
                        <template x-for="(cell, idx) in calendarCells" :key="idx">
                            <div class="relative bg-white min-h-[92px] sm:min-h-[110px] p-2 flex flex-col cursor-pointer hover:bg-gray-50 transition"
                                :class="{
                                    'bg-gray-50 text-gray-300': !cell.currentMonth,
                                    'ring-2 ring-inset ring-blue-500': cell.isToday,
                                    'bg-blue-50': selectedDate === cell.dateStr && cell.currentMonth
                                }"
                                @click="selectDate(cell)">

                                <span class="text-sm font-medium" :class="cell.isToday ? 'text-blue-600 font-bold' : ''" x-text="cell.day"></span>

                                <!-- Indikator Warna Tanggal Kegiatan -->
                                <div class="mt-1 flex flex-wrap gap-1">
                                    <template x-for="dot in cell.dots" :key="dot.id">
                                        <span class="w-2 h-2 rounded-full"
                                              :class="dot.color === 'red' ? 'bg-red-500' : 'bg-green-500'"
                                              :title="dot.title"></span>
                                    </template>
                                </div>

                                <div class="mt-auto space-y-0.5 hidden sm:block">
                                    <template x-for="ev in cell.events.slice(0,2)" :key="ev.id">
                                        <div class="truncate text-[10px] px-1 py-0.5 rounded"
                                             :class="ev.color === 'red' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'"
                                             x-text="ev.title"></div>
                                    </template>
                                    <div class="text-[10px] text-gray-400" x-show="cell.events.length > 2" x-text="'+' + (cell.events.length - 2) + ' lainnya'"></div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Detail Agenda Tanggal Terpilih -->
                <div class="border-t border-gray-200 p-6" x-show="selectedDate">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">
                        Agenda Tanggal <span x-text="selectedDateLabel"></span>
                    </h4>

                    <div x-show="selectedEvents.length === 0" class="text-sm text-gray-400">
                        Tidak ada agenda kegiatan pada tanggal ini.
                    </div>

                    <ul class="space-y-2">
                        <template x-for="ev in selectedEvents" :key="ev.id">
                            <li class="flex items-center justify-between gap-3 p-3 rounded-lg border border-gray-200 hover:border-blue-300 transition">
                                <div class="flex items-center gap-3 min-w-0">
                                    <span class="w-2.5 h-2.5 rounded-full flex-shrink-0"
                                          :class="ev.color === 'red' ? 'bg-red-500' : 'bg-green-500'"></span>
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate" x-text="ev.title"></p>
                                        <p class="text-xs text-gray-500" x-text="(ev.ormawa || '-') + ' · ' + ev.status_label"></p>
                                    </div>
                                </div>
                                <a :href="ev.url" class="text-xs font-semibold text-blue-600 hover:text-blue-800 flex-shrink-0">
                                    Detail &rarr;
                                </a>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    function calendarApp(events) {
        return {
            events: events || [],
            current: new Date(),
            selectedDate: null,
            selectedEvents: [],
            calendarCells: [],
            monthLabel: '',
            selectedDateLabel: '',

            init() {
                this.current.setDate(1);
                this.build();
            },

            pad(n) { return n < 10 ? '0' + n : '' + n; },

            toDateStr(y, m, d) {
                return `${y}-${this.pad(m + 1)}-${this.pad(d)}`;
            },

            eventsForDate(dateStr) {
                return this.events.filter(ev => dateStr >= ev.start && dateStr <= ev.end);
            },

            build() {
                const year = this.current.getFullYear();
                const month = this.current.getMonth();
                const monthNames = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                this.monthLabel = monthNames[month] + ' ' + year;

                const firstDay = new Date(year, month, 1);
                const startOffset = firstDay.getDay(); // 0 = Minggu
                const daysInMonth = new Date(year, month + 1, 0).getDate();
                const daysInPrevMonth = new Date(year, month, 0).getDate();

                const todayStr = this.toDateStr(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());

                const cells = [];

                // Tanggal dari bulan sebelumnya (pengisi)
                for (let i = startOffset - 1; i >= 0; i--) {
                    const day = daysInPrevMonth - i;
                    const prevMonth = month === 0 ? 11 : month - 1;
                    const prevYear = month === 0 ? year - 1 : year;
                    const dateStr = this.toDateStr(prevYear, prevMonth, day);
                    cells.push(this.buildCell(day, dateStr, false, todayStr));
                }

                // Tanggal bulan berjalan
                for (let day = 1; day <= daysInMonth; day++) {
                    const dateStr = this.toDateStr(year, month, day);
                    cells.push(this.buildCell(day, dateStr, true, todayStr));
                }

                // Pengisi agar total sel kelipatan 7
                let nextDay = 1;
                while (cells.length % 7 !== 0) {
                    const nextMonth = month === 11 ? 0 : month + 1;
                    const nextYear = month === 11 ? year + 1 : year;
                    const dateStr = this.toDateStr(nextYear, nextMonth, nextDay);
                    cells.push(this.buildCell(nextDay, dateStr, false, todayStr));
                    nextDay++;
                }

                this.calendarCells = cells;
            },

            buildCell(day, dateStr, currentMonth, todayStr) {
                const dayEvents = this.eventsForDate(dateStr);
                return {
                    day, dateStr, currentMonth,
                    isToday: dateStr === todayStr,
                    events: dayEvents,
                    dots: dayEvents.map(e => ({ id: e.id, color: e.color, title: e.title })),
                };
            },

            prevMonth() {
                this.current.setMonth(this.current.getMonth() - 1);
                this.build();
            },
            nextMonth() {
                this.current.setMonth(this.current.getMonth() + 1);
                this.build();
            },
            goToday() {
                this.current = new Date();
                this.current.setDate(1);
                this.build();
            },
            selectDate(cell) {
                this.selectedDate = cell.dateStr;
                this.selectedEvents = cell.events;
                const [y, m, d] = cell.dateStr.split('-');
                this.selectedDateLabel = `${d}/${m}/${y}`;
            }
        }
    }
    </script>
    @endpush
</x-app-layout>
