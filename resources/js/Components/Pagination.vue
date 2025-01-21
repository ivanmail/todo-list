<template>
  <nav role="navigation" class="flex items-center justify-between">
    <div class="flex justify-center flex-1">
      <span v-if="onFirstPage() == true" aria-disabled="true">
        <span
          class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5 dark:bg-gray-800 dark:border-gray-600"
          aria-hidden="true">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path
              fill-rule="evenodd"
              d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
              clip-rule="evenodd" />
          </svg>
        </span>
      </span>

      <a
        v-else
        :href="previousPageUrl()"
        rel="prev"
        class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:active:bg-gray-700 dark:focus:border-blue-800">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path
            fill-rule="evenodd"
            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
            clip-rule="evenodd" />
        </svg>
      </a>

      <a
        v-for="link in paginationLinks"
        :key="link.label"
        :href="link.url"
        :class="
          link.active
            ? 'font-bold inline-flex'
            : 'font-medium hidden md:inline-flex'
        "
        class="relative items-center px-4 py-2 -ml-px text-sm text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:text-gray-300 dark:active:bg-gray-700 dark:focus:border-blue-800">
        {{ link.label }}
      </a>

      <a
        :href="nextPageUrl()"
        rel="next"
        class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:active:bg-gray-700 dark:focus:border-blue-800">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path
            fill-rule="evenodd"
            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
            clip-rule="evenodd" />
        </svg>
      </a>
    </div>
  </nav>
</template>

<script>
export default {
  props: {
    pagination: {
      type: Object,
      default() {
        return null;
      },
    },
  },
  data() {
    return {
      paginationLinks: null,
    };
  },
  mounted() {
    this.setPaginationLinks();
  },
  methods: {
    onFirstPage() {
      return this.pagination.current_page <= 1;
    },
    previousPageUrl() {
      return this.pagination.prev_page_url;
    },
    nextPageUrl() {
      return this.pagination.next_page_url;
    },
    setPaginationLinks() {
      let links = this.pagination.links;
      links.shift();
      links.pop();

      links.map((link) => {
        link.disabled = false;

        if (link.label === "...") {
          link.disabled = true;
        }
      });

      this.paginationLinks = links;
    },
  },
};
</script>
