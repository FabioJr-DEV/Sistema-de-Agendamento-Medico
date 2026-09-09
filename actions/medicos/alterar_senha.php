<?php

session_start();

require_once "../../config/conexao.php";


/*
|--------------------------------------------------------------------------
| Verifica se o usuário está logado
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION["id"], $_SESSION["perfil"])) {

    header("Location: ../../public/index.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| Verifica se é médico
|--------------------------------------------------------------------------
*/

if ($_SESSION["perfil"] !== "Medico") {

    header("Location: ../../templates/painel-usuario.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| Verifica método
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: ../../templates/medico/alterar_senha.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| Recebe dados
|--------------------------------------------------------------------------
*/

$usuario_id = (int) $_SESSION["id"];

$senha_atual = $_POST["senha_atual"] ?? "";

$nova_senha = $_POST["nova_senha"] ?? "";

$confirmar_senha = $_POST["confirmar_senha"] ?? "";


/*
|--------------------------------------------------------------------------
| Validação
|--------------------------------------------------------------------------
*/

if (
    empty($senha_atual) ||
    empty($nova_senha) ||
    empty($confirmar_senha)
) {

    $_SESSION["erro"] = "Preencha todos os campos.";

    header("Location: ../../templates/medico/alterar_senha.php");
    exit;
}


if (strlen($nova_senha) < 6) {

    $_SESSION["erro"] = "A nova senha deve possuir pelo menos 6 caracteres.";

    header("Location: ../../templates/medico/alterar_senha.php");
    exit;
}


if ($nova_senha !== $confirmar_senha) {

    $_SESSION["erro"] = "A confirmação da nova senha não confere.";

    header("Location: ../../templates/medico/alterar_senha.php");
    exit;
}


if ($senha_atual === $nova_senha) {

    $_SESSION["erro"] = "A nova senha deve ser diferente da senha atual.";

    header("Location: ../../templates/medico/alterar_senha.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| Busca usuário
|--------------------------------------------------------------------------
*/

$sql = "SELECT senha
        FROM usuarios
        WHERE id = ?
        AND perfil = 'Medico'
        AND ativo = 1";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $usuario_id);

$stmt->execute();

$resultado = $stmt->get_result();


if ($resultado->num_rows !== 1) {

    $_SESSION["erro"] = "Usuário não encontrado.";

    header("Location: ../../public/index.php");
    exit;
}


$usuario = $resultado->fetch_assoc();


/*
|--------------------------------------------------------------------------
| Confere senha atual
|--------------------------------------------------------------------------
*/

if (!password_verify($senha_atual, $usuario["senha"])) {

    $_SESSION["erro"] = "A senha atual está incorreta.";

    header("Location: ../../templates/medico/alterar_senha.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| Cria novo hash
|--------------------------------------------------------------------------
*/

$nova_senha_hash = password_hash(
    $nova_senha,
    PASSWORD_DEFAULT
);


/*
|--------------------------------------------------------------------------
| Atualiza senha e primeiro acesso
|--------------------------------------------------------------------------
*/

$sql = "UPDATE usuarios
        SET senha = ?,
            primeiro_acesso = 0
        WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "si",
    $nova_senha_hash,
    $usuario_id
);

$stmt->execute();


/*
|--------------------------------------------------------------------------
| Finaliza
|--------------------------------------------------------------------------
*/

$_SESSION["sucesso"] = "Senha alterada com sucesso.";

header("Location: ../../templates/medico/dashboard.php");
exit;