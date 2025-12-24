<x-input.wrapper
    :$disabled
    :$errorFor
    :$inputAttributes
    :$label
    :$required
    :$type
>
    <div
        class="flex flex-col gap-2 items-center p-4 border-2 border-gray-300 border-dashed rounded-md cursor-pointer hover:bg-gray-50 relative"
        x-data="fileInput"
        @click="openFileExplorer"
    >
        <!-- Clear button (shown when a file is selected) -->
        <button
            type="button"
            x-show="fileName"
            @click.stop="resetFile"
            class="absolute top-2 right-2 inline-flex items-center justify-center h-7 w-7 rounded-full bg-white border border-gray-300 shadow text-gray-500 hover:bg-gray-100 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
            title="Remove file"
            aria-label="Remove file"
        >
            <span aria-hidden="true" class="text-base leading-none">&times;</span>
        </button>

        <!-- Preview -->
        <template x-if="fileName">
            <div class="flex flex-col items-center gap-2 text-center">
                <template x-if="isImage && previewUrl">
                    <img
                        :src="previewUrl"
                        alt="Selected file preview"
                        class="h-32 w-32 object-cover rounded-md border border-gray-300"
                    />
                </template>

                <template x-if="!isImage">
                    <x-icon
                        name="file-earmark"
                        class="text-gray-400 text-5xl"
                    />
                </template>

                <p
                    class="text-sm text-gray-700 break-all"
                    x-text="fileName"
                ></p>
            </div>
        </template>

        <!-- Default prompt (hidden when a file is selected) -->
        <div class="flex flex-col items-center gap-2" x-show="!fileName">
            <x-icon
                :name="$icon"
                class="text-gray-400"
            />

            <div class="flex text-sm text-gray-600">
                <label
                    for="{{ $field }}"
                    class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500"
                    @click.stop
                >
                    <span>Upload a file</span>

                    <input
                        id="{{ $field }}"
                        name="{{ $field }}"
                        type="file"
                        class="sr-only"
                        x-ref="fileInput"
                        @click.stop
                        wire:model="{{ $field }}"
                        {{ $attributes->only($inputAttributes) }}
                    >
                </label>

                <p class="pl-1">or drag and drop</p>
            </div>

            @if($help)
                <p class="text-xs text-gray-600">{!! $help !!}</p>
            @endif
        </div>
    </div>
</x-input.wrapper>
