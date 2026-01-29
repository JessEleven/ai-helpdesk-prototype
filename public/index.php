<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mesa de Ayuda Municipal</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color:rgb(48, 48, 48);
        }
        textarea {
            width: 100%;
            max-width: 700px;
        }
        #respuesta {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            display: none;
            white-space: pre-wrap;
        }
    </style>
</head>
<body>

<h2>Reporte de problema técnico</h2>

<textarea id="ticket" rows="6"
    placeholder="Describa el problema técnico..."></textarea>
<br><br>
<button onclick="enviarTicket()">Enviar ticket</button>

<div id="respuesta"></div>

<script>
function enviarTicket() {
    const ticket = document.getElementById('ticket').value.trim();
    const respuestaDiv = document.getElementById('respuesta');

    if (ticket === "") {
        alert("Por favor, describa el problema.");
        return;
    }

    respuestaDiv.style.display = "block";
    respuestaDiv.textContent = "Analizando el problema, por favor espere...";

    fetch("procesar_ticket.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "ticket=" + encodeURIComponent(ticket)
    })
    .then(response => response.text())
    .then(data => {
        respuestaDiv.textContent = data;
    })
    .catch(error => {
        respuestaDiv.textContent = "Error al obtener la respuesta del asistente.";
        console.error(error);
    });
}
</script>

</body>
</html>
