<?php
require_once "../../actions/relatorios_consultas_admin.php";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios - Administração</title>

    <link rel="stylesheet" href="../../public/css/app.css">
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

            <a href="dashboard.php">
                Dashboard
            </a>

            <a href="usuarios/index.php">
                Usuários
            </a>

            <a href="medicos/index.php">
                Médicos
            </a>

            <a href="especialidades/index.php">
                Especialidades
            </a>

            <a href="horarios/index.php">
                Horários
            </a>

            <a class="active" href="relatorios.php">
                Relatórios
            </a>

            <a href="../../logout.php">
                Sair
            </a>

        </nav>

    </aside>


    <!-- CONTEÚDO PRINCIPAL -->
    <main class="main">

        <div class="topbar">

            <div>
                <h1>Relatórios de Consultas</h1>
            </div>

            <div class="user">
                <?= htmlspecialchars($_SESSION["nome"] ?? "") ?>
            </div>

        </div>


        <!-- US031 -->
        <section class="card">

            <div class="card-header">

                <div>
                    <h2>Todas as Consultas</h2>
                    <p>US031 — Relatório geral de consultas</p>
                </div>

            </div>

            <div class="table-container">

                <table>

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Médico</th>
                            <th>Data de Início</th>
                            <th>Status</th>
                            <th>Especialidade</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if ($res_todas_consultas->num_rows > 0): ?>

                            <?php while ($row = $res_todas_consultas->fetch_assoc()): ?>

                                <tr>

                                    <td>
                                        <?= htmlspecialchars($row['id']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['medico_nome']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['data_inicio']) ?>
                                    </td>

                                    <td>

                                        <?php
                                        $status = $row['status'];

                                        $classe_status = 'badge-blue';

                                        if ($status === 'Finalizada') {
                                            $classe_status = 'badge-green';
                                        } elseif ($status === 'Cancelada') {
                                            $classe_status = 'badge-red';
                                        } elseif ($status === 'Em Andamento') {
                                            $classe_status = 'badge-yellow';
                                        }
                                        ?>

                                        <span class="badge <?= $classe_status ?>">
                                            <?= htmlspecialchars($status) ?>
                                        </span>

                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['especialidade']) ?>
                                    </td>

                                </tr>

                            <?php endwhile; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="5" class="empty">
                                    Nenhuma consulta encontrada.
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </section>


        <!-- US032 -->
        <section class="card">

            <div class="card-header">

                <div>
                    <h2>Consultas por Médico</h2>
                    <p>US032 — Total de consultas por médico</p>
                </div>

            </div>

            <div class="table-container">

                <table>

                    <thead>
                        <tr>
                            <th>Médico</th>
                            <th>Total de Consultas</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if ($res_consultas_por_medico->num_rows > 0): ?>

                            <?php while ($row = $res_consultas_por_medico->fetch_assoc()): ?>

                                <tr>

                                    <td>
                                        <?= htmlspecialchars($row['medico']) ?>
                                    </td>

                                    <td>
                                        <strong>
                                            <?= htmlspecialchars($row['total_consultas']) ?>
                                        </strong>
                                    </td>

                                </tr>

                            <?php endwhile; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="2" class="empty">
                                    Nenhuma consulta encontrada.
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </section>


        <!-- US033 -->
        <section class="card">

            <div class="card-header">

                <div>
                    <h2>Consultas por Especialidade</h2>
                    <p>US033 — Total de consultas por especialidade</p>
                </div>

            </div>

            <div class="table-container">

                <table>

                    <thead>
                        <tr>
                            <th>Especialidade</th>
                            <th>Total de Consultas</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if ($res_consultas_por_especialidade->num_rows > 0): ?>

                            <?php while ($row = $res_consultas_por_especialidade->fetch_assoc()): ?>

                                <tr>

                                    <td>
                                        <?= htmlspecialchars($row['especialidade']) ?>
                                    </td>

                                    <td>
                                        <strong>
                                            <?= htmlspecialchars($row['total_consultas']) ?>
                                        </strong>
                                    </td>

                                </tr>

                            <?php endwhile; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="2" class="empty">
                                    Nenhuma consulta encontrada.
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </section>

    </main>

</div>

<script src="../../public/js/app.js"></script>

</body>
</html>
```
