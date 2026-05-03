<?php

function calcularSaldo($transacoes) {
    $saldo = 0;

    foreach ($transacoes as $t) {
        if ($t['tipo'] == "receita") {
            $saldo += $t['valor'];
        } else {
            $saldo -= $t['valor'];
        }
    }

    return $saldo;
}

function calcularTotais($transacoes) {
    $receitas = 0;
    $despesas = 0;

    foreach ($transacoes as $t) {
        if ($t['tipo'] == "receita") {
            $receitas += $t['valor'];
        } else {
            $despesas += $t['valor'];
        }
    }

    return [$receitas, $despesas];
}

function calcularPercentual($valor, $total) {
    if ($total == 0) return 0;
    return ($valor / $total) * 100;
}

function limparHistorico() {
    $_SESSION['transacoes'] = [];
}