<?php
include 'firebase_config.php';

$ref = $database->getReference('users')->getValue();

if ($ref) {
    foreach ($ref as $key => $value) {
        $name = htmlspecialchars($value['name'] ?? 'N/A');
        $email = htmlspecialchars($value['email'] ?? 'N/A');
        $gender = htmlspecialchars($value['gender'] ?? 'N/A');
        $phone = htmlspecialchars($value['phone'] ?? 'N/A');

        echo "<tr>
                <td>{$name}</td>
                <td>{$email}</td>
                <td>{$gender}</td>
                <td>{$phone}</td>
                <td>
                    <button class='btn btn-warning btn-sm' onclick=\"openUpdateModal('$key', '{$name}', '{$email}', '{$gender}', '{$phone}')\">Edit</button>
                    <a href='delete.php?id=$key' class='btn btn-danger btn-sm'>Hapus</a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5' class='text-center'>Tidak ada data pengguna.</td></tr>";
}
?>
