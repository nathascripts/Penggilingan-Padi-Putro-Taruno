<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "tempo";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan data dari formulir
    $nama = $_POST['nama'];
    $hp = $_POST['hp'];
    $jenis = $_POST['jenis'];
    $jumlah = $_POST['jumlah'];
    $alamat = $_POST['alamat'];

    // SQL untuk memasukkan data ke tabel
    $sql = "INSERT INTO pemesanan (nama, hp, jenis, jumlah, alamat)
            VALUES ('$nama', '$hp', '$jenis', '$jumlah', '$alamat')";

    if ($conn->query($sql) === TRUE) {
        echo "OK"; // Mengirim respons sukses "OK"
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Menutup koneksi
    $conn->close();
}
?>
