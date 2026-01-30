import pandas as pd
import json
import os

BASE_DIR = os.path.dirname(os.path.abspath(__file__))

excel_path = os.path.join(BASE_DIR, "tickets_municipio_300.xlsx")
jsonl_path = os.path.join(BASE_DIR, "tickets_municipio.jsonl")

df = pd.read_excel(excel_path)

with open(jsonl_path, "w", encoding="utf-8") as f:
    for _, row in df.iterrows():
        item = {
            "prompt": f"""Eres un asistente de mesa de ayuda informática de un municipio.
Analiza el siguiente ticket y proporciona una solución clara, paso a paso y comprensible
para un usuario con conocimientos básicos de computación.

Problema reportado:
{row['descripción']}""",
            "response": row["recomendación"]
        }
        f.write(json.dumps(item, ensure_ascii=False) + "\n")

print("Archivo tickets_municipio.jsonl generado correctamente.")
