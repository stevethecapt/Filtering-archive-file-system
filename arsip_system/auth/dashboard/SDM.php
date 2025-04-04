<?php
session_start();
require_once("../../config/database.php");

if (!$pdo) {
    die("Koneksi ke database gagal.");
}

try {
    $sql = "SELECT * FROM arsip WHERE TRIM(bidang) = :bidang ORDER BY upload_date DESC";
    $stmt = $pdo->prepare($sql);
    $bidang = "SDM Umum dan Komunikasi";
    $stmt->bindParam(':bidang', $bidang, PDO::PARAM_STR);
    $stmt->execute();
    $files = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDM, Umum dan Komunikasi</title>
</head>
<body>
    <nav>
        <img src="../../img/bpjs.png" class="img">
        <div class="top-right">
        <a href="javascript:void(0);" onclick="toggleProfilePopup()" style="text-decoration: none; color: black; font-weight: bold;">
            <?php if (isset($_SESSION['username'])): ?>
                <?php echo htmlspecialchars($_SESSION['username']); ?>
            <?php endif; ?>
        </a>
        <div id="profilePopup" style="display: none; position: absolute; top: 70px; right: 0; width: 250px; padding: 20px; background: white; border-radius: 15px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); text-align: center;">
        <p style="font-size: 18px; font-weight: bold; margin-top: 10px;">
            <?php echo htmlspecialchars($user['fullname'] ?? 'Nama Tidak Ditemukan'); ?>
        </p>
        <p style="font-size: 14px; color: #666;">
            <?php echo htmlspecialchars($user['email'] ?? 'example@youremail.com'); ?>
        </p>
        <p style="font-size: 14px; color: #666;">
            <?php echo htmlspecialchars($user['phone'] ?? 'Your Number'); ?>
        </p>            
        <p style="font-size: 14px; color: #666;">
            <?php echo htmlspecialchars($user['bidang'] ?? 'Bidang'); ?>
        </p>
        <a href="profile/profile.php" style="display: block; background: #008CBA; color: white; text-decoration: none; padding: 10px; border-radius: 10px; margin-top: 10px;">Update Profile</a>
        <a href="logout.php" style="display: block; background: #f44336; color: white; text-decoration: none; padding: 10px; border-radius: 10px; margin-top: 5px;">Logout</a>
    </div>
    <script>
        function toggleProfilePopup() {
            var popup = document.getElementById("profilePopup");
            popup.style.display = (popup.style.display === "none" || popup.style.display === "") ? "block" : "none";
        }
    </script>
</nav>

    <div class="sidebar">
        <a href="../dashboard.php" class="sidetext">Dashboard</a>
        <a href="SDM.php" class="sidetext">SDM, Umum dan Komunikasi</a>
        <a href="perencanaan.php" class="sidetext">Perencanaan dan Keuangan</a>
        <a href="kepersertaan.php" class="sidetext">Kepersertaan dan Mutu Layanan</a>
        <a href="jaminan.php" class="sidetext">Jaminan Pelayanan Kesehatan</a>
    </div>

    <div class="content">
        <h2>SDM, Umum dan Komunikasi</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Judul Berkas</th>
                        <th>Uraian Isi</th>
                        <th>Kode Klasifikasi</th>
                        <th>Upload Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($files as $file) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($file["id"]); ?></td>
                        <td><?php echo htmlspecialchars($file["judul_berkas"]); ?></td>
                        <td><?php echo htmlspecialchars($file["uraian_isi"]); ?></td>
                        <td><?php echo htmlspecialchars($file["kode_klasifikasi"]); ?></td>
                        <td><?php echo htmlspecialchars($file["upload_date"]); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="btn-container">
            <a href="inputdata.php" class="inputbtn">Input</a>
            <a href="detail.php?bidang=<?php echo urlencode($bidang); ?>" class="btn-info">Detail</a>
            <a href="" class="downloadbtn">Download</a>
        </div>
    </div>
</body>
</html>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    display: flex;
    flex-direction: row;
}
nav {
    width: 100%;
    background: #fff;
    position: fixed;
    top: 0;
    left: 0;
    padding: 15px 20px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    justify-content: space-between;
    z-index: 1000;
}
.img {
    height: 38px;
    width: 200px;
    object-fit: fit;
}
.top-right {
    display: flex;
    align-items: center;
    gap: 10px;
}
.username {
    font-weight: bold;
    font-size: 1rem;
    color: #333;
}
.logoutbtn {
    font-size: 1rem;
    font-weight: 500;
    color: white;
    border: none;
    background-color: #dc3545;
    padding: 10px 15px;
    text-decoration: none;
    border-radius: 5px;
    text-align: center;
    cursor: pointer;
}
.sidebar {
    width: 230px;
    height: 100vh;
    background-color: #fff;
    position: fixed;
    top: 60px;
    left: 0;
    padding-top: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}
.sidetext {
    padding: 15px 18px;
    display: block;
    color: black;
    text-decoration: none;
    text-align: center;
    width: 90%;
    font-size: 14px;
    border-radius: 5px;
}
.sidetext:hover {
    background: #007bff;
    color: white;
    transform: scale(1.05);
}
.content {
    margin-left: 250px;
    padding: 80px 20px 20px;
    flex-grow: 1;
}

h2 {
    text-align: center;
    color: #333;
    margin-top: 20px;
    margin-bottom: 20px;
}

form {
    text-align: center;
    margin-bottom: 20px;
}

select {
    padding: 8px;
    font-size: 16px;
    border-radius: 5px;
    border: 1px solid #ccc;
    width: 200px;
    text-align: center;
}

.table-container {
    max-width: 80%;
    margin: 0 auto;
    max-height: 400px; 
    overflow-y: auto;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

table {
    width: 100%;
    border-collapse: collapse;
    background: white;
}

thead {
    background-color: #007bff;
    color: white;
    position: sticky;
    top: 0;
    z-index: 10;
}

th, td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

.btn-container {
    margin-top: 20px;
    text-align: center;
}

.inputbtn, .btn-info, .downloadbtn {
    padding: 12px 18px;
    border-radius: 5px;
    text-decoration: none;
    display: inline-block;
    margin: 5px;
    color: white;
    text-align: center;
    width: 130px; 
}

.inputbtn { background-color: #007bff; }
.btn-info { background-color: #17a2b8; }
.downloadbtn { background-color: #28a745; }
</style>