<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .form-input {
            transition: all 0.3s ease;
        }

        .form-input:focus {
            border-color: #63b3ed;
            outline: none;
            box-shadow: 0 0 0 2px rgba(99, 179, 237, 0.5);
        }

        .button-submit {
            transition: all 0.3s ease;
        }

        .button-submit:hover {
            background: #2b6cb0;
            transform: translateY(-2px);
        }

        .button-submit:active {
            background: #2b6cb0;
            transform: translateY(2px);
        }

        .card-shadow {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .input-label {
            font-weight: 500;
            color: #4A5568;
        }

        .form-section {
            margin-bottom: 15px;
        }
    </style>
</head>

<body class="bg-gray-50 flex justify-center items-center min-h-screen">

    <div class="w-full max-w-md p-6 bg-white rounded-lg card-shadow">

        <h2 class="text-2xl font-semibold text-center text-gray-900 mb-6">Edit Pelanggan</h2>

        <form action="{{ route('pelanggan.update', $pelanggan->id) }}" method="POST" class="space-y-5" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nama Pelanggan -->
            <div class="form-section">
                <label for="nama_pelanggan" class="input-label text-sm">Nama Pelanggan</label>
                <input type="text" name="nama_pelanggan" id="nama_pelanggan" value="{{ $pelanggan->nama_pelanggan }}" required
                    class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400 transition duration-300 ease-in-out">
            </div>

            <!-- Social Media (noWA) -->
            <div class="form-section">
                <label for="noWA" class="input-label text-sm">Social Media</label>
                <input type="text" name="noWA" id="noWA" value="{{ $pelanggan->noWA }}" required
                    class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400 transition duration-300 ease-in-out">
                @error('noWA')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Progress Transaksi -->
            <div class="form-section">
                <label for="progressTransaksi" class="input-label text-sm">Progress Transaksi</label>
                <input type="text" name="progressTransaksi" id="progressTransaksi" value="{{ $pelanggan->progressTransaksi }}" required
                    class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 placeholder-gray-400 transition duration-300 ease-in-out">
            </div>

            <!-- Member Dropdown -->
            <div class="form-section">
                <label for="id_member" class="input-label text-sm">Member</label>
                <select name="id_member" id="id_member"
                    class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition duration-300 ease-in-out">
                    <option value="">Pilih Member</option>
                    @foreach ($members as $member)
                    <option value="{{ $member->id }}" {{ $pelanggan->id_member == $member->id ? 'selected' : '' }}>
                        {{ $member->nama_member }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Status Dropdown -->
            <div class="form-section">
                <label for="status" class="input-label text-sm">Status</label>
                <select name="status" id="status"
                    class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition duration-300 ease-in-out">
                    <option value="1" {{ $pelanggan->status == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ $pelanggan->status == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="mt-5 flex justify-between gap-4">
                <button type="button" class="w-full py-3 px-4 bg-red-600 text-white font-semibold rounded-lg shadow-md transition duration-200 ease-in-out hover:bg-red-700"
                    onclick="window.location='{{ route('pelanggan.index') }}'">Cancel</button>
                <button type="submit"
                    class="w-full bg-gray-900 text-white py-3 rounded-lg shadow-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 transition duration-300 ease-in-out transform hover:scale-105">
                    Perbarui
                </button>
            </div>
        </form>

    </div>

</body>

</html>
