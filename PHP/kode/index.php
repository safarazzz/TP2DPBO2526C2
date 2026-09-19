<?php
require_once 'Item.php';
require_once 'MusicInstrument.php';
require_once 'Guitar.php';
session_start();

// ============ helper: data awal ============
function defaultGuitars() {
    return [
        new Guitar(1, 1500000, 24, "dipetik", "baru", "2.5 kg", "Yamaha", "Pacifica112", 24, "nikel", "images/yamaha-pacifica112.jpg"),
        new Guitar(2, 1200000, 2, "dipetik", "bekas", "2.7 kg", "Fender", "Player Stratocaster", 22, "baja", "images/fender-player-stratocaster.jpg"),
        new Guitar(3, 1200000, 9, "dipetik", "likenew", "5.5 kg", "Jackson", "JS22 Dinky", 24, "nikel", "images/jackson-js22-dinky.jpg"),
        new Guitar(4, 2100000, 5, "dipetik", "ori", "3.1 kg", "Schecter", "Omen Elite-6", 22, "baja", "images/schecter-omen-elite-6.jpg"),
        new Guitar(5, 800000, 12, "dipetik", "premium", "1.9 kg", "Yamaha", "C40 Classic", 19, "nilon", "images/yamaha-c40-classic.jpg"),
    ];
}

// helper: cek apakah data gitar di session masih valid (bukan objek rusak/kosong)
function isValidGuitarList($list) {
    if (!is_array($list)) return false;
    foreach ($list as $item) {
        if (!($item instanceof Guitar)) return false;
    }
    return true;
}

if (!isset($_SESSION['guitars']) || !isValidGuitarList($_SESSION['guitars'])) {
    $_SESSION['guitars'] = defaultGuitars();
}
if (!isset($_SESSION['log'])) {
    $_SESSION['log'] = [
        ["type" => "info", "text" => "Selamat datang di Toko Gitar kami!\nKetik 'panduan' untuk melihat daftar perintah."]
    ];
}

// ============ prosedur panduan ============
function panduanText() {
    $rows = [
        ["add", "add (id) (harga) (stok) (caraMain) (kondisi) (berat) (merek) (seri) (fret) (senar) (foto)", "Menambahkan satu gitar baru."],
        ["show", "show", "Menampilkan seluruh gitar (lihat tabel di bawah)."],
        ["panduan", "panduan", "Menampilkan panduan ini."],
        ["done", "done", "Mengakhiri sesi."]
    ];
    $out = "Panduan penggunaan program Toko Gitar:\n";
    foreach ($rows as $r) {
        $out .= "- " . str_pad($r[0], 8) . ": " . $r[1] . "\n  (" . $r[2] . ")\n";
    }
    $out .= "\nCatatan: (foto) diisi nama file gambar, contoh: images/fender-telecaster.jpg";
    return $out;
}

// ============ prosedur menambahkan gitar ============
function addGuitar(&$v, $tokens) {
    if (count($tokens) < 11) {
        return "Format salah. Gunakan: add (id) (harga) (stok) (caraMain) (kondisi) (berat) (merek) (seri) (fret) (senar) (foto)";
    }
    list($id, $price, $stock, $playingMethod, $condition, $weightNumber, $brand, $series, $fretSize, $stringType, $photo) = $tokens;

    if (!is_numeric($id) || !is_numeric($price) || !is_numeric($stock) || !is_numeric($weightNumber) || !is_numeric($fretSize)) {
        return "Format salah. Pastikan id, harga, stok, berat, dan fret berupa angka.";
    }

    $weight = number_format((float)$weightNumber, 1) . " kg";
    $guitar = new Guitar((int)$id, (float)$price, (int)$stock, $playingMethod, $condition, $weight, $brand, $series, (int)$fretSize, $stringType, $photo);
    $v[] = $guitar;
    return "Gitar \"$brand $series\" berhasil ditambahkan dengan id $id.";
}

