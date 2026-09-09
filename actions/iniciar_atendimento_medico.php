<?php

session_start();

require_once "../config/conexao.php";
require_once "../includes/verificar_medico.php";


/*
|--------------------------------------------------------------------------
| Verifica método da requisição
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: ../templates/medico/dashboard.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| Recebe ID da consulta
|--------------------------------------------------------------------------
*/

$id_consulta = filter_input(
    INPUT_POST,
    "id_consulta",
    FILTER_VALIDATE_INT
);


if (!$id_consulta) {

    $_SESSION["erro"] = "Consulta inválida.";

    header("Location: ../templates/medico/dashboard.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| Busca o médico vinculado ao usuário logado
|--------------------------------------------------------------------------
*/

$usuario_id = (int) $_SESSION["id"];

$sql = "
    SELECT id
    FROM medicos
    WHERE usuario_id = ?
    AND ativo = 1
    LIMIT 1
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();

$resultado = $stmt->get_result();

$medico = $resultado->fetch_assoc();


if (!$medico) {

    $_SESSION["erro"] = "Médico não encontrado.";

    header("Location: ../templates/medico/dashboard.php");
    exit;
}


$medico_id = (int) $medico["id"];


/*
|--------------------------------------------------------------------------
| Verifica se a consulta pertence ao médico
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT id, status
    FROM consultas
    WHERE id = ?
    AND medico_id = ?
    LIMIT 1
";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ii",
    $id_consulta,
    $medico_id
);

$stmt->execute();

$resultado = $stmt->get_result();

$consulta = $resultado->fetch_assoc();


if (!$consulta) {

    $_SESSION["erro"] = "Consulta não encontrada.";

    header("Location: ../templates/medico/dashboard.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| Verifica se já existe atendimento
|--------------------------------------------------------------------------
*/

$sql_check = "
    SELECT id
    FROM atendimentos
    WHERE consulta_id = ?
    LIMIT 1
";

$stmt_check = $conn->prepare($sql_check);

$stmt_check->bind_param(
    "i",
    $id_consulta
);

$stmt_check->execute();

$stmt_check->store_result();


if ($stmt_check->num_rows > 0) {

    $_SESSION["erro"] = "Atendimento já iniciado para esta consulta.";

    header("Location: ../templates/medico/dashboard.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| Inicia atendimento
|--------------------------------------------------------------------------
*/

$sql = "
    INSERT INTO atendimentos
        (consulta_id, medico_id, data_inicio, status)
    VALUES
        (?, ?, NOW(), 'em_andamento')
";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ii",
    $id_consulta,
    $medico_id
);


if ($stmt->execute()) {

    $_SESSION["sucesso"] = "Atendimento iniciado com sucesso.";

    header(
        "Location: ../templates/medico/registrar_prontuario.php?atendimento_id="
        . $stmt->insert_id
    );

    exit;
}


$_SESSION["erro"] = "Erro ao iniciar atendimento.";

header("Location: ../templates/medico/dashboard.php");
exit;