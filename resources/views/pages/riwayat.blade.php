@extends('Layouts.Base')

@section('content')
    {{-- Header --}}
<x-base-header
    title="Riwayat Diagnosa"
    icon="fa-solid fa-virus"
/>
    {{-- Body --}}
    <x-base-body
        title="Data Riawayat Diagnosa"
    >
        <div class="py-0">
            {{-- Table --}}
            <x-base-table initId="riwayatTabel" :columns="['No', 'Tanggal Diagnosa', 'Kondisi Lingkungan', 'Gejala Tanaman','Hasil Diagnosa ','Tingkat Kepercayaan', 'Rekomendasi Perawatan', 'Rekomendasi Pencegahan', 'Catatan Tambahan']">
                <tbody>

                </tbody>
            </x-base-table>

        </div>
    </x-base-body>
@endsection
@section('scripts')
    <script type="module" src="{{ asset('js/controllers/riwayat.controller.js')}}"></script>
@endsection
