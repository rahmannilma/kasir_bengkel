<!DOCTYPE html>
<html class="dark" lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasnati Motor Tasiu | Bengkel Mobil Modern Kalukku</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "surface-container-lowest": "#070e1d",
                        "surface-tint": "#bec7da",
                        "primary": "#bec7da",
                        "surface-container-high": "#232a3a",
                        "on-secondary-container": "#521300",
                        "surface-container-low": "#141b2b",
                        "on-secondary": "#5e1700",
                        "on-tertiary": "#233143",
                        "on-tertiary-container": "#7c8a9f",
                        "on-error": "#690005",
                        "error": "#ffb4ab",
                        "primary-fixed-dim": "#bec7da",
                        "on-surface": "#dce2f7",
                        "outline": "#8f9096",
                        "on-primary-fixed-variant": "#3e4757",
                        "surface-container": "#191f2f",
                        "outline-variant": "#45474b",
                        "inverse-primary": "#565f70",
                        "tertiary-fixed-dim": "#b9c8de",
                        "inverse-surface": "#dce2f7",
                        "secondary-fixed-dim": "#ffb59e",
                        "on-secondary-container": "#ff571a",
                        "on-surface": "#dce2f7",
                        "surface-container-highest": "#2e3545",
                        "secondary-container": "#ff571a",
                        "primary-container": "#192230",
                        "on-primary": "#283140",
                        "surface": "#0c1322",
                        "on-secondary-fixed": "#3a0b00",
                        "secondary": "#ffb59e",
                        "tertiary-container": "#142333",
                        "error-container": "#93000a",
                        "on-secondary-fixed-variant": "#852400",
                        "background": "#0c1322",
                        "surface-bright": "#323949",
                        "surface-variant": "#2e3545"
                    },
                    fontFamily: {
                        "headline": ["Space Grotesk"],
                        "body": ["Manrope"],
                        "label": ["Manrope"]
                    }
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .fill-0 {
            font-variation-settings: 'FILL' 0;
        }
        .fill-1 {
            font-variation-settings: 'FILL' 1;
        }
        .kinetic-gradient {
            background: linear-gradient(135deg, #ff571a 0%, #852400 100%);
        }
        .glass-header {
            backdrop-filter: blur(12px);
            background-color: rgba(12, 19, 34, 0.6);
        }
        body {
            background-color: #0c1322;
            color: #dce2f7;
            font-family: 'Manrope', sans-serif;
        }
        h1, h2, h3, h4, .brand-font {
            font-family: 'Space Grotesk', sans-serif;
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .glow-orange {
            box-shadow: 0 0 40px rgba(255, 87, 26, 0.3);
        }
    </style>
</head>
<body class="selection:bg-secondary-container selection:text-white">
    <!-- Top Navigation Bar -->
    <nav class="fixed top-0 w-full z-50 bg-slate-950/60 backdrop-blur-md shadow-2xl shadow-black/40 flex justify-between items-center px-6 lg:px-12 py-4 max-w-full mx-auto border-b border-slate-800/30">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg kinetic-gradient flex items-center justify-center">
                <span class="material-symbols-outlined text-white">settings</span>
            </div>
            <div>
                <div class="text-lg font-bold tracking-tight text-slate-200 uppercase">Hasnati Motor</div>
                <div class="text-xs text-orange-500 -mt-1 tracking-wider">Tasiu</div>
            </div>
        </div>
        <div class="hidden md:flex gap-8 items-center">
            <a class="font-bold uppercase tracking-wider text-orange-500 border-b-2 border-orange-600 pb-1 text-sm" href="#layanan">Layanan</a>
            <a class="font-bold uppercase tracking-wider text-slate-400 hover:text-slate-100 transition-colors text-sm" href="#tentang">Tentang</a>
            <a class="font-bold uppercase tracking-wider text-slate-400 hover:text-slate-100 transition-colors text-sm" href="#galeri">Galeri</a>
            <a class="font-bold uppercase tracking-wider text-slate-400 hover:text-slate-100 transition-colors text-sm" href="#testimoni">Testimoni</a>
            <a class="font-bold uppercase tracking-wider text-slate-400 hover:text-slate-100 transition-colors text-sm" href="#kontak">Kontak</a>
        </div>
        <div class="flex gap-3 items-center">
            <a href="https://wa.me/6281234567890" class="hidden sm:flex items-center gap-2 text-slate-400 hover:text-green-500 transition-colors font-bold uppercase text-xs tracking-wider">
                <span class="material-symbols-outlined">chat</span>
                WhatsApp
            </a>
            <a href="/login" class="flex items-center gap-2 border border-slate-600 text-slate-300 hover:border-orange-500 hover:text-orange-500 font-bold px-5 py-2 rounded-lg active:scale-95 transition-transform uppercase text-xs tracking-widest">
                <span class="material-symbols-outlined">login</span>
                Login
            </a>
            <button class="bg-secondary-container text-on-secondary-fixed kinetic-gradient font-bold px-5 py-2 rounded-lg active:scale-95 transition-transform uppercase text-xs tracking-widest">
                Book Now
            </button>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="relative h-screen min-h-[900px] flex items-center overflow-hidden pt-[10rem]">
        <div class="absolute inset-0 z-0">
            <img alt="Modern Car Workshop" class="w-full h-full object-cover opacity-65" src="/images/galeri/foto2.jpg">
            <div class="absolute inset-0 bg-gradient-to-r from-surface via-surface/80 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-surface/50 to-surface"></div>
        </div>
        
        <!-- Animated decorative elements -->
        <div class="absolute top-1/4 left-10 w-72 h-72 bg-orange-600/20 rounded-full filter blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 right-10 w-96 h-96 bg-orange-500/10 rounded-full filter blur-3xl animate-float" style="animation-delay: 2s;"></div>
        
        <div class="relative z-10 container mx-auto px-6 lg:px-16 grid grid-cols-1 lg:grid-cols-12 gap-8 pt-0 md:pt-0">
            <div class="lg:col-span-8">
                <div class="inline-block px-4 py-1 mb-6 border border-secondary-container/30 bg-secondary-container/10 rounded-full">
                    <span class="text-secondary font-bold text-xs uppercase tracking-[0.2em]">Authorized Technical Center</span>
                </div>
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-on-surface leading-tight tracking-tighter mb-6">
                    Bengkel Mobil Modern <span class="text-secondary-container">Terpercaya</span> di Kalukku
                </h1>
                <p class="text-lg md:text-xl text-slate-400 max-w-2xl mb-10 leading-relaxed">
                    Performa mesin maksimal dengan teknologi diagnosa terkini dan mekanik bersertifikat. Solusi otomotif presisi untuk keamanan berkendara Anda.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="#kontak" class="kinetic-gradient text-on-secondary-fixed font-black px-8 py-4 rounded-lg text-base uppercase tracking-wider hover:brightness-110 active:scale-95 transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined">event</span>
                        Booking Servis
                    </a>
                    <a href="#layanan" class="bg-surface-container-high text-primary font-bold px-8 py-4 rounded-lg text-base uppercase tracking-wider hover:bg-surface-container-highest transition-all flex items-center gap-3">
                        <span class="material-symbols-outlined">explore</span>
                        Lihat Layanan
                    </a>
                </div>
                
                <!-- Stats -->
                <div class="flex flex-wrap gap-8 mt-12 pt-8 border-t border-slate-800/50">
                    <div>
                        <div class="text-3xl font-bold text-on-surface">10+</div>
                        <div class="text-sm text-slate-500 uppercase tracking-wider">Tahun Pengalaman</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-on-surface">5000+</div>
                        <div class="text-sm text-slate-500 uppercase tracking-wider">Mobil Servis</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-on-surface">15+</div>
                        <div class="text-sm text-slate-500 uppercase tracking-wider">Teknisi Ahli</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-secondary-container">98%</div>
                        <div class="text-sm text-slate-500 uppercase tracking-wider">Kepuasan</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Scroll indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-float">
            <span class="material-symbols-outlined text-slate-500">keyboard_arrow_down</span>
        </div>
    </header>

    <!-- Why Choose Us -->
    <section id="tentang" class="py-24 bg-surface px-6 lg:px-16">
        <div class="max-w-7xl mx-auto">
            <div class="mb-16">
                <span class="text-primary font-bold text-xs uppercase tracking-[0.3em]">Excellence Engineered</span>
                <h2 class="text-4xl md:text-5xl font-bold mt-4 text-on-surface">Mengapa Memilih Kami</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-surface-container p-8 rounded-xl relative group overflow-hidden border border-surface-container-high/50 hover:border-secondary-container/30 transition-all">
                    <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-20 transition-opacity">
                        <span class="material-symbols-outlined text-8xl">verified</span>
                    </div>
                    <div class="mb-6 bg-secondary-container/20 w-14 h-14 flex items-center justify-center rounded-lg">
                        <span class="material-symbols-outlined text-secondary-container text-2xl">high_quality</span>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-on-surface">Quality First</h3>
                    <p class="text-slate-400 leading-relaxed">
                        Kami hanya menggunakan suku cadang orisinal dan oli berkualitas tinggi untuk menjamin durabilitas kendaraan Anda.
                    </p>
                </div>
                <div class="bg-surface-container-high p-8 rounded-xl relative group overflow-hidden border border-surface-container-high/50 hover:border-secondary-container/30 transition-all">
                    <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-20 transition-opacity">
                        <span class="material-symbols-outlined text-8xl">bolt</span>
                    </div>
                    <div class="mb-6 bg-secondary-container/20 w-14 h-14 flex items-center justify-center rounded-lg">
                        <span class="material-symbols-outlined text-secondary-container text-2xl">speed</span>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-on-surface">Express Service</h3>
                    <p class="text-slate-400 leading-relaxed">
                        Waktu Anda berharga. Proses diagnosa cepat dan pengerjaan efisien tanpa mengurangi ketelitian teknis.
                    </p>
                </div>
                <div class="bg-surface-container p-8 rounded-xl relative group overflow-hidden border border-surface-container-high/50 hover:border-secondary-container/30 transition-all">
                    <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-20 transition-opacity">
                        <span class="material-symbols-outlined text-8xl">engineering</span>
                    </div>
                    <div class="mb-6 bg-secondary-container/20 w-14 h-14 flex items-center justify-center rounded-lg">
                        <span class="material-symbols-outlined text-secondary-container text-2xl">psychology</span>
                    </div>
                    <h3 class="text-xl font-bold mb-4 text-on-surface">Master Techs</h3>
                    <p class="text-slate-400 leading-relaxed">
                        Tim teknisi kami terlatih secara profesional untuk menangani berbagai merk mobil dengan standar bengkel resmi.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="layanan" class="py-24 bg-surface-container-low px-6 lg:px-16 overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8">
                <div>
                    <span class="text-primary font-bold text-xs uppercase tracking-[0.3em]">Core Solutions</span>
                    <h2 class="text-4xl md:text-5xl font-bold mt-4 text-on-surface">Layanan Unggulan</h2>
                </div>
                <div class="h-[2px] w-32 bg-secondary-container mb-4"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="relative h-[400px] group cursor-pointer overflow-hidden rounded-xl md:col-span-2">
                    <img alt="Overhaul Engine" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-60" src="/images/galeri/fotoscanner.png">
                    <div class="absolute inset-0 bg-gradient-to-t from-surface via-surface/50 to-transparent"></div>
                    <div class="absolute bottom-0 p-8">
                        <span class="text-secondary text-xs font-bold tracking-[0.2em] uppercase">Performance</span>
                        <h3 class="text-2xl font-bold mt-2 text-on-surface">Scan & Diagnosa</h3>
                        <p class="text-sm text-slate-400 mt-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            Diagnosa menyeluruh menggunakan teknologi scanner modern untuk mendeteksi masalah pada sistem elektronik mobil Anda.
                        </p>
                    </div>
                </div>
                <div class="relative h-[400px] group cursor-pointer overflow-hidden rounded-xl">
                    <img alt="Brake System" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-60" src="/images/galeri/foto3.jpg">
                    <div class="absolute inset-0 bg-gradient-to-t from-surface to-transparent"></div>
                    <div class="absolute bottom-0 p-8">
                        <span class="text-secondary text-xs font-bold tracking-[0.2em] uppercase">Peformance</span>
                        <h3 class="text-xl font-bold mt-2 text-on-surface">Overhaul Engine</h3>
                    </div>
                </div>
                <div class="relative h-[400px] group cursor-pointer overflow-hidden rounded-xl">
                    <img alt="AC" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-60" src="/images/galeri/fotoac.png">
                    <div class="absolute inset-0 bg-gradient-to-t from-surface to-transparent"></div>
                    <div class="absolute bottom-0 p-8">
                        <span class="text-secondary text-xs font-bold tracking-[0.2em] uppercase">Comfort</span>
                        <h3 class="text-xl font-bold mt-2 text-on-surface">AC & Pendingin</h3>
                    </div>
                </div>
                <div class="relative h-[300px] group cursor-pointer overflow-hidden rounded-xl">
                    <img alt="Service" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-60" src="/images/galeri/foto4.jpg">
                    <div class="absolute inset-0 bg-gradient-to-t from-surface to-transparent"></div>
                    <div class="absolute bottom-0 p-6">
                        <span class="text-secondary text-xs font-bold tracking-[0.2em] uppercase">Maintenance</span>
                        <h3 class="text-lg font-bold mt-2 text-on-surface">Service Berkala</h3>
                    </div>
                </div>
                <div class="relative h-[300px] group cursor-pointer overflow-hidden rounded-xl">
                    <img alt="Electrical" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-60" src="/images/galeri/fotokelistrikan.png">
                    <div class="absolute inset-0 bg-gradient-to-t from-surface to-transparent"></div>
                    <div class="absolute bottom-0 p-6">
                        <span class="text-secondary text-xs font-bold tracking-[0.2em] uppercase">Electrical</span>
                        <h3 class="text-lg font-bold mt-2 text-on-surface">Kelistrikan</h3>
                    </div>
                </div>
                <div class="relative h-[300px] group cursor-pointer overflow-hidden rounded-xl md:col-span-2">
                    <img alt="Suspension" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-60" src="/images/galeri/foto5.jpg">
                    <div class="absolute inset-0 bg-gradient-to-t from-surface to-transparent"></div>
                    <div class="absolute bottom-0 p-6">
                        <span class="text-secondary text-xs font-bold tracking-[0.2em] uppercase">Handling</span>
                        <h3 class="text-lg font-bold mt-2 text-on-surface">Suspensi & Steering</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="galeri" class="py-24 bg-surface-container-low px-6 lg:px-16">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <span class="text-primary font-bold text-xs uppercase tracking-[0.3em]">Our Facility</span>
                <h2 class="text-4xl md:text-5xl font-bold mt-4 text-on-surface">Galeri Bengkel</h2>
                <p class="text-slate-400 mt-4 max-w-2xl mx-auto">
                    Lihat fasilitas dan suasana bengkel kami yang modern dan profesional
                </p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="group relative aspect-square overflow-hidden rounded-xl cursor-pointer" onclick="openGallery(0)">
                    <img alt="Bengkel Interior" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 opacity-70 group-hover:opacity-100" src="/images/galeri/areasporing.jpg">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-4xl">zoom_in</span>
                    </div>
                </div>
                <div class="group relative aspect-square overflow-hidden rounded-xl cursor-pointer" onclick="openGallery(1)">
                    <img alt="Teknisi Kerja" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 opacity-70 group-hover:opacity-100" src="/images/galeri/bukaban.jpg">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-4xl">zoom_in</span>
                    </div>
                </div>
                <div class="group relative aspect-square overflow-hidden rounded-xl cursor-pointer" onclick="openGallery(2)">
                    <img alt="Area Servis" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 opacity-70 group-hover:opacity-100" src="/images/galeri/foto2.jpg">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-4xl">zoom_in</span>
                    </div>
                </div>
                <div class="group relative aspect-square overflow-hidden rounded-xl cursor-pointer" onclick="openGallery(3)">
                    <img alt="Alat Diagnosa" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 opacity-70 group-hover:opacity-100" src="/images/galeri/foto5.jpg">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-4xl">zoom_in</span>
                    </div>
                </div>
                <div class="group relative aspect-square overflow-hidden rounded-xl cursor-pointer" onclick="openGallery(4)">
                    <img alt="Mesin Workshop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 opacity-70 group-hover:opacity-100" src="/images/galeri/foto6.jpg">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-4xl">zoom_in</span>
                    </div>
                </div>
                <div class="group relative aspect-square overflow-hidden rounded-xl cursor-pointer" onclick="openGallery(5)">
                    <img alt="Spare Parts" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 opacity-70 group-hover:opacity-100" src="/images/galeri/foto4.jpg">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-4xl">zoom_in</span>
                    </div>
                </div>
                <div class="group relative aspect-square overflow-hidden rounded-xl cursor-pointer" onclick="openGallery(6)">
                    <img alt="Car Service" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 opacity-70 group-hover:opacity-100" src="/images/galeri/foto1.jpg">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-4xl">zoom_in</span>
                    </div>
                </div>
                <div class="group relative aspect-square overflow-hidden rounded-xl cursor-pointer" onclick="openGallery(7)">
                    <img alt="Waiting Area" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 opacity-70 group-hover:opacity-100" src="/images/galeri/fotoscanner.png">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-4xl">zoom_in</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Lightbox Modal -->
    <div id="lightbox" class="fixed inset-0 z-[100] bg-black/95 hidden flex items-center justify-center">
        <button onclick="closeGallery()" class="absolute top-4 right-4 w-12 h-12 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-colors">
            <span class="material-symbols-outlined text-white text-3xl">close</span>
        </button>
        <button onclick="prevImage()" class="absolute left-4 w-12 h-12 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-colors">
            <span class="material-symbols-outlined text-white text-3xl">chevron_left</span>
        </button>
        <button onclick="nextImage()" class="absolute right-4 w-12 h-12 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-colors">
            <span class="material-symbols-outlined text-white text-3xl">chevron_right</span>
        </button>
        <img id="lightbox-img" src="" alt="Gallery" class="max-w-[90vw] max-h-[90vh] object-contain">
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 text-white text-sm" id="lightbox-caption"></div>
    </div>

    <!-- Testimonials Section -->
    <section id="testimoni" class="py-24 bg-surface px-6 lg:px-16">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <span class="text-primary font-bold text-xs uppercase tracking-[0.3em]">Customer Stories</span>
                <h2 class="text-4xl font-bold mt-4 text-on-surface">Apa Kata Pelanggan</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($reviews as $review)
                <div class="bg-surface-container p-8 rounded-xl border-l-4 border-secondary-container">
                    <div class="flex gap-1 text-secondary-container mb-4">
                        @for($i = 0; $i < 5; $i++)
                        <span class="material-symbols-outlined {{ $i < $review->rating ? 'text-orange-400 fill-1' : 'text-slate-600 fill-0' }}">star</span>
                        @endfor
                    </div>
                    <p class="text-lg italic text-slate-300 leading-relaxed mb-6">"{{ $review->komentar }}"</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-surface-bright flex items-center justify-center">
                            <span class="material-symbols-outlined text-slate-400">person</span>
                        </div>
                        <div>
                            <p class="font-bold text-on-surface">{{ $review->nama }}</p>
                            <p class="text-xs text-primary uppercase tracking-widest">{{ $review->mobil }} Owner</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Write Review Form -->
            <div class="mt-16 max-w-2xl mx-auto">
                <div class="bg-surface-container p-8 rounded-xl">
                    <h3 class="text-xl font-bold text-on-surface mb-6 text-center">Tulis Ulasan Anda</h3>
                    @if(session('success'))
                        <div class="bg-green-600/20 border border-green-500 text-green-400 px-4 py-3 rounded-lg mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-red-600/20 border border-red-500 text-red-400 px-4 py-3 rounded-lg mb-4">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form action="{{ route('reviews.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm text-slate-400 mb-2">Nama</label>
                            <input type="text" name="nama" placeholder="Nama Anda" required class="w-full px-4 py-3 bg-surface-container-low border border-slate-700 rounded-lg text-on-surface placeholder-slate-500 focus:outline-none focus:border-orange-500">
                        </div>
                        <div>
                            <label class="block text-sm text-slate-400 mb-2">Mobil</label>
                            <input type="text" name="mobil" placeholder="Jenis Mobil" required class="w-full px-4 py-3 bg-surface-container-low border border-slate-700 rounded-lg text-on-surface placeholder-slate-500 focus:outline-none focus:border-orange-500">
                        </div>
                        <div>
                            <label class="block text-sm text-slate-400 mb-2">Rating</label>
                            <div class="flex gap-2" id="rating-stars">
                                <button type="button" onclick="setRating(1)" class="text-2xl text-slate-600 hover:text-orange-400 transition-colors">★</button>
                                <button type="button" onclick="setRating(2)" class="text-2xl text-slate-600 hover:text-orange-400 transition-colors">★</button>
                                <button type="button" onclick="setRating(3)" class="text-2xl text-slate-600 hover:text-orange-400 transition-colors">★</button>
                                <button type="button" onclick="setRating(4)" class="text-2xl text-slate-600 hover:text-orange-400 transition-colors">★</button>
                                <button type="button" onclick="setRating(5)" class="text-2xl text-slate-600 hover:text-orange-400 transition-colors">★</button>
                            </div>
                            <input type="hidden" name="rating" id="review-rating" value="0" required>
                        </div>
                        <div>
                            <label class="block text-sm text-slate-400 mb-2">Ulasan</label>
                            <textarea name="komentar" placeholder="Tulis pengalaman servis Anda..." rows="4" required class="w-full px-4 py-3 bg-surface-container-low border border-slate-700 rounded-lg text-on-surface placeholder-slate-500 focus:outline-none focus:border-orange-500 resize-none"></textarea>
                        </div>
                        <button type="submit" class="w-full kinetic-gradient text-on-secondary-fixed font-bold px-6 py-3 rounded-lg uppercase tracking-wider hover:brightness-110 transition-all">
                            Kirim Ulasan
                        </button>
                    </form>
                    <script>
                        function setRating(rating) {
                            document.getElementById('review-rating').value = rating;
                            const stars = document.querySelectorAll('#rating-stars button');
                            stars.forEach((star, i) => {
                                star.classList.toggle('text-orange-400', i < rating);
                                star.classList.toggle('text-slate-600', i >= rating);
                            });
                        }
                    </script>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-surface-container-low relative overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 left-1/4 w-64 h-64 bg-orange-600 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-64 h-64 bg-orange-500 rounded-full filter blur-3xl"></div>
        </div>
        <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
            <h2 class="text-3xl md:text-4xl font-bold text-on-surface mb-6">
                Siapkan Mobil Anda Untuk Perjalanan?
            </h2>
            <p class="text-slate-400 mb-8 max-w-xl mx-auto">
                Jadwalkan servis sekarang dan rasakan perbedaan pelayanan premium dari Hasnati Motor Tasiu.
            </p>
            <a href="https://wa.me/6285396587024?text=Halo%20Hasnati%20Motor%20Tasiu,%20saya%20ingin%20memesan%20jadwal%20servis" class="kinetic-gradient text-on-secondary-fixed font-black px-8 py-4 rounded-lg text-base uppercase tracking-wider hover:brightness-110 transition-all inline-flex items-center gap-3">
                <span class="material-symbols-outlined">chat</span>
                Hubungi via WhatsApp
            </a>
        </div>
    </section>

    <!-- Map & Contact Info -->
    <section id="kontak" class="py-24 bg-surface-container-lowest border-t border-surface-container-high px-6 lg:px-16">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div>
                <span class="text-primary font-bold text-xs uppercase tracking-[0.3em]">Visit Us</span>
                <h2 class="text-4xl font-bold mb-8 mt-4 text-on-surface">Kunjungi Workshop Kami</h2>
                <div class="space-y-8">
                    <div class="flex gap-6">
                        <span class="material-symbols-outlined text-secondary-container text-4xl">location_on</span>
                        <div>
                            <p class="text-xl font-bold mb-2 text-on-surface">Lokasi Utama</p>
                            <p class="text-slate-400 leading-relaxed">
                                Jl. Poros Mamuju - Palu,<br>
                                Kec. Kalukku, Kab. Mamuju,<br>
                                Sulawesi Barat
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-6">
                        <span class="material-symbols-outlined text-secondary-container text-4xl">schedule</span>
                        <div>
                            <p class="text-xl font-bold mb-2 text-on-surface">Jam Operasional</p>
                            <p class="text-slate-400">Senin - Sabtu: 08.00 - 17.00 WITA</p>
                            <p class="text-slate-400">Minggu: Tutup</p>
                        </div>
                    </div>
                    <div class="flex gap-6">
                        <span class="material-symbols-outlined text-secondary-container text-4xl">call</span>
                        <div>
                            <p class="text-xl font-bold mb-2 text-on-surface">Hubungi Kami</p>
                            <p class="text-slate-400">Hotline: +62 85396587024</p>
                            <a href="https://wa.me/6285396587024" class="text-green-500 hover:text-green-400">WhatsApp: +6285396587024</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative h-[400px] w-full rounded-2xl overflow-hidden shadow-2xl border border-surface-container-high/50">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3985.8556597360493!2d119.05171887394691!3d-2.553821038323077!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d92e9d9c551d85d%3A0xbb25fdc29d8899e4!2sBengkel%20Hasnati%20Motor%20Tasiu!5e0!3m2!1sid!2sid!4v1776602584083!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
                <div class="absolute inset-0 bg-surface/20 pointer-events-none"></div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-950 w-full border-t border-slate-800/30">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 px-8 lg:px-16 py-16 w-full">
            <div class="md:col-span-1">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-lg kinetic-gradient flex items-center justify-center">
                        <span class="material-symbols-outlined text-white">settings</span>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-slate-100 uppercase">Hasnati Motor</div>
                        <div class="text-xs text-orange-500 -mt-1">Tasiu</div>
                    </div>
                </div>
                <p class="text-sm tracking-wide text-slate-500 leading-relaxed">
                    Spesialis perbaikan mobil modern dengan standar teknologi terkini di Sulawesi Selatan.
                </p>
            </div>
            <div class="md:col-span-1">
                <p class="text-orange-500 font-bold mb-6 uppercase tracking-widest text-xs">Layanan</p>
                <ul class="space-y-3 text-sm tracking-wide">
                    <li><a class="text-slate-500 hover:text-orange-500 transition-colors" href="#">General Repair</a></li>
                    <li><a class="text-slate-500 hover:text-orange-500 transition-colors" href="#">Computer Diagnosis</a></li>
                    <li><a class="text-slate-500 hover:text-orange-500 transition-colors" href="#">AC System Repair</a></li>
                    <li><a class="text-slate-500 hover:text-orange-500 transition-colors" href="#">Engine Overhaul</a></li>
                </ul>
            </div>
            <div class="md:col-span-1">
                <p class="text-orange-500 font-bold mb-6 uppercase tracking-widest text-xs">Link Penting</p>
                <ul class="space-y-3 text-sm tracking-wide">
                    <li><a class="text-slate-500 hover:text-orange-500 transition-colors" href="#tentang">Tentang Kami</a></li>
                    <li><a class="text-slate-500 hover:text-orange-500 transition-colors" href="#layanan">Layanan</a></li>
                    <li><a class="text-slate-500 hover:text-orange-500 transition-colors" href="#galeri">Galeri</a></li>
                    <li><a class="text-slate-500 hover:text-orange-500 transition-colors" href="#kontak">Kontak</a></li>
                    <li><a class="text-slate-500 hover:text-orange-500 transition-colors" href="#testimoni">Testimoni</a></li>
                </ul>
            </div>
            <div class="md:col-span-1">
                <p class="text-orange-500 font-bold mb-6 uppercase tracking-widest text-xs">Stay Connected</p>
                <div class="flex gap-4 mb-6">
                    <a href="https://wa.me/6285396587024" class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center hover:bg-secondary-container group transition-colors">
                        <span class="material-symbols-outlined text-slate-400 group-hover:text-white">chat</span>
                    </a>
                    <a href="https://maps.app.goo.gl/nVxd1njsBNZoBavq6" target="_blank" class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center hover:bg-secondary-container group transition-colors">
                        <span class="material-symbols-outlined text-slate-400 group-hover:text-white">map</span>
                    </a>
                </div>
                <p class="text-xs text-slate-600">2024 Hasnati Motor Tasiu. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar background on scroll
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.classList.add('shadow-xl', 'bg-slate-950/90');
            } else {
                nav.classList.remove('shadow-xl', 'bg-slate-950/90');
            }
        });

        // Gallery Lightbox
        const galleryImages = [
            { src: '/images/galeri/areasporing.jpg', caption: 'Sporing' },
            { src: '/images/galeri/bukaban.jpg', caption: 'Teknisi Sedang Bekerja' },
            { src: '/images/galeri/foto2.jpg', caption: 'Area Servis Rem' },
            { src: '/images/galeri/foto5.jpg', caption: 'area ban' },
            { src: '/images/galeri/foto6.jpg', caption: 'Mesin Workshop' },
            { src: '/images/galeri/foto4.jpg', caption: 'Servis Berkala' },
            { src: '/images/galeri/foto1.jpg', caption: 'Tim Mekanik' },
            { src: '/images/galeri/fotoscanner.png', caption: 'Scan diangnosa' }
        ];
        let currentImageIndex = 0;
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightbox-img');
        const lightboxCaption = document.getElementById('lightbox-caption');

        function openGallery(index) {
            currentImageIndex = index;
            updateLightboxImage();
            lightbox.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeGallery() {
            lightbox.classList.add('hidden');
            document.body.style.overflow = '';
        }

        function nextImage() {
            currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
            updateLightboxImage();
        }

        function prevImage() {
            currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
            updateLightboxImage();
        }

        function updateLightboxImage() {
            lightboxImg.src = galleryImages[currentImageIndex].src;
            lightboxCaption.textContent = galleryImages[currentImageIndex].caption;
        }

        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) closeGallery();
        });

        document.addEventListener('keydown', (e) => {
            if (lightbox.classList.contains('hidden')) return;
            if (e.key === 'Escape') closeGallery();
            if (e.key === 'ArrowRight') nextImage();
            if (e.key === 'ArrowLeft') prevImage();
        });
    </script>
</body>
</html>