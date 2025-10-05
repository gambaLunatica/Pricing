<?php
require_once 'config.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $date = $_POST['fecha'] ?? null;
    $price = $_POST['precio'] ?? null;
    $commet = $_POS['comentario'] ?? null;

    if($date && $price !== null){
        $query = "INSERT INTO precio (fecha, precio, comentario) VALUES (?, ?, ?, ?)";
        $stm = $pdo->prepare($query);
        $stm->executate([$date, $prie, $comment]);

        // Redirect back to the calendar for the correct month
        $month = date('m', strtotime($applyDate));
        $year = date('Y', strtotime($applyDate));
        header("Location: index.php?year=$year&month=$month");
        exit;
    } else {
        echo "Missing required fields.";
    }
}else {
    echo "Invalid request.";
}
?>
