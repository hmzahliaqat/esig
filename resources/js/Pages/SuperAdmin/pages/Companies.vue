<template>
  <div class="bg-gray-50">
    <div id="app">
      <Sidebar />

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

              <h1 class="text-xl font-bold text-gray-900 lg:ml-0 ml-4">Companies</h1>

              <!-- Search and user profile -->
              <div class="flex items-center space-x-4">
                <div class="relative hidden md:block">
                  <input
                    type="text"
                    placeholder="Search companies..."
                    v-model="searchQuery"
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

          <!-- Companies Content -->
          <main class="px-4 sm:px-6 lg:px-8 py-6">
            <!-- Actions Bar -->
            <div
              class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between"
            >
              <div class="flex-1 min-w-0">
                <h2 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">
                  All Companies
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                  A list of all the companies in your account
                </p>
              </div>
            </div>

            <!-- Companies Table -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
              <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                    <tr>
                      <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                      >
                        <div
                          class="flex items-center cursor-pointer"
                          @click="sortBy('name')"
                        >
                          Name
                          <svg
                            v-if="sortColumn === 'name' && sortDirection === 'asc'"
                            xmlns="http://www.w3.org/2000/svg"
                            class="ml-1 h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M5 15l7-7 7 7"
                            />
                          </svg>
                          <svg
                            v-if="sortColumn === 'name' && sortDirection === 'desc'"
                            xmlns="http://www.w3.org/2000/svg"
                            class="ml-1 h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M19 9l-7 7-7-7"
                            />
                          </svg>
                        </div>
                      </th>
                      <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                      >
                        <div
                          class="flex items-center cursor-pointer"
                          @click="sortBy('email')"
                        >
                          Email
                          <svg
                            v-if="sortColumn === 'email' && sortDirection === 'asc'"
                            xmlns="http://www.w3.org/2000/svg"
                            class="ml-1 h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M5 15l7-7 7 7"
                            />
                          </svg>
                          <svg
                            v-if="sortColumn === 'email' && sortDirection === 'desc'"
                            xmlns="http://www.w3.org/2000/svg"
                            class="ml-1 h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M19 9l-7 7-7-7"
                            />
                          </svg>
                        </div>
                      </th>
                      <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                      >
                        <div
                          class="flex items-center cursor-pointer"
                          @click="sortBy('employees')"
                        >
                          Employees
                          <svg
                            v-if="sortColumn === 'employees' && sortDirection === 'asc'"
                            xmlns="http://www.w3.org/2000/svg"
                            class="ml-1 h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M5 15l7-7 7 7"
                            />
                          </svg>
                          <svg
                            v-if="sortColumn === 'employees' && sortDirection === 'desc'"
                            xmlns="http://www.w3.org/2000/svg"
                            class="ml-1 h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M19 9l-7 7-7-7"
                            />
                          </svg>
                        </div>
                      </th>
                      <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                      >
                        <div
                          class="flex items-center cursor-pointer"
                          @click="sortBy('documents')"
                        >
                          Documents
                          <svg
                            v-if="sortColumn === 'documents' && sortDirection === 'asc'"
                            xmlns="http://www.w3.org/2000/svg"
                            class="ml-1 h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M5 15l7-7 7 7"
                            />
                          </svg>
                          <svg
                            v-if="sortColumn === 'documents' && sortDirection === 'desc'"
                            xmlns="http://www.w3.org/2000/svg"
                            class="ml-1 h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M19 9l-7 7-7-7"
                            />
                          </svg>
                        </div>
                      </th>
                      <th
                        scope="col"
                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
                      >
                        Actions
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr
                      v-for="company in paginatedCompanies"
                      :key="company.id"
                      class="hover:bg-gray-50 transition-colors duration-150"
                    >
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                          <div
                            class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-r"
                            :class="company.bgColor"
                          >
                            <div
                              class="h-full w-full flex items-center justify-center text-white font-bold"
                            >
                              {{ company.initials }}
                            </div>
                          </div>
                          <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">
                              {{ company.name }}
                            </div>
                            <div class="text-sm text-gray-500">
                              {{ company.industry }}
                            </div>
                          </div>
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ company.email }}</div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                          {{ company.employees_count }}
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                          {{ company.documents_count }}
                        </div>
                      </td>
                      <td
                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                      >
                        <button class="text-indigo-600 hover:text-indigo-900 mr-3">
                          Activate
                        </button>
                        <button class="text-red-600 hover:text-red-900">Disable</button>
                      </td>
                    </tr>
                    <!-- Empty state when no results -->
                    <tr v-if="paginatedCompanies.length === 0">
                      <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          class="mx-auto h-12 w-12 text-gray-400"
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
                        <p class="mt-2 text-sm font-medium">No companies found</p>
                        <p class="mt-1 text-sm">
                          Try adjusting your search or filter to find what you're looking
                          for.
                        </p>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <!-- Pagination -->
              <div
                class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6"
              >
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                  <div>
                    <p class="text-sm text-gray-700">
                      Showing
                      <span class="font-medium">{{ startIndex + 1 }}</span>
                      to
                      <span class="font-medium">{{
                        Math.min(endIndex, filteredCompanies.length)
                      }}</span>
                      of
                      <span class="font-medium">{{ filteredCompanies.length }}</span>
                      results
                    </p>
                  </div>
                  <div>
                    <nav
                      class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                      aria-label="Pagination"
                    >
                      <button
                        @click="prevPage"
                        :disabled="currentPage === 1"
                        :class="[
                          currentPage === 1
                            ? 'cursor-not-allowed opacity-50'
                            : 'hover:bg-gray-50',
                        ]"
                        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500"
                      >
                        <span class="sr-only">Previous</span>
                        <svg
                          class="h-5 w-5"
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 20 20"
                          fill="currentColor"
                          aria-hidden="true"
                        >
                          <path
                            fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd"
                          />
                        </svg>
                      </button>

                      <button
                        v-for="page in totalPages"
                        :key="page"
                        @click="goToPage(page)"
                        :class="[
                          page === currentPage
                            ? 'bg-indigo-50 border-indigo-500 text-indigo-600'
                            : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                        ]"
                        class="relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                      >
                        {{ page }}
                      </button>

                      <button
                        @click="nextPage"
                        :disabled="currentPage === totalPages"
                        :class="[
                          currentPage === totalPages
                            ? 'cursor-not-allowed opacity-50'
                            : 'hover:bg-gray-50',
                        ]"
                        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500"
                      >
                        <span class="sr-only">Next</span>
                        <svg
                          class="h-5 w-5"
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 20 20"
                          fill="currentColor"
                          aria-hidden="true"
                        >
                          <path
                            fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"
                          />
                        </svg>
                      </button>
                    </nav>
                  </div>
                </div>
                <!-- Mobile pagination -->
                <div class="flex items-center justify-between w-full sm:hidden">
                  <button
                    @click="prevPage"
                    :disabled="currentPage === 1"
                    :class="[
                      currentPage === 1
                        ? 'cursor-not-allowed opacity-50'
                        : 'hover:bg-gray-50',
                    ]"
                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white"
                  >
                    Previous
                  </button>
                  <span class="text-sm text-gray-500">
                    Page {{ currentPage }} of {{ totalPages }}
                  </span>
                  <button
                    @click="nextPage"
                    :disabled="currentPage === totalPages"
                    :class="[
                      currentPage === totalPages
                        ? 'cursor-not-allowed opacity-50'
                        : 'hover:bg-gray-50',
                    ]"
                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white"
                  >
                    Next
                  </button>
                </div>
              </div>
            </div>
          </main>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import Sidebar from "../components/Sidebar.vue";
