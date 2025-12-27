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

---

## Local Development (Docker)

### Build image
docker build -t jp-note .

### Run container
docker run --rm -p 8080:8080 -e PORT=8080 jp-note

### Open in browser
http://localhost:8080