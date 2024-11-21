<?php
session_start();
require_once 'db_connect.php';

// Check if user is logged in as an admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Rest of your existing PHP code for admin_food.php goes here

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_category'])) {
        $category_name = $_POST['category_name'];
        $stmt = $MySQL->prepare("INSERT INTO food_category (name) VALUES (?)");
        $stmt->bind_param("s", $category_name);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['add_item'])) {
        $item_name = $_POST['item_name'];
        $item_price = $_POST['item_price'];
        $item_category = $_POST['item_category'];
        $photo_url = $_POST['photo_url'];

        $stmt = $MySQL->prepare("INSERT INTO food_items (name, photo_url, price, category_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdi", $item_name, $photo_url, $item_price, $item_category);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['edit_item'])) {
        $item_id = $_POST['item_id'];
        $item_name = $_POST['item_name'];
        $item_price = $_POST['item_price'];
        $item_category = $_POST['item_category'];
        $photo_url = $_POST['photo_url'];

        $stmt = $MySQL->prepare("UPDATE food_items SET name = ?, photo_url = ?, price = ?, category_id = ? WHERE id = ?");
        $stmt->bind_param("ssdii", $item_name, $photo_url, $item_price, $item_category, $item_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch categories
$categories = [];
$result = $MySQL->query("SELECT * FROM food_category");
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

// Fetch food items
$food_items = [];
$result = $MySQL->query("SELECT fi.*, fc.name as category_name FROM food_items fi JOIN food_category fc ON fi.category_id = fc.id");
while ($row = $result->fetch_assoc()) {
    $food_items[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Food Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'nav.php'; ?>
    <h1>Food Management</h1>

    <h2>Add Category</h2>
    <form method="post">
        <input type="text" name="category_name" required>
        <input type="submit" name="add_category" value="Add Category">
    </form>

    <h2>Add Food Item</h2>
    <form method="post">
        <input type="text" name="item_name" placeholder="Item Name" required>
        <input type="number" name="item_price" placeholder="Price" step="0.01" required>
        <input type="text" name="photo_url" placeholder="Photo URL">
        <select name="item_category" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" name="add_item" value="Add Item">
    </form>

    <h2>Food Items</h2>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Category</th>
            <th>Photo</th>
            <th>Action</th>
        </tr>
        <?php foreach ($food_items as $item): ?>
            <tr>
                <td><?php echo $item['name']; ?></td>
                <td><?php echo $item['price']; ?></td>
                <td><?php echo $item['category_name']; ?></td>
                <td>
                    <?php if ($item['photo_url']): ?>
                        <img src="<?php echo $item['photo_url']; ?>" alt="<?php echo $item['name']; ?>" style="max-width: 100px;">
                    <?php else: ?>
                        No photo
                    <?php endif; ?>
                </td>
                <td>
                    <button onclick="showEditForm(<?php echo $item['id']; ?>)">Edit</button>
                </td>
            </tr>
            <tr class="edit-form" id="edit-form-<?php echo $item['id']; ?>">
                <td colspan="5">
                    <form method="post">
                        <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                        <input type="text" name="item_name" value="<?php echo $item['name']; ?>" required>
                        <input type="number" name="item_price" value="<?php echo $item['price']; ?>" step="0.01" required>
                        <input type="text" name="photo_url" value="<?php echo $item['photo_url']; ?>">
                        <select name="item_category" required>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>" <?php echo ($category['id'] == $item['category_id']) ? 'selected' : ''; ?>>
                                    <?php echo $category['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="submit" name="edit_item" value="Update Item">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <script>
        function showEditForm(itemId) {
            var editForm = document.getElementById('edit-form-' + itemId);
            if (editForm.style.display === 'none' || editForm.style.display === '') {
                editForm.style.display = 'table-row';
            } else {
                editForm.style.display = 'none';
            }
        }
    </script>
</body>
</html>