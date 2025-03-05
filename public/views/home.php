<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zoho Vault Manager</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <style>
        /* Stile generale */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1e2a38, #29394d);
            color: white;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        /* Contenitore principale */
        .main-container {
            width: 100%;
            max-width: 500px;
            padding: 40px;
            text-align: center;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .main-container h1 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .main-container p {
            font-size: 1rem;
            opacity: 0.8;
            margin-bottom: 25px;
        }

        /* Pulsanti */
        .btn-custom {
            width: 100%;
            padding: 12px;
            font-size: 1rem;
            font-weight: 500;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: all 0.3s ease-in-out;
        }

        .btn-custom:hover {
            transform: scale(1.05);
        }

        .btn-primary {
            background: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background: #0056b3;
        }

        .btn-outline-light {
            border: 2px solid white;
            color: white;
        }

        .btn-outline-light:hover {
            background: white;
            color: #1e2a38;
        }

        /* Footer */
        .footer {
            position: absolute;
            bottom: 15px;
            font-size: 0.9rem;
            opacity: 0.7;
        }
    </style>
</head>

<body>

    <div class="main-container">
        <h1>Gestione Sicura delle Password</h1>
        <p>Zoho Vault Manager ti aiuta a proteggere e organizzare le tue credenziali in modo semplice e sicuro.</p>

        <?php if ($oauth->isAuthenticated()): ?>
            <a href="/?action=list" class="btn btn-custom btn-outline-light">📂 Visualizza Password</a>
            <a href="/?action=create" class="btn btn-custom btn-outline-light">➕ Aggiungi Password</a>
            <a href="/?action=logout" class="btn btn-custom btn-primary">🔒 Logout</a>
        <?php else: ?>
            <a href="/?action=login" class="btn btn-custom btn-primary">🔑 Accedi con Zoho</a>
        <?php endif; ?>
    </div>

    <div class="footer">© 2025 Zoho Vault Manager - Sicurezza prima di tutto.</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>