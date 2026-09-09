```php
<?php

/*
|--------------------------------------------------------------------------
| Página: consultar horários
|--------------------------------------------------------------------------
| Objetivo:
| Exibir os horários de atendimento cadastrados pelos administradores.
|--------------------------------------------------------------------------
*/

require_once "../../../includes/verificar_admin.php";
require_once "../../../config/conexao.php";


/*
|--------------------------------------------------------------------------
| Busca os horários
|--------------------------------------------------------------------------
*/

$sql = "SELECT
            h.id,
            h.medico_id,
            h.dia_semana,
            h.hora_inicio,
            h.hora_fim,
            h.intervalo_minutos,
            h.ativo,
            u.nome AS medico_nome

        FROM horarios h

        INNER JOIN medicos m
            ON m.id = h.medico_id

        INNER JOIN usuarios u
            ON u.id = m.usuario_id

        ORDER BY
            u.nome ASC,
            h.dia_semana ASC,
            h.hora_inicio ASC";


$stmt = $conn->prepare($sql);

$stmt->execute();

$resultado = $stmt->get_result();


/*
|--------------------------------------------------------------------------
| Converte o número do dia para o nome
|--------------------------------------------------------------------------
*/

$dias_semana = [
    0 => "Domingo",
    1 => "Segunda-feira",
    2 => "Terça-feira",
    3 => "Quarta-feira",
    4 => "Quinta-feira",
    5 => "Sexta-feira",
    6 => "Sábado"
];

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Horários de Atendimento</title>

    <link
        rel="stylesheet"
        href="../../../public/css/app.css"
    >

</head>

<body>

<div class="layout">

    <!-- ==========================================================
         MENU LATERAL
    =========================================================== -->

    <aside class="sidebar">

        <div class="brand">

            Clínica Vida+

            <small>Administrador</small>

        </div>

        <nav class="nav">

            <a href="../dashboard.php">
                Dashboard
            </a>

            <a href="../usuarios/index.php">
                Usuários
            </a>

            <a href="../medicos/index.php">
                Médicos
            </a>

            <a href="../especialidades/index.php">
                Especialidades
            </a>

            <a class="active" href="index.php">
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


    <!-- ==========================================================
         CONTEÚDO PRINCIPAL
    =========================================================== -->

    <main class="main">

        <div class="topbar">

            <div>

                <h1>Horários de Atendimento</h1>

                <div class="user">
                    Gerencie os horários de atendimento dos médicos
                </div>

            </div>

            <div class="user">

                <?= htmlspecialchars($_SESSION["nome"] ?? "") ?>

            </div>

        </div>


        <!-- ======================================================
             MENSAGEM DE SUCESSO
        ======================================================= -->

        <?php if (isset($_SESSION["sucesso"])): ?>

            <div class="alert alert-success">

                <?= htmlspecialchars($_SESSION["sucesso"]) ?>

            </div>

            <?php unset($_SESSION["sucesso"]); ?>

        <?php endif; ?>


        <!-- ======================================================
             MENSAGEM DE ERRO
        ======================================================= -->

        <?php if (isset($_SESSION["erro"])): ?>

            <div class="alert alert-error">

                <?= htmlspecialchars($_SESSION["erro"]) ?>

            </div>

            <?php unset($_SESSION["erro"]); ?>

        <?php endif; ?>


        <!-- ======================================================
             CARD PRINCIPAL
        ======================================================= -->

        <div class="card">

            <div class="card-header">

                <div>

                    <h2>Horários cadastrados</h2>

                    <p>
                        Consulte os horários de atendimento definidos para cada médico.
                    </p>

                </div>

                <a
                    class="btn btn-primary"
                    href="cadastrar.php"
                >
                    + Definir novo horário
                </a>

            </div>


            <!-- ==================================================
                 TABELA
            =================================================== -->

            <div class="table-container">

                <table>

                    <thead>

                        <tr>

                            <th>Médico</th>

                            <th>Dia</th>

                            <th>Horário inicial</th>

                            <th>Horário final</th>

                            <th>Intervalo</th>

                            <th>Status</th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php if ($resultado->num_rows > 0): ?>

                        <?php while ($horario = $resultado->fetch_assoc()): ?>

                            <tr>

                                <!-- MÉDICO -->

                                <td>

                                    <strong>
                                        <?= htmlspecialchars(
                                            $horario["medico_nome"]
                                        ) ?>
                                    </strong>

                                </td>


                                <!-- DIA -->

                                <td>

                                    <?= htmlspecialchars(
                                        $dias_semana[$horario["dia_semana"]]
                                        ?? "Desconhecido"
                                    ) ?>

                                </td>


                                <!-- HORÁRIO INICIAL -->

                                <td>

                                    <?= htmlspecialchars(
                                        substr($horario["hora_inicio"], 0, 5)
                                    ) ?>

                                </td>


                                <!-- HORÁRIO FINAL -->

                                <td>

                                    <?= htmlspecialchars(
                                        substr($horario["hora_fim"], 0, 5)
                                    ) ?>

                                </td>


                                <!-- INTERVALO -->

                                <td>

                                    <?= (int) $horario["intervalo_minutos"] ?>

                                    minutos

                                </td>


                                <!-- STATUS -->

                                <td>

                                    <?php if ($horario["ativo"] == 1): ?>

                                        <span class="status status-active">
                                            Ativo
                                        </span>

                                    <?php else: ?>

                                        <span class="status status-inactive">
                                            Inativo
                                        </span>

                                    <?php endif; ?>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>

                            <td
                                colspan="6"
                                class="empty"
                            >
                                Nenhum horário cadastrado.
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
