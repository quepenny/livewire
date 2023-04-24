<div
    x-data
    @wire-toast.window="$store.toast.wire($event)"
    class="fixed bottom-0 right-0 p-4 overflow-x-hidden"
>
  <template
    x-for="(toast, index) in $store.toast.list"
    :key="toast.id"
  >
    <div
      @click="$store.toasts.hide(index)"
      x-transition:enter="transition ease-in duration-200"
      x-transition:enter-start="transform opacity-0 translate-y-2"
      x-transition:enter-end="transform opacity-100"
      x-transition:leave="transition ease-out duration-500"
      x-transition:leave-start="transform translate-x-0 opacity-100"
      x-transition:leave-end="transform translate-x-full opacity-0"
      class="bg-gray-900 bg-gradient-to-r text-white p-3 rounded mb-3 shadow-lg flex items-center"
      :class="toast.class"
    >
      <svg
        class="w-6 h-6 mr-2"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 20 20"
        fill="currentColor"
      >
        <path
          fill-rule="evenodd"
          :d="toast.svg"
          clip-rule="evenodd"
        />
      </svg>

      <div x-text="toast.message"></div>
    </div>
  </template>
</div>