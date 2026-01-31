@echo off
REM Activar entorno virtual y correr FastAPI con Uvicorn
call venv\Scripts\activate
python -m uvicorn src.api:app --reload --host 127.0.0.1 --port 8000