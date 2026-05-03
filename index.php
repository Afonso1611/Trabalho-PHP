<?php
session_start();
require_once "funcoes.php";

if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['transacoes'])) {
    $_SESSION['transacoes'] = [];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['limpar'])) {
        $_SESSION['transacoes'] = []; 
    } else {
        $nome = htmlspecialchars($_POST['nomeTransacao']);
        $valor = floatval($_POST['valorTransacao']);
        $tipo  = $_POST['tipoTransacao'];

        $_SESSION['transacoes'][] = [
            "nome" => $nome,
            "valor" => $valor,
            "tipo"  => $tipo
        ];
    }
}

list($totalReceitas, $totalDespesas) = calcularTotais($_SESSION['transacoes']);
$saldo = calcularSaldo($_SESSION['transacoes']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>MyWallet - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, sans-serif; }

body { background-color: #f4f7f6; color: #333; }

.navbar {
    background-color: #212529;
    color: white;
    padding: 15px 50px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.nav-left { display: flex; align-items: center; gap: 10px; font-weight: bold; }

.btn-sair { 
    background-color: #ff4d4d; 
    color: white; 
    text-decoration: none; 
    padding: 5px 15px; 
    border-radius: 4px; 
    margin-left: 15px;
}

.container { padding: 40px 50px; max-width: 1200px; margin: 0 auto; }

.summary-container {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 30px;
}
.card {
    background: white;
    flex: 1;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    border-left: 5px solid #ddd;
}
.card p { font-size: 15px; color: #000; margin-bottom: 10px; }

.card h3 { font-size: 24px; }

.card-receitas { border-left-color: #28a745; color: #28a745; }

.card-despesas { border-left-color: #dc3545; color: #dc3545; }

.card-saldo { 
    background: linear-gradient(to right, #007bff, #0056b3); 
    color: white; 
    border-left: none;
}

.form-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    overflow: hidden;
}
.form-header {
    background: #fff;
    padding: 15px 20px;
    font-weight: bold;
    border-bottom: 1px solid #eee;
}
.transaction-form {
    display: flex;
    padding: 20px;
    gap: 15px;
    align-items: flex-end;
}
.input-group { flex: 1; display: flex; flex-direction: column; gap: 5px; }
.input-group label { font-size: 12px; color: #666; }
.input-group input, .input-group select {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    outline: none;
}
.btn-add {
    background-color: #212529;
    color: white;
    padding: 11px 30px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
}

.actions { text-align: center; margin-top: 30px; display: flex; flex-direction: column; gap: 10px; align-items: center;}
.btn-outline {
    text-decoration: none;
    color: #555;
    border: 1px solid #ccc;
    padding: 10px 25px;
    border-radius: 4px;
    background: white;
    transition: 0.3s;
}
.btn-outline:hover { background: #eee; }
.btn-danger:hover { background: #ffebeb; color: #dc3545; border-color: #dc3545; cursor:pointer;}
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="nav-left">
            <i class="fas fa-wallet"></i>
            <span>MyWallet</span>
        </div>
        <div class="nav-right">
            <span>Olá, Admin</span>
            <a href="logout.php" class="btn-sair">Sair</a>
        </div>
    </nav>

    <div class="container">
        
        <div class="summary-container">
            <div class="card card-receitas">
                <p>Total Receitas</p>
                <h3>R$ <?= number_format($totalReceitas, 2, ',', '.') ?></h3>
            </div>
            <div class="card card-despesas">
                <p>Total Despesas</p>
                <h3>R$ <?= number_format($totalDespesas, 2, ',', '.') ?></h3>
            </div>
            <div class="card card-saldo">
                <p>Saldo Disponível</p>
                <h3>R$ <?= number_format($saldo, 2, ',', '.') ?></h3>
            </div>
        </div>

        <div class="form-card">
            <div class="form-header">Nova Transação</div>
            <form method="post" class="transaction-form">
                <div class="input-group">
                    <label>Descrição</label>
                    <input type="text" name="nomeTransacao" placeholder="Ex: Salário, Aluguel..." required>
                </div>
                <div class="input-group">
                    <label>Valor</label>
                    <input type="number" step="0.01" name="valorTransacao" placeholder="0,00" required>
                </div>
                <div class="input-group">
                    <label>Tipo</label>
                    <select name="tipoTransacao">
                        <option value="receita">Receita</option>
                        <option value="despesa">Despesa</option>
                    </select>
                </div>
                <button type="submit" class="btn-add">Adicionar</button>
            </form>
        </div>

        <div class="actions">
            <a href="historico.php" class="btn-outline">Ver Detalhes do Histórico</a>
            <form method="post" style="display:inline;">
                <button name="limpar" class="btn-outline btn-danger">Zerar Mês</button>
            </form>
        </div>

    </div>
</body>
</html>