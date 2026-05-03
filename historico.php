<?php
session_start();
require_once "funcoes.php";

if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    if (isset($_SESSION['transacoes'][$id])) {
        unset($_SESSION['transacoes'][$id]);
        header("Location: historico.php");
        exit;
    }
}

$transacoes = $_SESSION['transacoes'] ?? [];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>MyWallet - Histórico</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }

body { background-color: #f4f7f6; padding: 50px; }

.container { max-width: 1100px; margin: 0 auto; }

.history-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    padding: 20px;
}

.history-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding: 10px 0;
}

.history-header h2 { font-size: 20px; color: #333; }

.btn-back, .btn-clear {
    text-decoration: none;
    font-size: 13px;
    padding: 8px 15px;
    border-radius: 6px;
    font-weight: bold;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    cursor: pointer;
    border: none;
}

.btn-back { background: #f1f3f5; color: #495057; border: 1px solid #dee2e6; }
.btn-clear { background: #e63946; color: white; margin-left: 10px; }

.history-table {
    width: 100%;
    border-collapse: collapse;
}

.history-table th {
    background-color: #f8f9fa;
    text-align: left;
    padding: 12px 15px;
    font-size: 13px;
    color: #666;
    border-bottom: 2px solid #eee;
}

.history-table td {
    padding: 15px;
    font-size: 14px;
    border-bottom: 1px solid #eee;
    vertical-align: middle;
}

.date-col { color: #999; font-size: 12px; }
.desc-col { color: #333; }

.badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: bold;
    text-transform: capitalize;
}

.badge-receita { background-color: #d4edda; color: #155724; }
.badge-despesa { background-color: #f8d7da; color: #721c24; }

.text-right { text-align: right; }
.text-center { text-align: center; }

.valor-receita { color: #28a745; font-weight: bold; }
.valor-despesa { color: #dc3545; font-weight: bold; }

.btn-delete { color: #dc3545; font-size: 18px; text-decoration: none; transition: 0.2s; }
.btn-delete:hover { color: #a71d2a; }
    </style>    
</head>
<body>

    <div class="container">
        <div class="history-card">
            
            <div class="history-header">
                <h2>Histórico de Movimentações</h2>
                <div class="header-actions">
                    <a href="index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Voltar</a>
                    <form method="post" action="index.php" style="display:inline;">
                        <button name="limpar" class="btn-clear"><i class="fas fa-trash"></i> Zerar</button>
                    </form>
                </div>
            </div>

            <table class="history-table">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th class="text-right">Valor</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($transacoes)): ?>
                        <tr>
                            <td colspan="5" style="text-align:center; padding: 20px; color: #999;">
                                Nenhuma transação registrada.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($transacoes as $id => $t): ?>
                            <tr>
                                <td class="date-col"><?= $t['data'] ?? date('d/m/Y H:i') ?></td>
                                
                                <td class="desc-col"><strong><?= $t['nome'] ?></strong></td>
                                
                                <td>
                                    <span class="badge badge-<?= $t['tipo'] ?>">
                                        <?= ucfirst($t['tipo']) ?>
                                    </span>
                                </td>
                                
                                <td class="text-right valor-<?= $t['tipo'] ?>">
                                    <?= ($t['tipo'] == "receita" ? "+ " : "- ") ?>
                                    R$ <?= number_format($t['valor'], 2, ',', '.') ?>
                                </td>
                                
                                <td class="text-center">
                                    <a href="historico.php?excluir=<?= $id ?>" class="btn-delete" title="Excluir">
                                        <i class="fas fa-times-circle"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>

</body>
</html>