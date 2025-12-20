@extends('admin.layouts.pp')

@section('title','Detail Pesan')
@section('page-title','Detail Pesan')

@section('content')

<div class="bg-white/10 backdrop-blur-xl border border-white/10
    rounded-2xl p-6 shadow-xl max-w-6xl">

    <h4 class="text-xl font-semibold mb-4 flex items-center gap-2">
        <i class="fa-solid fa-envelope-open-text text-indigo-400"></i>
        Detail Pesan Masuk
    </h4>

    <div class="space-y-4 text-sm">
        <div>
            <span class="text-gray-300">Nama</span>
            <div class="font-medium">{{ $message->name }}</div>
        </div>

        <div>
            <span class="text-gray-300">Email</span>
            <div class="font-medium">{{ $message->email }}</div>
        </div>

        <div>
            <span class="text-gray-300">No Telepon</span>
            <div class="font-medium">{{ $message->phone }}</div>
        </div>

        <div>
            <span class="text-gray-300">Pesan</span>
            <div class="mt-2 p-4 rounded-lg bg-white/5 border border-white/10">
                {{ $message->message }}
            </div>
        </div>
    </div>

    <div class="flex gap-3 mt-6">
        <a href="{{ route('admin.inbox.index') }}"
           class="px-4 py-2 bg-gray-500/20 text-gray-300 rounded-lg
           hover:bg-gray-500 hover:text-white transition">
            ← Kembali
        </a>

        <a href="https://wa.me/{{ preg_replace('/[^0-9]/','',$message->phone) }}"
           target="_blank"
           class="px-4 py-2 bg-green-500/20 text-green-300 rounded-lg
           hover:bg-green-500 hover:text-white transition flex items-center gap-2">
            <i class="fa-brands fa-whatsapp"></i>
            Balas WhatsApp
        </a>
    </div>

</div>

@endsection
