<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Elenco Password - Zoho Vault Manager</title>
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
        .list-container {
            width: 100%;
            max-width: 600px;
            padding: 40px;
            text-align: center;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .list-container h1 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        /* Tabella */
        .table {
            color: white;
            background: transparent;
        }

        .table th,
        .table td {
            border-color: rgba(255, 255, 255, 0.2);
        }

        .table thead th {
            background: rgba(255, 255, 255, 0.1);
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

        .btn-outline-light {
            border: 2px solid white;
            color: white;
        }

        .btn-outline-light:hover {
            background: white;
            color: #1e2a38;
        }

        .btn-info {
            background: #17a2b8;
            border: none;
        }

        .btn-info:hover {
            background: #138496;
        }
    </style>
</head>

<body>

    <div class="list-container">
        <h1>🔑 Le tue Password</h1>

        <?php if (empty($secrets["secrets"])): ?>
            <div class="alert alert-warning text-dark">
                Non hai ancora salvato nessuna password in Zoho Vault.
            </div>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Servizio</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($secrets["secrets"] as $secret): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($secret["secretName"]); ?></td>
                            <td>
                                <a href="/?action=view&id=<?php echo $secret["secretId"]; ?>" class="btn btn-sm btn-info">👁 Visualizza</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <div class="mt-3">
            <a href="/" class="btn btn-custom btn-outline-light">🏠 Torna alla Home</a>
            <a href="/?action=create" class="btn btn-custom btn-outline-light">➕ Aggiungi Password</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>