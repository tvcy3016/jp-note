# JP-Note

JP-Note 是一個**個人用的日語學習筆記與複習系統**，  
核心目標是協助整理「單字、文法、錯題」，並建立可持續複習的學習流程。

本專案以 **理解導向學習** 為設計原則，  
不追求大量刷題、不強制背誦。

目前專案已完成 **v0.1 MVP（筆記管理）**，  
並準備進入 **v0.2（題庫管理與手動出題）** 階段。

---

## 專案定位

- 個人使用（不考慮多人協作）
- MVP 優先、不過度工程
- 先好用，再談自動化（SRS / AI 皆為後期）

---

## Features

### 已完成（v0.1）

- 日語筆記管理
  - 單字（vocabulary）
  - 文法（grammar）
  - 錯題（mistake）
- 單表設計（notes）
- 新增 / 編輯 / 刪除筆記
- 依筆記類型動態顯示欄位
- 登入 / 登出（Supabase Auth）
- 使用者筆記存取權限控管（user_id）

---

### 規劃中（v0.2）

- 題庫管理（手動出題）
- 題目與筆記關聯（特別是 mistake 類型）
- 基礎作答紀錄（僅蒐集資料，不做排程）
- 為未來 SRS 預留資料結構（不實作演算法）

> v0.2 不包含 AI、不包含自動複習排程

---

## Tech Stack

### Backend

- Laravel 12
- PHP 8.4
- PostgreSQL（Supabase）

---

### Auth / Database

- Supabase Auth
- Supabase PostgreSQL
- Laravel Session 儲存登入狀態
- Middleware：`supabase.auth`

---

### Frontend

- Blade Templates
- Bootstrap（Card-based UI）
- Vite（僅負責前端資產編譯）

---

### Container / Runtime

- Docker（僅封裝 PHP / Laravel）
- 本機開發使用 Docker
- 不在 Docker 內執行 npm / Vite
- Container 監聽 `$PORT`（可相容 Serverless 環境）

---

## Database Design (Current)

### notes（單表設計）

共用欄位：

- id
- user_id
- note_type（vocabulary / grammar / mistake）
- title
- content
- timestamps

#### vocabulary

- reading
- meaning

#### grammar

- usage
- example

#### mistake

- question
- answer
- explanation
- difficulty

---

## Local Development

### Prerequisites

- Docker
- Git
- Node.js（僅用於前端資產）

> 本機不需安裝 PHP / Composer

---

### Build Docker image
```bash
docker build -t jp-note .
```

### Run container
```bash
docker run -d -p 8080:8080 -e PORT=8080 jp-note
```

### Open in browser
```bash
http://localhost:8080
```

### Frontend Assets（Vite）
```bash
npm install
npm run dev
```
