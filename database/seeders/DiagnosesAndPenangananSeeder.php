<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Diagnosis;
use App\Models\Penanganan;

class DiagnosesAndPenangananSeeder extends Seeder
{
    public function run()
    {
        $user = User::firstOrCreate(
            ['email' => 'nilahealth@example.com'],
            [
                'name' => 'User Dummy',
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        $diagnosisList = [
            "Streptococcosis" => "Beri antibiotik spektrum luas, tingkatkan kualitas air, dan isolasi ikan yang terinfeksi.",
            "Parasitic Diseases" => "Gunakan antiparasit seperti formalin atau garam, dan bersihkan dasar kolam.",
            "Columnaris Disease" => "Bersihkan kolam, ganti air, dan gunakan antibiotik seperti oxytetracycline.",
            "Tilapia Lake virus" => "Isolasi ikan terinfeksi, tingkatkan imun dengan pakan bergizi, dan hindari stres lingkungan.",
            "Motile Aeromonad Septicemia" => "Gunakan antibiotik seperti enrofloxacin, perbaiki manajemen air dan pakan.",
            "Normal Nile Tilapia" => null
        ];

        foreach ($diagnosisList as $penyakit => $saran) {
            $diagnosis = Diagnosis::create([
                'user_id' => $user->id,
                'hasil_diagnosis' => $penyakit,
            ]);

            if ($saran) {
                Penanganan::create([
                    'diagnosis_id' => $diagnosis->id,
                    'deskripsi' => $saran
                ]);
            }
        }
    }
}
