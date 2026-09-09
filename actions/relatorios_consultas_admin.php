```php
<?php

require_once "../../includes/verificar_admin.php";
require_once "../../config/conexao.php";


// ============================================================
// US031 – Todas as consultas
// ============================================================

$sql_todas_consultas = "
    SELECT
        c.id,
        CONCAT(c.data_consulta, ' ', c.horario) AS data_inicio,
        c.status,
        u.nome AS medico_nome,
        GROUP_CONCAT(DISTINCT e.nome ORDER BY e.nome SEPARATOR ', ') AS especialidade
    FROM consultas c
    INNER JOIN medicos m
        ON c.medico_id = m.id
    INNER JOIN usuarios u
        ON m.usuario_id = u.id
    LEFT JOIN medicos_especialidades me
        ON m.id = me.medico_id
    LEFT JOIN especialidades e
        ON me.especialidade_id = e.id
    GROUP BY
        c.id,
        c.data_consulta,
        c.horario,
        c.status,
        u.nome
    ORDER BY c.data_consulta DESC, c.horario DESC
";

$res_todas_consultas = $conn->query($sql_todas_consultas);


// ============================================================
// US032 – Consultas por Médico
// ============================================================

$sql_consultas_por_medico = "
    SELECT
        u.nome AS medico,
        COUNT(c.id) AS total_consultas
    FROM consultas c
    INNER JOIN medicos m
        ON c.medico_id = m.id
    INNER JOIN usuarios u
        ON m.usuario_id = u.id
    GROUP BY
        m.id,
        u.nome
    ORDER BY total_consultas DESC
";

$res_consultas_por_medico = $conn->query($sql_consultas_por_medico);


// ============================================================
// US033 – Consultas por Especialidade
// ============================================================

$sql_consultas_por_especialidade = "
    SELECT
        e.nome AS especialidade,
        COUNT(c.id) AS total_consultas
    FROM consultas c
    INNER JOIN medicos m
        ON c.medico_id = m.id
    INNER JOIN medicos_especialidades me
        ON m.id = me.medico_id
    INNER JOIN especialidades e
        ON me.especialidade_id = e.id
    GROUP BY
        e.id,
        e.nome
    ORDER BY total_consultas DESC
";

$res_consultas_por_especialidade = $conn->query($sql_consultas_por_especialidade);


// ============================================================
// Verificação de erros
// ============================================================

if (
    !$res_todas_consultas ||
    !$res_consultas_por_medico ||
    !$res_consultas_por_especialidade
) {
    die("Erro ao executar consultas: " . $conn->error);
}

