<?php 
$currentPage = basename($_SERVER['PHP_SELF']); 
?>

<!-- sidebar.php -->
<nav class="w-[280px] min-h-screen bg-gradient-to-br from-slate-800 to-indigo-900 text-white shadow-lg flex flex-col p-4">
    <div class="border-b border-white/10 pb-4 mb-4">
        <h4 class="flex items-center text-xl font-bold">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            GSO Admin
        </h4>
    </div>

    <ul class="space-y-2">
        <!-- Dashboard -->
        <li>
            <a href="index.php" 
               class="flex items-center px-4 py-3 rounded-lg group transition-all duration-200 hover:bg-white/25 hover:translate-x-1 
               <?= $currentPage == 'index.php' ? 'bg-white/20 text-white' : 'text-white/90' ?>">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"/>
                    <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"/>
                </svg>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Dropdown Template -->
        <li>
            <button data-toggle="dropdown" class="flex items-center justify-between w-full px-4 py-3 text-white/90 rounded-lg transition-all duration-200 hover:bg-white/10 hover:translate-x-1">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5z"/></svg>
                    <span>Requests</span>
                </div>
                <svg class="w-4 h-4 transition-transform duration-200 arrow" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4-4-4a1 1 0 010-1.414z"/>
                </svg>
            </button>
            <div class="hidden mt-2 ml-4 space-y-2">
                <a href="#" class="flex items-center px-4 py-2 text-sm text-white/80 rounded-lg hover:bg-white/10">Capitol Offices</a>
                <a href="#" class="flex items-center px-4 py-2 text-sm text-white/80 rounded-lg hover:bg-white/10">Private Offices</a>
            </div>
        </li>

        <!-- Letters -->
        <li>
            <button data-toggle="dropdown" class="flex items-center justify-between w-full px-4 py-3 text-white/90 rounded-lg transition-all duration-200 hover:bg-white/10 hover:translate-x-1">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                    <span>Letters</span>
                </div>
                <svg class="w-4 h-4 transition-transform duration-200 arrow" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4-4-4a1 1 0 010-1.414z"/>
                </svg>
            </button>
            <div class="hidden mt-2 ml-4 space-y-2">
                <a href="#" class="flex items-center px-4 py-2 text-sm text-white/80 rounded-lg hover:bg-white/10">Incoming</a>
                <a href="#" class="flex items-center px-4 py-2 text-sm text-white/80 rounded-lg hover:bg-white/10">Outgoing</a>
            </div>
        </li>

        <!-- Vehicle/Venue -->
        <li>
            <button data-toggle="dropdown" class="flex items-center justify-between w-full px-4 py-3 text-white/90 rounded-lg transition-all duration-200 hover:bg-white/10 hover:translate-x-1">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/><path d="M3 4h3.879a1.5 1.5 0 011.06.44l1.122 1.12A1.5 1.5 0 0110.12 6H15V3a1 1 0 00-1-1H3v14z"/></svg>
                    <span>Vehicle / Venue</span>
                </div>
                <svg class="w-4 h-4 transition-transform duration-200 arrow" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4-4-4a1 1 0 010-1.414z"/>
                </svg>
            </button>
            <div class="hidden mt-2 ml-4 space-y-2">
                <a href="vehicles.php" <?= $currentPage == 'vehicles.php' ? 'bg-white/20 text-white' : 'text-white/90' ?> class="flex items-center px-4 py-2 text-sm text-white/80 rounded-lg hover:bg-white/10">Vehicle Requests</a>
                <a href="#" class="flex items-center px-4 py-2 text-sm text-white/80 rounded-lg hover:bg-white/10">Venue Reservations</a>
            </div>
        </li>

        <!-- User Management -->
        <li>
            <a href="users.php" 
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 hover:bg-white/10 hover:translate-x-1 
               <?= $currentPage == 'users.php' ? 'bg-white/20 text-white' : 'text-white/90' ?>">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 12a5 5 0 100-10 5 5 0 000 10zm-7 8a7 7 0 0114 0H3z"/>
                </svg>
                <span>User Management</span>
            </a>
        </li>

        <li>
            <a href="#" class="flex items-center px-4 py-3 text-white/90 rounded-lg transition-all duration-200 hover:bg-white/10 hover:translate-x-1">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 12a5 5 0 100-10 5 5 0 000 10zm-7 8a7 7 0 0114 0H3z"/>
                </svg>
                <span>Inventory Management</span>
            </a>
        </li>

        <!-- Database Management -->
        <li>
            <a href="#" class="flex items-center px-4 py-3 text-white/90 rounded-lg transition-all duration-200 hover:bg-white/10 hover:translate-x-1">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 5a8 8 0 1112 0v10a8 8 0 11-12 0V5zm2 0a6 6 0 1012 0 6 6 0 00-12 0z"/>
                </svg>
                <span>Database Management</span>
            </a>
        </li>
    </ul>
</nav>

<script>
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("[data-toggle='dropdown']").forEach(button => {
        button.addEventListener("click", () => {
            const dropdown = button.nextElementSibling;
            const arrow = button.querySelector(".arrow");
            dropdown.classList.toggle("hidden");
            arrow.classList.toggle("rotate-180");
        });
    });
});
</script>
