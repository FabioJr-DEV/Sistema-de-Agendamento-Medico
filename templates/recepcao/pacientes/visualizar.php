<?php

require_once "../../../includes/verificar_recepcao.php";
require_once "../../../config/conexao.php";

/*
|--------------------------------------------------------------------------
| Página: visualizar paciente
|--------------------------------------------------------------------------
| Objetivo:
| Exibir os dados completos de um paciente em modo somente leitura.
|--------------------------------------------------------------------------
*/

// Verifica se o ID foi informado
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    $_SESSION["erro"] = "Paciente inválido.";
    header("Location: index.php");
    exit;
}

$id = (int) $_GET["id"];

// Busca os dados do paciente
$sql = "SELECT
            id,
            nome,
            cpf,
            data_nascimento,
            sexo,
            telefone,
            email,
            endereco,
            convenio,
            tipo_sanguineo,
            alergias,
            observacoes,
            ativo,
            created_at,
            updated_at
        FROM pacientes
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    $_SESSION["erro"] = "Paciente não encontrado.";
    header("Location: index.php");
    exit;
}

$paciente = $resultado->fetch_assoc();

/*
|--------------------------------------------------------------------------
| Formatação
|--------------------------------------------------------------------------
*/

$data_nascimento = "";

if (!empty($paciente["data_nascimento"])) {
    $data_nascimento = date(
        "d/m/Y",
        strtotime($paciente["data_nascimento"])
    );
}

$status = $paciente["ativo"] == 1 ? "Ativo" : "Inativo";

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Visualizar Paciente</title>

    <link
        rel="stylesheet"
        href="../../../public/css/app.css"
    >

</head>

<body>

<div class="layout">

    <!-- MENU LATERAL -->

    <aside class="sidebar">

        <div class="brand">
            Clínica Vida+
            <small>Recepção</small>
        </div>

        <nav class="nav">

            <a href="../dashboard.php">
                Dashboard
            </a>

            <a
                href="index.php"
                class="active"
            >
                Pacientes
            </a>

            <a href="../medicos/index.php">
                Médicos
            </a>

            <a href="../agenda/index.php">
                Agenda
            </a>

            <a href="../consultas/index.php">
                Consultas
            </a>

            <a href="../../../logout.php">
                Sair
            </a>

        </nav>

    </aside>


    <!-- CONTEÚDO PRINCIPAL -->

    <main class="main">

        <div class="topbar">

            <div>

                <h1>Visualizar Paciente</h1>

                <p style="color: var(--muted); margin-top: 5px;">
                    Informações cadastrais do paciente
                </p>

            </div>

            <div class="user">
                <?= htmlspecialchars($_SESSION["nome"] ?? "") ?>
            </div>

        </div>


        <!-- CARD PRINCIPAL -->

        <div class="card">

            <div class="card-header">

                <div>

                    <h2>
                        <?= htmlspecialchars($paciente["nome"]) ?>
                    </h2>

                    <p>
                        CPF:
                        <?= htmlspecialchars($paciente["cpf"]) ?>
                    </p>

                </div>

                <div>

                    <?php if ($paciente["ativo"] == 1): ?>

                        <span class="status status-active">
                            Ativo
                        </span>

                    <?php else: ?>

                        <span class="status status-inactive">
                            Inativo
                        </span>

                    <?php endif; ?>

                </div>

            </div>


            <!-- DADOS PESSOAIS -->

            <div class="card" style="margin-top: 20px;">

                <h2 style="margin-bottom: 20px;">
                    Dados pessoais
                </h2>

                <div class="form-grid">

                    <div class="field">

                        <label>Nome completo</label>

                        <input
                            type="text"
                            value="<?= htmlspecialchars($paciente["nome"]) ?>"
                            readonly
                        >

                    </div>


                    <div class="field">

                        <label>CPF</label>

                        <input
                            type="text"
                            value="<?= htmlspecialchars($paciente["cpf"]) ?>"
                            readonly
                        >

                    </div>


                    <div class="field">

                        <label>Data de nascimento</label>

                        <input
                            type="text"
                            value="<?= htmlspecialchars($data_nascimento) ?>"
                            readonly
                        >

                    </div>


                    <div class="field">

                        <label>Sexo</label>

                        <input
                            type="text"
                            value="<?= htmlspecialchars($paciente["sexo"] ?? "") ?>"
                            readonly
                        >

                    </div>


                    <div class="field">

                        <label>Telefone</label>

                        <input
                            type="text"
                            value="<?= htmlspecialchars($paciente["telefone"] ?? "") ?>"
                            readonly
                        >

                    </div>


                    <div class="field">

                        <label>E-mail</label>

                        <input
                            type="text"
                            value="<?= htmlspecialchars($paciente["email"] ?? "") ?>"
                            readonly
                        >

                    </div>

                </div>

            </div>


            <!-- ENDEREÇO E CONVÊNIO -->

            <div class="card">

                <h2 style="margin-bottom: 20px;">
                    Endereço e convênio
                </h2>

                <div class="form-grid">

                    <div class="field full">

                        <label>Endereço</label>

                        <input
                            type="text"
                            value="<?= htmlspecialchars($paciente["endereco"] ?? "") ?>"
                            readonly
                        >

                    </div>


                    <div class="field">

                        <label>Convênio</label>

                        <input
                            type="text"
                            value="<?= htmlspecialchars($paciente["convenio"] ?? "") ?>"
                            readonly
                        >

                    </div>


                    <div class="field">

                        <label>Tipo sanguíneo</label>

                        <input
                            type="text"
                            value="<?= htmlspecialchars($paciente["tipo_sanguineo"] ?? "") ?>"
                            readonly
                        >

                    </div>

                </div>

            </div>


            <!-- INFORMAÇÕES MÉDICAS -->

            <div class="card">

                <h2 style="margin-bottom: 20px;">
                    Informações médicas
                </h2>

                <div class="form-grid">

                    <div class="field full">

                        <label>Alergias</label>

                        <textarea readonly><?= htmlspecialchars($paciente["alergias"] ?? "") ?></textarea>

                    </div>


                    <div class="field full">

                        <label>Observações</label>

                        <textarea readonly><?= htmlspecialchars($paciente["observacoes"] ?? "") ?></textarea>

                    </div>

                </div>

            </div>


            <!-- STATUS -->

            <div class="card">

                <h2 style="margin-bottom: 20px;">
                    Status do cadastro
                </h2>

                <div class="field">

                    <label>Status</label>

                    <input
                        type="text"
                        value="<?= htmlspecialchars($status) ?>"
                        readonly
                    >

                </div>

            </div>


            <!-- BOTÕES -->

            <div class="card-footer">

                <div class="actions">

                    <a
                        href="index.php"
                        class="btn btn-secondary"
                    >
                        Voltar
                    </a>

                    <a
                        href="editar.php?id=<?= $paciente["id"] ?>"
                        class="btn btn-primary"
                    >
                        Editar paciente
                    </a>

                </div>

            </div>

        </div>

    </main>

</div>


<script src="../../../public/js/app.js"></script>

</body>

</html>