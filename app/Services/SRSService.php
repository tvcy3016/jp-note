<?php

namespace App\Services;

use Carbon\Carbon;

class SRSService
{
    /**
     * 計算下一次複習的數據 (基於 SM-2 演算法變體)
     * * @param array $currentStats 目前題目的狀態 [ease_factor, repetitions, interval_days]
     * @param int $quality 使用者評分 (0:忘記, 3:困難, 4:良好, 5:簡單)
     * @return array 新的狀態
     */
    public function calculateNextReview(array $currentStats, int $quality): array
    {
        $ef = $currentStats['ease_factor'];
        $reps = $currentStats['repetitions'];
        $interval = $currentStats['interval_days'];

        // 如果評分小於 3 (忘記了/完全不會)，重置進度
        if ($quality < 3) {
            $reps = 0;
            $interval = 0; // 設定為 0 代表需要「立即/今天」重來
        } else {
            // 1. 更新難易度係數 (Ease Factor) - 這是 SM-2 的核心公式
            // 公式：EF' = EF + (0.1 - (5 - q) * (0.08 + (5 - q) * 0.02))
            $ef = $ef + (0.1 - (5 - $quality) * (0.08 + (5 - $quality) * 0.02));
            
            // EF 不得低於 1.3 (避免間隔永遠不增長)
            $ef = max(1.3, $ef);

            // 2. 更新連續次數
            $reps++;

            // 3. 計算新的間隔天數
            if ($reps === 1) {
                $interval = 1; // 第一次答對，隔 1 天
            } elseif ($reps === 2) {
                $interval = 6; // 第二次答對，隔 6 天
            } else {
                // 之後就是 前次間隔 * EF
                $interval = ceil($interval * $ef);
            }
        }

        return [
            'ease_factor' => $ef,
            'repetitions' => $reps,
            'interval_days' => $interval,
            'next_review_at' => ($interval == 0) ? Carbon::now() : Carbon::now()->addDays($interval)
        ];
    }
}