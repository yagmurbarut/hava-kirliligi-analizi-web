<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İletişim</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <div>Hava Kirliliği Analizi</div>
        <div>
            <a href="index.php">Ana Sayfa</a>
            <a href="about.php">Hakkımızda</a>
            <a href="contact.php">İletişim</a>
        </div>
    </div>
    <!-- İçerik -->
    <section class="selection-container">
        <h2>İletişim</h2>
        <form action="php/contact_process.php" method="POST">
            <label for="name">Adınız:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">E-posta:</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Mesajınız:</label>
            <textarea id="message" name="message" required></textarea>

            <button type="submit">Gönder</button>
        </form>
    </section>

    <!-- Footer -->
    <div class="footer">
        &copy; 2025 Hava Kirliliği Analizi
    </div>

</body>
</html>
