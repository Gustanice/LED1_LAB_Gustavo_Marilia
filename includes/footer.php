<?php
require_once __DIR__ . '/../backend/config/db.php';

$stmt = $pdo->query("SELECT * FROM footer LIMIT 1");
$footer = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<footer style="background:#111;color:#fff;padding:30px 0;">
    <div style="max-width:1100px;margin:auto;display:flex;justify-content:space-between;flex-wrap:wrap;gap:20px;">

        <div>
            <strong>LeD1 Lab</strong><br>
            <?= htmlspecialchars($footer['morada']) ?>
        </div>

        <div>
            📧 <?= htmlspecialchars($footer['email']) ?><br>
            📞 <?= htmlspecialchars($footer['telefone']) ?>
        </div>

        <div>
            <a href="<?= $footer['instagram'] ?>" target="_blank">Instagram</a><br>
            <a href="<?= $footer['linkedin'] ?>" target="_blank">LinkedIn</a><br>
            <a href="<?= $footer['github'] ?>" target="_blank">GitHub</a>
        </div>
    </div>

    <div style="text-align:center;margin-top:20px;opacity:.6;">
        <?= htmlspecialchars($footer['texto_copyright']) ?>
        <?= date('Y') ?> LeD1 Lab. Todos os direitos reservados.
    </div>
</footer>
