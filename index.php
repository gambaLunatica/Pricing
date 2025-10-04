<?php
require_once 'config.php';
require_once 'functions.php';

// Get current year/month from URL or default
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
$month = isset($_GET['month']) ? intval($_GET['month']) : date('m');

// Calculate previous and next month
$prevMonth = $month - 1;
$prevYear  = $year;
if ($prevMonth < 1) {
    $prevMonth = 12;
    $prevYear--;
}

$nextMonth = $month + 1;
$nextYear  = $year;
if ($nextMonth > 12) {
    $nextMonth = 1;
    $nextYear++;
}
// Generate list of days in the month
$days = [];
$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
for ($day = 1; $day <= $days_in_month; $day++) {
    $days[] = sprintf('%02d-%02d', $day, $month);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Revenue Calendar – <?= "$year-$month" ?></title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
  <div class="calendar">
    <h2>Monthly Calendar – <?= date('F Y', strtotime("$year-$month-01")) ?></h2>
    <div class="calendar-header">
        <a class="arrow" href="?year=<?= $prevYear ?>&month=<?= str_pad($prevMonth, 2, '0', STR_PAD_LEFT) ?>">←</a>
        <h2><?= date('F Y', strtotime("$year-$month-01")) ?></h2>
        <a class="arrow" href="?year=<?= $nextYear ?>&month=<?= str_pad($nextMonth, 2, '0', STR_PAD_LEFT) ?>">→</a>
    </div>
    <div class="grid">
      <?php foreach ($days as $date): ?>
        <div class="day-box">
          <strong><?= $date ?></strong>
          <ul>
            <li><strong>Price:</strong> 
              <?php $price = getLastPrice($pdo, $date); echo $price ? "€$price" : "-"; ?>
            </li>
            <li><strong>Closure:</strong> 
              <?php $closure = getLastClose($pdo, $date); echo $closure ? $closure : "-"; ?>
            </li>
            <li><strong>Min Stay:</strong> 
              <?php $min = getLastMinStay($pdo, $date); echo $min ? "$min nights" : "-"; ?>
            </li>
          </ul>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="sidebar">
    <h2>Actions</h2>
    <ul>
      <li><a href="#">Set Price</a></li>
      <li><a href="#">Set Closure</a></li>
      <li><a href="#">Set Min Stay</a></li>
    </ul>
  </div>
</div>
</body>
</html>
