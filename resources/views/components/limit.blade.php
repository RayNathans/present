<div>
    <form action="{{ route($route) }}" method="GET" class="flex items-center">
        <label for="limit" class="text-gray-700 mr-2">Show:</label>
        <select name="limit" id="limit" onchange="this.form.submit()"
            class="border border-gray-300 rounded-lg px-4 py-2 shadow mr-2">
            @foreach ($limitOptions as $option)
                <option value="{{ $option }}" {{ request('limit') == $option ? 'selected' : '' }}>
                    {{ $option }}</option>
            @endforeach
        </select>

        <!-- Tambahkan parameter search ke URL -->
        <input type="hidden" name="search" value="{{ request('search') }}">
    </form>
</div>
