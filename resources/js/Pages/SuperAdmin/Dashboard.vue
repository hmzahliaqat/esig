<template>
  <div class="bg-gray-50">
    <Sidebar :user="props?.auth?.user" />
    <!-- Overlay for mobile sidebar -->
    <div
      id="sidebar-overlay"
      class="fixed inset-0 bg-black opacity-50 z-20 hidden lg:hidden"
    ></div>

    <div class="min-h-screen">
      <!-- Main Content -->
      <div class="lg:ml-64 transition-all duration-300">
        <!-- Header -->
        <header class="bg-white shadow-sm">
          <div class="px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            <!-- Mobile menu button -->
            <button
              id="mobile-menu-button"
              class="lg:hidden p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"
                />
              </svg>
            </button>

            <h1 class="text-xl font-bold text-gray-900 lg:ml-0 ml-4">Dashboard</h1>

            <!-- Search and user profile -->
            <div class="flex items-center space-x-4">
              <div class="relative hidden md:block">
                <input
                  type="text"
                  placeholder="Search..."
                  class="w-64 pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                />
                <div class="absolute left-3 top-2.5 text-gray-400">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                    />
                  </svg>
                </div>
              </div>

              <div class="flex items-center">
                <button
                  class="p-1 rounded-full text-gray-500 hover:text-gray-700 focus:outline-none"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                    />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </header>

        <!-- Dashboard Content -->
        <main class="px-4 sm:px-6 lg:px-8 py-6">
          <!-- Stats Section -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Companies -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
              <div class="p-6 relative">
                <div class="absolute top-0 right-0 p-4">
                  <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-6 w-6"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                      />
                    </svg>
                  </div>
                </div>
                <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">
                  Total Companies
                </h3>
                <div class="mt-2 flex items-baseline">
                  <p class="text-3xl font-extrabold text-gray-900">
                    {{ props?.total_companies }}
                  </p>
                  <p
                    class="ml-2 flex items-baseline text-sm font-semibold text-green-600"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-4 w-4 self-center"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 10l7-7m0 0l7 7m-7-7v18"
                      />
                    </svg>
                    <span class="ml-1">12%</span>
                  </p>
                </div>
                <div class="mt-4">
                  <div class="w-full bg-gray-100 rounded-full h-2">
                    <div
                      class="bg-gradient-to-r from-blue-400 to-blue-600 h-2 rounded-full"
                      style="width: 75%"
                    ></div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Total Documents -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
              <div class="p-6 relative">
                <div class="absolute top-0 right-0 p-4">
                  <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-6 w-6"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                      />
                    </svg>
                  </div>
                </div>
                <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">
                  Total Documents
                </h3>
                <div class="mt-2 flex items-baseline">
                  <p class="text-3xl font-extrabold text-gray-900">
                    {{ props?.total_documents }}
                  </p>
                  <p
                    class="ml-2 flex items-baseline text-sm font-semibold text-green-600"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-4 w-4 self-center"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 10l7-7m0 0l7 7m-7-7v18"
                      />
                    </svg>
                    <span class="ml-1">8%</span>
                  </p>
                </div>
                <div class="mt-4">
                  <div class="w-full bg-gray-100 rounded-full h-2">
                    <div
                      class="bg-gradient-to-r from-purple-400 to-purple-600 h-2 rounded-full"
                      style="width: 65%"
                    ></div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Shared Documents -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
              <div class="p-6 relative">
                <div class="absolute top-0 right-0 p-4">
                  <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-6 w-6"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"
                      />
                    </svg>
                  </div>
                </div>
                <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">
                  Shared Documents
                </h3>
                <div class="mt-2 flex items-baseline">
                  <p class="text-3xl font-extrabold text-gray-900">
                    {{ props?.total_shared_documents }}
                  </p>
                  <p
                    class="ml-2 flex items-baseline text-sm font-semibold text-green-600"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-4 w-4 self-center"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 10l7-7m0 0l7 7m-7-7v18"
                      />
                    </svg>
                    <span class="ml-1">15%</span>
                  </p>
                </div>
                <div class="mt-4">
                  <div class="w-full bg-gray-100 rounded-full h-2">
                    <div
                      class="bg-gradient-to-r from-green-400 to-green-600 h-2 rounded-full"
                      style="width: 45%"
                    ></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Activity Section -->
          <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div
              class="px-6 py-4 border-b border-gray-200 flex justify-between items-center"
            >
              <h2 class="text-lg font-medium text-gray-900">Recent Activity</h2>
              <div class="flex space-x-2">
                <button
                  class="px-3 py-1 text-xs font-medium rounded-md bg-indigo-100 text-indigo-700 hover:bg-indigo-200 transition-colors duration-150"
                >
                  All
                </button>
                <button
                  class="px-3 py-1 text-xs font-medium rounded-md text-gray-600 hover:bg-gray-100 transition-colors duration-150"
                >
                  Documents
                </button>
                <button
                  class="px-3 py-1 text-xs font-medium rounded-md text-gray-600 hover:bg-gray-100 transition-colors duration-150"
                >
                  Companies
                </button>
              </div>
            </div>
            <ul class="divide-y divide-gray-200">
              <li
                v-for="log in props?.logs"
                class="px-6 py-4 hover:bg-gray-50 transition-colors duration-150"
              >
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <div
                      class="h-10 w-10 rounded-full bg-gradient-to-r from-pink-500 to-purple-500 flex items-center justify-center text-white font-medium"
                    >
                      SJ
                    </div>
                  </div>
                  <div class="ml-4 flex-1">
                    <div class="flex items-center justify-between">
                      <p class="text-sm font-medium text-gray-900">
                        {{ log?.user?.name }}
                      </p>
                      <p class="text-sm text-gray-500">{{ log?.created_at }}</p>
                    </div>
                    <p class="text-sm text-gray-500">
                      {{ getLogsMessages(log?.action) }}
                      <span class="font-medium text-indigo-600">
                        {{ log?.document?.title }}</span
                      >
                    </p>
                  </div>
                </div>
              </li>
            </ul>
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
              <a
                href="#"
                class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors duration-150 flex items-center justify-center"
              >
                View all activity
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-4 w-4 ml-1"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 5l7 7-7 7"
                  />
                </svg>
              </a>
            </div>
          </div>
        </main>
      </div>
    </div>

    <!-- JavaScript for sidebar functionality -->
    <!-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const mobileMenuButton = document.getElementById('mobile-menu-button');

            // Initially hide sidebar on mobile
            if (window.innerWidth < 1024) {
                sidebar.classList.add('-translate-x-full');
            }

            // Toggle sidebar on mobile
            mobileMenuButton.addEventListener('click', function() {
                sidebar.classList.toggle('-translate-x-full');
                sidebarOverlay.classList.toggle('hidden');
                document.body.classList.toggle('overflow-hidden');
            });

            // Hide sidebar when clicking overlay
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    sidebar.classList.remove('-translate-x-full');
                    sidebarOverlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                } else {
                    sidebar.classList.add('-translate-x-full');
                }
            });
        });
    </script> -->
  </div>
</template>

<script setup>
import Sidebar from "./components/Sidebar.vue";
const props = defineProps([
  "auth",
  "total_companies",
  "total_documents",
  "total_shared_documents",
  "logs",
]);

const getLogsMessages = (action) => {
  switch (action) {
    case "uploaded":
      return `Uploaded a new document`;
    case "shared":
      return `Shared a document`;
    case "signed":
      return `Signed a document `;
    case "downloaded":
      return `Downloaded a document`;
    default:
      return "";
  }
};
</script>

<style>
/* Custom scrollbar */
::-webkit-scrollbar {
  width: 6px;
  height: 6px;
}
::-webkit-scrollbar-track {
  background: #f1f1f1;
}
::-webkit-scrollbar-thumb {
  background: #cbd5e0;
  border-radius: 3px;
}
::-webkit-scrollbar-thumb:hover {
  background: #a0aec0;
}

/* Sidebar transition */
.sidebar-container {
  transition: transform 0.3s ease-in-out;
}
</style>
