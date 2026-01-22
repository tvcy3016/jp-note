# JP-Note

這是一個結合「個人筆記」與「AI 智慧練習」的複習系統。透過 **Gemini 1.5 Flash** 進行題目變形，並利用 **間隔重複 (SRS)** 演算法（基於 SM-2）優化長期記憶效率，解決「死背答案」的問題。

---

## 🚀 目前開發進度 (Current Status)

> **版本狀態：v0.2.1 (Phase 2 完成 - SRS 核心已實裝)**
>
> 目前系統已具備完整的筆記 CRUD、題庫管理以及基於科學記憶法的複習功能。
> **下一步 (Next Step)：** 串接 Gemini API 實作題目 AI 變形功能。

### ✅ 已完成功能
- [x] **使用者系統**：Supabase Auth 整合 (Login/Register)。
- [x] **筆記管理**：Markdown 編輯、標籤系統、CRUD。
- [x] **題庫系統**：題目與筆記關聯、支援單選/填空題。
- [x] **複習核心 (SRS)**：
    - 實作 SM-2 演算法變體 (SRSService)。
    - 支援 `Ease Factor`、`Interval`、`Next Review` 自動計算。
    - 複習介面優化（抽認卡 Flashcard 風格）。
    - 支援繁體中文人性化時間顯示（如：30分鐘後、明天）。

### 🚧 開發中 (Coming Soon)
- [ ] **AI 變形引擎**：串接 Gemini 1.5 Flash 生成變體題目。
- [ ] **學習儀表板**：視覺化學習熱點圖與答題歷史記錄。
- [ ] **Livewire 優化**：將複習流程改為異步操作，提升體驗。

---

## 🛠 技術架構 (Tech Stack)

- **Backend framework**: PHP 8.4 / Laravel 12
- **Database**: PostgreSQL (via Supabase)
- **Authentication**: Supabase Auth
- **AI Engine**: Google Gemini 1.5 Flash (Planning)
- **Frontend**: Blade Templates + Bootstrap 5 + Alpine.js
- **Deployment**: Google Cloud Run (Target)

---

## 📂 資料庫關鍵設計 (Database Schema)

目前主要資料表結構如下：

- **users**: 系統使用者 (同步 Supabase Auth)。
- **notes**: 學習筆記，儲存 Markdown 內容與標籤。
- **questions**: 題庫核心。
    - `question_text`, `answer_text`, `choices` (JSON)
    - **SRS 欄位**: `ease_factor`, `interval_days`, `repetitions`, `next_review_at`

---

## ⚙️ 安裝與執行 (Local Setup)

1. **Clone 專案**
   ```bash
   git clone <repo-url>
   cd jp-note
   ```
2. **安裝依賴**
  ```bash
  composer install
  npm install && npm run build
  ```
3. **環境設定 (.env) 請複製 .env.example 並填入 Supabase Credentials**
  ```bash
  SUPABASE_URL=your_supabase_url
  SUPABASE_KEY=your_supabase_anon_key
  DB_CONNECTION=pgsql

  # ... 其他資料庫連線設定
  # 時區設定
  APP_TIMEZONE='Asia/Taipei'
  ```
4. **資料庫遷移**
  ```bash
  php artisan migrate
  ```
5. **啟動伺服器**
  ```bash
  php artisan serve
  ```