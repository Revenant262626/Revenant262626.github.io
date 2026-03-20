<?php
header('Content-Type: application/json');

$dataFile = 'ratings.json';

$season = isset($_POST['season']) ? intval($_POST['season']) : 0;
$grade = isset($_POST['grade']) ? intval($_POST['grade']) : 0;

// Проверка
if ($season < 1 || $season > 4) {
    echo json_encode(['success' => false, 'message' => 'Неверный номер сезона']);
    exit;
}

if ($grade < 1 || $grade > 10) {
    echo json_encode(['success' => false, 'message' => 'Оценка должна быть от 1 до 10']);
    exit;
}

// Загружаем существующие данные
$data = [];
if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);
    $data = json_decode($json, true);
    if (!is_array($data)) $data = [];
}

// Обновляем данные для сезона
if (!isset($data[$season])) {
    $data[$season] = ['total' => 0, 'count' => 0];
}

$data[$season]['total'] += $grade;
$data[$season]['count']++;
$data[$season]['avg'] = $data[$season]['total'] / $data[$season]['count'];

// Сохраняем
if (file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
    echo json_encode(['success' => true, 'message' => "Оценка $grade для $season сезона сохранена!"]);
} else {
    echo json_encode(['success' => false, 'message' => 'Ошибка сохранения']);
}
?>