// Companies data

const props = defineProps(["companies"]);

// Pagination
const currentPage = ref(1);
const itemsPerPage = ref(5);

// Sorting
const sortColumn = ref("name");
const sortDirection = ref("asc");

// Search
const searchQuery = ref("");

// Sorting logic
function sortCompanies(companiesToSort) {
  return [...companiesToSort].sort((a, b) => {
    let aValue = a[sortColumn.value];
    let bValue = b[sortColumn.value];
    if (typeof aValue === "string") {
      aValue = aValue.toLowerCase();
      bValue = bValue.toLowerCase();
    }
    return sortDirection.value === "asc"
      ? aValue > bValue
        ? 1
        : -1
      : aValue < bValue
      ? 1
      : -1;
  });
}

// Computed data
const filteredCompanies = computed(() => {
  if (!searchQuery.value) return sortCompanies(props.companies);
  const query = searchQuery.value.toLowerCase();
  return sortCompanies(
    companies.value.filter(
      (c) =>
        c.name.toLowerCase().includes(query) ||
        c.email.toLowerCase().includes(query) ||
        c.industry.toLowerCase().includes(query)
    )
  );
});

const totalPages = computed(() =>
  Math.ceil(filteredCompanies.value.length / itemsPerPage.value)
);

const startIndex = computed(() => (currentPage.value - 1) * itemsPerPage.value);

const endIndex = computed(() => startIndex.value + itemsPerPage.value);

const paginatedCompanies = computed(() =>
  filteredCompanies.value.slice(startIndex.value, endIndex.value)
);

// Methods
function sortBy(column) {
  if (sortColumn.value === column) {
    sortDirection.value = sortDirection.value === "asc" ? "desc" : "asc";
  } else {
    sortColumn.value = column;
    sortDirection.value = "asc";
  }
}

function prevPage() {
  if (currentPage.value > 1) currentPage.value--;
}

function nextPage() {
  if (currentPage.value < totalPages.value) currentPage.value++;
}

function goToPage(page) {
  currentPage.value = page;
}

// Sidebar logic on mount
onMounted(() => {
  const sidebar = document.getElementById("sidebar");
  const sidebarOverlay = document.getElementById("sidebar-overlay");
  const mobileMenuButton = document.getElementById("mobile-menu-button");

  if (window.innerWidth < 1024) {
    sidebar?.classList.add("-translate-x-full");
  }

  mobileMenuButton?.addEventListener("click", () => {
    sidebar?.classList.toggle("-translate-x-full");
    sidebarOverlay?.classList.toggle("hidden");
    document.body.classList.toggle("overflow-hidden");
  });

  sidebarOverlay?.addEventListener("click", () => {
    sidebar?.classList.add("-translate-x-full");
    sidebarOverlay?.classList.add("hidden");
    document.body.classList.remove("overflow-hidden");
  });

  window.addEventListener("resize", () => {
    if (window.innerWidth >= 1024) {
      sidebar?.classList.remove("-translate-x-full");
      sidebarOverlay?.classList.add("hidden");
      document.body.classList.remove("overflow-hidden");
    } else {
      sidebar?.classList.add("-translate-x-full");
    }
  });
});
</script>
