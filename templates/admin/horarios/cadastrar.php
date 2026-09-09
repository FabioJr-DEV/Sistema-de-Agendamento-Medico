```php
<?php

/*
|--------------------------------------------------------------------------
| Página: cadastrar horário
|--------------------------------------------------------------------------
| Objetivo:
| Permitir que o administrador defina a disponibilidade de um médico.
|--------------------------------------------------------------------------
*/

require_once "../../../includes/verificar_admin.php";
require_once "../../../config/conexao.php";


/*
|--------------------------------------------------------------------------
| Busca os médicos ativos
|--------------------------------------------------------------------------
*/

$sql = "SELECT
            m.id,
            u.nome

        FROM medicos m

        INNER JOIN usuarios u
            ON u.id = m.usuario_id

        WHERE m.ativo = 1
        AND u.ativo = 1

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

    <title>Definir Horário</title>

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

                <h1>Definir Horário de Atendimento</h1>

                <div class="user">
                    Configure a disponibilidade de um médico
                </div>

            </div>

            <div class="user">

                <?= htmlspecialchars($_SESSION["nome"] ?? "") ?>

            </div>

        </div>


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
             FORMULÁRIO
        ======================================================= -->

        <div class="card">

            <div class="card-header">

                <div>

                    <h2>Novo horário</h2>

                    <p>
                        Defina o dia e o período em que o médico estará disponível.
                    </p>

                </div>

            </div>


            <form
                action="../../../actions/horarios/cadastrar.php"
                method="POST"
            >

                <div class="form-grid">


                    <!-- MÉDICO -->

                    <div class="field full">

                        <label for="medico_id">
                            Médico *
                        </label>

                        <select
                            id="medico_id"
                            name="medico_id"
                            required
                        >

                            <option value="">
                                Selecione o médico
                            </option>

                            <?php while ($medico = $resultado->fetch_assoc()): ?>

                                <option
                                    value="<?= (int) $medico["id"] ?>"
                                >
                                    <?= htmlspecialchars($medico["nome"]) ?>
                                </option>

                            <?php endwhile; ?>

                        </select>

                    </div>


                    <!-- DIA DA SEMANA -->

                    <div class="field">

                        <label for="dia_semana">
                            Dia da semana *
                        </label>

                        <select
                            id="dia_semana"
                            name="dia_semana"
                            required
                        >

                            <option value="">
                                Selecione
                            </option>

                            <option value="0">
                                Domingo
                            </option>

                            <option value="1">
                                Segunda-feira
                            </option>

                            <option value="2">
                                Terça-feira
                            </option>

                            <option value="3">
                                Quarta-feira
                            </option>

                            <option value="4">
                                Quinta-feira
                            </option>

                            <option value="5">
                                Sexta-feira
                            </option>

                            <option value="6">
                                Sábado
                            </option>

                        </select>

                    </div>


                    <!-- INTERVALO -->

                    <div class="field">

                        <label for="intervalo_minutos">
                            Intervalo entre atendimentos *
                        </label>

                        <select
                            id="intervalo_minutos"
                            name="intervalo_minutos"
                            required
                        >

                            <option value="15">
                                15 minutos
                            </option>

                            <option value="30" selected>
                                30 minutos
                            </option>

                            <option value="45">
                                45 minutos
                            </option>

                            <option value="60">
                                60 minutos
                            </option>

                        </select>

                    </div>


                    <!-- HORA INICIAL -->

                    <div class="field">

                        <label for="hora_inicio">
                            Hora inicial *
                        </label>

                        <input
                            type="time"
                            id="hora_inicio"
                            name="hora_inicio"
                            required
                        >

                    </div>


                    <!-- HORA FINAL -->

                    <div class="field">

                        <label for="hora_fim">
                            Hora final *
                        </label>

                        <input
                            type="time"
                            id="hora_fim"
                            name="hora_fim"
                            required
                        >

                    </div>


                </div>


                <!-- ==================================================
                     BOTÕES
                =================================================== -->

                <div class="actions">

                    <a
                        class="btn btn-secondary"
                        href="index.php"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Cadastrar horário
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
