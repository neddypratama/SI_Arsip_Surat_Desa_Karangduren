<?php

use Livewire\Volt\Component;

new class extends Component {
    public array $profile = [
        'nama' => 'Neddy Pratama Wiryawan',
        'nim' => '2141762101',
        'prodi' => 'Sistem Informasi Bisnis',
        'tanggal' => '2025-09-03',
    ];
};
?>

<div class="flex justify-center items-center min-h-screen bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 p-6">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg relative overflow-visible">
        <!-- Background Top -->
        <div class="h-40 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-t-3xl"></div>

        <!-- Profile Image -->
        <div class="absolute -top-16 left-1/2 transform -translate-x-1/2">
            <img src="{{ asset('foto.png') }}" alt="Foto Profil"
                 class="w-40 h-40 rounded-full border-4 border-white shadow-lg object-cover">
        </div>

        <!-- Profile Info -->
        <div class="mt-12 text-center px-6 pb-6">
            <h1 class="text-2xl font-extrabold text-gray-800">{{ $profile['nama'] }}</h1>
            <p class="text-gray-500 mt-1">NIM: {{ $profile['nim'] }}</p>
            <p class="text-gray-500">Prodi: {{ $profile['prodi'] }}</p>
            <p class="text-gray-400 mt-2 text-sm">
                Tanggal dibuat: {{ \Carbon\Carbon::parse($profile['tanggal'])->format('d M Y') }}
            </p>
        </div>
    </div>
</div>
