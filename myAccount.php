<?php
// Start session before ANY output
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flowershop";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the current user's role
$user_id = $_SESSION['user_id'];
$query = "SELECT role FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$role = $user['role'];

// Handle user deletion if admin
if ($role === 'admin' && isset($_POST['delete_user'])) {
    $delete_id = $_POST['user_id'];

    // Prevent admin from deleting themselves
    if ($delete_id != $user_id) {
        $delete_query = "DELETE FROM users WHERE id = ? AND role != 'admin'";
        $delete_stmt = $conn->prepare($delete_query);
        $delete_stmt->bind_param("i", $delete_id);
        $delete_stmt->execute();

        if ($delete_stmt->affected_rows > 0) {
            $_SESSION['message'] = "User successfully deleted";
        } else {
            $_SESSION['error'] = "Unable to delete user";
        }
    } else {
        $_SESSION['error'] = "You cannot delete your own account";
    }
}

// Now include the header after all session and redirect logic
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="myAccount.css">
    <title>My Account</title>

    <style>
        /* General body styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #fce4ec; /* Light pink background */
            margin: 0;
            padding: 0;
        }

        /* Main content styling */
        main {
            padding: 20px;
        }

        /* Heading */
        h1 {
            font-size: 2.5rem;
            color: #d81b60; /* Pink text */
            text-align: center;
        }

        /* Alert message styling */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        /* User list table styling */
        .user-list {
            overflow-x: auto;
            margin: 20px 0;
        }

        .user-list table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 10px;
            background-color: #ffffff; /* White background */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Soft shadow for a modern look */
        }

        .user-list th,
        .user-list td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #f8bbd0; /* Soft pink border for separation */
        }

        .user-list th {
            background-color: #f5f5f5; /* Light gray background for headers */
            color: #d81b60; /* Pink text for headers */
            font-weight: bold;
        }

        .user-list tr:hover {
            background-color: #fce4ec; /* Light pink hover effect on rows */
        }

        /* Admin section styling */
        .admin-section h2 {
            font-size: 2rem;
            color: #d81b60; /* Pink header color */
            margin-bottom: 20px;
        }

        /* Buttons styling */
        .btn {
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            border: none;
            margin: 0 5px;
            display: inline-block;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        /* Edit button */
        .btn-edit {
            background-color: #f06292; /* Soft pink */
            color: white;
        }

        .btn-edit:hover {
            background-color: #c2185b; /* Darker pink on hover */
        }

        /* Delete button */
        .btn-delete {
            background-color: #dc3545; /* Red for delete */
            color: white;
        }

        .btn-delete:hover {
            background-color: #c82333; /* Darker red on hover */
        }

        /* Form styling */
        form {
            display: inline-block;
        }
    </style>

</head>
<body>
<main>
    <h1>My Account</h1>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success">
            <?php
            echo htmlspecialchars($_SESSION['message']);
            unset($_SESSION['message']);
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php
            echo htmlspecialchars($_SESSION['error']);
            unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>


    <!-- Admin section -->
    <?php if ($role === 'admin'): ?>
        <div class="admin-section">
            <h2>User Management</h2>
            <div class="user-list">
                <table>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Fetch all users except the current admin
                    $user_query = "SELECT id, firstName, lastName, email, role FROM users WHERE id != ?";
                    $stmt = $conn->prepare($user_query);
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $users_result = $stmt->get_result();

                    while ($row = $users_result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['firstName']) ?></td>
                            <td><?= htmlspecialchars($row['lastName']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['role']) ?></td>
                            <td>
                                <a href="edit_user.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-edit">Edit</a>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="user_id" value="<?= htmlspecialchars($row['id']) ?>">
                                    <button type="submit" name="delete_user" class="btn btn-delete"
                                            onclick="return confirm('Are you sure you want to delete this user?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

</main>

</body>
</html>
