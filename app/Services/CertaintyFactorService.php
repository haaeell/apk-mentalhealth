<?php

namespace App\Services;

use App\Models\MentalDisorder;
use App\Models\DisorderSymptom;

class CertaintyFactorService
{
    /**
     * Nilai kepercayaan user (CF_user) berdasarkan pilihan
     * Skala: Tidak = 0, Tidak Tahu = 0.2, Mungkin = 0.4, Kemungkinan Besar = 0.6, Hampir Pasti = 0.8, Pasti = 1.0
     */
    public static function cfUserScale(): array
    {
        return [
            ['label' => 'Tidak',            'value' => 0.0, 'desc' => 'Saya tidak mengalami gejala ini sama sekali', 'color' => 'gray'],
            ['label' => 'Tidak Yakin',      'value' => 0.2, 'desc' => 'Saya tidak yakin apakah mengalami ini',       'color' => 'blue'],
            ['label' => 'Mungkin',          'value' => 0.4, 'desc' => 'Mungkin saya mengalami ini sesekali',          'color' => 'yellow'],
            ['label' => 'Kemungkinan Besar', 'value' => 0.6, 'desc' => 'Saya cukup sering mengalami ini',              'color' => 'orange'],
            ['label' => 'Hampir Pasti',     'value' => 0.8, 'desc' => 'Saya hampir selalu mengalami ini',             'color' => 'red'],
            ['label' => 'Pasti',            'value' => 1.0, 'desc' => 'Saya pasti mengalami gejala ini',              'color' => 'darkred'],
        ];
    }

    /**
     * Hitung CF untuk satu gejala
     * CF(H,E) = MB(H,E) - MD(H,E) * CF_user
     */
    public static function calculateCF(float $mb, float $md, float $cfUser): float
    {
        return ($mb - $md) * $cfUser;
    }

    /**
     * Kombinasikan dua nilai CF
     * CF_combine(CF1, CF2) = CF1 + CF2 * (1 - CF1)  jika keduanya positif
     */
    public static function combineCF(float $cf1, float $cf2): float
    {
        if ($cf1 >= 0 && $cf2 >= 0) {
            return $cf1 + $cf2 * (1 - $cf1);
        } elseif ($cf1 < 0 && $cf2 < 0) {
            return $cf1 + $cf2 * (1 + $cf1);
        } else {
            return ($cf1 + $cf2) / (1 - min(abs($cf1), abs($cf2)));
        }
    }

    /**
     * Proses semua jawaban dan kembalikan CF tiap gangguan
     * @param array $answers ['symptom_id' => cf_user_value, ...]
     * @return array ['disorder_id' => cf_value, ...]
     */
    public static function processAnswers(array $answers): array
    {
        $disorders = MentalDisorder::where('is_active', true)->with('disorderSymptoms')->get();
        $results = [];

        foreach ($disorders as $disorder) {
            $cfCombined = null;

            foreach ($disorder->disorderSymptoms as $ds) {
                $symptomId = $ds->symptom_id;

                if (!isset($answers[$symptomId]) || $answers[$symptomId] == 0) {
                    continue;
                }

                $cfUser = (float) $answers[$symptomId];
                $cfSymptom = self::calculateCF($ds->mb, $ds->md, $cfUser);

                if ($cfCombined === null) {
                    $cfCombined = $cfSymptom;
                } else {
                    $cfCombined = self::combineCF($cfCombined, $cfSymptom);
                }
            }

            if ($cfCombined !== null && $cfCombined > 0) {
                $results[$disorder->id] = round($cfCombined, 4);
            }
        }

        arsort($results);
        return $results;
    }
}
