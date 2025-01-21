<template>
  <div
    class="flex flex-col bg-white rounded-[20px] justify-center items-stretch mt-7 md:w-1/2 mx-auto">
    <div class="flex flex-col">
      <div
        class="relative flex flex-col md:flex-row justify-between items-center px-4 pt-4">
        <h4
          class="text-xl font-bold text-navy-700 dark:text-white pb-2 md:pb-0">
          Edit Task
        </h4>
      </div>

      <div class="h-full w-full">
        <form @submit.prevent="updateTask" class="py-6 px-9" method="POST">
          <div class="mb-5">
            <label
              for="title"
              class="mb-3 block text-base font-medium text-[#07074D]">
              Title:
            </label>
            <input
              v-model="form.title"
              type="text"
              name="title"
              id="title"
              placeholder="Enter task title"
              class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />

            <div class="text-red-500" v-if="$page.props.errors.title">
              {{ $page.props.errors.title }}
            </div>
          </div>

          <div class="mb-5">
            <label
              for="description"
              class="mb-3 block text-base font-medium text-[#07074D]">
              Description:
            </label>
            <textarea
              v-model="form.description"
              type="text"
              id="description"
              placeholder="Enter task description"
              class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"></textarea>

            <div class="text-red-500" v-if="$page.props.errors.description">
              {{ $page.props.errors.description }}
            </div>
          </div>

          <div class="mb-5">
            <label
              for="completed"
              class="mb-3 block text-base font-medium text-[#07074D]">
              Completed:
            </label>
            <input
              type="checkbox"
              class="defaultCheckbox relative flex h-[20px] min-h-[20px] w-[20px] min-w-[20px] appearance-none items-center justify-center rounded-md border border-gray-300 text-white/0 outline-none transition duration-[0.2s] checked:border-none checked:text-white hover:cursor-pointer dark:border-white/10 checked:bg-brand-500 dark:checked:bg-brand-400"
              name="completed"
              v-model="form.completed" />
          </div>

          <button
            type="submit"
            class="middle none center rounded-lg bg-indigo-500 py-3 px-6 text-xs font-bold uppercase text-white shadow-md shadow-indigo-500/20 transition-all hover:shadow-lg hover:shadow-indigo-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
            data-ripple-light="true">
            Update
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { router, useForm } from "@inertiajs/vue3";

export default {
  props: {
    task: {
      type: Object,
      default() {
        return null;
      },
    },
  },
  setup(props) {
    const form = useForm({
      title: props.task.title,
      description: props.task.description,
      completed: !!props.task.completed,
    });

    function updateTask() {
      router.put(`/tasks/${props.task.id}`, form);
    }

    return { form, updateTask };
  },
};
</script>
