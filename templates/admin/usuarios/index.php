```php
<?php

/*
|--------------------------------------------------------------------------
| Página: index.php
|--------------------------------------------------------------------------
| Objetivo:
| Exibir a listagem de usuários cadastrados.
|
| Responsabilidades:
| - Verificar se o usuário é administrador.
| - Buscar os usuários cadastrados.
| - Exibir a lista de usuários.
|--------------------------------------------------------------------------
*/

require_once __DIR__ . "/../../../includes/verificar_admin.php";
require_once __DIR__ . "/../../../config/conexao.php";


/*
|--------------------------------------------------------------------------
| Busca os usuários
|--------------------------------------------------------------------------
*/

$sql = "SELECT
            id,
            nome,
            email,
            perfil,
            created_at
        FROM usuarios
        ORDER BY nome ASC";

$stmt = $conn->prepare($sql);
$stmt->execute();

$resultado = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Usuários</title>

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

            <small>
                Administrador
            </small>

        </div>

        <nav class="nav">

            <a href="../dashboard.php">
                Dashboard
            </a>

            <a
                href="index.php"
                class="active"
            >
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

                <h1>
                    Usuários
                </h1>

                <p style="color: var(--muted); margin-top: 5px;">
                    Gerenciamento dos usuários do sistema
                </p>

            </div>

            <div class="user">

                <?= htmlspecialchars($_SESSION["nome"] ?? "") ?>

            </div>

        </div>


        <!-- MENSAGENS -->

        <?php if (isset($_SESSION["sucesso"])): ?>

            <div class="alert alert-success">

                <?= htmlspecialchars($_SESSION["sucesso"]) ?>

            </div>

            <?php unset($_SESSION["sucesso"]); ?>

        <?php endif; ?>


        <?php if (isset($_SESSION["erro"])): ?>

            <div class="alert alert-error">

                <?= htmlspecialchars($_SESSION["erro"]) ?>

            </div>

            <?php unset($_SESSION["erro"]); ?>

        <?php endif; ?>


        <!-- CARD -->

        <div class="card">

            <div class="card-header">

                <div>

                    <h2>
                        Usuários cadastrados
                    </h2>

                    <p>
                        Consulte e gerencie os usuários do sistema.
                    </p>

                </div>

                <a
                    href="cadastrar.php"
                    class="btn btn-primary"
                >
                    + Novo usuário
                </a>

            </div>


            <!-- TABELA -->

            <div class="table-container">

                <table>

                    <thead>

                        <tr>

                            <th>
                                ID
                            </th>

                            <th>
                                Nome
                            </th>

                            <th>
                                E-mail
                            </th>

                            <th>
                                Perfil
                            </th>

                            <th>
                                Data de cadastro
                            </th>

                            <th>
                                Ações
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php if ($resultado->num_rows > 0): ?>

                        <?php while ($usuario = $resultado->fetch_assoc()): ?>

                            <tr>

                                <td>
                                    <?= htmlspecialchars($usuario["id"]) ?>
                                </td>

                                <td>

                                    <strong>
                                        <?= htmlspecialchars($usuario["nome"]) ?>
                                    </strong>

                                </td>

                                <td>
                                    <?= htmlspecialchars($usuario["email"]) ?>
                                </td>

                                <td>

                                    <?php

                                    $classePerfil = "badge-blue";

                                    if ($usuario["perfil"] === "Administrador") {
                                        $classePerfil = "badge-red";
                                    } elseif ($usuario["perfil"] === "Medico") {
                                        $classePerfil = "badge-green";
                                    } elseif ($usuario["perfil"] === "Recepcionista") {
                                        $classePerfil = "badge-yellow";
                                    }

                                    ?>

                                    <span class="badge <?= $classePerfil ?>">

                                        <?= htmlspecialchars($usuario["perfil"]) ?>

                                    </span>

                                </td>

                                <td>

                                    <?= date(
                                        "d/m/Y H:i",
                                        strtotime($usuario["created_at"])
                                    ) ?>

                                </td>

                                <td>

                                    <div class="actions" style="margin-top: 0;">

                                        <a
                                            href="editar.php?id=<?= $usuario["id"] ?>"
                                            class="btn btn-secondary"
                                        >
                                            Editar
                                        </a>

                                        <a
                                            href="../../../actions/usuarios/excluir.php?id=<?= $usuario["id"] ?>"
                                            class="btn btn-danger"
                                            onclick="return confirm('Tem certeza que deseja excluir este usuário?');"
                                        >
                                            Excluir
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>

                            <td
                                colspan="6"
                                class="empty"
                            >

                                Nenhum usuário cadastrado.

                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </main>

</div>


<script src="../../../public/js/app.js"></script>

</body>

</html>
```
