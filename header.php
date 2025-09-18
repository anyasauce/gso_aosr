<nav class="bg-white/90 backdrop-blur-lg sticky top-0 z-50 border-b border-slate-200/60">
    <div class="container mx-auto flex items-center justify-between px-6 py-4">
        <a href="index.php" class="text-3xl font-bold text-slate-800 tracking-tight">GSO <span class="text-indigo-600">CONNECT</span></a>

        <div class="hidden md:flex items-center space-x-4">
            <a href="#about" class="text-slate-600 hover:text-indigo-600 hover:bg-slate-100 px-4 py-2 rounded-full transition-all duration-300 font-medium">About</a>
            <a href="#features" class="text-slate-600 hover:text-indigo-600 hover:bg-slate-100 px-4 py-2 rounded-full transition-all duration-300 font-medium">Features</a>
            <a href="#reservation" class="text-slate-600 hover:text-indigo-600 hover:bg-slate-100 px-4 py-2 rounded-full transition-all duration-300 font-medium">Reserve</a>
            <a href="repair.php" class="text-slate-600 hover:text-indigo-600 hover:bg-slate-100 px-4 py-2 rounded-full transition-all duration-300 font-medium">Repair</a>
        </div>

        <div class="md:hidden">
            <button id="mobile-menu-button" class="p-2 text-slate-600 hover:text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-slate-200">
        <div class="flex flex-col space-y-2 p-4">
            <a href="#about" class="text-slate-600 hover:text-indigo-600 hover:bg-slate-100 px-4 py-3 rounded-lg transition-all duration-300 font-medium">About</a>
            <a href="#features" class="text-slate-600 hover:text-indigo-600 hover:bg-slate-100 px-4 py-3 rounded-lg transition-all duration-300 font-medium">Features</a>
            <a href="#reservation" class="text-slate-600 hover:text-indigo-600 hover:bg-slate-100 px-4 py-3 rounded-lg transition-all duration-300 font-medium">Reserve</a>
        </div>
    </div>
</nav>

<script>
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
</script>