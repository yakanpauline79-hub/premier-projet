<?php
require_once 'config.php';

// ==========================================================
// CRUD RESERVATIONS : Ajouter / Modifier / Supprimer / Lister
// ==========================================================

// Fonction utilitaire pour récupérer les champs du formulaire
function getReservationFields() {
    return [
        'Name' => $_POST['Name'] ?? '',
        'Email' => $_POST['Email'] ?? '',
        'Region' => $_POST['Region'] ?? '',
        'City' => $_POST['City'] ?? '',
        'Site' => $_POST['Site'] ?? '',
        'Number' => $_POST['Number'] ?? '',
        'Adress' => $_POST['Adress'] ?? '',
        'Payement' => $_POST['Payement'] ?? '',
    ];
}

// --- AJOUT ---
if (isset($_POST['ajouter'])) {
    $f = getReservationFields();
    if ($f['Name'] && $f['Email']) {
        $stmt = $pdo->prepare("INSERT INTO reservation (Name, Email, Region, City, Site, Number, Adress, Payement) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$f['Name'], $f['Email'], $f['Region'], $f['City'], $f['Site'], $f['Number'], $f['Adress'], $f['Payement']]);
    }
    header("Location: reservation.php");
    exit;
}

// --- SUPPRESSION ---
if (isset($_GET['supprimer'])) {
    $id = (int) $_GET['supprimer'];
    $stmt = $pdo->prepare("DELETE FROM reservation WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: reservation.php");
    exit;
}

// --- MODIFICATION ---
if (isset($_POST['modifier'])) {
    $id = (int) $_POST['id'];
    $f = getReservationFields();
    if ($id && $f['Name'] && $f['Email']) {
        $stmt = $pdo->prepare("UPDATE reservation SET Name=?, Email=?, Region=?, City=?, Site=?, Number=?, Adress=?, Payement=? WHERE id=?");
        $stmt->execute([$f['Name'], $f['Email'], $f['Region'], $f['City'], $f['Site'], $f['Number'], $f['Adress'], $f['Payement'], $id]);
    }
    header("Location: reservation.php");
    exit;
}

// --- LECTURE ---
$stmt = $pdo->query("SELECT * FROM reservation ORDER BY id DESC");
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// --- CHARGEMENT D'UNE RESERVATION POUR MODIFICATION ---
$edit = null;
if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM reservation WHERE id = ?");
    $stmt->execute([$id]);
    $edit = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - Gestion des Reservations</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #29d9d5;
            --primary-dark: #1ba8a5;
            --dark: #0f1115;
            --dark-2: #181c23;
            --dark-3: #222;
            --gradient: linear-gradient(135deg, #29d9d5 0%, #17a2b8 100%);
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", "Raleway", sans-serif;
        }
        body {
            background: var(--dark);
            color: #e6edf3;
            padding: 30px 15px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: var(--dark-2);
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.5);
            border: 1px solid rgba(41, 217, 213, 0.15);
        }
        .back-home {
            display: inline-block;
            margin-bottom: 20px;
            padding: 8px 18px;
            background: var(--gradient);
            color: #fff;
            border-radius: 30px;
            font-weight: 600;
            font-size: 14px;
            transition: 0.3s;
        }
        .back-home:hover {
            box-shadow: 0 0 20px rgba(41, 217, 213, 0.5);
            transform: translateY(-2px);
        }
        h1 {
            text-align: center;
            color: var(--primary);
            font-size: 28px;
            margin-bottom: 30px;
        }
        h2 {
            color: #fff;
            font-size: 20px;
            margin: 25px 0 15px;
            padding-left: 12px;
            border-left: 4px solid var(--primary);
        }
        form.res-form {
            background: var(--dark-3);
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 20px;
            border: 1px solid rgba(41, 217, 213, 0.1);
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px 20px;
            margin-bottom: 15px;
        }
        .form-grid label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 6px;
        }
        input[type="text"], select {
            width: 100%;
            padding: 11px 14px;
            background: var(--dark);
            border: 1px solid rgba(41, 217, 213, 0.35);
            border-radius: 8px;
            color: #fff;
            font-size: 14px;
            outline: 0;
            transition: 0.3s;
        }
        input[type="text"]:focus, select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 10px rgba(41, 217, 213, 0.3);
        }
        .form-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }
        button {
            background: var(--gradient);
            color: #fff;
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            box-shadow: 0 0 20px rgba(41, 217, 213, 0.5);
            transform: translateY(-2px);
        }
        .cancel {
            color: var(--primary);
            font-weight: 600;
            font-size: 14px;
        }
        .table-wrap {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: var(--dark-3);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            border: 1px solid rgba(255,255,255,0.08);
            padding: 12px;
            text-align: center;
            font-size: 14px;
        }
        th {
            background: var(--gradient);
            color: #fff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }
        tr:hover td {
            background: rgba(41, 217, 213, 0.06);
        }
        .btn-edit {
            padding: 6px 14px;
            background: var(--primary);
            color: var(--dark);
            border-radius: 20px;
            font-weight: 600;
            font-size: 13px;
            transition: 0.3s;
        }
        .btn-edit:hover {
            background: #fff;
        }
        .btn-delete {
            padding: 6px 14px;
            background: #e74c3c;
            color: #fff;
            border-radius: 20px;
            font-weight: 600;
            font-size: 13px;
            transition: 0.3s;
        }
        .btn-delete:hover {
            background: #c0392b;
        }
        .empty {
            color: var(--primary);
            font-weight: 600;
        }
        a {
            text-decoration: none;
        }
        @media (max-width: 700px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <a href="index.html" class="back-home">&larr; Retour à l'accueil</a>
    <h1>Gestion des Reservations</h1>

    <?php if ($edit): ?>
        <!-- FORMULAIRE DE MODIFICATION -->
        <h2>Modifier une Reservation</h2>
        <form method="POST" action="reservation.php" class="res-form">
            <input type="hidden" name="id" value="<?= (int)$edit['id'] ?>">
            <div class="form-grid">
                <div>
                    <label>Name</label>
                    <input type="text" name="Name" value="<?= htmlspecialchars($edit['Name']) ?>" required>
                </div>
                <div>
                    <label>Email</label>
                    <input type="text" name="Email" value="<?= htmlspecialchars($edit['Email']) ?>" required>
                </div>
                <div>
                    <label>Region</label>
                    <input type="text" name="Region" value="<?= htmlspecialchars($edit['Region']) ?>">
                </div>
                <div>
                    <label>City</label>
                    <input type="text" name="City" value="<?= htmlspecialchars($edit['City']) ?>">
                </div>
                <div>
                    <label>Site</label>
                    <input type="text" name="Site" value="<?= htmlspecialchars($edit['Site']) ?>">
                </div>
                <div>
                    <label>Number</label>
                    <input type="text" name="Number" value="<?= htmlspecialchars($edit['Number']) ?>">
                </div>
                <div>
                    <label>Adress</label>
                    <input type="text" name="Adress" value="<?= htmlspecialchars($edit['Adress']) ?>">
                </div>
                <div>
                    <label>Payment Method</label>
                    <select name="Payement">
                        <option value="Carte" <?= $edit['Payement'] === 'Carte' ? 'selected' : '' ?>>Carte</option>
                        <option value="Mobile Money" <?= $edit['Payement'] === 'Mobile Money' ? 'selected' : '' ?>>Mobile Money</option>
                        <option value="Cash" <?= $edit['Payement'] === 'Cash' ? 'selected' : '' ?>>Cash</option>
                    </select>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" name="modifier">Modifier</button>
                <a href="reservation.php" class="cancel">Annuler</a>
            </div>
        </form>
    <?php else: ?>
        <!-- FORMULAIRE D'AJOUT -->
        <h2>Ajouter une Reservation</h2>
        <form method="POST" action="reservation.php" class="res-form">
            <div class="form-grid">
                <div>
                    <label>Name</label>
                    <input type="text" name="Name" placeholder="Enter name" required>
                </div>
                <div>
                    <label>Email</label>
                    <input type="text" name="Email" placeholder="Enter email" required>
                </div>
                <div>
                    <label>Region</label>
                    <input type="text" name="Region" placeholder="Enter region">
                </div>
                <div>
                    <label>City</label>
                    <input type="text" name="City" placeholder="Enter city">
                </div>
                <div>
                    <label>Site</label>
                    <input type="text" name="Site" placeholder="Enter site">
                </div>
                <div>
                    <label>Number</label>
                    <input type="text" name="Number" placeholder="Enter number">
                </div>
                <div>
                    <label>Adress</label>
                    <input type="text" name="Adress" placeholder="Enter address">
                </div>
                <div>
                    <label>Payment Method</label>
                    <select name="Payement">
                        <option value="Carte">Carte</option>
                        <option value="Mobile Money">Mobile Money</option>
                        <option value="Cash">Cash</option>
                    </select>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" name="ajouter">Ajouter</button>
            </div>
        </form>
    <?php endif; ?>

    <h2>Liste des Reservations</h2>
    <div class="table-wrap">
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Region</th>
                <th>City</th>
                <th>Site</th>
                <th>Number</th>
                <th>Adress</th>
                <th>Payement</th>
                <th>Actions</th>
            </tr>
            <?php if (count($reservations) > 0): ?>
                <?php foreach ($reservations as $r): ?>
                    <tr>
                        <td><?= (int)$r['id'] ?></td>
                        <td><?= htmlspecialchars($r['Name']) ?></td>
                        <td><?= htmlspecialchars($r['Email']) ?></td>
                        <td><?= htmlspecialchars($r['Region']) ?></td>
                        <td><?= htmlspecialchars($r['City']) ?></td>
                        <td><?= htmlspecialchars($r['Site']) ?></td>
                        <td><?= htmlspecialchars($r['Number']) ?></td>
                        <td><?= htmlspecialchars($r['Adress']) ?></td>
                        <td><?= htmlspecialchars($r['Payement']) ?></td>
                        <td>
                            <a href="?edit=<?= (int)$r['id'] ?>" class="btn-edit">Modifier</a>
                            <a href="?supprimer=<?= (int)$r['id'] ?>" class="btn-delete" onclick="return confirm('Supprimer cette reservation ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="10" class="empty">Aucune reservation trouvée.</td></tr>
            <?php endif; ?>
        </table>
    </div>
</div>
</body>
</html>
