<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Member</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .form-input {
            transition: all 0.3s ease;
        }

        .form-input:focus {
            border-color: #38b2ac;
            outline: none;
            box-shadow: 0 0 0 2px rgba(56, 178, 172, 0.5);
        }

        .button-submit {
            transition: all 0.3s ease;
        }

        .button-submit:hover {
            background: #38a169;
            transform: translateY(-2px);
        }

        .button-submit:active {
            background: #38a169;
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

        <h2 class="text-2xl font-semibold text-center text-gray-900 mb-6">Edit Member</h2>

        <form action="{{ route('member.update', $member->id) }}" method="POST" class="space-y-5" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nama Member -->
            <div class="form-section">
                <label for="nama_member" class="input-label text-sm">Nama Member</label>
                <input type="text" name="nama_member" id="nama_member" value="{{ $member->nama_member }}" required
                    class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-teal-400 focus:border-teal-400 placeholder-gray-400 transition duration-300 ease-in-out">
                @error('nama_member')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Diskon Member -->
            <div class="form-section">
                <label for="diskon_member" class="input-label text-sm">Diskon Member (%)</label>
                <input type="number" step="0.01" name="diskon_member" id="diskon_member" value="{{ $member->diskon_member }}" required
                    class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-teal-400 focus:border-teal-400 placeholder-gray-400 transition duration-300 ease-in-out">
                @error('diskon_member')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Batas Atas Member -->
            <div class="form-section">
                <label for="batas_atas_member" class="input-label text-sm">Batas Atas Member</label>
                <input type="number" name="batas_atas_member" id="batas_atas_member" value="{{ $member->batas_atas_member }}" required
                    class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-teal-400 focus:border-teal-400 placeholder-gray-400 transition duration-300 ease-in-out">
                @error('batas_atas_member')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Batas Bawah Member -->
            <div class="form-section">
                <label for="batas_bawah_member" class="input-label text-sm">Batas Bawah Member</label>
                <input type="number" name="batas_bawah_member" id="batas_bawah_member" value="{{ $member->batas_bawah_member }}" required
                    class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-teal-400 focus:border-teal-400 placeholder-gray-400 transition duration-300 ease-in-out">
                @error('batas_bawah_member')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="mt-5 flex justify-between gap-4">
                <button type="button" class="w-full py-3 px-4 bg-red-600 text-white font-semibold rounded-lg shadow-md transition duration-200 ease-in-out hover:bg-red-700" onclick="window.location='{{ route('member.index') }}'">Cancel</button>
                <button type="submit"
                    class="w-full bg-gray-900 text-white py-3 rounded-lg shadow-md hover:bg-gray-700">
                    Perbarui
                </button>
            </div>
        </form>

    </div>

</body>

</html>
