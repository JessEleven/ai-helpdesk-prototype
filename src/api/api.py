import subprocess
from fastapi import FastAPI
from pydantic import BaseModel

app = FastAPI(title="AI Help Desk API")

# ----- Modelo de entrada -----
class TicketRequest(BaseModel):
    asunto: str
    descripcion: str

# ----- Endpoint POST -----
@app.post("/api/v1/ticket-suggestions")

def procesar_ticket(ticket: TicketRequest):
    prompt = f"""
        Eres un asistente automático de mesa de ayuda informática
        para empleados municipales.

    Ticket:
    Asunto: {ticket.asunto}
    Descripción: {ticket.descripcion}

    Proporciona una solución clara y paso a paso.
    """

    try:
        result = subprocess.run(
            ["ollama", "run", "mesa_ayuda_municipio", prompt],
            capture_output=True,
            text=True,
            timeout=120
        )

        if result.returncode != 0:
            return {
                "success": False,
                "error": "Error al ejecutar el modelo"
            }

        return {
            "success": True,
            "respuesta": result.stdout.strip()
        }

    except Exception as e:
        return {
            "success": False,
            "error": str(e)
        }
