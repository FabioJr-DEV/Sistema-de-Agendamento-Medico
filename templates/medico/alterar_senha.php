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

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Clínica Vida+ | Alterar senha</title>

    <link rel="stylesheet" href="../../public/css/app.css">
</head>

<body>

<div class="login-page">

    <div class="login-card">

        <div class="login-brand">
            <div class="icon">✚</div>

            <h1>Primeiro acesso</h1>

            <p>
                Por segurança, altere sua senha antes de continuar.
            </p>
        </div>

        <?php if (isset($_SESSION["erro"])): ?>

            <div class="alert alert-error">
                <?= htmlspecialchars($_SESSION["erro"]) ?>
            </div>

            <?php unset($_SESSION["erro"]); ?>

        <?php endif; ?>


        <?php if (isset($_SESSION["sucesso"])): ?>

            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION["sucesso"]) ?>
            </div>

            <?php unset($_SESSION["sucesso"]); ?>

        <?php endif; ?>


        <form action="../../actions/medicos/alterar_senha.php" method="POST">

            <div class="field">

                <label for="senha_atual">
                    Senha atual
                </label>

                <input
                    id="senha_atual"
                    type="password"
                    name="senha_atual"
                    required
                >

            </div>


            <div class="field">

                <label for="nova_senha">
                    Nova senha
                </label>

                <input
                    id="nova_senha"
                    type="password"
                    name="nova_senha"
                    minlength="6"
                    required
                >

            </div>


            <div class="field">

                <label for="confirmar_senha">
                    Confirmar nova senha
                </label>

                <input
                    id="confirmar_senha"
                    type="password"
                    name="confirmar_senha"
                    minlength="6"
                    required
                >

            </div>


            <button
                class="btn-primary"
                type="submit"
            >
                Alterar senha
            </button>

        </form>

    </div>

</div>

</body>

</html>