<div>
    <form action="{{ route($route) }}" method="GET" class="flex items-center">
        <input type="text" name="search" placeholder="Cari..." value="{{ request('search') }}"
            class="px-4 py-2 bg-white rounded-lg shadow focus:outline-none">

        <!-- Tambahkan parameter limit ke URL -->
        <input type="hidden" name="limit" value="{{ request('limit', 5) }}">

        <button type="submit"
            class="bg-gray-900 text-white px-4 py-2 ml-2 rounded-lg shadow hover:bg-gray-700 transition duration-200">Cari</button>
    </form>
</div>
