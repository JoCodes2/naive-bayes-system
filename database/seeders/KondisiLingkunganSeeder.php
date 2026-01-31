<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KondisiLingkunganModel;
use Illuminate\Support\Str;

class KondisiLingkunganSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Suhu Udara
            ['param' => 'Suhu Udara', 'satuan' => '°C', 'label' => 'rendah', 'min' => 0.00, 'max' => 22.99, 'desc' => 'Udara terasa sejuk/dingin'],
            ['param' => 'Suhu Udara', 'satuan' => '°C', 'label' => 'normal', 'min' => 23.00, 'max' => 27.99, 'desc' => 'Udara terasa hangat (Ideal)'],
            ['param' => 'Suhu Udara', 'satuan' => '°C', 'label' => 'tinggi', 'min' => 28.00, 'max' => 45.00, 'desc' => 'Udara terasa panas terik'],

            // Kelembapan Udara
            ['param' => 'Kelembapan Udara', 'satuan' => '%', 'label' => 'rendah', 'min' => 0.00, 'max' => 50.99, 'desc' => 'Udara kering/gersang'],
            ['param' => 'Kelembapan Udara', 'satuan' => '%', 'label' => 'normal', 'min' => 51.00, 'max' => 75.99, 'desc' => 'Kelembapan sedang'],
            ['param' => 'Kelembapan Udara', 'satuan' => '%', 'label' => 'tinggi', 'min' => 76.00, 'max' => 100.00, 'desc' => 'Udara sangat lembap/mendung'],

            // Kelembapan Tanah
            ['param' => 'Kelembapan Tanah', 'satuan' => '%', 'label' => 'rendah', 'min' => 0.00, 'max' => 40.99, 'desc' => 'Tanah kering/pecah-pecah'],
            ['param' => 'Kelembapan Tanah', 'satuan' => '%', 'label' => 'normal', 'min' => 41.00, 'max' => 70.99, 'desc' => 'Tanah lembap/hitam'],
            ['param' => 'Kelembapan Tanah', 'satuan' => '%', 'label' => 'tinggi', 'min' => 71.00, 'max' => 100.00, 'desc' => 'Tanah becek/tergenang'],

            // Intensitas Cahaya
            ['param' => 'Intensitas Cahaya', 'satuan' => 'Lux', 'label' => 'rendah', 'min' => 0.00, 'max' => 2000.00, 'desc' => 'Mendung/ternaungi'],
            ['param' => 'Intensitas Cahaya', 'satuan' => 'Lux', 'label' => 'normal', 'min' => 2001.00, 'max' => 5000.00, 'desc' => 'Cerah berawan'],
            ['param' => 'Intensitas Cahaya', 'satuan' => 'Lux', 'label' => 'tinggi', 'min' => 5001.00, 'max' => 10000.00, 'desc' => 'Terik matahari langsung'],

            // Curah Hujan
            ['param' => 'Curah Hujan', 'satuan' => 'mm', 'label' => 'rendah', 'min' => 0.00, 'max' => 10.00, 'desc' => 'Jarang hujan/panas'],
            ['param' => 'Curah Hujan', 'satuan' => 'mm', 'label' => 'normal', 'min' => 10.01, 'max' => 50.00, 'desc' => 'Hujan sedang/rutin'],
            ['param' => 'Curah Hujan', 'satuan' => 'mm', 'label' => 'tinggi', 'min' => 50.01, 'max' => 200.00, 'desc' => 'Hujan lebat/badai'],

            // pH Tanah
            ['param' => 'pH Tanah', 'satuan' => 'pH', 'label' => 'rendah', 'min' => 1.00, 'max' => 5.49, 'desc' => 'Tanah Asam (Karat)'],
            ['param' => 'pH Tanah', 'satuan' => 'pH', 'label' => 'normal', 'min' => 5.50, 'max' => 7.00, 'desc' => 'Tanah Netral (Ideal)'],
            ['param' => 'pH Tanah', 'satuan' => 'pH', 'label' => 'tinggi', 'min' => 7.01, 'max' => 14.00, 'desc' => 'Tanah Basa (Alkali)'],
        ];

        foreach ($data as $item) {
            KondisiLingkunganModel::updateOrCreate(
                [
                    'nama_parameter' => $item['param'],
                    'nilai_label' => $item['label']
                ],
                [
                    'id' => (string) Str::uuid(),
                    'satuan' => $item['satuan'],
                    'min_value' => $item['min'],
                    'max_value' => $item['max'],
                    'deskripsi' => $item['desc'],
                ]
            );
        }
    }
}
