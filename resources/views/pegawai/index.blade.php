<x-app-layout>
    <x-slot name="header">
        Master Data Pegawai
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Action Button -->
        <div class="mb-4 flex justify-end">
            <a href="{{ route('pegawai.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 text-sm flex items-center shadow">
                <i class="fas fa-plus mr-2"></i> Tambah Pegawai
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 uppercase text-xs leading-normal">
                                <th class="py-3 px-6">Nama Pegawai</th>
                                <th class="py-3 px-6">Username</th>
                                <th class="py-3 px-6">Jabatan</th>
                                <th class="py-3 px-6">No HP</th>
                                <th class="py-3 px-6 text-center">Status</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @forelse($pegawai as $p)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 font-medium text-gray-800">
                                    {{ $p->nama_pegawai }}
                                    @if($p->tim_syiar)
                                        <br><span class="text-xs text-gray-500">Tim: {{ $p->tim_syiar }}</span>
                                    @endif
                                </td>
                                <td class="py-3 px-6">{{ $p->username }}</td>
                                <td class="py-3 px-6">{{ $p->jabatan ?? '-' }}</td>
                                <td class="py-3 px-6">{{ $p->no_hp ?? '-' }}</td>
                                <td class="py-3 px-6 text-center">
                                    @if($p->status == 'AKTIF')
                                        <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs font-bold">AKTIF</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-xs font-bold">TIDAK AKTIF</span>
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center">
                                        <a href="{{ route('pegawai.edit', $p->id_pegawai) }}" class="w-4 mr-2 transform hover:text-yellow-500 hover:scale-110" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('pegawai.destroy', $p->id_pegawai) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus pegawai ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-4 mr-2 transform hover:text-red-500 hover:scale-110" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-6 px-6 text-center text-gray-500">
                                    Belum ada data pegawai.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $pegawai->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
