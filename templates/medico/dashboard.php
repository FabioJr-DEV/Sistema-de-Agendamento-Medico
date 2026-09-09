<?php

session_start();

if (!isset($_SESSION["id"], $_SESSION["perfil"])) {
    header("Location: ../../public/index.php");
    exit;
}

if ($_SESSION["perfil"] !== "Medico") {
    header("Location: ../painel-usuario.php");
    exit;
}

require_once "../../config/conexao.php";

$usuario_id = (int) $_SESSION["id"];

/*
|--------------------------------------------------------------------------
| Busca o médico vinculado ao usuário
|--------------------------------------------------------------------------
*/

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
    die("Médico não encontrado.");
}

$medico_id = (int) $medico["id"];


/*
|--------------------------------------------------------------------------
| Estatísticas do dia
|--------------------------------------------------------------------------
*/

$total_hoje = 0;
$agendadas = 0;
$em_andamento = 0;
$finalizadas = 0;

$sql = "
    SELECT
        COUNT(*) AS total,
        SUM(status = 'Agendada') AS agendadas,
        SUM(status = 'Em Andamento') AS em_andamento,
        SUM(status = 'Finalizada') AS finalizadas
    FROM consultas
    WHERE medico_id = ?
    AND data_consulta = CURDATE()
    AND status <> 'Cancelada'
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $medico_id);
$stmt->execute();

$resultado = $stmt->get_result();
$estatisticas = $resultado->fetch_assoc();

if ($estatisticas) {
    $total_hoje = (int) ($estatisticas["total"] ?? 0);
    $agendadas = (int) ($estatisticas["agendadas"] ?? 0);
    $em_andamento = (int) ($estatisticas["em_andamento"] ?? 0);
    $finalizadas = (int) ($estatisticas["finalizadas"] ?? 0);
}


/*
|--------------------------------------------------------------------------
| Consultas de hoje
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT
        c.id,
        c.horario,
        c.status,
        c.motivo_consulta,
        p.id AS paciente_id,
        p.nome AS paciente_nome,
        p.telefone
    FROM consultas c
    INNER JOIN pacientes p ON c.paciente_id = p.id
    WHERE c.medico_id = ?
    AND c.data_consulta = CURDATE()
    AND c.status <> 'Cancelada'
    ORDER BY c.horario ASC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $medico_id);
$stmt->execute();

$consultas = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Clínica Vida+ | Dashboard Médico</title>

    <link
        rel="stylesheet"
        href="../../public/css/app.css"
    >

</head>

<body>

<div class="layout">

    <aside class="sidebar">

        <div class="brand">
            Clínica Vida+
            <small>Área médica</small>
        </div>

        <nav class="nav">

            <a
                class="active"
                href="dashboard.php"
            >
                Dashboard
            </a>

            <a href="agenda.php">
                Agenda
            </a>

            <a href="pacientes.php">
                Pacientes
            </a>

            <a href="prontuario.php">
                Prontuário
            </a>

            <a href="alterar_senha.php">
                Alterar senha
            </a>

            <a href="../../logout.php">
                Sair
            </a>

        </nav>

    </aside>


    <main class="main">

        <div class="topbar">

            <div>
                <h1>Dashboard</h1>

                <p style="margin-top: 5px; color: #64748b;">
                    Acompanhamento dos seus atendimentos
                </p>
            </div>

            <div class="user">

                <?= htmlspecialchars($_SESSION["nome"] ?? "") ?>

            </div>

        </div>


        <!-- Estatísticas -->

        <div class="grid">

            <div class="stat">

                <span>Consultas hoje</span>

                <strong>
                    <?= $total_hoje ?>
                </strong>

            </div>


            <div class="stat">

                <span>Agendadas</span>

                <strong>
                    <?= $agendadas ?>
                </strong>

            </div>


            <div class="stat">

                <span>Em andamento</span>

                <strong>
                    <?= $em_andamento ?>
                </strong>

            </div>


            <div class="stat">

                <span>Finalizadas</span>

                <strong>
                    <?= $finalizadas ?>
                </strong>

            </div>

        </div>


        <!-- Consultas -->

        <div class="card">

            <div class="card-header">

                <div>

                    <h2>
                        Consultas de hoje
                    </h2>

                    <p>
                        <?= date("d/m/Y") ?>
                    </p>

                </div>

                <a
                    href="agenda.php"
                    class="btn btn-secondary"
                >
                    Ver agenda
                </a>

            </div>


            <div class="table-container">

                <?php if ($consultas->num_rows > 0): ?>

                    <table>

                        <thead>

                            <tr>

                                <th>Horário</th>

                                <th>Paciente</th>

                                <th>Telefone</th>

                                <th>Status</th>

                                <th>Ação</th>

                            </tr>

                        </thead>

                        <tbody>

                        <?php while ($consulta = $consultas->fetch_assoc()): ?>

                            <tr>

                                <td>
                                    <?= htmlspecialchars(
                                        date(
                                            "H:i",
                                            strtotime($consulta["horario"])
                                        )
                                    ) ?>
                                </td>


                                <td>
                                    <?= htmlspecialchars(
                                        $consulta["paciente_nome"]
                                    ) ?>
                                </td>


                                <td>
                                    <?= htmlspecialchars(
                                        $consulta["telefone"] ?? "-"
                                    ) ?>
                                </td>


                                <td>

                                    <?php

                                    $classe_status = "badge-blue";

                                    if ($consulta["status"] === "Agendada") {
                                        $classe_status = "badge-yellow";
                                    }

                                    if ($consulta["status"] === "Em Andamento") {
                                        $classe_status = "badge-blue";
                                    }

                                    if ($consulta["status"] === "Finalizada") {
                                        $classe_status = "badge-green";
                                    }

                                    ?>

                                    <span class="badge <?= $classe_status ?>">

                                        <?= htmlspecialchars(
                                            $consulta["status"]
                                        ) ?>

                                    </span>

                                </td>


                                <td>

                                    <?php if ($consulta["status"] === "Agendada"): ?>

                                        <form
    action="../../actions/iniciar_atendimento_medico.php"
    method="POST"
    style="display:inline;"
>
    <input
        type="hidden"
        name="id_consulta"
        value="<?= (int) $consulta["id"] ?>"
    >

    <button
        type="submit"
        class="btn btn-primary"
    >
        Iniciar
    </button>
</form>

                                    <?php elseif ($consulta["status"] === "Em Andamento"): ?>

                                        <a
                                            href="registrar_prontuario.php?id=<?= $consulta["id"] ?>"
                                            class="btn btn-primary"
                                        >
                                            Atendimento
                                        </a>

                                    <?php else: ?>

                                        <span style="color:#64748b;">
                                            Concluída
                                        </span>

                                    <?php endif; ?>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                        </tbody>

                    </table>

                <?php else: ?>

                    <div class="empty">

                        Nenhuma consulta agendada para hoje.

                    </div>

                <?php endif; ?>

            </div>

        </div>


        <!-- Acesso rápido -->

        <div class="card">

            <h2>Acesso rápido</h2>

            <div class="actions">

                <a
                    href="agenda.php"
                    class="btn btn-primary"
                >
                    Ver agenda
                </a>

                <a
                    href="pacientes.php"
                    class="btn btn-secondary"
                >
                    Consultar pacientes
                </a>

                <a
                    href="prontuario.php"
                    class="btn btn-secondary"
                >
                    Prontuários
                </a>

            </div>

        </div>

    </main>

</div>

<script src="../../public/js/app.js"></script>

</body>

</html>