<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/controller/database.php';

if (isset($_POST['btn-login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($password == $row['password']) {
            $_SESSION['user_id'] = $row['id'];
            header("Location: home.php"); // Redirecionar para a página inicial após o login bem-sucedido
        } else {
            $errorMessage = "Senha incorreta.";
        }
    } else {
        $errorMessage = "Nome de usuário não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Sistema de reservas de mesas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="assets/style.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header">
                        <h4 class="text-center">Sistema de reservas de mesas</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($errorMessage)) { ?>
                            <div><?php echo $errorMessage; ?></div>
                        <?php } ?>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="form-group">
                                <label for="username">Usuário</label>
                                <input type="text" class="form-control" id="username" placeholder="Digite seu usuário" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Senha</label>
                                <input type="password" class="form-control" id="password" placeholder="Digite sua senha" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" name="btn-login">Entrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>