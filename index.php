<?php
session_start();
require_once 'config.php';
require_once 'functions.php';

if (!isset($_SESSION['kata_data'])) {
    $_SESSION['kata_data'] = ambil_kata_acak($pdo);
    $_SESSION['textbox'] = buat_textbox($_SESSION['kata_data']['kata']);
}

$pesan = '';
$skor = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['jawaban'])) {
        $jawaban_user = strtoupper(trim($_POST['jawaban']));
        $kata_benar = strtoupper($_SESSION['kata_data']['kata']);

        if (strlen($jawaban_user) != strlen($kata_benar)) {
            $pesan = "Panjang jawaban tidak sesuai.";
        } else {
            $skor = hitung_skor($jawaban_user, $kata_benar, $_SESSION['textbox']);
            $pesan = "Skor Anda: $skor";
            $_SESSION['skor'] = $skor;
        }
    } elseif (isset($_POST['simpan'])) {
        $nama = trim($_POST['nama']);
        simpan_skor($pdo, $nama, $_SESSION['skor']);
        $pesan = "Skor berhasil disimpan.";

        unset($_SESSION['kata_data'], $_SESSION['textbox'], $_SESSION['skor']);
        header("Location: index.php");
        exit;
    } elseif (isset($_POST['main_lagi'])) {
        unset($_SESSION['kata_data'], $_SESSION['textbox'], $_SESSION['skor']);
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Asah Otak</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e9ecef;
            color: #343a40;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h1 {
            text-align: center;
            color: #28a745;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        input[type="text"] {
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ced4da;
            border-radius: 5px;
            width: 250px;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus {
            border-color: #28a745;
            outline: none;
        }
        button {
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100px;
            margin-top: 10px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #218838;
        }
        .pesan {
            text-align: center;
            font-weight: bold;
            margin: 10px 0;
            color: #dc3545; 
        }
        .clue {
            font-style: italic;
            color: #6c757d;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Game Asah Otak</h1>

    <?php if (!isset($_SESSION['skor'])): ?>
        <p class="clue">Petunjuk: <?php echo htmlspecialchars($_SESSION['kata_data']['clue']); ?></p>
        <p>Kata: <?php echo implode(" ", $_SESSION['textbox']); ?></p>

        <form method="post">
            <input type="text" name="jawaban" placeholder="Masukkan jawaban" required>
            <button type="submit">Jawab</button>
        </form>
    <?php else: ?>
        <p class="pesan"><?php echo htmlspecialchars($pesan); ?></p>
        <form method="post">
            <input type="text" name="nama" placeholder="Masukkan nama Anda" required>
            <button type="submit" name="simpan">Simpan Skor</button>
        </form>
        <form method="post">
            <button type="submit" name="main_lagi">Main Lagi</button>
        </form>
    <?php endif; ?>

    <?php if ($pesan): ?>
        <p class="pesan"><?php echo htmlspecialchars($pesan); ?></p>
    <?php endif; ?>
</body>
</html>
