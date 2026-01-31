<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GejalaModel;
use Illuminate\Support\Str;

class GejalaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode' => 'G01', 'nama' => 'Daun bawah menguning', 'kat' => 'daun', 'desc' => 'Menguningnya daun tua (paling bawah), kemudian merambat ke daun muda di atasnya.'],
            ['kode' => 'G02', 'nama' => 'Layu mendadak siang hari', 'kat' => 'umum', 'desc' => 'Tanaman layu saat terik matahari, tetapi tampak segar kembali pada pagi atau sore hari.'],
            ['kode' => 'G03', 'nama' => 'Daun keriting melengkung ke atas', 'kat' => 'daun', 'desc' => 'Tepi daun melipat ke atas seperti perahu, tekstur daun biasanya kaku.'],
            ['kode' => 'G04', 'nama' => 'Daun keriting melengkung ke bawah', 'kat' => 'daun', 'desc' => 'Daun mengerut dan melengkung ke bawah, seringkali warna daun menjadi lebih gelap.'],
            ['kode' => 'G05', 'nama' => 'Bercak bulat konsentris di daun', 'kat' => 'daun', 'desc' => 'Bercak coklat kecil melingkar seperti target panah dengan pusat berwarna abu-abu.'],
            ['kode' => 'G06', 'nama' => 'Daun mosaik (kuning-hijau)', 'kat' => 'daun', 'desc' => 'Warna daun tidak merata, terdapat pola bercak kuning terang yang bercampur hijau.'],
            ['kode' => 'G07', 'nama' => 'Sisi bawah daun keperakan', 'kat' => 'daun', 'desc' => 'Permukaan bawah daun berwarna mengkilap seperti perak akibat isapan hama.'],
            ['kode' => 'G08', 'nama' => 'Daun berlubang tidak teratur', 'kat' => 'daun', 'desc' => 'Terdapat bekas gigitan di pinggir atau tengah daun hingga tersisa tulang daunnya saja.'],
            ['kode' => 'G09', 'nama' => 'Bercak cekung coklat pada buah', 'kat' => 'buah', 'desc' => 'Buah membusuk kering dengan lubang cekung berbentuk lingkaran yang meluas.'],
            ['kode' => 'G10', 'nama' => 'Buah busuk benyek dan berair', 'kat' => 'buah', 'desc' => 'Jaringan buah hancur, menjadi sangat lembek dan berisi cairan keruh.'],
            ['kode' => 'G11', 'nama' => 'Adanya kotoran atau telur hama', 'kat' => 'umum', 'desc' => 'Ditemukan butiran hitam kecil atau gumpalan telur di permukaan bawah daun.'],
            ['kode' => 'G12', 'nama' => 'Batang menghitam dan busuk', 'kat' => 'batang', 'desc' => 'Bagian batang dekat tanah atau percabangan berubah warna menjadi coklat tua/hitam.'],
            ['kode' => 'G13', 'nama' => 'Lendir putih pada batang terpotong', 'kat' => 'batang', 'desc' => 'Saat batang dipotong dan dimasukkan ke air, keluar cairan putih seperti kabut/lendir.'],
            ['kode' => 'G14', 'nama' => 'Tanaman kerdil (stunting)', 'kat' => 'umum', 'desc' => 'Jarak antar buku daun sangat pendek, tanaman tidak bisa tumbuh tinggi secara normal.'],
            ['kode' => 'G15', 'nama' => 'Tanaman layu permanen', 'kat' => 'umum', 'desc' => 'Tanaman tetap layu meskipun sudah disiram atau waktu sudah sore, berakhir mati.'],
            ['kode' => 'G16', 'nama' => 'Bunga atau buah muda rontok', 'kat' => 'umum', 'desc' => 'Tangkai bunga/buah menguning lalu lepas sebelum berkembang sempurna.'],
            ['kode' => 'G17', 'nama' => 'Akar tanaman busuk kecokelatan', 'kat' => 'akar', 'desc' => 'Akar yang seharusnya putih berubah menjadi coklat, lunak, dan mudah terkelupas.'],
            ['kode' => 'G18', 'nama' => 'Buah rontok dan berlubang kecil', 'kat' => 'buah', 'desc' => 'Terdapat titik hitam bekas tusukan serangga, buah sering jatuh sebelum matang.'],
            ['kode' => 'G19', 'nama' => 'Tulang daun pucat (Veklorosis)', 'kat' => 'daun', 'desc' => 'Tulang-tulang daun kehilangan warna hijau dan berubah menjadi putih atau kuning.'],
            ['kode' => 'G20', 'nama' => 'Daun terasa tebal dan kaku', 'kat' => 'daun', 'desc' => 'Daun menjadi sangat keras saat diraba dan mudah patah jika dilipat.'],
            ['kode' => 'G21', 'nama' => 'Bau busuk menyengat', 'kat' => 'umum', 'desc' => 'Tercium aroma tidak sedap yang tajam di area tanaman yang membusuk (khas bakteri).'],
            ['kode' => 'G22', 'nama' => 'Batang rapuh dan mudah patah', 'kat' => 'batang', 'desc' => 'Kekuatan batang berkurang drastis akibat jaringan dalam yang rusak/keropos.'],
            ['kode' => 'G23', 'nama' => 'Daun layu mulai dari pucuk', 'kat' => 'daun', 'desc' => 'Gejala kelayuan yang berawal dari daun paling muda (pucuk tanaman).'],
            ['kode' => 'G24', 'nama' => 'Pertumbuhan tunas baru terhenti', 'kat' => 'umum', 'desc' => 'Titik tumbuh atau pucuk tanaman mati/mengering (dieback).'],
            ['kode' => 'G25', 'nama' => 'Benang halus sarang laba-laba', 'kat' => 'umum', 'desc' => 'Terdapat jaring-jaring halus di sela daun/batang, tanda serangan tungau.'],
        ];

        foreach ($data as $item) {
            GejalaModel::updateOrCreate(
                ['kode_gejala' => $item['kode']],
                [
                    'id' => (string) Str::uuid(),
                    'nama_gejala' => $item['nama'],
                    'kategori' => $item['kat'],
                    'deskripsi' => $item['desc'],
                ]
            );
        }
    }
}
