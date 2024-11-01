<?php
include 'db.php';

$sql = "SELECT * FROM products LIMIT 9";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Katalog proizvoda - Komentari</title>
    <style>
      
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #f4f4f4;
        }

        h1, h2 {
            color: #333;
            text-align: center;
        }

        .container {
            max-width: 1200px;
            width: 100%;
            padding: 20px;
        }

        .success-message {
            color: green;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        
        .product-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 20px;
        }

        .product-item {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            width: 100%;
            height: auto;
            max-width: 150px;
            border-radius: 4px;
        }

        
        .centered-container {
            max-width: 800px;
            width: 100%;
            margin: 0 auto; 
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
        }

        .comment {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .comment strong {
            color: #555;
        }

        .comment p {
            margin: 0;
            color: #333;
        }

        .comment-form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 800px;
            width: 100%;
            margin: 20px auto; 
        }

        .comment-form input,
        .comment-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border 0.3s;
        }

        .comment-form input:focus,
        .comment-form textarea:focus {
            border-color: #333;
            outline: none;
        }

        .comment-form button {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .comment-form button:hover {
            background-color: #555;
        }
    </style>
    <script>
        function submitComment(event) {
            event.preventDefault();
            
            const formData = new FormData(document.querySelector('.comment-form'));
            fetch('submit_comment.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector('.success-message').textContent = "Uspešno ste dodali komentar!";
                    document.querySelector('.comment-form').reset();
                } else {
                    alert("Došlo je do greške prilikom slanja komentara.");
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</head>
<body>
    <div class="container">
       
        <h1>Katalog proizvoda</h1>
        <div class="product-grid">
            <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="product-item">
                    <img src="<?= htmlspecialchars($row['image']); ?>" alt="<?= htmlspecialchars($row['title']); ?>" class="product-image">
                    <h2><?= htmlspecialchars($row['title']); ?></h2>
                    <p><?= htmlspecialchars($row['description']); ?></p>
                </div>
            <?php endwhile; ?>
        </div>

       
        <h2>Komentari</h2>
        <?php
        $comment_sql = "SELECT * FROM comments WHERE approved = 1 ORDER BY id DESC";
        $comment_result = $conn->query($comment_sql);
        ?>

        <div class="centered-container">
            <?php while ($comment = $comment_result->fetch_assoc()) : ?>
                <div class="comment">
                    <strong><?= htmlspecialchars($comment['name']); ?></strong> (<?= htmlspecialchars($comment['email']); ?>):
                    <p><?= htmlspecialchars($comment['text']); ?></p>
                </div>
            <?php endwhile; ?>
        </div>

        <h2>Dodajte komentar</h2>
        <p class="success-message"></p>
        <form class="comment-form" onsubmit="submitComment(event)">
            <input type="text" name="name" placeholder="Ime" required>
            <input type="email" name="email" placeholder="Email" required>
            <textarea name="text" placeholder="Vaš komentar" required></textarea>
            <button type="submit">Pošalji komentar</button>
        </form>
    </div>
</body>
</html>
