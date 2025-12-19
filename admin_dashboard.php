<?php
session_start();
include 'koneksi.php';

/* ===== PROTEKSI ADMIN ===== */
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Ambil keyword dari search bar
$search = '';
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

// Query user
if (!empty($search)) {
    $query = "SELECT * FROM users 
              WHERE role != 'admin' 
              AND (nama LIKE '%$search%' OR nis LIKE '%$search%' OR email LIKE '%$search%' OR kelas LIKE '%$search%')
              ORDER BY kelas ASC, nama ASC";
    $result = mysqli_query($conn, $query);

    $kelas_list = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $kelas_list[$row['kelas'] ?? 'Belum ditentukan'][] = $row;
    }
} else {
    $kelas_result = mysqli_query($conn, "SELECT DISTINCT kelas FROM users ORDER BY kelas ASC");
    $kelas_list = [];
    while ($row = mysqli_fetch_assoc($kelas_result)) {
        $kelas_list[$row['kelas'] ?? 'Belum ditentukan'] = [];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard - Users</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="assett/navbar.css">
<style>
body{
    font-family:'Segoe UI',sans-serif;
    background:url('assett/img/foto4.jpg') no-repeat center center;
    background-size: cover;
    background-attachment: fixed;
    margin:0;
    padding:0;
}
.container{
    max-width:1200px;
    margin:50px auto;
    padding:20px;
    background: rgba(255,255,255,0.95);
    border-radius:12px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.3);
}
.judul{
    text-align:center;
    color:#0d2a44;
    margin-bottom:30px;
}
.search-bar{
    margin-bottom:20px;
    text-align:center;
}
.search-bar input[type=text]{
    width:60%;
    padding:10px 15px;
    border-radius:8px;
    border:1px solid #ccc;
    font-size:16px;
}
.kelas-section{
    margin-bottom:50px;
}
.kelas-section h2{
    color:#0d2a44;
    margin-bottom:10px;
}
table{
    width:100%;
    border-collapse:collapse;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}
th, td{
    padding:12px 15px;
    text-align:center;
    border-bottom:1px solid #ddd;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
th{
    background: #00c6ff;
    color:#fff;
}
tr:hover{
    background:#e3f2fd;
}
.back{
    display:inline-block;
    margin-bottom:20px;
    color:#2196f3;
    text-decoration:none;
}
@media(max-width:768px){
    .search-bar input[type=text]{
        width:90%;
    }
}
</style>
</head>
<body>

<?php include 'assett/navbar.php'; ?>

<div class="container">
    <h1 class="judul">Admin Dashboard - Users</h1>

    <div class="search-bar">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Cari nama, NIS, email, atau kelas..." value="<?= htmlspecialchars($search) ?>">
        </form>
    </div>

    <?php foreach($kelas_list as $kelas => $users):
        if(empty($search)){
            $q = ($kelas === 'Belum ditentukan') 
                ? "SELECT * FROM users WHERE kelas IS NULL AND role != 'admin' ORDER BY nama ASC" 
                : "SELECT * FROM users WHERE kelas='$kelas' AND role != 'admin' ORDER BY nama ASC";
            $res = mysqli_query($conn, $q);
            $users = [];
            while($row = mysqli_fetch_assoc($res)){
                $users[] = $row;
            }
        }
        if(count($users) === 0) continue;
    ?>
    <div class="kelas-section">
        <h2>Kelas: <?= htmlspecialchars($kelas) ?></h2>
        <table>
            <thead>
                <tr>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Kelas</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user): ?>
                <tr style="cursor:pointer" onclick="window.location.href='admin_detail.php?user=<?= $user['id'] ?>'">
                    <td><?= htmlspecialchars($user['nis']) ?></td>
                    <td><?= htmlspecialchars($user['nama']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['kelas'] ?? 'Belum ditentukan') ?></td>
                    <td><a href="admin_detail.php?user=<?= $user['id'] ?>">Lihat</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endforeach; ?>
</div>

</body>
</html>
