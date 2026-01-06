<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

class PenyakitSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $data = [
            [
                'kode_penyakit' => 'P001',
                'nama_penyakit' => 'Antraknosa (Patek)',
                'deskripsi' => 'Infeksi jamur Colletotrichum yang menyerang buah cabai, ditandai dengan bercak melingkar cekung seperti terbakar.',
                'solusi_perawatan' => "1. Semprot fungisida berbahan aktif Mankozeb atau Tembaga Hidroksida.\n2. Cabut dan buang buah yang busuk jauh dari lahan.\n3. Kurangi pemupukan Nitrogen tinggi.",
                'tindakan_pencegahan' => "1. Gunakan mulsa plastik.\n2. Atur jarak tanam agar sirkulasi udara lancar.\n3. Gunakan benih tahan (resisten).",
                'faktor_risiko' => 'Kelembapan >80%, curah hujan tinggi, suhu 25-30°C'
            ],
            [
                'kode_penyakit' => 'P002',
                'nama_penyakit' => 'Layu Fusarium',
                'deskripsi' => 'Penyakit tular tanah yang menyebabkan tanaman layu perlahan diawali dari daun bagian bawah hingga seluruh tanaman mengering.',
                'solusi_perawatan' => "1. Kucur tanaman dengan agen hayati Trichoderma.\n2. Cabut tanaman yang sakit agar tidak menular melalui akar.\n3. Berikan kapur dolomit untuk menaikkan pH tanah.",
                'tindakan_pencegahan' => "1. Perbaiki drainase agar air tidak menggenang.\n2. Rotasi tanaman dengan keluarga padi-padian.\n3. Pastikan pH tanah ideal (6-7).",
                'faktor_risiko' => 'Tanah asam (pH rendah), genangan air, suhu tanah panas.'
            ],
            [
                'kode_penyakit' => 'P003',
                'nama_penyakit' => 'Layu Bakteri',
                'deskripsi' => 'Tanaman layu mendadak secara keseluruhan (hijau layu). Jika batang dipotong, keluar lendir putih keruh.',
                'solusi_perawatan' => "1. Semprot dengan bakterisida (Streptomisin).\n2. Isolasi tanaman yang terinfeksi.\n3. Kurangi penyiraman yang berlebihan.",
                'tindakan_pencegahan' => "1. Sterilisasi alat pertanian.\n2. Gunakan benih sehat.\n3. Jangan biarkan air mengalir dari area sakit ke area sehat.",
                'faktor_risiko' => 'Luka pada akar, suhu udara tinggi, tanah sangat lembap.'
            ],
            [
                'kode_penyakit' => 'P004',
                'nama_penyakit' => 'Virus Kuning (Bule)',
                'deskripsi' => 'Disebabkan oleh virus Gemini yang dibawa kutu kebul. Daun berubah warna menjadi kuning terang dan mengerut.',
                'solusi_perawatan' => "1. Tidak ada obat virus, segera cabut tanaman agar tidak jadi sumber penularan.\n2. Kendalikan vektor (kutu kebul) dengan insektisida.\n3. Berikan pupuk daun untuk menjaga daya tahan.",
                'tindakan_pencegahan' => "1. Pasang perangkap kuning (Yellow Trap).\n2. Tanam tanaman pagar (Jagung) di sekeliling lahan.\n3. Kendalikan gulma.",
                'faktor_risiko' => 'Populasi Kutu Kebul tinggi, musim kemarau, kebersihan lahan buruk.'
            ],
            [
                'kode_penyakit' => 'P005',
                'nama_penyakit' => 'Bercak Daun (Cercospora)',
                'deskripsi' => 'Muncul bercak bulat kecil berwarna coklat dengan titik putih di tengah pada daun.',
                'solusi_perawatan' => "1. Semprot fungisida berbahan aktif Difenokonazol.\n2. Buang daun tua yang terinfeksi.\n3. Kurangi penyiraman di atas tanaman (gunakan irigasi tetes).",
                'tindakan_pencegahan' => "1. Bersihkan sisa tanaman musim lalu.\n2. Jangan menanam terlalu rapat.\n3. Pemupukan berimbang.",
                'faktor_risiko' => 'Daun basah terlalu lama, sirkulasi udara buruk.'
            ],
            [
                'kode_penyakit' => 'P006',
                'nama_penyakit' => 'Hama Thrips (Keriting Daun)',
                'deskripsi' => 'Hama yang menghisap cairan daun, menyebabkan daun mengeriting ke atas dan terdapat warna perak di bawah daun.',
                'solusi_perawatan' => "1. Semprot insektisida berbahan aktif Abamektin.\n2. Gunakan pestisida nabati (asap cair/daun mimba).\n3. Berikan air yang cukup untuk memulihkan tanaman.",
                'tindakan_pencegahan' => "1. Pantau populasi thrips sejak dini.\n2. Gunakan mulsa perak untuk memantulkan cahaya matahari.",
                'faktor_risiko' => 'Cuaca panas kering, kurang air, lingkungan berdebu.'
            ],
            [
                'kode_penyakit' => 'P007',
                'nama_penyakit' => 'Busuk Phytophthora',
                'deskripsi' => 'Busuk basah pada pangkal batang atau buah. Tanaman mati mendadak dengan batang yang menghitam.',
                'solusi_perawatan' => "1. Semprot fungisida sistemik berbahan aktif Metalaksil.\n2. Perbaiki bedengan yang ambles.\n3. Hentikan penyiraman sementara.",
                'tindakan_pencegahan' => "1. Bedengan harus cukup tinggi (min 30cm).\n2. Jangan gunakan pupuk kandang yang belum matang.",
                'faktor_risiko' => 'Musim hujan ekstrem, tanah liat/berat, kelembapan ekstrem.'
            ],
            [
                'kode_penyakit' => 'P008',
                'nama_penyakit' => 'Mosaik Virus',
                'deskripsi' => 'Daun memiliki corak belang hijau tua dan muda, ukuran daun mengecil dan bentuknya tidak beraturan.',
                'solusi_perawatan' => "1. Tidak bisa disembuhkan, cabut tanaman.\n2. Kendalikan kutu daun (Aphids).\n3. Sterilkan tangan setelah memegang tanaman sakit.",
                'tindakan_pencegahan' => "1. Bersihkan gulma di sekitar lahan.\n2. Pilih varietas benih yang tahan virus.",
                'faktor_risiko' => 'Serangan kutu daun (Aphids), alat potong tidak steril.'
            ],
            [
                'kode_penyakit' => 'P009',
                'nama_penyakit' => 'Embun Tepung (Powdery Mildew)',
                'deskripsi' => 'Muncul lapisan seperti tepung putih di permukaan bawah daun, menyebabkan daun menguning dan gugur.',
                'solusi_perawatan' => "1. Semprot fungisida berbahan aktif Belerang (Sulfur).\n2. Pangkas bagian yang terserang parah.\n3. Tambah asupan sinar matahari.",
                'tindakan_pencegahan' => "1. Jarak tanam tidak boleh terlalu rapat.\n2. Lahan harus terpapar sinar matahari penuh.",
                'faktor_risiko' => 'Suhu sejuk namun kering di atas daun, kurang cahaya matahari.'
            ],
            [
                'kode_penyakit' => 'P010',
                'nama_penyakit' => 'Bercak Bakteri (Xanthomonas)',
                'deskripsi' => 'Bercak hitam tidak beraturan pada daun dan buah. Terlihat seperti kerak kasar jika sudah parah.',
                'solusi_perawatan' => "1. Semprot bakterisida berbahan tembaga (Copper).\n2. Kurangi pemupukan Nitrogen.\n3. Hindari masuk ke lahan saat tanaman masih basah embun.",
                'tindakan_pencegahan' => "1. Pastikan benih bebas bakteri (perlakuan air panas).\n2. Sanitasi lahan secara total.",
                'faktor_risiko' => 'Embun pagi yang lama, angin kencang disertai hujan.'
            ],
        ];

        $finalData = [];
        foreach ($data as $item) {
            $item['id'] = Uuid::uuid4()->toString();
            $item['created_at'] = $now;
            $item['updated_at'] = $now;
            $finalData[] = $item;
        }

        DB::table('penyakit')->insert($finalData);
    }
}
