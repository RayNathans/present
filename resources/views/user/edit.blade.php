<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
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

<body class="bg-gray-50 flex justify-center items-center min-h-screen p-8">

    <div class="w-full max-w-lg p-6 bg-white rounded-lg card-shadow">

        <h2 class="text-2xl font-semibold text-center text-gray-900 mb-6">Edit User</h2>

        <form action="{{ route('user.update', $user->id) }}" method="POST" class="space-y-5" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nama -->
            <div class="form-section">
                <label for="name" class="input-label text-sm">Nama</label>
                <input type="text" name="name" id="name" value="{{ $user->name }}" required class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-teal-400 focus:border-teal-400 placeholder-gray-400 transition duration-300 ease-in-out">
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-section">
                <label for="email" class="input-label text-sm">Email</label>
                <input type="email" name="email" id="email" value="{{ $user->email }}" required class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-teal-400 focus:border-teal-400 placeholder-gray-400 transition duration-300 ease-in-out">
                @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role -->
            <div class="form-section">
                <label for="id_role" class="input-label text-sm">Role</label>
                <select name="id_role" id="id_role" required class="form-input w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-teal-400 focus:border-teal-400 placeholder-gray-400 transition duration-300 ease-in-out">
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ $role->id == $user->id_role ? 'selected' : '' }}>{{ $role->nama_role }}</option>
                    @endforeach
                </select>
                @error('id_role')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="mt-5 flex justify-between gap-4">
                <button type="button" class="w-full py-3 px-4 bg-red-600 text-white font-semibold rounded-lg shadow-md transition duration-200 ease-in-out hover:bg-red-700" onclick="window.location='{{ route('user.index') }}'">Kembali</button>
                <button type="submit" class="w-full bg-gray-900 text-white py-3 rounded-lg shadow-md hover:bg-gray-700">
                    Update
                </button>
            </div>
        </form>

    </div>

</body>

</html>
