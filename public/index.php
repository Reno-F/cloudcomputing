<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'firebase_config.php';

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Firebase PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">CRUD Firebase dengan PHP</h2>
    <p class="text-end">Login sebagai: <strong><?php echo $_SESSION['user']['email']; ?></strong></p>
    <a href="logout.php" class="btn btn-danger">Logout</a>
    <hr>

    <h3>Tambah Pengguna</h3>
    <form method="POST" action="add.php">
        <div class="mb-3">
            <label class="form-label">Nama:</label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Gender:</label>
            <select class="form-control" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Phone:</label>
            <input type="text" class="form-control" name="phone" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Data</button>
    </form>
    <hr>

    <h3>Data Pengguna</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Phone</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php include 'fetch.php'; ?>
        </tbody>
    </table>
</div>

<!-- Modal Update -->
<div id="updateModal" style="display: none;">
    <form method="POST" action="update.php">
        <input type="hidden" name="key">
        <label>Nama:</label>
        <input type="text" name="name" required>
        <label>Email:</label>
        <input type="email" name="email" required>
        <label>Gender:</label>
        <select name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
        <label>Phone:</label>
        <input type="text" name="phone" required>
        <button type="submit">Update</button>
        <button type="button" onclick="document.getElementById('updateModal').style.display='none'">Batal</button>
    </form>
</div>

<script>
function openUpdateModal(key, name, email, gender, phone) {
    document.querySelector('input[name="key"]').value = key;
    document.querySelector('input[name="name"]').value = name;
    document.querySelector('input[name="email"]').value = email;
    document.querySelector('select[name="gender"]').value = gender;
    document.querySelector('input[name="phone"]').value = phone;
    document.getElementById('updateModal').style.display = 'block';
}
</script>

</body>
</html>
