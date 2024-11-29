@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge([
        'class' =>
            'dark:bg-transparent dark:bg-border-gray-300 dark:text-white w-full rounded-md shadow-sm border-2 border-white py-1 px-1 text-sm',
    ]) }}>
