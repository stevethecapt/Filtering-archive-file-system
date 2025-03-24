<?php
require_once("../../config/database.php");

$tanggal_hari_ini = date('Y-m-d');
$tanggal_batas_pemusnahan = date('Y-m-d', strtotime('-3 days', strtotime($tanggal_hari_ini)));

$query = "SELECT * FROM arsip WHERE jadwal_inaktif <= ? ORDER BY jadwal_inaktif ASC";
$stmt = $pdo->prepare($query);
$stmt->execute([$tanggal_batas_pemusnahan]);
$arsip_pemusnahan = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip untuk Pemusnahan</title>
    <link rel="stylesheet" href="../../styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-3 text-center">Daftar Arsip untuk Pemusnahan</h2>
        <div class="table-container">
            <table class="table table-striped">
                <thead class="table-container">
                    <tr>
                        <th>No.</th>
                        <th>Nomor Berkas</th>
                        <th>Judul Berkas</th>
                        <th>Uraian Isi</th>
                        <th>Bidang</th>
                        <th>Jadwal Inaktif</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($arsip_pemusnahan)) : ?>
                        <?php foreach ($arsip_pemusnahan as $index => $file) { ?>
                        <tr>
                            <td class="text-center"><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($file["nomor_berkas"]); ?></td>
                            <td><?php echo htmlspecialchars($file["judul_berkas"]); ?></td>
                            <td><?php echo htmlspecialchars($file["uraian_isi"]); ?></td>
                            <td><?php echo htmlspecialchars($file["bidang"]); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($file["jadwal_inaktif"]); ?></td>
                        </tr>
                        <?php } ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada arsip yang siap dimusnahkan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="btn-container mt-3 text-center">
            <?php if (!empty($arsip_pemusnahan)) : ?>
                <a href="detail.php?type=pemusnahan" class="btn btn-info">
                <a href="download.php?id=<?php echo urlencode($file['id']); ?>" class="btn btn-success">Download</a>
                <a href="hapus_arsip.php?id=<?php echo urlencode($file['id']); ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus arsip ini?')">Hapus</a>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
