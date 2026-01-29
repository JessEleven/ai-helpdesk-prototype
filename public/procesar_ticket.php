<?php
$ticket = $_POST['ticket'] ?? '';

if (empty($ticket)) {
    echo "No se recibió ningún ticket.";
    exit;
}

$prompt = "Analiza el siguiente ticket de soporte técnico y proporciona una solución clara y paso a paso:\n\n" . $ticket;

$data = [
    "model" => "mesa_ayuda_municipio",
    "prompt" => $prompt,
    "stream" => false
];

$ch = curl_init("http://localhost:11434/api/generate");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/x-www-form-urlencoded"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);

if ($response === false) {
    echo "Error al conectar con Ollama.";
    exit;
}

curl_close($ch);

$result = json_decode($response, true);

echo $result['response'] ?? "No se pudo generar una respuesta.";
