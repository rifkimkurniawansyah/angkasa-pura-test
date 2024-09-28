<?php
function ambil_kata_acak($pdo) {
    $stmt = $pdo->query("SELECT * FROM master_kata ORDER BY RAND() LIMIT 1");
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function buat_textbox($kata) {
    $textbox = [];
    for ($i = 0; $i < strlen($kata); $i++) {
        if ($i == 2 || $i == 6) {
            $textbox[] = $kata[$i];
        } else {
            $textbox[] = '_';
        }
    }
    return $textbox;
}

function hitung_skor($jawaban_user, $kata_benar, $textbox) {
    $skor = 0;
    for ($i = 0; $i < strlen($kata_benar); $i++) {
        if ($jawaban_user[$i] == $kata_benar[$i]) {
            if ($textbox[$i] == '_') {
                $skor += 10;
            }
        } else {
            $skor -= 2;
        }
    }
    return $skor;
}

function simpan_skor($pdo, $nama_user, $skor) {
    $stmt = $pdo->prepare("INSERT INTO point_game (nama_user, total_point) VALUES (?, ?)");
    $stmt->execute([$nama_user, $skor]);
}
?>
