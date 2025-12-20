@extends('admin.layouts.pp')

@section('title','Inbox Pesan')
@section('page-title','Inbox Pesan Masuk')

@section('content')

<div class="overflow-x-auto">
    <table class="w-full border border-white/10 rounded-xl overflow-hidden text-sm">
        <thead class="bg-indigo-500/20 text-indigo-200">
            <tr>
                <th class="px-4 py-3 text-left">Nama</th>
                <th class="px-4 py-3 text-left">Email</th>
                <th class="px-4 py-3 text-left">Telepon</th>
                <th class="px-4 py-3 text-left">Tanggal</th>
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-white/10">

        @forelse($messages as $msg)
            <tr class="hover:bg-white/5 transition">
                <td class="px-4 py-3">{{ $msg->name }}</td>
                <td class="px-4 py-3">{{ $msg->email }}</td>
                <td class="px-4 py-3">{{ $msg->phone }}</td>
                <td class="px-4 py-3">
                    {{ $msg->created_at->format('d M Y H:i') }}
                </td>
                <td class="px-4 py-3 text-center space-x-2">

                    <a href="{{ route('admin.inbox.show', $msg->id) }}"
                       class="inline-flex items-center gap-1 px-3 py-1
                       bg-indigo-500/30 text-indigo-200 rounded-lg
                       hover:bg-indigo-500 transition">
                        <i class="fa fa-eye"></i> Detail
                    </a>

                    <form action="{{ route('admin.inbox.destroy', $msg->id) }}"
                          method="POST" class="inline">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            onclick="return confirm('Hapus pesan ini?')"
                            class="inline-flex items-center gap-1 px-3 py-1
                            bg-red-500/30 text-red-300 rounded-lg
                            hover:bg-red-500 hover:text-white transition">
                            <i class="fa fa-trash"></i> Hapus
                        </button>
                    </form>

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-4 py-6 text-center text-gray-300">
                    📭 Belum ada pesan masuk
                </td>
            </tr>
        @endforelse

        </tbody>
    </table>
</div>

@endsection
