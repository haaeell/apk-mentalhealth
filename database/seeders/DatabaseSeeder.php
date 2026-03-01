<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MentalDisorder;
use App\Models\Symptom;
use App\Models\DisorderSymptom;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@mental.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create Demo User
        User::create([
            'name' => 'Demo User',
            'email' => 'user@mental.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'gender' => 'male',
            'birth_date' => '1995-05-15',
        ]);

        // ========================
        // SYMPTOMS (Gejala)
        // ========================
        $symptoms = [
            ['G001', 'Perasaan sedih berkepanjangan', 'Merasa sedih, kosong, atau tanpa harapan hampir setiap hari', 'Apakah Anda sering merasa sedih, kosong, atau tidak bersemangat hampir sepanjang hari?', 'emosi'],
            ['G002', 'Kehilangan minat', 'Kehilangan minat atau kesenangan dalam aktivitas yang dulunya dinikmati', 'Apakah Anda kehilangan minat pada hobi atau kegiatan yang biasanya Anda sukai?', 'emosi'],
            ['G003', 'Perubahan pola tidur', 'Insomnia atau tidur berlebihan', 'Apakah Anda mengalami kesulitan tidur atau tidur terlalu banyak?', 'fisik'],
            ['G004', 'Perubahan nafsu makan', 'Penurunan atau peningkatan nafsu makan signifikan', 'Apakah nafsu makan Anda berubah drastis belakangan ini?', 'fisik'],
            ['G005', 'Kelelahan ekstrem', 'Merasa lelah atau kehilangan energi hampir setiap hari', 'Apakah Anda sering merasa sangat lelah meski tidak banyak beraktivitas?', 'fisik'],
            ['G006', 'Kesulitan konsentrasi', 'Sulit berkonsentrasi, mengingat, atau membuat keputusan', 'Apakah Anda sering kesulitan fokus atau mengingat sesuatu?', 'kognitif'],
            ['G007', 'Perasaan tidak berharga', 'Merasa tidak berharga atau merasa bersalah berlebihan', 'Apakah Anda sering merasa tidak berguna atau merasa bersalah tanpa alasan jelas?', 'emosi'],
            ['G008', 'Pikiran tentang kematian', 'Pikiran berulang tentang kematian atau bunuh diri', 'Apakah Anda memiliki pikiran tentang kematian atau menyakiti diri sendiri?', 'kognitif'],
            ['G009', 'Kecemasan berlebihan', 'Khawatir atau cemas berlebihan yang sulit dikontrol', 'Apakah Anda sering merasa cemas atau khawatir berlebihan tentang berbagai hal?', 'emosi'],
            ['G010', 'Gejala fisik tanpa penyebab', 'Sakit kepala, nyeri otot, atau gangguan pencernaan tanpa penyebab medis', 'Apakah Anda sering mengalami keluhan fisik seperti sakit kepala atau nyeri tanpa alasan medis?', 'fisik'],
            ['G011', 'Serangan panik', 'Rasa takut atau tidak nyaman intens yang muncul tiba-tiba', 'Apakah Anda pernah tiba-tiba merasa sangat takut disertai jantung berdebar, sesak napas, atau pusing?', 'emosi'],
            ['G012', 'Menghindari situasi sosial', 'Menghindari situasi sosial karena rasa takut atau malu', 'Apakah Anda sering menghindari pertemuan sosial atau acara karena merasa cemas atau takut?', 'perilaku'],
            ['G013', 'Pikiran mengganggu berulang', 'Pikiran tidak diinginkan yang terus muncul dan sulit dihentikan', 'Apakah Anda memiliki pikiran tertentu yang terus berulang dan mengganggu?', 'kognitif'],
            ['G014', 'Tindakan berulang', 'Melakukan tindakan atau ritual tertentu berulang kali untuk mengurangi kecemasan', 'Apakah Anda merasa perlu melakukan ritual atau kebiasaan tertentu berulang kali?', 'perilaku'],
            ['G015', 'Sulit berinteraksi sosial', 'Kesulitan dalam memulai atau mempertahankan percakapan', 'Apakah Anda kesulitan untuk memulai percakapan atau berinteraksi dengan orang lain?', 'perilaku'],
            ['G016', 'Perubahan suasana hati drastis', 'Perubahan mood yang ekstrem dan cepat', 'Apakah suasana hati Anda berubah sangat drastis dalam waktu singkat?', 'emosi'],
            ['G017', 'Perilaku impulsif', 'Melakukan hal-hal berisiko tanpa pikir panjang', 'Apakah Anda sering melakukan hal-hal berisiko secara impulsif?', 'perilaku'],
            ['G018', 'Episode manik', 'Periode energi sangat tinggi, kebutuhan tidur berkurang, berbicara cepat', 'Apakah Anda pernah mengalami periode dimana Anda merasa sangat bersemangat, tidak butuh tidur banyak, dan berbicara sangat cepat?', 'emosi'],
            ['G019', 'Flashback trauma', 'Mengalami kembali kejadian traumatis', 'Apakah Anda sering mengalami kilasan ingatan dari kejadian traumatis yang tidak menyenangkan?', 'kognitif'],
            ['G020', 'Menghindari hal yang mengingatkan trauma', 'Menghindari situasi, tempat, atau orang yang mengingatkan pada trauma', 'Apakah Anda menghindari hal-hal yang mengingatkan pada pengalaman buruk di masa lalu?', 'perilaku'],
        ];

        $symptomIds = [];
        foreach ($symptoms as $s) {
            $sym = Symptom::create([
                'code' => $s[0],
                'name' => $s[1],
                'description' => $s[2],
                'question' => $s[3],
                'category' => $s[4],
            ]);
            $symptomIds[$s[0]] = $sym->id;
        }

        // ========================
        // DISORDERS (Gangguan)
        // ========================
        $disorders = [
            [
                'code' => 'P001',
                'name' => 'Depresi Mayor',
                'description' => 'Depresi mayor adalah gangguan mood serius yang memengaruhi cara seseorang berpikir, merasa, dan menangani aktivitas sehari-hari seperti tidur, makan, atau bekerja.',
                'recommendation' => "1. Segera konsultasikan dengan psikiater atau psikolog klinis.\n2. Pertimbangkan terapi kognitif-perilaku (CBT).\n3. Jaga rutinitas harian yang teratur.\n4. Olahraga minimal 30 menit sehari.\n5. Bangun sistem dukungan sosial yang kuat.\n6. Hindari alkohol dan zat psikoaktif.\n7. Ikuti program self-care yang konsisten.",
                'severity' => 'berat',
                'color_code' => '#4f46e5',
                'symptoms' => [
                    'G001' => ['mb' => 0.8, 'md' => 0.1],
                    'G002' => ['mb' => 0.7, 'md' => 0.1],
                    'G003' => ['mb' => 0.6, 'md' => 0.2],
                    'G004' => ['mb' => 0.5, 'md' => 0.2],
                    'G005' => ['mb' => 0.7, 'md' => 0.1],
                    'G006' => ['mb' => 0.6, 'md' => 0.2],
                    'G007' => ['mb' => 0.8, 'md' => 0.1],
                    'G008' => ['mb' => 0.9, 'md' => 0.05],
                    'G010' => ['mb' => 0.4, 'md' => 0.3],
                ]
            ],
            [
                'code' => 'P002',
                'name' => 'Gangguan Kecemasan Umum (GAD)',
                'description' => 'Gangguan kecemasan umum ditandai dengan kecemasan dan kekhawatiran yang berlebihan, tidak terkontrol, dan persisten tentang berbagai hal dalam kehidupan sehari-hari.',
                'recommendation' => "1. Konsultasi dengan psikolog untuk terapi CBT atau terapi eksposur.\n2. Pelajari teknik relaksasi: pernapasan dalam, meditasi mindfulness.\n3. Batasi konsumsi kafein dan alkohol.\n4. Rutin berolahraga aerobik.\n5. Jaga pola tidur yang baik.\n6. Catat pikiran cemas dalam jurnal harian.",
                'severity' => 'sedang',
                'color_code' => '#059669',
                'symptoms' => [
                    'G009' => ['mb' => 0.9, 'md' => 0.05],
                    'G005' => ['mb' => 0.6, 'md' => 0.2],
                    'G003' => ['mb' => 0.6, 'md' => 0.2],
                    'G006' => ['mb' => 0.5, 'md' => 0.2],
                    'G010' => ['mb' => 0.7, 'md' => 0.1],
                    'G016' => ['mb' => 0.5, 'md' => 0.2],
                ]
            ],
            [
                'code' => 'P003',
                'name' => 'Gangguan Panik',
                'description' => 'Gangguan panik adalah jenis gangguan kecemasan yang ditandai dengan serangan panik berulang—rasa takut atau tidak nyaman intens yang muncul tiba-tiba dan mencapai puncak dalam beberapa menit.',
                'recommendation' => "1. Terapi CBT khususnya teknik exposure therapy.\n2. Pelajari teknik pernapasan diafragma.\n3. Grounding techniques saat serangan panik.\n4. Konsultasikan kemungkinan pengobatan dengan dokter.\n5. Hindari kafein dan stimulan lainnya.",
                'severity' => 'sedang',
                'color_code' => '#dc2626',
                'symptoms' => [
                    'G011' => ['mb' => 0.95, 'md' => 0.02],
                    'G009' => ['mb' => 0.7, 'md' => 0.1],
                    'G012' => ['mb' => 0.6, 'md' => 0.2],
                    'G010' => ['mb' => 0.6, 'md' => 0.2],
                ]
            ],
            [
                'code' => 'P004',
                'name' => 'Fobia Sosial (SAD)',
                'description' => 'Gangguan kecemasan sosial adalah rasa takut yang intens dan persisten terhadap situasi sosial di mana orang tersebut mungkin diperiksa, dihakimi, atau dipermalukan oleh orang lain.',
                'recommendation' => "1. Terapi CBT dengan fokus pada restrukturisasi kognitif.\n2. Exposure therapy bertahap pada situasi sosial.\n3. Bergabung dengan kelompok dukungan.\n4. Latihan keterampilan sosial.\n5. Mindfulness untuk mengurangi self-consciousness.",
                'severity' => 'sedang',
                'color_code' => '#7c3aed',
                'symptoms' => [
                    'G012' => ['mb' => 0.9, 'md' => 0.05],
                    'G015' => ['mb' => 0.85, 'md' => 0.05],
                    'G009' => ['mb' => 0.7, 'md' => 0.1],
                    'G010' => ['mb' => 0.5, 'md' => 0.2],
                ]
            ],
            [
                'code' => 'P005',
                'name' => 'OCD (Obsesif-Kompulsif)',
                'description' => 'OCD adalah gangguan di mana seseorang memiliki pikiran yang tidak diinginkan dan berulang (obsesi) dan/atau tindakan berulang (kompulsi) yang mereka rasa harus dilakukan.',
                'recommendation' => "1. Terapi Exposure and Response Prevention (ERP).\n2. CBT dengan fokus OCD.\n3. Hindari memberikan kepuasan pada kompulsi.\n4. Dukungan keluarga sangat penting.\n5. Konsultasi untuk evaluasi medikasi jika diperlukan.",
                'severity' => 'berat',
                'color_code' => '#d97706',
                'symptoms' => [
                    'G013' => ['mb' => 0.95, 'md' => 0.02],
                    'G014' => ['mb' => 0.95, 'md' => 0.02],
                    'G009' => ['mb' => 0.6, 'md' => 0.2],
                    'G005' => ['mb' => 0.5, 'md' => 0.3],
                ]
            ],
            [
                'code' => 'P006',
                'name' => 'Gangguan Bipolar',
                'description' => 'Gangguan bipolar adalah kondisi kesehatan mental yang menyebabkan perubahan suasana hati yang ekstrem, termasuk episode emosional manik (highs) dan depresif (lows).',
                'recommendation' => "1. Wajib konsultasi psikiater untuk evaluasi dan pengobatan.\n2. Mood stabilizer sesuai resep dokter.\n3. Terapi CBT dan psikoedukai.\n4. Jaga rutinitas tidur yang sangat konsisten.\n5. Pantau mood harian dengan aplikasi atau jurnal.\n6. Bangun jaringan dukungan yang kuat.",
                'severity' => 'berat',
                'color_code' => '#0284c7',
                'symptoms' => [
                    'G018' => ['mb' => 0.95, 'md' => 0.02],
                    'G016' => ['mb' => 0.9, 'md' => 0.05],
                    'G017' => ['mb' => 0.8, 'md' => 0.1],
                    'G001' => ['mb' => 0.6, 'md' => 0.2],
                    'G003' => ['mb' => 0.6, 'md' => 0.2],
                ]
            ],
            [
                'code' => 'P007',
                'name' => 'PTSD (Trauma)',
                'description' => 'PTSD adalah kondisi kesehatan mental yang dipicu oleh pengalaman traumatis—baik dengan mengalaminya secara langsung atau menyaksikannya.',
                'recommendation' => "1. Terapi EMDR (Eye Movement Desensitization and Reprocessing).\n2. Trauma-focused CBT.\n3. Kelompok dukungan trauma.\n4. Teknik grounding untuk mengelola flashback.\n5. Konsultasi dengan profesional kesehatan mental.\n6. Bangun rasa aman dan rutinitas yang stabil.",
                'severity' => 'berat',
                'color_code' => '#be185d',
                'symptoms' => [
                    'G019' => ['mb' => 0.95, 'md' => 0.02],
                    'G020' => ['mb' => 0.9, 'md' => 0.05],
                    'G009' => ['mb' => 0.7, 'md' => 0.1],
                    'G003' => ['mb' => 0.6, 'md' => 0.2],
                    'G016' => ['mb' => 0.6, 'md' => 0.2],
                    'G013' => ['mb' => 0.5, 'md' => 0.3],
                ]
            ],
        ];

        foreach ($disorders as $d) {
            $disorder = MentalDisorder::create([
                'code' => $d['code'],
                'name' => $d['name'],
                'description' => $d['description'],
                'recommendation' => $d['recommendation'],
                'severity' => $d['severity'],
                'color_code' => $d['color_code'],
            ]);

            foreach ($d['symptoms'] as $code => $values) {
                if (isset($symptomIds[$code])) {
                    DisorderSymptom::create([
                        'mental_disorder_id' => $disorder->id,
                        'symptom_id' => $symptomIds[$code],
                        'mb' => $values['mb'],
                        'md' => $values['md'],
                    ]);
                }
            }
        }
    }
}
