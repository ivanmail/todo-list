<template>
  <div
    class="flex flex-col bg-white rounded-[20px] justify-center items-stretch my-7 pb-7 md:w-1/2 mx-auto">
    <div class="flex flex-col">
      <div
        class="relative flex flex-col md:flex-row justify-between items-center px-4 pt-4">
        <h4
          class="text-xl font-bold text-navy-700 dark:text-white pb-2 md:pb-0">
          Todo List
        </h4>

        <Link
          :href="createTaskUrl"
          class="middle none center rounded-lg bg-indigo-500 py-3 px-6 text-xs font-bold uppercase text-white shadow-md shadow-indigo-500/20 transition-all hover:shadow-lg hover:shadow-indigo-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
          data-ripple-light="true">
          Create Task
        </Link>
      </div>

      <div class="h-full w-full p-4">
        <Task v-for="task in tasks.data" :key="task.id" :task="task"></Task>
      </div>
    </div>

    <Pagination :pagination="tasks"></Pagination>
  </div>
</template>

<script>
import { Link, router } from "@inertiajs/vue3";
import Pagination from "../../Components/Pagination.vue";
import Task from "../../Components/Task.vue";

export default {
  components: {
    Link,
    Pagination,
    Task,
  },
  props: {
    tasks: {
      type: Object,
      default() {
        return null;
      },
    },
  },
  computed: {
    createTaskUrl() {
      return route("tasks.create");
    },
  },
  methods: {
    handleCheckboxChange(event, task) {
      let isChecked = event.target.checked;
      router.put(
        "/tasks/completion/" + task.id,
        { completed: isChecked },
        {
          preserveState: true,
          preserveScroll: true,
        },
      );
    },
  },
};
</script>
