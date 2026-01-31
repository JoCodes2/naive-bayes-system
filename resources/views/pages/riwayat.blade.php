@extends('Layouts.Base')

@section('content')
    {{-- Header --}}
<x-base-header
    title="Riwayat Diagnosa"
    icon="fa-solid fa-clock-rotate-left"
/>
    {{-- Body --}}
    <x-base-body
        title="Data Riawayat Diagnosa"
    >
        <div class="py-0">
            {{-- Table --}}
                    {{-- Table --}}
            <x-base-table initId="riwayatTabel" :columns="[
                'No',
                'Tanggal',
                'Nama Pengguna',
                'Inputan (Lgk/Gjl)',
                'Hasil Diagnosa',
                'Kepercayaan',
            ]">
                <tbody>
                    {{-- Data akan diisi oleh riwayat.controller.js --}}
                </tbody>
            </x-base-table>

        </div>
    </x-base-body>

@endsection
@section('scripts')
    <script type="module" src="{{ asset('js/controllers/riwayat.controller.js')}}"></script>
@endsection
