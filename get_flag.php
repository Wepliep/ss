<?php
header('Content-Type: application/json');

session_start();

// Final aşamada olup olmadığını kontrol et
// $scenario bağımlılığını kaldırıyoruz, sadece step kontrolü yapacağız
if (!isset($_SESSION['step']) || $_SESSION['step'] < 15) { // 15, toplam adım sayısıdır (senaryo uzunluğuna göre sabit)
    echo json_encode(['success' => false, 'message' => 'Final aşamasına ulaşmadınız.']);
    exit;
}

// Ses dosyasını istemciye gönder (stream olarak)
if (isset($_GET['action']) && $_GET['action'] === 'play_sound') {
    $file = __DIR__ . '/assets/final_sound.mp3'; // Tam dosya yolunu kullan
    if (file_exists($file)) {
        header('Content-Type: audio/mpeg');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Ses dosyası bulunamadı: ' . $file]);
        exit;
    }
}

// Bayrağı döndür
echo json_encode([
    'success' => true,
    'flag' => 'ASCII ART ı incele!'
]);
exit;