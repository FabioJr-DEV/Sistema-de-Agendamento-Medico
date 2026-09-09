<?php

require_once "../../../includes/verificar_recepcao.php";
require_once "../../../config/conexao.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    $_SESSION["erro"] = "Paciente inválido.";
    header("Location: index.php");
    exit;
}

$id = (int) $_GET["id"];

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
            ativo
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

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

```
<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Editar Paciente | Clínica Vida+</title>

<link
    rel="stylesheet"
    href="../../../public/css/app.css"
>
```

</head>

<body>

<div class="layout">

```
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

        <a class="active" href="index.php">
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


<!-- CONTEÚDO -->
<main class="main">

    <div class="topbar">

        <div>

            <h1>Editar paciente</h1>

            <p>
                Atualize os dados cadastrais do paciente.
            </p>

        </div>

        <div class="user">
            <?= htmlspecialchars($_SESSION["nome"] ?? "") ?>
        </div>

    </div>


    <div class="card">

        <div class="card-header">

            <div>

                <h2>Dados do paciente</h2>

                <p>
                    Altere as informações necessárias e salve as alterações.
                </p>

            </div>

        </div>


        <?php if (isset($_SESSION["erro"])): ?>

            <div class="alert alert-error">

                <?= htmlspecialchars($_SESSION["erro"]) ?>

            </div>

            <?php unset($_SESSION["erro"]); ?>

        <?php endif; ?>


        <form
            action="../../../actions/pacientes/editar.php"
            method="POST"
        >

            <input
                type="hidden"
                name="id"
                value="<?= htmlspecialchars($paciente["id"]) ?>"
            >


            <div class="form-grid">

                <!-- NOME -->
                <div class="field full">

                    <label for="nome">
                        Nome completo
                    </label>

                    <input
                        type="text"
                        id="nome"
                        name="nome"
                        value="<?= htmlspecialchars($paciente["nome"]) ?>"
                        maxlength="100"
                        required
                    >

                </div>


                <!-- CPF -->
                <div class="field">

                    <label for="cpf">
                        CPF
                    </label>

                    <input
                        type="text"
                        id="cpf"
                        name="cpf"
                        value="<?= htmlspecialchars($paciente["cpf"]) ?>"
                        maxlength="14"
                        required
                    >

                </div>


                <!-- DATA DE NASCIMENTO -->
                <div class="field">

                    <label for="data_nascimento">
                        Data de nascimento
                    </label>

                    <input
                        type="date"
                        id="data_nascimento"
                        name="data_nascimento"
                        value="<?= htmlspecialchars($paciente["data_nascimento"]) ?>"
                        required
                    >

                </div>


                <!-- SEXO -->
                <div class="field">

                    <label for="sexo">
                        Sexo
                    </label>

                    <select
                        id="sexo"
                        name="sexo"
                        required
                    >

                        <option value="">
                            Selecione
                        </option>

                        <option
                            value="Masculino"
                            <?= $paciente["sexo"] === "Masculino" ? "selected" : "" ?>
                        >
                            Masculino
                        </option>

                        <option
                            value="Feminino"
                            <?= $paciente["sexo"] === "Feminino" ? "selected" : "" ?>
                        >
                            Feminino
                        </option>

                        <option
                            value="Outro"
                            <?= $paciente["sexo"] === "Outro" ? "selected" : "" ?>
                        >
                            Outro
                        </option>

                    </select>

                </div>


                <!-- TELEFONE -->
                <div class="field">

                    <label for="telefone">
                        Telefone
                    </label>

                    <input
                        type="text"
                        id="telefone"
                        name="telefone"
                        value="<?= htmlspecialchars($paciente["telefone"] ?? "") ?>"
                        maxlength="20"
                    >

                </div>


                <!-- E-MAIL -->
                <div class="field">

                    <label for="email">
                        E-mail
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?= htmlspecialchars($paciente["email"] ?? "") ?>"
                        maxlength="150"
                    >

                </div>


                <!-- ENDEREÇO -->
                <div class="field full">

                    <label for="endereco">
                        Endereço
                    </label>

                    <input
                        type="text"
                        id="endereco"
                        name="endereco"
                        value="<?= htmlspecialchars($paciente["endereco"] ?? "") ?>"
                        maxlength="255"
                    >

                </div>


                <!-- CONVÊNIO -->
                <div class="field">

                    <label for="convenio">
                        Convênio
                    </label>

                    <input
                        type="text"
                        id="convenio"
                        name="convenio"
                        value="<?= htmlspecialchars($paciente["convenio"] ?? "") ?>"
                        maxlength="100"
                    >

                </div>


                <!-- TIPO SANGUÍNEO -->
                <div class="field">

                    <label for="tipo_sanguineo">
                        Tipo sanguíneo
                    </label>

                    <input
                        type="text"
                        id="tipo_sanguineo"
                        name="tipo_sanguineo"
                        value="<?= htmlspecialchars($paciente["tipo_sanguineo"] ?? "") ?>"
                        maxlength="5"
                    >

                </div>


                <!-- ALERGIAS -->
                <div class="field full">

                    <label for="alergias">
                        Alergias
                    </label>

                    <textarea
                        id="alergias"
                        name="alergias"
                    ><?= htmlspecialchars($paciente["alergias"] ?? "") ?></textarea>

                </div>


                <!-- OBSERVAÇÕES -->
                <div class="field full">

                    <label for="observacoes">
                        Observações
                    </label>

                    <textarea
                        id="observacoes"
                        name="observacoes"
                    ><?= htmlspecialchars($paciente["observacoes"] ?? "") ?></textarea>

                </div>


                <!-- STATUS -->
                <div class="field">

                    <label for="ativo">
                        Status
                    </label>

                    <select
                        id="ativo"
                        name="ativo"
                        required
                    >

                        <option
                            value="1"
                            <?= $paciente["ativo"] == 1 ? "selected" : "" ?>
                        >
                            Ativo
                        </option>

                        <option
                            value="0"
                            <?= $paciente["ativo"] == 0 ? "selected" : "" ?>
                        >
                            Inativo
                        </option>

                    </select>

                </div>

            </div>


            <div class="actions">

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Salvar alterações
                </button>

                <a
                    href="index.php"
                    class="btn btn-secondary"
                >
                    Cancelar
                </a>

            </div>

        </form>

    </div>

</main>
```

</div>

<script src="../../../public/js/app.js"></script>

</body>

</html>
