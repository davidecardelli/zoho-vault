<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aggiungi Password - Zoho Vault Manager</title>
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
            align-items: center;
            justify-content: center;
        }

        /* Contenitore principale */
        .form-container {
            width: 100%;
            max-width: 500px;
            padding: 40px;
            text-align: center;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .form-container h1 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        /* Input */
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
            color: white;
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

        .btn-success {
            background: #28a745;
            border: none;
        }

        .btn-success:hover {
            background: #218838;
        }

        .btn-outline-light {
            border: 2px solid white;
            color: white;
        }

        .btn-outline-light:hover {
            background: white;
            color: #1e2a38;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h1>🔐 Aggiungi Nuova Password</h1>

        <form method="post" action="/?action=create">
            <div class="mb-3">
                <input type="text" class="form-control" id="name" name="name" placeholder="Nome del servizio" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-custom btn-success">💾 Salva Password</button>
        </form>

        <div class="mt-3">
            <a href="/" class="btn btn-custom btn-outline-light">🏠 Torna alla Home</a>
            <a href="/?action=list" class="btn btn-custom btn-outline-light">📂 Visualizza Password</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>