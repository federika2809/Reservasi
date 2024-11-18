<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Ruangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('ruangan.update', $ruangan) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="nama_ruangan" class="block text-gray-700 text-sm font-bold mb-2">Nama Ruangan:</label>
                            <input type="text" name="nama_ruangan" id="nama_ruangan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nama_ruangan') border-red-500 @enderror" value="{{ old('nama_ruangan', $ruangan->nama_ruangan) }}" required>
                            @error('nama_ruangan')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="kapasitas" class="block text-gray-700 text-sm font-bold mb-2">Kapasitas:</label>
                            <input type="number" name="kapasitas" id="kapasitas" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('kapasitas') border-red-500 @enderror" value="{{ old('kapasitas', $ruangan->kapasitas) }}" required>
                            @error('kapasitas')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="fasilitas" class="block text-gray-700 text-sm font-bold mb-2">Fasilitas:</label>
                            <textarea name="fasilitas" id="fasilitas" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('fasilitas') border-red-500 @enderror" required>{{ old('fasilitas', $ruangan->fasilitas) }}</textarea>
                            @error('fasilitas')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Update
                            </button>
                            <a href="{{ route('ruangan.index') }}" class="text-gray-600 hover:text-gray-800">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>