<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Reservasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between mb-6">
                        <h3 class="text-lg font-semibold">Daftar Reservasi</h3>
                        @if (!Auth::user()->hasRole('admin'))
                            <a href="{{ route('reservasi.create') }}"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Buat Reservasi
                            </a>
                        @endif
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <table class="min-w-full">
                        <thead>
                            <tr>
                                @if (Auth::user()->hasRole('admin'))
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left">Pemohon</th>
                                @endif
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left">Ruangan</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left">Tanggal</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left">Waktu</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left">Status</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($reservasi as $res)
                                <tr>
                                    @if (Auth::user()->hasRole('admin'))
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                            {{ $res->user->nama }}
                                        </td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        {{ $res->ruangan->nama_ruangan }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        {{ $res->tanggal_kegiatan->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        {{ $res->waktu_mulai->format('H:i') }} -
                                        {{ $res->waktu_selesai->format('H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $res->status_verifikasi === 'approved'
                                                ? 'bg-green-100 text-green-800'
                                                : ($res->status_verifikasi === 'rejected'
                                                    ? 'bg-red-100 text-red-800'
                                                    : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ ucfirst($res->status_verifikasi) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        @if (Auth::user()->hasRole('admin'))
                                            @if ($res->status_verifikasi === 'pending')
                                                <button onclick="showVerifikasiModal({{ $res->id_reservasi }})"
                                                    class="text-blue-600 hover:text-blue-900 mr-4">
                                                    Verifikasi
                                                </button>
                                            @endif
                                        @else
                                            @if ($res->status_verifikasi === 'pending')
                                                <a href="{{ route('reservasi.edit', $res) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 mr-4">
                                                    Edit
                                                </a>
                                                <form action="{{ route('reservasi.destroy', $res) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                                        onclick="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?')">
                                                        Batalkan
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $reservasi->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (Auth::user()->usertype == 'admin')
        <!-- Verifikasi Modal -->
        <div id="verifikasiModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form id="verifikasiForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
                                <select name="status_verifikasi" class="shadow
<select name="status_verifikasi"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="approved">Disetujui</option>
                                    <option value="rejected">Ditolak</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Pesan:</label>
                                <textarea name="pesan" rows="3"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    required></textarea>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Simpan
                            </button>
                            <button type="button" onclick="hideVerifikasiModal()"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function showVerifikasiModal(reservasiId) {
                const modal = document.getElementById('verifikasiModal');
                const form = document.getElementById('verifikasiForm');
                form.action = `/reservasi/${reservasiId}/verifikasi`;
                modal.classList.remove('hidden');
            }

            function hideVerifikasiModal() {
                const modal = document.getElementById('verifikasiModal');
                modal.classList.add('hidden');
            }
        </script>
    @endif
</x-app-layout>
