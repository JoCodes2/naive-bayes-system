<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PenyakitModel;
use Illuminate\Support\Str;

class PenyakitSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'kode_penyakit' => 'P01',
                'nama_penyakit' => 'Layu Fusarium',
                'deskripsi' => 'Penyakit akibat jamur Fusarium oxysporum yang menyerang jaringan pembuluh tanaman, menyebabkan layu permanen dan kematian.',
                'solusi_treatment' => "1. Cabut dan bakar tanaman yang terinfeksi total.\n2. Kocor pangkal batang dengan fungisida sistemik (Benomil).\n3. Aplikasikan agen hayati Trichoderma pada lubang tanam.\n4. Kurangi penggunaan pupuk Nitrogen (Urea) berlebih.",
                'pencegahan' => 'Gunakan benih tahan layu, rotasi tanaman non-cabai, dan pastikan pH tanah tetap netral (5.5-7).',
            ],
            [
                'kode_penyakit' => 'P02',
                'nama_penyakit' => 'Embun Tepung (Powdery Mildew)',
                'deskripsi' => 'Munculnya lapisan putih menyerupai tepung pada permukaan daun akibat jamur Oidium sp, menghambat fotosintesis.',
                'solusi_treatment' => "1. Semprotkan fungisida berbahan aktif belerang (Sulfur) atau klorotalonil.\n2. Lakukan perempelan daun yang sudah tertutup embun tepung.\n3. Pastikan tanaman mendapatkan sinar matahari cukup.\n4. Semprot di pagi hari agar daun cepat kering.",
                'pencegahan' => 'Atur jarak tanam agar sirkulasi udara lancar dan hindari penanaman di tempat yang terlalu teduh.',
            ],
            [
                'kode_penyakit' => 'P03',
                'nama_penyakit' => 'Virus Kuning (Bule)',
                'deskripsi' => 'Penyakit akibat Virus Gemini yang dibawa oleh kutu kebul, menyebabkan daun menguning cerah dan mengerut.',
                'solusi_treatment' => "1. Kendalikan vektor (Kutu Kebul) dengan insektisida Abamektin.\n2. Berikan pupuk mikro (Zn, Fe) untuk memperkuat daya tahan.\n3. Cabut tanaman kerdil agar tidak menular ke tanaman sehat.\n4. Pasang perangkat kuning (yellow trap) di sekitar lahan.",
                'pencegahan' => 'Tanam varietas tahan virus, gunakan mulsa plastik perak, dan bersihkan gulma inang di sekitar lahan.',
            ],
            [
                'kode_penyakit' => 'P04',
                'nama_penyakit' => 'Layu Bakteri',
                'deskripsi' => 'Disebabkan bakteri Ralstonia solanacearum, ditandai layu mendadak pada siang hari dan keluar lendir putih pada batang.',
                'solusi_treatment' => "1. Segera cabut tanaman dan buang jauh dari lahan.\n2. Kocor lubang tanam dengan bakterisida (Streptomisin).\n3. Taburkan kapur dolomit untuk menaikkan pH tanah.\n4. Sterilisasi alat pertanian setelah kontak dengan tanaman sakit.",
                'pencegahan' => 'Perbaiki drainase lahan (jangan biarkan air menggenang) dan gunakan pupuk organik yang sudah terdekomposisi sempurna.',
            ],
            [
                'kode_penyakit' => 'P05',
                'nama_penyakit' => 'Antraknosa (Patek)',
                'deskripsi' => 'Penyakit jamur Colletotrichum yang menyebabkan busuk kering pada buah berupa bercak melingkar cekung ke dalam.',
                'solusi_treatment' => "1. Petik dan musnahkan buah yang terkena bercak.\n2. Semprot fungisida kontak (Mankozeb) atau sistemik (Difenokonazol).\n3. Hindari penyemprotan air ke tajuk saat malam hari.\n4. Gunakan kalsium untuk memperkuat dinding sel buah.",
                'pencegahan' => 'Gunakan benih berkualitas, jangan menanam di musim hujan ekstrem tanpa naungan plastik (greenhouse).',
            ],
            [
                'kode_penyakit' => 'P06',
                'nama_penyakit' => 'Bercak Daun (Cercospora)',
                'deskripsi' => 'Muncul bercak kecil berbentuk bulat dengan pusat warna abu-abu pada daun, menyebabkan kerontokan daun hebat.',
                'solusi_treatment' => "1. Lakukan sanitasi lahan dari sisa-sisa daun yang gugur.\n2. Semprot fungisida berbahan aktif Tembaga Hidroksida.\n3. Kurangi kelembapan di sekitar tajuk tanaman.\n4. Berikan nutrisi daun untuk mempercepat pemulihan jaringan.",
                'pencegahan' => 'Jaga kebersihan lahan dan hindari penggunaan air permukaan (parit) yang tercemar untuk penyiraman.',
            ],
            [
                'kode_penyakit' => 'P07',
                'nama_penyakit' => 'Hama Thrips (Keriting Daun)',
                'deskripsi' => 'Serangan serangga kecil yang menghisap cairan daun, menyebabkan daun mengeriting ke atas dan berwarna keperakan.',
                'solusi_treatment' => "1. Semprot insektisida berbahan aktif Imidakloprid atau Fipronil.\n2. Lakukan penyemprotan di pagi atau sore hari saat hama aktif.\n3. Bersihkan sela-sela pucuk daun saat menyemprot.\n4. Gunakan minyak mimba sebagai penolak hama (repellent).",
                'pencegahan' => 'Pasang mulsa perak untuk memantulkan cahaya matahari yang dibenci thrips dan lakukan pergiliran tanaman.',
            ],
            [
                'kode_penyakit' => 'P08',
                'nama_penyakit' => 'Bercak Bakteri (Xanthomonas)',
                'deskripsi' => 'Penyakit Xanthomonas campestris yang menyebabkan bercak hitam kecil berair pada daun dan buah.',
                'solusi_treatment' => "1. Semprotkan bakterisida berbahan aktif Tembaga Sulfat.\n2. Kurangi jarak tanam agar tajuk tidak saling bersentuhan.\n3. Pastikan tangan bersih saat melakukan pemangkasan.\n4. Buang bagian tanaman yang terinfeksi berat.",
                'pencegahan' => 'Hindari penyiraman model percik (overhead) dan gunakan benih yang bebas bakteri (certified seeds).',
            ],
            [
                'kode_penyakit' => 'P09',
                'nama_penyakit' => 'Mosaik Virus',
                'deskripsi' => 'Serangan virus CMV yang menyebabkan daun memiliki pola mosaik hijau tua dan muda serta bentuk daun tidak rata.',
                'solusi_treatment' => "1. Musnahkan tanaman yang menunjukkan gejala mosaik berat.\n2. Kendalikan hama penghisap (Kutu Daun/Aphis) sebagai pembawa.\n3. Tingkatkan aplikasi kalium (K) untuk daya tahan tanaman.\n4. Jangan merokok di dekat tanaman karena virus bisa menular lewat tangan.",
                'pencegahan' => 'Sterilisasi tangan dan alat kerja, serta kendalikan gulma rumput-rumputan sebagai inang alternatif virus.',
            ],
            [
                'kode_penyakit' => 'P10',
                'nama_penyakit' => 'Busuk Phytophthora',
                'deskripsi' => 'Jamur Phytophthora capsici menyerang seluruh bagian tanaman, menyebabkan busuk basah kehitaman pada batang dan daun.',
                'solusi_treatment' => "1. Turunkan kelembapan tanah dengan memperbaiki saluran air.\n2. Semprot fungisida berbahan aktif Metalaksil atau Fosetil Aluminium.\n3. Berikan penutup plastik pada bedengan jika hujan turun terus menerus.\n4. Oleskan pasta fungisida pada batang yang membusuk.",
                'pencegahan' => 'Hindari menanam cabai secara terus-menerus di lahan yang sama dan pastikan jarak tanam tidak terlalu rapat.',
            ],
        ];

        foreach ($data as $item) {
            PenyakitModel::updateOrCreate(
                ['kode_penyakit' => $item['kode_penyakit']],
                [
                    'id' => (string) Str::uuid(),
                    'nama_penyakit' => $item['nama_penyakit'],
                    'deskripsi' => $item['deskripsi'],
                    'solusi_treatment' => $item['solusi_treatment'],
                    'pencegahan' => $item['pencegahan'],
                ]
            );
        }
    }
}
