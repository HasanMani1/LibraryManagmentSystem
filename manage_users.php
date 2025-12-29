<?php
session_start();
include 'db_connect.php';
include 'back_button.php';
include 'log_activity.php';

// ✅ Only Admin can access
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    header("Location: unauthorized.php");
    exit;
}

// ✅ Handle delete
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $conn->query("DELETE FROM user WHERE user_id = $delete_id");
    logActivity($_SESSION['user_id'], "Deleted user ID: $delete_id");
    header("Location: manage_users.php?deleted=1");
    exit;
}

// ✅ Search and filter logic (SCALABLE)
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$filter_role = isset($_GET['filter_role']) ? intval($_GET['filter_role']) : 0;

$users_loaded = false;
$result = null;

if ($search !== '' || $filter_role > 0) {
    $users_loaded = true;

    $query = "
        SELECT user.user_id, user.name, user.email, role.role_name
        FROM user
        INNER JOIN role ON user.role_id = role.role_id
        WHERE (user.name LIKE ? OR user.email LIKE ?)
    ";

    if ($filter_role > 0) {
        $query .= " AND user.role_id = ?";
    }

    $query .= " ORDER BY user.user_id ASC";

    $stmt = $conn->prepare($query);
    $like = '%' . $search . '%';

    if ($filter_role > 0) {
        $stmt->bind_param("ssi", $like, $like, $filter_role);
    } else {
        $stmt->bind_param("ss", $like, $like);
    }

    $stmt->execute();
    $result = $stmt->get_result();
}

// Fetch roles for filter dropdown
$roles = $conn->query("SELECT role_id, role_name FROM role");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Users</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
      .back-btn {
            position: fixed;
            top: 25px;
            left: 25px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, #007bff, #00bfff);
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 50px;
            padding: 10px 18px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-decoration: none;
            transition: all 0.3s ease-in-out;
            z-index: 1000;
        }
        .back-btn:hover {
            background: linear-gradient(135deg, #0056b3, #0080ff);
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
            color: #f8f9fa;
            text-decoration: none;
        }
        .back-btn i {
            font-size: 18px;
        }
body {
    font-family: Arial, sans-serif;
    background-size: cover;
    background-attachment: fixed;
    padding-top: 120px;
}

.container {
    width: 90%;
    margin: auto;
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.filter-bar {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}

input, select {
    padding: 8px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

button, .btn {
    padding: 6px 12px;
    border-radius: 5px;
    color: white;
    border: none;
    cursor: pointer;
    text-decoration: none;
}

.btn-search {
    background: linear-gradient(135deg, #007bff, #00bfff);
}

.btn-search:hover {
    transform: scale(1.05);
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
    text-align: center;
}

th {
    background-color: #007bff;
    color: white;
}

tr:hover {
    background-color: #f2f2f2;
}

.btn-edit {
    background: linear-gradient(135deg, #ffc107, #ffb300);
}

.btn-delete {
    background: linear-gradient(135deg, #dc3545, #c82333);
}

.alert {
    width: 90%;
    margin: 15px auto;
    padding: 10px;
    border-radius: 6px;
    text-align: center;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
}
</style>
</head>

<body>

<?php if (isset($_GET['deleted'])): ?>
    <div class="alert alert-success">✅ User deleted successfully!</div>
<?php elseif (isset($_GET['updated'])): ?>
    <div class="alert alert-success">✅ User updated successfully!</div>
<?php endif; ?>

<div class="container">
<h2>👥 Manage Users</h2>

<form class="filter-bar" method="GET">
    <input type="text" name="search" style="   border: 2px solid #94a3b8;"placeholder="Search by name or email..."
           value="<?= htmlspecialchars($search); ?>">

    <select name="filter_role"style="   border: 2px solid #94a3b8;">
        <option value="0">All Roles</option>
        <?php while ($r = $roles->fetch_assoc()): ?>
            <option value="<?= $r['role_id']; ?>"
                <?= ($filter_role == $r['role_id']) ? 'selected' : ''; ?>>
                <?= htmlspecialchars($r['role_name']); ?>
            </option>
        <?php endwhile; ?>
    </select>

    <button type="submit" class="btn btn-search">
        <i class="bi bi-search"></i> Search
    </button>
</form>

<table>
<thead>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Role</th>
    <th>Actions</th>
</tr>
</thead>

<tbody>
<?php if (!$users_loaded): ?>
<tr>
    <td colspan="5" style="padding:20px; font-weight:600;">
        🔍 Please use the search or filter options to display users.
    </td>
</tr>

<?php elseif ($result->num_rows === 0): ?>
<tr>
    <td colspan="5" style="padding:20px;">
        ❌ No users found.
    </td>
</tr>

<?php else: ?>
<?php while ($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['user_id']; ?></td>
    <td><?= htmlspecialchars($row['name']); ?></td>
    <td><?= htmlspecialchars($row['email']); ?></td>
    <td><?= htmlspecialchars($row['role_name']); ?></td>
    <td>
        <a href="edit_user.php?id=<?= $row['user_id']; ?>" class="btn btn-edit">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="manage_users.php?delete=<?= $row['user_id']; ?>"
           class="btn btn-delete"
           onclick="return confirm('Are you sure you want to delete this user?');">
           <i class="bi bi-trash"></i> Delete
        </a>
    </td>
</tr>
<?php endwhile; ?>
<?php endif; ?>
</tbody>
</table>

<div style="margin-top:25px;">
    <a href="register.php" class="btn btn-search">
        <i class="bi bi-person-plus"></i> Add New User
    </a>
</div>

</div>
</body>
</html>
