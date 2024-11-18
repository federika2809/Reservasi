<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Reservasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('reservasi.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="id_ruangan" class="block text-gray-700 text-sm font-bold mb-2">Ruangan:</label>
                            <select name="id_ruangan" id="id_ruangan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <option value="">Pilih Ruangan</option>
                                @foreach($ruangan as $room)
                                    <option value="{{ $room->id_ruangan }}" {{ old('id_ruangan') == $room->id_ruangan ? 'selected' : '' }}>
                                        {{ $room->nama_ruangan }} (Kapasitas: {{ $room->kapasitas }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="tanggal_kegiatan" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Kegiatan:</label>
                            <input type="date" name="tanggal_kegiatan" id="tanggal_kegiatan" 
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                   value="{{ old('tanggal_kegiatan') }}" required min="{{ date('Y-m-d') }}">
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="waktu_mulai" class="block text-gray-700 text-sm font-bold mb-2">Waktu Mulai:</label>
                                <input type="time" name="waktu_mulai" id="waktu_mulai" 
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                       value="{{ old('waktu_mulai') }}" required>
                            </div>
                            <div>
                                <label for="waktu_selesai" class="block text-gray-700 text-sm font-bold mb-2">Waktu Selesai:</label>
                                <input type="time" name="waktu_selesai" id="waktu_selesai" 
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                       value="{{ old('waktu_selesai') }}" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="tujuan_kegiatan" class="block text-gray-700 text-sm font-bold mb-2">Tujuan Kegiatan:</label>
                            <textarea name="tujuan_kegiatan" id="tujuan_kegiatan" rows="3" 
                                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                      required>{{ old('tujuan_kegiatan') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="jumlah_peserta" class="block text-gray-700 text-sm font-bold mb-2">Jumlah Peserta:</label>
                            <input type="number" name="jumlah_peserta" id="jumlah_peserta" 
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                   value="{{ old('jumlah_peserta') }}" required min="1">
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Simpan
                            </button>
                            <a href="{{ route('reservasi.index') }}" class="text-gray-600 hover:text-gray-800">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>