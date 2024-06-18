<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include '../db.php';

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM pemesanan WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $message = "Pesanan berhasil dihapus.";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['table']) && isset($_POST['harga'])) {
    $id = $_POST['id'];
    $table = $_POST['table'];
    $harga = $_POST['harga'];

    if ($table == "padi") {
        $sql = "UPDATE padi SET harga=? WHERE id=?";
    } else {
        $sql = "UPDATE beras SET harga=? WHERE id=?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $harga, $id);

    if ($stmt->execute()) {
        $message = "Harga berhasil diubah.";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}

$padi = $conn->query("SELECT * FROM padi");
$beras = $conn->query("SELECT * FROM beras");
$orders = $conn->query("SELECT * FROM pemesanan");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Admin Panel</h2>
    <a href="https://panelharga.badanpangan.go.id/" target="_blank">Lihat Harga Realtime</a>
    <a href="http://localhost/Tempo/pelanggan/index.php" target="_blank">Lihat Website Visitor</a>

    <?php if(isset($message)) echo "<p>$message</p>"; ?>

    <h3>Jenis Padi</h3>
    <table>
        <tr>
            <th>Nama</th>
            <th>Harga</th>
            <th>Ubah Harga</th>
        </tr>
        <?php while($row = $padi->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['nama']; ?></td>
            <td><?php echo $row['harga']; ?></td>
            <td>
                <form method="post" action="">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="table" value="padi">
                    <input type="text" name="harga" value="<?php echo $row['harga']; ?>">
                    <input type="submit" value="Update">
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>

    <h3>Jenis Beras</h3>
    <table>
        <tr>
            <th>Nama</th>
            <th>Harga</th>
            <th>Ubah Harga</th>
        </tr>
        <?php while($row = $beras->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['nama']; ?></td>
            <td><?php echo $row['harga']; ?></td>
            <td>
                <form method="post" action="">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="table" value="beras">
                    <input type="text" name="harga" value="<?php echo $row['harga']; ?>">
                    <input type="submit" value="Update">
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>

    <h3>Pesanan Pelanggan</h3>
    <table>
        <tr>
            <th>Nama</th>
            <th>Nomor WhatsApp</th>
            <th>Jenis</th>
            <th>Jumlah</th>
            <th>Alamat</th>
            <th>Selesai</th>
        </tr>
        <?php while($row = $orders->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['nama']; ?></td>
            <td><?php echo $row['hp']; ?></td>
            <td><?php echo $row['jenis']; ?></td>
            <td><?php echo $row['jumlah']; ?></td>
            <td><?php echo $row['alamat']; ?></td>
            <td>
                <form method="post" action="">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
                    <input type="submit" name="delete" value="Hapus" />
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>

    <a href="logout.php">Logout</a>
</body>
</html>

<?php
$conn->close();
?>
