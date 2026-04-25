<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 8px; padding: 32px; border-top: 4px solid #2563eb; }
        .logo { font-size: 22px; font-weight: bold; color: #2563eb; margin-bottom: 24px; }
        .message { font-size: 15px; color: #374151; line-height: 1.7; }
        .footer { margin-top: 32px; font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">PsyLink</div>
        <div class="message">{{ $mailMessage }}</div>
        <div class="footer">Cet e-mail a été envoyé automatiquement par la plateforme PsyLink. Merci de ne pas y répondre.</div>
    </div>
</body>
</html>
