<template>
  <div class="mt-5 px-2 pt-2 md:px-4 md:pt-4 rounded-lg border-2">
    <div class="flex items-center gap-2">
      <input
        type="checkbox"
        class="defaultCheckbox relative flex h-[20px] min-h-[20px] w-[20px] min-w-[20px] appearance-none items-center justify-center rounded-md border border-gray-300 text-white/0 outline-none transition duration-[0.2s] checked:border-none checked:text-white hover:cursor-pointer dark:border-white/10 checked:bg-brand-500 dark:checked:bg-brand-400"
        name="completed"
        :checked="task.completed"
        @change="(event) => handleCheckboxChange(event, task)" />
      <p class="text-sm md:text-base font-bold text-navy-700 dark:text-white">
        {{ task.title }}
      </p>
    </div>

    <p class="text-sm md:text-base mt-2 text-gray-400 pb-2">
      {{ task.description }}
    </p>

    <div class="mb-2">
      <Link :href="taskUrl" class="text-sm md:text-base text-gray-400 mr-2">
        Edit
      </Link>
      <button
        @click="deleteTask(task.id)"
        class="text-sm md:text-base text-red-400 mr-2">
        Delete
      </button>
    </div>
  </div>
</template>

<script>
import { Link, router } from "@inertiajs/vue3";
import Swal from "sweetalert2";

export default {
  components: {
    Link,
  },
  props: {
    task: {
      type: Object,
      default() {
        return null;
      },
    },
  },
  computed: {
    taskUrl() {
      return route("tasks.edit", this.task.id);
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
    deleteTask(id) {
      Swal.fire({
        title: "Are You sure?",
        text: "Do you want to continue?",
        icon: "alert",
        confirmButtonText: "Yes",
        showCancelButton: true,
        confirmButtonColor: "#6466f5",
        cancelButtonColor: "#d33",
      }).then((result) => {
        if (result.isConfirmed) {
          router.delete(`/tasks/${id}`, {
            preserveState: true,
            preserveScroll: true,
          });
        }
      });
    },
  },
};
</script>