// ============ proses command yang diketik ============
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['command'])) {
    $line = trim($_POST['command']);
    if ($line !== "") {
        $tokens = preg_split('/\s+/', $line);
        $cmd = strtolower(array_shift($tokens));

        if ($cmd === "add") {
            $outputText = addGuitar($_SESSION['guitars'], $tokens);
        } elseif ($cmd === "show") {
            $jumlah = count($_SESSION['guitars']);
            $outputText = ($jumlah === 0)
                ? "Daftar gitar anda masih kosong!"
                : "Menampilkan $jumlah gitar (lihat tabel di bawah).";
        } elseif ($cmd === "panduan") {
            $outputText = panduanText();
        } elseif ($cmd === "done") {
            $outputText = "Terimakasih dan silahkan datang kembali!";
        } else {
            $outputText = "Perintah tidak dikenali. Ketik 'panduan' untuk melihat daftar perintah.";
        }

        $_SESSION['log'][] = ["type" => "cmd", "text" => $line];
        $_SESSION['log'][] = ["type" => "out", "text" => $outputText];
    }
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Toko Gitar - CLI</title>
<style>
    body {
        background: #1e1e1e;
        color: #eee;
        font-family: "Courier New", monospace;
        margin: 0;
        padding: 32px 16px;
        display: flex;
        justify-content: center;
    }
    .container {
        width: 100%;
        max-width: 1000px;
    }
    h1 {
        color: #4fc3f7;
        font-size: 24px;
        text-align: center;
        margin-bottom: 24px;
    }
    h2 {
        font-size: 18px;
        color: #4fc3f7;
        margin-top: 32px;
    }
    .terminal {
        background: #111;
        border: 1px solid #333;
        border-radius: 6px;
        padding: 14px;
        height: 260px;
        overflow-y: auto;
        white-space: pre-wrap;
        margin-bottom: 24px;
        font-size: 15px;
    }
    .cmd { color: #4fc3f7; }
    .out { color: #c8e6c9; }
    .info { color: #90caf9; }
    table {
        border-collapse: collapse;
        width: 100%;
        font-size: 15px;
        margin-top: 12px;
    }
    th, td {
        border: 1px solid #333;
        padding: 10px 12px;
        text-align: left;
    }
    th { background: #222; color: #4fc3f7; }
    tr:nth-child(even) { background: #1a1a1a; }
    td img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 4px;
        display: block;
    }
    form.cmdline {
        display: flex;
        gap: 8px;
        margin-top: 32px;
    }
    form.cmdline span { align-self: center; color: #4fc3f7; font-size: 16px; }
    input[type=text] {
        flex: 1;
        background: #000;
        color: #0f0;
        border: 1px solid #333;
        padding: 10px;
        font-family: inherit;
        font-size: 15px;
    }
    button {
        background: #333;
        color: #fff;
        border: none;
        padding: 10px 22px;
        cursor: pointer;
        font-family: inherit;
        font-size: 15px;
    }
    button:hover { background: #4fc3f7; color: #111; }
</style>
</head>
<body>
<div class="container">

    <h1>Toko Gitar &mdash; Command Line</h1>

    <div class="terminal" id="terminal">
    <?php foreach ($_SESSION['log'] as $entry): ?>
    <?php if ($entry['type'] === 'cmd'): ?>
<span class="cmd">|| <?php echo htmlspecialchars($entry['text']); ?></span>
    <?php elseif ($entry['type'] === 'out'): ?>
<span class="out"><?php echo nl2br(htmlspecialchars($entry['text'])); ?></span>
    <?php else: ?>
<span class="info"><?php echo nl2br(htmlspecialchars($entry['text'])); ?></span>
    <?php endif; ?>

    <?php endforeach; ?>
    </div>

    <h2>Daftar Gitar Saat Ini</h2>
    <?php if (count($_SESSION['guitars']) === 0): ?>
        <p>Daftar gitar masih kosong.</p>
    <?php else: ?>
    <table>
    <tr>
        <th>Gambar</th><th>ID</th><th>Harga</th><th>Stok</th><th>CaraMain</th>
        <th>Kondisi</th><th>Berat</th><th>Merek</th><th>Seri</th><th>Fret</th><th>Senar</th>
    </tr>
    <?php foreach ($_SESSION['guitars'] as $g): ?>
    <tr>
        <td><img src="<?php echo htmlspecialchars($g->getPhoto()); ?>" alt="<?php echo htmlspecialchars($g->getSeries()); ?>"></td>
        <td><?php echo $g->getId(); ?></td>
        <td><?php echo number_format($g->getPrice(), 0, ',', '.'); ?></td>
        <td><?php echo $g->getStock(); ?></td>
        <td><?php echo htmlspecialchars($g->getPlayingMethod()); ?></td>
        <td><?php echo htmlspecialchars($g->getCondition()); ?></td>
        <td><?php echo htmlspecialchars($g->getWeight()); ?></td>
        <td><?php echo htmlspecialchars($g->getBrand()); ?></td>
        <td><?php echo htmlspecialchars($g->getSeries()); ?></td>
        <td><?php echo $g->getFretSize(); ?></td>
        <td><?php echo htmlspecialchars($g->getStringType()); ?></td>
    </tr>
    <?php endforeach; ?>
    </table>
    <?php endif; ?>

    <form class="cmdline" method="post" action="index.php">
        <span>||</span>
        <input type="text" name="command" autofocus autocomplete="off"
               placeholder="add 6 2500000 10 dipetik baru 3.0 Fender Stratocaster 22 baja images/fender-stratocaster.jpg">
        <button type="submit">Enter</button>
    </form>

</div>

<script>
    var term = document.getElementById('terminal');
    term.scrollTop = term.scrollHeight;
</script>
</body>
</html>