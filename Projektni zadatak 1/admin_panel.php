<?php
session_start();
require_once 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Function to get all users
function getUsers($MySQL) {
    $result = $MySQL->query("SELECT id, username, email FROM admin_users");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to add a new user
function addUser($MySQL, $username, $password, $email) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $MySQL->prepare("INSERT INTO admin_users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashedPassword, $email);
    return $stmt->execute();
}

// Function to update a user
function updateUser($MySQL, $id, $username, $email) {
    $stmt = $MySQL->prepare("UPDATE admin_users SET username = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $username, $email, $id);
    return $stmt->execute();
}

// Function to delete a user
function deleteUser($MySQL, $id) {
    $stmt = $MySQL->prepare("DELETE FROM admin_users WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_user'])) {
        addUser($MySQL, $_POST['new_username'], $_POST['new_password'], $_POST['new_email']);
    } elseif (isset($_POST['update_user'])) {
        updateUser($MySQL, $_POST['user_id'], $_POST['username'], $_POST['email']);
    } elseif (isset($_POST['delete_user'])) {
        deleteUser($MySQL, $_POST['user_id']);
    }
}

$users = getUsers($MySQL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'nav.php'; ?>
    <h1>Admin Panel</h1>
    <p>Welcome, <?php echo $_SESSION['admin_username']; ?>! <a href="logout.php">Logout</a></p>

    <h2>Add New User</h2>
    <form method="post" action="">
        <input type="text" name="new_username" placeholder="Username" required>
        <input type="password" name="new_password" placeholder="Password" required>
        <input type="email" name="new_email" placeholder="Email" required>
        <input type="submit" name="add_user" value="Add User">
    </form>

    <h2>Manage Users</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['username']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td>
                <form method="post" action="" style="display: inline;">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <input type="text" name="username" value="<?php echo $user['username']; ?>" required>
                    <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
                    <input type="submit" name="update_user" value="Update">
                </form>
                <form method="post" action="" style="display: inline;">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <input type="submit" name="delete_user" value="Delete" onclick="return confirm('Are you sure you want to delete this user?');">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>