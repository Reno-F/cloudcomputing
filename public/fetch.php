<?php
include 'firebase_config.php';

$ref = $database->getReference('users')->getValue();

if ($ref) {
    foreach ($ref as $key => $value) {
        $name = isset($value['name']) ? $value['name'] : 'N/A';
        $email = isset($value['email']) ? $value['email'] : 'N/A';
        $gender = isset($value['gender']) ? $value['gender'] : 'N/A';
        $phone = isset($value['phone']) ? $value['phone'] : 'N/A';

        echo "<tr>
                <td>{$name}</td>
                <td>{$email}</td>
                <td>{$gender}</td>
                <td>{$phone}</td>
                <td>
                    <button class='btn btn-warning btn-sm' onclick=\"openUpdateModal('$key', '{$name}', '{$email}')\">Edit</button>
                    <a href='delete.php?id=$key' class='btn btn-danger btn-sm'>Hapus</a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5' class='text-center'>Tidak ada data pengguna.</td></tr>";
}
?>
