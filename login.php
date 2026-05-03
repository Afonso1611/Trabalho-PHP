<?php
session_start();

if (isset($_SESSION['logado'])) {
    header("Location: index.php"); 
    exit;
}

$usuario_padrao = "admin";
$senha_hash = password_hash("1234", PASSWORD_DEFAULT);
$erro = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if ($usuario == $usuario_padrao && password_verify($senha, $senha_hash)) {
        $_SESSION['logado'] = true;
        header("Location: index.php"); 
        exit;
    } else {
        $erro = "Usuário ou senha inválidos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyWallet - Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: sans-serif; }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            background: #fff;
            width: 350px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .header {
            background: #212529;
            color: white;
            text-align: center;
            padding: 40px 20px;
        }

        .header i { font-size: 50px; margin-bottom: 10px; }
        .header h1 { font-size: 24px; }
        .header p { font-size: 12px; opacity: 0.7; }

        .form-body { padding: 30px; }

        .input-group { margin-bottom: 20px; }
        .input-group label {
            display: block;
            font-size: 11px;
            font-weight: bold;
            color: #666;
            margin-bottom: 5px;
        }

        .input-field {
            display: flex;
            align-items: center;
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
        }

        .input-field i { color: #ccc; margin-right: 10px; }
        .input-field input {
            border: none;
            background: none;
            outline: none;
            width: 100%;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 5px;
            background: linear-gradient(to right, #5c7cfa, #9155b4);
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .error-msg {
            color: #ff4d4d;
            font-size: 12px;
            text-align: center;
            margin-top: 15px;
        }

        .footer {
            text-align: center;
            padding-bottom: 20px;
            font-size: 10px;
            color: #aaa;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="header">
        <i class="fas fa-wallet"></i>
        <h1>MyWallet</h1>
        <p>Gestão Financeira Pessoal</p>
    </div>

    <div class="form-body">
        <form method="post">
            <div class="input-group">
                <label>UTILIZADOR</label>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="usuario" placeholder="Usuário" required>
                </div>
            </div>

            <div class="input-group">
                <label>PALAVRA-PASSE</label>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="senha" placeholder="Senha" required>
                </div>
            </div>

            <button type="submit" class="btn-submit">ENTRAR NO SISTEMA</button>
            
            <?php if ($erro): ?>
                <p class="error-msg"><?= $erro ?></p>
            <?php endif; ?>
        </form>
    </div>

    <div class="footer">
        PHP Academic Project © <?= date("Y") ?>
    </div>
</div>

</body>
</html>