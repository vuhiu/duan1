<!-- filepath: c:\laragon\www\duan1\client\views\change-password.php -->
<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['user']['user_id'])) {
    header("Location: form-login.php");
    exit();
}

$userId = $_SESSION['user']['user_id'];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = $_POST['old_password'];
    $new = $_POST['new_password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (password_verify($old, $user['password'])) {
        $newHash = password_hash($new, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
        $stmt->execute([$newHash, $userId]);
        $message = "Đổi mật khẩu thành công.";
    } else {
        $message = "Mật khẩu cũ không đúng.";
    }
}
?>

<h2>Đổi mật khẩu</h2>
<form method="post">
    <label>Mật khẩu cũ:</label>
    <input type="password" name="old_password" required><br>
    <label>Mật khẩu mới:</label>
    <input type="password" name="new_password" required><br>
    <button type="submit">Đổi mật khẩu</button>
</form>
<p><?= $message ?></p>