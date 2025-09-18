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
            GSO Secretary
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
            <a href="requests.php" 
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 hover:bg-white/10 hover:translate-x-1 
               <?= $currentPage == 'requests.php' ? 'bg-white/20 text-white' : 'text-white/90' ?>">
                 <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5z"/></svg>
                    <span>Requests</span>
                </div>
            </a>
        </li>


        <li>
<<<<<<< HEAD
            <a href="governorequest.php" 
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 hover:bg-white/10 hover:translate-x-1 
               <?= $currentPage == 'governorequest.php' ? 'bg-white/20 text-white' : 'text-white/90' ?>">
                 <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5z"/></svg>
                    <span>Governor's Requests</span>
                </div>
            </a>
        </li>

        
        <li>
=======
>>>>>>> 31d07f4e30fc24c47bc601c3fa6ab089bd847881
            <a href="letter.php" 
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 hover:bg-white/10 hover:translate-x-1 
               <?= $currentPage == 'letter.php' ? 'bg-white/20 text-white' : 'text-white/90' ?>">
                 <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                    <span>Letter</span>
                </div>
            </a>
        </li>
<<<<<<< HEAD
        
=======
>>>>>>> 31d07f4e30fc24c47bc601c3fa6ab089bd847881

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
