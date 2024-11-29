<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans">

    <div class="flex min-h-screen items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-lg bg-white p-8 rounded-2xl shadow-xl">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-8">Tambah Pelanggan</h2>

            <form action="{{ route('pelanggan.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf

                <!-- Nama Pelanggan -->
                <div>
                    <label for="nama_pelanggan" class="block text-gray-700 text-sm font-medium">Nama Pelanggan</label>
                    <input type="text" name="nama_pelanggan" id="nama_pelanggan" required
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Social Media (noWA) -->
                <div>
                    <label for="noWA" class="block text-gray-700 text-sm font-medium">Social Media</label>
                    <input type="text" name="noWA" id="noWA" 
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('noWA')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Progress Transaksi -->
                <div>
                    <label for="progressTransaksi" class="block text-gray-700 text-sm font-medium">Progress Transaksi</label>
                    <input type="text" name="progressTransaksi" id="progressTransaksi"
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Select Member -->
                <div>
                    <label for="id_member" class="block text-gray-700 text-sm font-medium">Member</label>
                    <select name="id_member" id="id_member" 
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Member</option>
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}">{{ $member->nama_member }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="mt-6 flex justify-between gap-4">
                    <button type="button" class="w-full py-3 px-4 bg-red-600 text-white font-semibold rounded-lg shadow-md transition duration-200 ease-in-out hover:bg-red-700" onclick="window.location='{{ route('pelanggan.index') }}'">Cancel</button>
                    <button type="submit"
                        class="w-full py-3 px-4 bg-gray-900 text-white font-semibold rounded-lg shadow-md transition duration-200 ease-in-out hover:bg-gray-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
