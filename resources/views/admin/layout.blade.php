<!DOCTYPE html>
<html class="h-full">
<head>
  <meta charset="UTF-8">
  <title>LinkPro Admin</title>
  <!-- Font Awesome CDN -->
  <link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
  integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIJDB8OaYkzKcXn/tWtIaxVXM2CwHFlJw8WPG2rO3Q8ug=="
  crossorigin="anonymous"
  referrerpolicy="no-referrer"
/>


  @vite('resources/css/app.css')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const sidebar = document.getElementById('sidebar');
      const toggleBtn = document.getElementById('menu-toggle');
      const closeBtn = document.getElementById('menu-close');

      toggleBtn.addEventListener('click', () => sidebar.classList.remove('-translate-x-full'));
      closeBtn.addEventListener('click', () => sidebar.classList.add('-translate-x-full'));
    });
  </script>
</head>
<body class="h-full bg-gray-100">
<div class="flex min-h-screen">

  <!-- Mobile Topbar -->
  <div class="lg:hidden fixed top-0 left-0 w-full bg-gray-900 text-white flex justify-between items-center px-4 py-3 z-20">
    <span class="font-bold text-lg">LinkPro</span>
    <button id="menu-toggle" class="text-white focus:outline-none">
      ☰
    </button>
  </div>

  <!-- Sidebar -->
  <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 w-64 bg-gray-900 text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-200 z-30">
      <div class="p-4 text-center font-bold text-xl border-b border-gray-700 flex justify-between items-center">
        LinkPro
        <button id="menu-close" class="lg:hidden text-gray-400 hover:text-white">✕</button>
      </div>
      <nav class="mt-4 space-y-1">
         <a href="{{ route('clients.index') }}"
            class="block py-2 px-4 rounded {{ request()->routeIs('clients.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            Clients
         </a>
         <a href="{{ route('contents.index') }}"
            class="block py-2 px-4 rounded {{ request()->routeIs('contents.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            Contents
         </a>
         <form action="/logout" method="POST" class="mt-4 px-4">
            @csrf
            <button class="w-full bg-red-500 text-white py-2 rounded hover:bg-red-600">Logout</button>
         </form>
      </nav>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-6 pt-20 lg:pt-6 overflow-x-hidden">
      @if(session('success'))
          <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
      @endif
      @yield('content')
  </main>

</div>
</body>
</html>
