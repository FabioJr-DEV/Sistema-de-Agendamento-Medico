```php
<?php
/*
|--------------------------------------------------------------------------
| Página: editar.php
|--------------------------------------------------------------------------
| Objetivo:
| Exibir o formulário de edição de usuários.
|--------------------------------------------------------------------------
*/

require_once "../../../includes/verificar_admin.php";
require_once "../../../config/conexao.php";

if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET["id"];

$sql = "SELECT
            id,
            nome,
            email,
            perfil
        FROM usuarios
        WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$resultado = $stmt->get_result();

$usuario = $resultado->fetch_assoc();

if (!$usuario) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Usuário - Administração</title>

    <link rel="stylesheet" href="../../../public/css/app.css">

</head>

<body>

<div class="layout">

    <!-- MENU LATERAL -->
    <aside class="sidebar">

        <div class="brand">
            Clínica Vida+
            <small>Administração</small>
        </div>

        <nav class="nav">

            <a href="../dashboard.php">
                Dashboard
            </a>

            <a class="active" href="index.php">
                Usuários
            </a>

            <a href="../medicos/index.php">
                Médicos
            </a>

            <a href="../especialidades/index.php">
                Especialidades
            </a>

            <a href="../horarios/index.php">
                Horários
            </a>

            <a href="../relatorios.php">
                Relatórios
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
                <h1>Editar Usuário</h1>
            </div>

            <div class="user">
                <?= htmlspecialchars($_SESSION["nome"] ?? "") ?>
            </div>

        </div>


        <!-- FORMULÁRIO -->
        <div class="card">

            <div class="card-header">

                <div>
                    <h2>Dados do usuário</h2>
                    <p>Altere as informações do usuário selecionado.</p>
                </div>

            </div>


            <form action="../../../actions/usuarios/editar.php" method="POST">

                <input
                    type="hidden"
                    name="id"
                    value="<?= htmlspecialchars($usuario["id"]) ?>"
                >


                <div class="form-grid">

                    <!-- NOME -->
                    <div class="field">

                        <label for="nome">
                            Nome
                        </label>

                        <input
                            type="text"
                            id="nome"
                            name="nome"
                            value="<?= htmlspecialchars($usuario["nome"]) ?>"
                            required
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
                            value="<?= htmlspecialchars($usuario["email"]) ?>"
                            required
                        >

                    </div>


                    <!-- PERFIL -->
                    <div class="field">

                        <label for="perfil">
                            Perfil
                        </label>

                        <select
                            id="perfil"
                            name="perfil"
                            required
                        >

                            <option
                                value="Administrador"
                                <?= $usuario["perfil"] == "Administrador" ? "selected" : "" ?>
                            >
                                Administrador
                            </option>

                            <option
                                value="Recepcionista"
                                <?= $usuario["perfil"] == "Recepcionista" ? "selected" : "" ?>
                            >
                                Recepcionista
                            </option>

                            <option
                                value="Medico"
                                <?= $usuario["perfil"] == "Medico" ? "selected" : "" ?>
                            >
                                Médico
                            </option>

                        </select>

                    </div>

                </div>


                <!-- BOTÕES -->
                <div class="actions">

                    <a
                        href="index.php"
                        class="btn btn-secondary"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Salvar Alterações
                    </button>

                </div>

            </form>

        </div>

    </main>

</div>


<script src="../../../public/js/app.js"></script>

</body>

</html>
```
