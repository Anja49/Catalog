<?php
session_start();
include 'db.php';


if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}


$query = "SELECT * FROM comments WHERE approved = 0";
$result = $conn->query($query);

if (!$result) {
    die("Greška sa upitom: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Odobravanje Komentara</title>
    <style>
       
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #333;
            margin-top: 20px;
        }

       
        table {
            width: 100%;
            max-width: 800px;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #333;
            color: #fff;
            font-weight: bold;
        }

        td {
            color: #555;
        }

       
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

       
        a {
            margin-top: 20px;
            color: #333;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        a:hover {
            color: #555;
        }
    </style>
</head>
<body>
    <h2>Neodobreni Komentari</h2>
    <table>
        <tr>
            <th>Ime</th>
            <th>Email</th>
            <th>Komentar</th>
            <th>Akcija</th>
        </tr>
        <?php while ($comment = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($comment['name']); ?></td>
                <td><?= htmlspecialchars($comment['email']); ?></td>
                <td><?= htmlspecialchars($comment['text']); ?></td>
                <td>
                    <form action="approve_comment.php" method="post" style="display:inline;">
                        <input type="hidden" name="comment_id" value="<?= $comment['id']; ?>">
                        <button type="submit">Odobri</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="logout.php">Odjavi se</a>
</body>
</html>
