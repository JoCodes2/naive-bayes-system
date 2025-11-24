@extends('Layouts.Base')

@section('content')

<div class="card">

    {{-- Header --}}
    <x-base-header
        title="Data Gejala"
        icon="fa-solid fa-virus"
        :button="['id' => 'btnTambahGejala', 'label' => 'Tambah Daftar Gejala']"
    />

    {{-- Body --}}
    <x-base-body>
        <div class="py-3">
            <h6>Daftar Gejala Tanaman</h6>

            {{-- Table --}}
            <x-base-table :columns="['No', 'Nama Gejala', 'Deskripsi', 'Aksi']">
                <tbody id="gejalaBody">
                    <tr>
                        <td colspan="4" class="text-center">Memuat data...</td>
                    </tr>
                </tbody>
            </x-base-table>

        </div>
    </x-base-body>

</div>

@endsection
