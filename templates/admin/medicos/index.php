```php
<?php

/*
|--------------------------------------------------------------------------
| Página: consultar médicos - administrador
|--------------------------------------------------------------------------
*/

require_once "../../../includes/verificar_admin.php";
require_once "../../../config/conexao.php";


/*
|--------------------------------------------------------------------------
| Busca os médicos
|--------------------------------------------------------------------------
*/

$sql = "SELECT
            m.id,
            u.nome,
            u.email,
            m.crm_numero,
            m.crm_uf,
            m.telefone,
            m.ativo,

            GROUP_CONCAT(
                e.nome
                ORDER BY e.nome
                SEPARATOR ', '
            ) AS especialidades

        FROM medicos m

        INNER JOIN usuarios u
            ON u.id = m.usuario_id

        LEFT JOIN medicos_especialidades me
            ON me.medico_id = m.id

        LEFT JOIN especialidades e
            ON e.id = me.especialidade_id

        GROUP BY
            m.id,
            u.nome,
            u.email,
            m.crm_numero,
            m.crm_uf,
            m.telefone,
            m.ativo

        ORDER BY u.nome ASC";


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

    <title>Médicos</title>

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

            <a href="../usuarios/index.php">
                Usuários
            </a>

            <a
                href="index.php"
                class="active"
            >
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
                    Médicos
                </h1>

                <p style="color: var(--muted); margin-top: 5px;">
                    Gerenciamento dos médicos cadastrados
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
                        Médicos cadastrados
                    </h2>

                    <p>
                        Consulte e gerencie os médicos da clínica.
                    </p>

                </div>

                <a
                    href="cadastrar.php"
                    class="btn btn-primary"
                >
                    + Novo médico
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
                                CRM
                            </th>

                            <th>
                                Especialidade
                            </th>

                            <th>
                                Telefone
                            </th>

                            <th>
                                E-mail
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Ações
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php if ($resultado->num_rows > 0): ?>

                        <?php while ($medico = $resultado->fetch_assoc()): ?>

                            <tr>

                                <td>
                                    <?= htmlspecialchars($medico["id"]) ?>
                                </td>


                                <td>

                                    <strong>
                                        <?= htmlspecialchars($medico["nome"]) ?>
                                    </strong>

                                </td>


                                <td>

                                    <?= htmlspecialchars($medico["crm_numero"]) ?>

                                    /

                                    <?= htmlspecialchars($medico["crm_uf"]) ?>

                                </td>


                                <td>

                                    <?= htmlspecialchars(
                                        $medico["especialidades"]
                                        ?? "Não informada"
                                    ) ?>

                                </td>


                                <td>

                                    <?= htmlspecialchars(
                                        $medico["telefone"]
                                        ?? ""
                                    ) ?>

                                </td>


                                <td>

                                    <?= htmlspecialchars(
                                        $medico["email"]
                                    ) ?>

                                </td>


                                <td>

                                    <?php if ($medico["ativo"] == 1): ?>

                                        <span class="status status-active">
                                            Ativo
                                        </span>

                                    <?php else: ?>

                                        <span class="status status-inactive">
                                            Inativo
                                        </span>

                                    <?php endif; ?>

                                </td>


                                <td>

                                    <div
                                        class="actions"
                                        style="margin-top: 0;"
                                    >

                                        <a
                                            href="editar.php?id=<?= $medico["id"] ?>"
                                            class="btn btn-secondary"
                                        >
                                            Editar
                                        </a>

                                        <a
                                            href="../../../actions/medicos/excluir.php?id=<?= $medico["id"] ?>"
                                            class="btn btn-danger"
                                            onclick="return confirm('Tem certeza que deseja excluir este médico?');"
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
                                colspan="8"
                                class="empty"
                            >

                                Nenhum médico cadastrado.

                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>


            <!-- RODAPÉ -->

            <div class="card-footer">

                <a
                    href="cadastrar.php"
                    class="btn btn-primary"
                >
                    + Cadastrar novo médico
                </a>

            </div>

        </div>

    </main>

</div>


<script src="../../../public/js/app.js"></script>

</body>

</html>
```
