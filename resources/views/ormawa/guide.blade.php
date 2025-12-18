<!-- resources/views/ormawa/guide.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panduan Penggunaan Sistem
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Hero Section -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg shadow-lg p-8 mb-6 text-white">
                <h1 class="text-3xl font-bold mb-2">Selamat Datang di Sistem Monitoring ORMAWA! 👋</h1>
                <p class="text-lg text-blue-100">
                    Panduan lengkap untuk membantu Anda mengelola kegiatan organisasi dengan mudah dan efektif.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                
                <!-- Sidebar Navigation -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-6">
                        <div class="p-6">
                            <h3 class="font-semibold mb-4">Daftar Isi</h3>
                            <nav class="space-y-2">
                                <a href="#pendahuluan" class="block text-sm text-gray-700 hover:text-blue-600 hover:bg-blue-50 px-3 py-2 rounded">
                                    Pendahuluan
                                </a>
                                <a href="#proposal" class="block text-sm text-gray-700 hover:text-blue-600 hover:bg-blue-50 px-3 py-2 rounded">
                                    Mengajukan Proposal
                                </a>
                                <a href="#monitoring" class="block text-sm text-gray-700 hover:text-blue-600 hover:bg-blue-50 px-3 py-2 rounded">
                                    Monitoring Kegiatan
                                </a>
                                <a href="#lpj" class="block text-sm text-gray-700 hover:text-blue-600 hover:bg-blue-50 px-3 py-2 rounded">
                                    Membuat LPJ
                                </a>
                                <a href="#tips" class="block text-sm text-gray-700 hover:text-blue-600 hover:bg-blue-50 px-3 py-2 rounded">
                                    Tips & Trik
                                </a>
                                <a href="#faq" class="block text-sm text-gray-700 hover:text-blue-600 hover:bg-blue-50 px-3 py-2 rounded">
                                    FAQ
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-3 space-y-6">
                    
                    <!-- Pendahuluan -->
                    <div id="pendahuluan" class="bg-white overflow-hidden shadow-sm sm:rounded-lg scroll-mt-6">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold mb-4 text-gray-900">Pendahuluan</h2>
                            <div class="prose max-w-none">
                                <p class="text-gray-700 mb-4">
                                    Sistem Monitoring ORMAWA adalah platform digital yang dirancang khusus untuk memudahkan organisasi mahasiswa 
                                    dalam mengelola kegiatan dari tahap perencanaan hingga pelaporan.
                                </p>
                                
                                <h3 class="text-lg font-semibold mt-6 mb-3">Fitur Utama:</h3>
                                <ul class="list-disc list-inside space-y-2 text-gray-700">
                                    <li>Pengajuan proposal kegiatan secara online</li>
                                    <li>Monitoring progress kegiatan real-time</li>
                                    <li>Upload dokumentasi kegiatan</li>
                                    <li>Pembuatan LPJ digital</li>
                                    <li>Arsip kegiatan berdasarkan periode</li>
                                </ul>

                                <div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded">
                                    <p class="text-sm text-blue-900">
                                        <strong>💡 Tips:</strong> Pastikan Anda sudah login menggunakan akun organisasi Anda untuk mengakses semua fitur.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mengajukan Proposal -->
                    <div id="proposal" class="bg-white overflow-hidden shadow-sm sm:rounded-lg scroll-mt-6">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold mb-4 text-gray-900">Mengajukan Proposal Kegiatan</h2>
                            
                            <div class="space-y-4">
                                <div class="border-l-4 border-blue-500 pl-4">
                                    <h3 class="font-semibold text-lg mb-2">Langkah 1: Akses Menu Proposal</h3>
                                    <p class="text-gray-700">
                                        Klik menu <strong>"Proposal Kegiatan"</strong> di sidebar, kemudian pilih tombol 
                                        <strong class="text-blue-600">"+ Ajukan Proposal Baru"</strong>.
                                    </p>
                                </div>

                                <div class="border-l-4 border-blue-500 pl-4">
                                    <h3 class="font-semibold text-lg mb-2">Langkah 2: Isi Form Proposal</h3>
                                    <p class="text-gray-700 mb-2">Lengkapi form dengan informasi berikut:</p>
                                    <ul class="list-disc list-inside space-y-1 text-gray-700 ml-4">
                                        <li><strong>Nama Kegiatan:</strong> Tuliskan nama kegiatan yang jelas dan spesifik</li>
                                        <li><strong>Deskripsi:</strong> Jelaskan tujuan dan rencana kegiatan</li>
                                        <li><strong>Tanggal:</strong> Pilih tanggal mulai dan selesai kegiatan</li>
                                        <li><strong>Tempat:</strong> Lokasi pelaksanaan kegiatan</li>
                                        <li><strong>Anggaran:</strong> Masukkan total anggaran yang dibutuhkan</li>
                                        <li><strong>File Proposal:</strong> Upload file PDF (maks 5MB)</li>
                                    </ul>
                                </div>

                                <div class="border-l-4 border-blue-500 pl-4">
                                    <h3 class="font-semibold text-lg mb-2">Langkah 3: Submit Proposal</h3>
                                    <p class="text-gray-700">
                                        Klik tombol <strong class="text-blue-600">"Ajukan Proposal"</strong>. Sistem akan otomatis 
                                        menggenerate kode proposal dan mengirimkan ke BEM untuk review.
                                    </p>
                                </div>

                                <div class="mt-4 p-4 bg-yellow-50 border-l-4 border-yellow-500 rounded">
                                    <p class="text-sm text-yellow-900">
                                        <strong>⚠️ Penting:</strong> Pastikan semua data sudah benar sebelum submit. 
                                        Proposal yang sudah diajukan tidak dapat diedit.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Monitoring Kegiatan -->
                    <div id="monitoring" class="bg-white overflow-hidden shadow-sm sm:rounded-lg scroll-mt-6">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold mb-4 text-gray-900">Monitoring Kegiatan</h2>
                            
                            <div class="space-y-4">
                                <p class="text-gray-700">
                                    Setelah proposal disetujui, Anda dapat melakukan monitoring melalui menu 
                                    <strong>"Monitoring Kegiatan"</strong>.
                                </p>

                                <h3 class="font-semibold text-lg mt-6">Update Status Kegiatan</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                                    <div class="border border-blue-200 rounded-lg p-4">
                                        <div class="flex items-center mb-2">
                                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">
                                                Dijadwalkan
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-600">Kegiatan telah disetujui dan menunggu pelaksanaan</p>
                                    </div>
                                    <div class="border border-yellow-200 rounded-lg p-4">
                                        <div class="flex items-center mb-2">
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">
                                                Sedang Berlangsung
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-600">Kegiatan sedang dalam tahap pelaksanaan</p>
                                    </div>
                                    <div class="border border-green-200 rounded-lg p-4">
                                        <div class="flex items-center mb-2">
                                            <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                                Selesai
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-600">Kegiatan telah selesai dilaksanakan</p>
                                    </div>
                                    <div class="border border-red-200 rounded-lg p-4">
                                        <div class="flex items-center mb-2">
                                            <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">
                                                Dibatalkan
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-600">Kegiatan dibatalkan karena alasan tertentu</p>
                                    </div>
                                </div>

                                <h3 class="font-semibold text-lg mt-6">Upload Dokumentasi</h3>
                                <p class="text-gray-700">
                                    Dokumentasikan kegiatan Anda dengan mengupload foto-foto atau dokumen pendukung. 
                                    Format yang didukung: JPG, PNG, PDF (maks 5MB per file).
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Membuat LPJ -->
                    <div id="lpj" class="bg-white overflow-hidden shadow-sm sm:rounded-lg scroll-mt-6">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold mb-4 text-gray-900">Membuat Laporan Pertanggungjawaban (LPJ)</h2>
                            
                            <div class="space-y-4">
                                <p class="text-gray-700">
                                    LPJ wajib dibuat setelah kegiatan selesai dilaksanakan. Akses melalui detail kegiatan 
                                    dan klik tombol <strong class="text-blue-600">"Buat LPJ"</strong>.
                                </p>

                                <h3 class="font-semibold text-lg mt-6">Komponen LPJ:</h3>
                                <div class="space-y-3">
                                    <div class="flex items-start">
                                        <span class="flex-shrink-0 w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-semibold mr-3">
                                            1
                                        </span>
                                        <div>
                                            <h4 class="font-semibold">Laporan Kegiatan</h4>
                                            <p class="text-sm text-gray-600">Narasi lengkap pelaksanaan kegiatan</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <span class="flex-shrink-0 w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-semibold mr-3">
                                            2
                                        </span>
                                        <div>
                                            <h4 class="font-semibold">Realisasi Anggaran</h4>
                                            <p class="text-sm text-gray-600">Total pengeluaran aktual kegiatan</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <span class="flex-shrink-0 w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-semibold mr-3">
                                            3
                                        </span>
                                        <div>
                                            <h4 class="font-semibold">Kendala & Solusi</h4>
                                            <p class="text-sm text-gray-600">Hambatan yang dihadapi dan cara mengatasinya</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <span class="flex-shrink-0 w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-semibold mr-3">
                                            4
                                        </span>
                                        <div>
                                            <h4 class="font-semibold">File LPJ Lengkap</h4>
                                            <p class="text-sm text-gray-600">Upload file PDF dengan lampiran lengkap</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 p-4 bg-green-50 border-l-4 border-green-500 rounded">
                                    <p class="text-sm text-green-900">
                                        <strong>✓ Checklist LPJ:</strong> Pastikan LPJ Anda sudah lengkap dengan halaman pengesahan, 
                                        rincian anggaran, dan dokumentasi foto kegiatan.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tips & Trik -->
                    <div id="tips" class="bg-white overflow-hidden shadow-sm sm:rounded-lg scroll-mt-6">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold mb-4 text-gray-900">Tips & Trik</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-500 transition-colors">
                                    <h3 class="font-semibold mb-2 text-blue-600">📝 Proposal</h3>
                                    <ul class="text-sm text-gray-700 space-y-1">
                                        <li>• Buat proposal minimal H-14 sebelum kegiatan</li>
                                        <li>• Gunakan format PDF untuk file proposal</li>
                                        <li>• Pastikan anggaran realistis dan terperinci</li>
                                    </ul>
                                </div>

                                <div class="border border-gray-200 rounded-lg p-4 hover:border-green-500 transition-colors">
                                    <h3 class="font-semibold mb-2 text-green-600">📸 Dokumentasi</h3>
                                    <ul class="text-sm text-gray-700 space-y-1">
                                        <li>• Upload foto dokumentasi saat kegiatan berlangsung</li>
                                        <li>• Beri keterangan pada setiap foto</li>
                                        <li>• Simpan foto dengan resolusi yang baik</li>
                                    </ul>
                                </div>

                                <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-500 transition-colors">
                                    <h3 class="font-semibold mb-2 text-purple-600">📊 LPJ</h3>
                                    <ul class="text-sm text-gray-700 space-y-1">
                                        <li>• Buat LPJ maksimal H+7 setelah kegiatan</li>
                                        <li>• Lampirkan bukti pengeluaran yang lengkap</li>
                                        <li>• Dokumentasikan kendala untuk evaluasi</li>
                                    </ul>
                                </div>

                                <div class="border border-gray-200 rounded-lg p-4 hover:border-yellow-500 transition-colors">
                                    <h3 class="font-semibold mb-2 text-yellow-600">💾 Arsip</h3>
                                    <ul class="text-sm text-gray-700 space-y-1">
                                        <li>• Backup semua file penting di komputer Anda</li>
                                        <li>• Simpan soft copy proposal dan LPJ</li>
                                        <li>• Dokumentasikan serah terima kepengurusan</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ -->
                    <div id="faq" class="bg-white overflow-hidden shadow-sm sm:rounded-lg scroll-mt-6">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold mb-4 text-gray-900">Frequently Asked Questions (FAQ)</h2>
                            
                            <div class="space-y-4">
                                <details class="group border border-gray-200 rounded-lg">
                                    <summary class="flex justify-between items-center cursor-pointer p-4 hover:bg-gray-50">
                                        <span class="font-semibold">Bagaimana jika proposal ditolak?</span>
                                        <svg class="w-5 h-5 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </summary>
                                    <div class="px-4 pb-4 text-gray-700">
                                        Anda akan menerima catatan dari BEM/Admin. Perbaiki proposal sesuai masukan dan ajukan kembali.
                                    </div>
                                </details>

                                <details class="group border border-gray-200 rounded-lg">
                                    <summary class="flex justify-between items-center cursor-pointer p-4 hover:bg-gray-50">
                                        <span class="font-semibold">Apakah bisa edit proposal yang sudah diajukan?</span>
                                        <svg class="w-5 h-5 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </summary>
                                    <div class="px-4 pb-4 text-gray-700">
                                        Proposal yang sudah diajukan tidak dapat diedit. Jika ada kesalahan, hubungi admin untuk bantuan.
                                    </div>
                                </details>

                                <details class="group border border-gray-200 rounded-lg">
                                    <summary class="flex justify-between items-center cursor-pointer p-4 hover:bg-gray-50">
                                        <span class="font-semibold">Berapa lama proses approval proposal?</span>
                                        <svg class="w-5 h-5 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </summary>
                                    <div class="px-4 pb-4 text-gray-700">
                                        Proses approval biasanya memakan waktu 3-7 hari kerja. Pastikan mengajukan proposal jauh-jauh hari sebelum kegiatan.
                                    </div>
                                </details>

                                <details class="group border border-gray-200 rounded-lg">
                                    <summary class="flex justify-between items-center cursor-pointer p-4 hover:bg-gray-50">
                                        <span class="font-semibold">Apa yang terjadi jika LPJ terlambat?</span>
                                        <svg class="w-5 h-5 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </summary>
                                    <div class="px-4 pb-4 text-gray-700">
                                        LPJ yang terlambat dapat mempengaruhi pengajuan proposal berikutnya. Usahakan submit LPJ maksimal H+7 setelah kegiatan.
                                    </div>
                                </details>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Support -->
                    <div class="bg-gradient-to-r from-blue-50 to-purple-50 border border-blue-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-2">Butuh Bantuan Lebih Lanjut?</h3>
                        <p class="text-gray-700 mb-4">
                            Jika Anda masih memiliki pertanyaan atau mengalami kendala, jangan ragu untuk menghubungi admin.
                        </p>
                        <button class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                            Hubungi Admin
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>