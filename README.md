# JP-Note

JP-Note 是一個以日語學習為核心的個人化筆記與複習系統，  
目標是結合筆記整理、錯題管理與間隔重複（SRS），  
避免死背題目，強化「理解型學習」。

本專案目前為個人開發中的 MVP 階段，採用 Docker 與雲端無伺服器部署架構。

---

## Features (Planned / In Progress)

- 日語筆記管理（文法、單字、例句）
- 錯題記錄與重複複習
- 間隔重複系統（SRS）
- AI 輔助題目變形與筆記轉題（規劃中）

---

## Tech Stack

### Application
- Laravel Framework 12.44.0
- PHP (Runtime): 8.4.16 (cli)

### Container / Deployment
- Docker
- Cloud Run (managed, serverless)
- Container listens on dynamic `$PORT` (Cloud Run compatible)

### Tooling
- Composer 2.9.2 (used via official Composer image)
- Node.js（僅用於前端資源建置，非必要於 API 或後端邏輯）

---

## Development Workflow Overview

本專案採用以下開發與部署流程：

1. 以 Laravel 作為後端應用框架
2. 使用 Docker 封裝執行環境（PHP Runtime）
3. 本機以 Docker 啟動進行測試
4. 建立容器映像後部署至雲端 Serverless 平台
5. 生產環境不依賴固定埠號，使用平台提供的 `$PORT`

---

## Local Development (Docker)

### Prerequisites

本機需安裝以下工具：

- Docker (Desktop / Engine)
- Git

> 本機不需要安裝 PHP、Composer 或 Web Server  
> 所有執行環境皆由 Docker Container 提供

---

### Build image
docker build -t jp-note:latest .

### Run container
docker run --rm -p 8080:8080 -e PORT=8080 jp-note:latest

### Open in browser
http://localhost:8080

### Frontend Assets (Vite)
npm install
npm run build
