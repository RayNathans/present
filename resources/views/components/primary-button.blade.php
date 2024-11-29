<button {{ $attributes->merge(['type' => 'submit', 'class' => 'items-center text-center w-full px-4 py-2 bg-blue-500 dark:bg-blue-500 border border-transparent rounded-md font-bold text-white dark:text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-blue-700 focus:bg-gray-700 dark:focus:bg-blue-500 active:bg-gray-900 dark:active:bg-blue-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
