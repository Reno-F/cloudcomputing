<?php
include 'firebase_config.php';

$ref = $database->getReference('users')->getValue();

if ($ref) {
    foreach ($ref as $key => $value) {
        echo "<tr>
                <td>{$value['name']}</td>
                <td>{$value['email']}</td>
                <td>{$value['gender']}</td>
                <td>{$value['phone']}</td>
                <td>
                    <button class='btn btn-warning btn-sm' onclick=\"openUpdateModal('$key', '{$value['name']}', '{$value['email']}')\">Edit</button>
                    <a href='delete.php?id=$key' class='btn btn-danger btn-sm'>Hapus</a>
                </td>
              </tr>";
    }
}
?>
