<!-- Header -->
<nav class="flex items-center justify-between px-4 py-3 bg-white/95 backdrop-blur border-b border-gray-100">
    <div class="flex items-center">
        <a href="#" class="flex items-center text-xl font-bold text-gray-800 hover:text-indigo-600 transition-colors">
            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 16 16">
                <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zm8 0A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm-8 8A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm8 0A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3z"/>
            </svg>
            Dashboard
        </a>
    </div>
    
    <div class="flex items-center space-x-4">
        <!-- Notifications -->
        <div class="relative">
            <button class="text-gray-600 hover:text-gray-800 transition-colors">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z"/>
                </svg>
                <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-xs text-white">
                    3
                </span>
            </button>
        </div>

        <!-- Divider -->
        <div class="h-6 w-px bg-gray-200"></div>

        <!-- User Profile -->
        <div class="flex items-center">
            <img src="https://ui-avatars.com/api/?name=Admin&background=0D8ABC&color=fff" 
                 alt="Admin" 
                 class="w-8 h-8 rounded-full mr-2">
            <div class="flex flex-col">
                <span class="font-semibold text-sm text-gray-800">Admin User</span>
                <span class="text-xs text-gray-500">Administrator</span>
            </div>
        </div>

        <!-- Logout Button -->
        <button class="text-red-500 hover:text-red-600 transition-transform hover:translate-x-0.5" title="Logout">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
            </svg>
        </button>
    </div>
</nav>