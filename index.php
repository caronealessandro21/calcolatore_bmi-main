<?php
// 1. ELABORAZIONE DEI DATI INVIATI
$nome = "";
$peso = 0;
$altezza_cm = 0;
$bmi = 0;
$bmi_formatted = "";
$stato = "";
$calcolato = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = htmlspecialchars($_POST['nome'] ?? '');
    $peso = floatval($_POST['peso'] ?? 0);
    $altezza_cm = floatval($_POST['altezza'] ?? 0);

    if ($peso > 0 && $altezza_cm > 0) {
        $altezza_m = $altezza_cm / 100;
        $bmi = $peso / ($altezza_m * $altezza_m);
        $bmi_formatted = number_format($bmi, 2);

        // Determinazione dello stato BMI
        if ($bmi < 18.5) {
            $stato = "SOTTOPESO";
        } elseif ($bmi >= 18.5 && $bmi <= 24.9) {
            $stato = "NORMOPESO";
        } elseif ($bmi >= 25.0 && $bmi <= 29.9) {
            $stato = "SOVRAPPESO";
        } else {
            $stato = "OBESITÀ";
        }

        $calcolato = true;
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcolo BMI</title>
    <style>
        body {
            background-color: white;
            font-family: Arial, sans-serif;
        }
        main {
            padding-top: 0;
            padding-bottom: 0;
            padding-left: 60px;
            padding-right: 60px;
        }
        .card {
            background-color: white;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-bottom: 24px;
        }
        .rigaForm {
            margin-bottom: 15px;
        }
        .rigaForm label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .rigaForm input[type="text"],
        .rigaForm input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .rigaForm input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }
        .card-result {
            background-color: #e8f5e9;
            border: 2px solid #4caf50;
        }
        .bmi-value {
            font-size: 38px;
            font-weight: bold;
            color: #2e7d32;
            margin: 10px 0;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            background-color: #2e7d32;
            color: white;
            font-weight: bold;
            border-radius: 12px;
        }
    </style>
</head>
<body>

<main>
    <h1 class="title">Calcolo BMI</h1>

    <!-- 2. FORM DI INSERIMENTO -->
    <div class="card">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <div class="rigaForm">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo $nome; ?>" required>
            </div>

            <div class="rigaForm">
                <label for="peso">Peso (kg):</label>
                <input type="number" step="0.1" id="peso" name="peso" value="<?php echo $peso > 0 ? $peso : ''; ?>" required>
            </div>

            <div class="rigaForm">
                <label for="altezza">Altezza (cm):</label>
                <input type="number" id="altezza" name="altezza" value="<?php echo $altezza_cm > 0 ? $altezza_cm : ''; ?>" required>
            </div>

            <div class="rigaForm">
                <input type="submit" name="calcola" value="Calcola">
            </div>
        </form>
    </div>

    <!-- 3. STAMPA DEL RISULTATO VIA PHP -->
    <?php if ($calcolato): ?>
        <div class="card card-result">
            <h2>Risultato del Calcolo</h2>
            <p><strong>Utente:</strong> <?php echo $nome; ?></p>
            <p><strong>Dati inseriti:</strong> <?php echo $peso; ?> kg | <?php echo $altezza_cm; ?> cm</p>
            <div class="bmi-value"><?php echo $bmi_formatted; ?></div>
            <span class="status-badge"><?php echo $stato; ?></span>
            <br><br>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>" style="color: #2e7d32; font-weight: bold;">Nuovo calcolo</a>
        </div>
    <?php endif; ?>

</main>

</body>
</html>