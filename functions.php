<?php
require_once 'config.php';

function getMonth($year, $month) {
    $days = [];
    $date = "$year-$month-01";
    $last = date("t", strtotime($date));

    for ($i = 1; $i <= $last; $i++) {
        $day = str_pad($i, 2, '0', STR_PAD_LEFT);
        $days[] = "$year-$month-$day";
    }
    return $days;
}

function getLastPrice($pdo, $date) {
    $stmt = $pdo->prepare("SELECT precio FROM precio WHERE fecha = ? ORDER BY fecha_configuracion DESC LIMIT 1");
    $stmt->execute([$date]);
    return $stmt->fetchColumn();
}

function getLastClose($pdo, $date) {
    $stmt = $pdo->prepare("
        SELECT CONCAT(o.nombre, ' / ', r.nombre) AS cierre 
        FROM cierre c
        JOIN ocupacion o ON c.ocupacion_id = o.id
        JOIN regimen r ON c.regimen_id = r.id
        WHERE c.fecha = ?
        ORDER BY c.fecha_configuracion DESC LIMIT 1");
    $stmt->execute([$date]);
    return $stmt->fetchColumn();
}

function getLastMinStay($pdo, $date) {
    $stmt = $pdo->prepare("SELECT noches FROM estancias_minimas WHERE fecha = ? ORDER BY fecha_configuracion DESC LIMIT 1");
    $stmt->execute([$date]);
    return $stmt->fetchColumn();
}