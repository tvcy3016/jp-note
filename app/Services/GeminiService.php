<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->baseUrl = config('services.gemini.base_url');
    }

    /**
     * 呼叫 Gemini 生成變體題目
     *
     * @param string $question 原題目
     * @param string $answer 原答案
     * @param string|null $noteContent 關聯筆記內容 (提供上下文)
     * @return array|null 回傳生成的題目結構，失敗回傳 null
     */
    public function generateVariant(string $question, string $answer, ?string $noteContent = ''): ?array
    {
        // 1. 組合 Prompt (提示詞工程)
        $prompt = $this->buildPrompt($question, $answer, $noteContent);

        // 2. 發送 API 請求
        $url = "{$this->baseUrl}?key={$this->apiKey}";
        
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7, // 0.7 讓 AI 有點創意但不過於發散
                    'responseMimeType' => 'application/json', // 強制回傳 JSON
                ]
            ]);

            // 3. 處理回應
            if ($response->successful()) {
                $data = $response->json();
                
                // Gemini 的回應結構較深，需層層剝開
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    $jsonText = $data['candidates'][0]['content']['parts'][0]['text'];
                    return json_decode($jsonText, true);
                }
            }
            
            Log::error('Gemini API Error: ' . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error('Gemini Connection Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * 定義 AI 的角色與規則
     */
    private function buildPrompt(string $question, string $answer, ?string $context): string
    {
        return <<<EOT
你是一個專業的日語教師。請根據以下的原題目，生成一個「變形練習題」。

【嚴格規則】
1. 保持原題的「文法結構」與「句型」完全不變。
2. 僅替換句子中的「名詞」、「地點」、「時間」或「副詞」。
3. 難度必須與原題一致 (N5/N4/N3...)。
4. 若等級為N1則允許使用冷僻或艱深的單字。
5. 回傳格式必須是標準的 JSON。
6. 如果題目類型是填空題，則不需要生成choices

【參考資訊】
原題目：{$question}
原答案：{$answer}
參考筆記內容：{$context}

【預期輸出格式 (JSON)】
{
    "question_text": "變形後的題目 (挖空處請用 ____ 表示)",
    "answer_text": "變形後的正確答案",
    "choices": ["選項1", "選項2", "選項3", "選項4"],
    "explanation": "簡短解釋：這題將原本的[原單字]換成了[新單字]，文法重點依然是..."
}
EOT;
    }
}