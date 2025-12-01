<?php
// database/seeders/PenyakitSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class PenyakitSeeder extends Seeder
{
    public function run(): void
    {
        $penyakit = [
            [
                'id' => Uuid::uuid4(),
                'kode_penyakit' => 'P001',
                'nama_penyakit' => 'Antraknosa (Busuk Buah)',
                'deskripsi' => 'Penyakit busuk buah yang disebabkan oleh jamur Colletotrichum spp. Menyebabkan bercak cekung pada buah dengan warna hitam atau coklat.',
                'solusi_perawatan' => "1. Semprot fungisida seperti Antracol atau Dithane M-45\n2. Buang dan musnahkan buah yang terinfeksi\n3. Berikan pupuk kalium untuk meningkatkan ketahanan tanaman\n4. Kurangi kelembapan dengan pengaturan jarak tanam",
                'tindakan_pencegahan' => "1. Gunakan benih yang sehat dan bersertifikat\n2. Lakukan rotasi tanaman minimal 2 tahun\n3. Pasang mulsa plastik untuk mengurangi percikan air tanah\n4. Hindari penyiraman di atas daun dan buah",
                'faktor_risiko' => 'Kelembapan tinggi (>80%), curah hujan tinggi, suhu 25-30°C'
            ],
            [
                'id' => Uuid::uuid4(),
                'kode_penyakit' => 'P002',
                'nama_penyakit' => 'Layu Fusarium',
                'deskripsi' => 'Penyakit layu yang disebabkan oleh jamur Fusarium oxysporum. Tanaman layu secara tiba-tiba meskipun cukup air, dimulai dari daun bawah.',
                'solusi_perawatan' => "1. Cabut dan bakar tanaman yang terinfeksi\n2. Berikan fungisida sistemik seperti Benlate\n3. Tingkatkan pH tanah dengan kapur pertanian\n4. Berikan pupuk organik untuk memperbaiki struktur tanah",
                'tindakan_pencegahan' => "1. Gunakan varietas tahan layu\n2. Sterilisasi media tanam dengan solarisasi\n3. Perbaiki drainase lahan\n4. Hindari penanaman di tanah yang pernah terinfeksi",
                'faktor_risiko' => 'Tanah asam (pH < 5.5), drainase buruk, suhu tanah tinggi'
            ],
            [
                'id' => Uuid::uuid4(),
                'kode_penyakit' => 'P003',
                'nama_penyakit' => 'Bercak Daun Cercospora',
                'deskripsi' => 'Penyakit bercak daun yang disebabkan oleh jamur Cercospora capsici. Bercak kecil bulat berwarna coklat dengan pinggiran kuning.',
                'solusi_perawatan' => "1. Semprot fungisida seperti Daconil atau Antracol\n2. Pangkas daun yang terinfeksi parah\n3. Berikan pupuk nitrogen seimbang\n4. Tingkatkan sirkulasi udara",
                'tindakan_pencegahan' => "1. Hindari penanaman terlalu rapat\n2. Sanitasi kebun secara berkala\n3. Gunakan mulsa jerami\n4. Rotasi tanaman dengan keluarga bukan solanaceae",
                'faktor_risiko' => 'Kelembapan tinggi, daun basah berkepanjangan, suhu 20-30°C'
            ],
            [
                'id' => Uuid::uuid4(),
                'kode_penyakit' => 'P004',
                'nama_penyakit' => 'Busuk Daun Phytophthora',
                'deskripsi' => 'Penyakit busuk daun dan buah yang disebabkan oleh Phytophthora capsici. Menyebabkan busuk basah pada daun, batang, dan buah.',
                'solusi_perawatan' => "1. Semprot fungisida sistemik seperti Metalaxyl\n2. Buang bagian tanaman yang terinfeksi\n3. Kurangi penyiraman berlebihan\n4. Berikan pupuk fosfor untuk ketahanan",
                'tindakan_pencegahan' => "1. Gunakan bedengan tinggi untuk drainase\n2. Hindari genangan air\n3. Sterilisasi alat pertanian\n4. Pemilihan lokasi tanam yang tidak lembap",
                'faktor_risiko' => 'Genangan air, drainase buruk, kelembapan tinggi'
            ],
            [
                'id' => Uuid::uuid4(),
                'kode_penyakit' => 'P005',
                'nama_penyakit' => 'Kerdil Virus CMV',
                'deskripsi' => 'Penyakit kerdil yang disebabkan oleh Cucumber Mosaic Virus. Daun mengkerut, tanaman kerdil, buah kecil dan tidak normal.',
                'solusi_perawatan' => "1. Cabut dan bakar tanaman terinfeksi\n2. Kendalikan vektor kutu daun\n3. Berikan pupuk lengkap untuk pemulihan\n4. Semprot insektisida sistemik",
                'tindakan_pencegahan' => "1. Gunakan benih bebas virus\n2. Pasang insect net house\n3. Kendalikan gulma inang virus\n4. Rotasi tanaman dengan non-inang",
                'faktor_risiko' => 'Serangan kutu daun, penggunaan alat tidak steril, gulma banyak'
            ],
            [
                'id' => Uuid::uuid4(),
                'kode_penyakit' => 'P006',
                'nama_penyakit' => 'Busuk Leher Batang',
                'deskripsi' => 'Penyakit busuk pada leher batang yang disebabkan oleh Sclerotium rolfsii. Batang membusuk di bagian pangkal dengan miselium putih.',
                'solusi_perawatan' => "1. Oleskan fungisida pada bagian yang terinfeksi\n2. Kurangi kelembapan sekitar batang\n3. Berikan kapur pertanian\n4. Gemburkan tanah sekitar tanaman",
                'tindakan_pencegahan' => "1. Hindari penanaman terlalu dalam\n2. Gunakan mulsa plastik\n3. Perbaiki drainase\n4. Sterilisasi tanah sebelum tanam",
                'faktor_risiko' => 'Tanah berat, kelembapan tinggi, jarak tanam rapat'
            ],
            [
                'id' => Uuid::uuid4(),
                'kode_penyakit' => 'P007',
                'nama_penyakit' => 'Embun Tepung',
                'deskripsi' => 'Penyakit yang disebabkan oleh Oidium spp. Menimbulkan lapisan tepung putih pada permukaan daun, menyebabkan daun menguning dan gugur.',
                'solusi_perawatan' => "1. Semprot fungisida seperti Bayleton atau Benomyl\n2. Kurangi kelembapan\n3. Berikan pupuk kalium\n4. Tingkatkan intensitas cahaya",
                'tindakan_pencegahan' => "1. Jarak tanam optimal\n2. Pemangkasan daun tua\n3. Sirkulasi udara baik\n4. Hindari naungan berlebihan",
                'faktor_risiko' => 'Kelembapan tinggi, suhu dingin, intensitas cahaya rendah'
            ],
            [
                'id' => Uuid::uuid4(),
                'kode_penyakit' => 'P008',
                'nama_penyakit' => 'Layu Bakteri',
                'deskripsi' => 'Penyakit layu yang disebabkan oleh bakteri Ralstonia solanacearum. Tanaman layu mendadak, batang mengeluarkan lendir bakteri.',
                'solusi_perawatan' => "1. Cabut dan bakar tanaman sakit\n2. Berikan bakterisida seperti Agrept\n3. Tingkatkan pH tanah\n4. Berikan pupuk organik matang",
                'tindakan_pencegahan' => "1. Gunakan varietas tahan\n2. Sterilisasi alat pertanian\n3. Rotasi tanaman panjang\n4. Hindari luka mekanis pada akar",
                'faktor_risiko' => 'Tanah asam, suhu tinggi, luka pada akar'
            ],
            [
                'id' => Uuid::uuid4(),
                'kode_penyakit' => 'P009',
                'nama_penyakit' => 'Bercak Bakteri',
                'deskripsi' => 'Penyakit bercak pada daun dan buah yang disebabkan oleh Xanthomonas campestris. Bercak kecil basah berubah menjadi coklat dengan halo kuning.',
                'solusi_perawatan' => "1. Semprot bakterisida seperti Copper\n2. Pangkas daun terinfeksi\n3. Kurangi penyiraman atas\n4. Berikan pupuk berimbang",
                'tindakan_pencegahan' => "1. Hindari kerja saat tanaman basah\n2. Sanitasi kebun\n3. Gunakan benih sehat\n4. Rotasi tanaman minimal 1 tahun",
                'faktor_risiko' => 'Curah hujan tinggi, angin kencang, suhu 25-30°C'
            ],
            [
                'id' => Uuid::uuid4(),
                'kode_penyakit' => 'P010',
                'nama_penyakit' => 'Busuk Akar',
                'deskripsi' => 'Penyakit busuk akar yang disebabkan oleh jamur Rhizoctonia solani. Akar membusuk, tanaman layu, pertumbuhan terhambat.',
                'solusi_perawatan' => "1. Siram fungisida sistemik\n2. Berikan trichoderma\n3. Perbaiki drainase\n4. Berikan pupuk organik",
                'tindakan_pencegahan' => "1. Sterilisasi media semai\n2. Hindari genangan air\n3. Gunakan bedengan tinggi\n4. Rotasi tanaman",
                'faktor_risiko' => 'Tanah berat, drainase buruk, kelembapan tanah tinggi'
            ],
            [
                'id' => Uuid::uuid4(),
                'kode_penyakit' => 'P011',
                'nama_penyakit' => 'Kuning Keriting Virus',
                'deskripsi' => 'Penyakit virus yang menyebabkan daun menguning dan keriting, tanaman kerdil, hasil buah menurun drastis.',
                'solusi_perawatan' => "1. Cabut tanaman terinfeksi\n2. Kendalikan vektor whitefly\n3. Berikan pupuk lengkap\n4. Semprot insektisida sistemik",
                'tindakan_pencegahan' => "1. Gunakan varietas tahan\n2. Pasang perangkap kuning\n3. Sanitasi lingkungan\n4. Rotasi tanaman",
                'faktor_risiko' => 'Serangan whitefly, suhu tinggi, kelembapan rendah'
            ],
            [
                'id' => Uuid::uuid4(),
                'kode_penyakit' => 'P012',
                'nama_penyakit' => 'Hawar Daun',
                'deskripsi' => 'Penyakit hawar daun yang disebabkan oleh Alternaria solani. Bercak konsentris seperti target pada daun tua.',
                'solusi_perawatan' => "1. Semprot fungisida seperti Mancozeb\n2. Buang daun terinfeksi\n3. Berikan pupuk kalium\n4. Kurangi kelembapan",
                'tindakan_pencegahan' => "1. Rotasi tanaman 3 tahun\n2. Sanitasi sisa tanaman\n3. Jarak tanam optimal\n4. Hindari penyiraman sore",
                'faktor_risiko' => 'Cuaca lembap, daun basah, suhu 20-25°C'
            ],
            [
                'id' => Uuid::uuid4(),
                'kode_penyakit' => 'P013',
                'nama_penyakit' => 'Busuk Ujung Buah',
                'deskripsi' => 'Gangguan fisiologis karena defisiensi kalsium. Ujung buah membusuk dan mengering, sering disebut blossom end rot.',
                'solusi_perawatan' => "1. Semprot kalsium nitrat 0.5%\n2. Pertahankan kelembapan tanah konstan\n3. Berikan dolomit\n4. Kurangi pupuk nitrogen berlebihan",
                'tindakan_pencegahan' => "1. Pemupukan berimbang\n2. Pengairan teratur\n3. Pengapuran tanah\n4. Pemilihan varietas tahan",
                'faktor_risiko' => 'Fluktuasi kelembapan tanah, defisiensi Ca, pemupukan N tinggi'
            ],
            [
                'id' => Uuid::uuid4(),
                'kode_penyakit' => 'P014',
                'nama_penyakit' => 'Nematoda Puru Akar',
                'deskripsi' => 'Serangan nematoda Meloidogyne spp. menyebabkan bintil/bengkak pada akar, tanaman kerdil, dan hasil menurun.',
                'solusi_perawatan' => "1. Berikan nematisida seperti Furadan\n2. Berikan pupuk organik\n3. Tanam tagetes sebagai tanaman pagar\n4. Berikan trichoderma",
                'tindakan_pencegahan' => "1. Rotasi tanaman dengan bukan inang\n2. Gunakan benih bebas nematoda\n3. Solarisasi tanah\n4. Penggunaan mulsa plastik",
                'faktor_risiko' => 'Tanah berpasir, monokultur, suhu tanah tinggi'
            ],
            [
                'id' => Uuid::uuid4(),
                'kode_penyakit' => 'P015',
                'nama_penyakit' => 'Klorosis',
                'deskripsi' => 'Gangguan fisiologis karena defisiensi hara terutama nitrogen dan magnesium. Daun menguning mulai dari daun tua.',
                'solusi_perawatan' => "1. Berikan pupuk nitrogen seimbang\n2. Semprot pupuk daun mengandung Mg\n3. Perbaiki pH tanah\n4. Berikan pupuk organik",
                'tindakan_pencegahan' => "1. Pemupukan berimbang\n2. Pengapuran tanah\n3. Rotasi tanaman\n4. Pemantauan hara tanah",
                'faktor_risiko' => 'Tanah masam, drainase buruk, pemupukan tidak seimbang'
            ]
        ];

        DB::table('penyakit')->insert($penyakit);
    }
}
