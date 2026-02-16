<header class="fixed top-0 left-0 w-full h-16 bg-blue-900 text-white flex items-center justify-between px-6 shadow-md z-50">
          <div class="flex items-center space-x-4">
            <!-- {/* Mobile Menu Toggle (Visible only on small screens) */} -->
            <button class="md:hidden p-2 hover:bg-blue-800 rounded-lg">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" /></svg>
            </button>
            <h1 class="text-xl font-bold tracking-wide hidden sm:block">
              Sistema de Gestión de Ambientes
            </h1>
            <h1 class="text-xl font-bold tracking-wide sm:hidden">
              SGA
            </h1>
          </div>
    
          <div class="flex items-center space-x-6">
            <div class="relative cursor-pointer group">
              <button class="p-2 hover:bg-blue-800 rounded-full transition-colors relative">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                <span class="absolute top-1.5 right-1.5 w-3 h-3 bg-red-500 border-2 border-blue-900 rounded-full"></span>
              </button>
            </div>
    
            <div class="flex items-center space-x-3 cursor-pointer group">
              <div class="hidden sm:block text-right">
                <p class="text-sm font-semibold leading-none">Admin Usuario</p>
                <p class="text-xs text-blue-300 leading-tight">Administrador General</p>
              </div>
              <div class="relative">
                <img 
                  src="https://picsum.photos/seed/admin/100/100" 
                  alt="Avatar" 
                  class="w-10 h-10 rounded-full border-2 border-blue-400 group-hover:border-white transition-all duration-200"
                />
              </div>
            </div>
          </div>
        </header>