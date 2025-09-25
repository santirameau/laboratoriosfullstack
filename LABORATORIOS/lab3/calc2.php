<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laboratorio 3 - Calculadora Bases Numéricas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<!-- Sidebar -->
<div class="w3-sidebar w3-bar-block" style="display:none;z-index:5" id="mySidebar">
    <button class="w3-bar-item w3-button w3-xxlarge" onclick="w3_close()">Close &times;</button>
    <a href="calc1.php" class="w3-bar-item w3-button">Conversión de Bases</a>
    <a href="calc2.php" class="w3-bar-item w3-button active">Calculadora de Bases</a>
</div>

<div class="w3-overlay" onclick="w3_close()" style="cursor:pointer" id="myOverlay"></div>

<div>
    <button class="w3-button w3-white w3-xxlarge menu-button" onclick="w3_open()">&#9776;</button>
</div>

<div class="formClass">
    <h1>Calculadora de Bases Numéricas</h1>
   
    <div>
        <strong>Información sobre bases:</strong><br>
        • Binario (base 2): dígitos 0-1<br>
        • Octal (base 8): dígitos 0-7<br>
        • Decimal (base 10): dígitos 0-9<br>
        • Hexadecimal (base 16): dígitos 0-9,A-F<br>
    </div>

    <!-- Formulario -->
    <form action="" method="post" id="formCalculadora">
        <select name="base1" id="base1" required>
            <option value="">Base del primer número</option>
            <option value="2">Binario (2)</option>
            <option value="8">Octal (8)</option>
            <option value="10">Decimal (10)</option>
            <option value="16">Hexadecimal (16)</option>
        </select>
        <input type="text" name="numero1" id="numero1" placeholder="Primer número (ej: 1010, FF, 123)" required>
       
        <select name="base2" id="base2" required>
            <option value="">Base del segundo número</option>
            <option value="2">Binario (2)</option>
            <option value="8">Octal (8)</option>
            <option value="10">Decimal (10)</option>
            <option value="16">Hexadecimal (16)</option>
        </select>
        <input type="text" name="numero2" id="numero2" placeholder="Segundo número (ej: 1101, A0, 456)" required>

        <select name="operacion" id="operacion" required>
            <option value="">Seleccione operación</option>
            <option value="suma">Suma (+)</option>
            <option value="resta">Resta (-)</option>
            <option value="multiplicacion">Multiplicación (×)</option>
            <option value="division">División (÷)</option>
        </select>

        <button type="submit" id="submitbtn">CALCULAR</button>
    </form>

<?php
// Función unificada para convertir bases
function convBase($numberInput, $fromBaseInput, $toBaseInput) {
    if ($fromBaseInput == $toBaseInput) return strtoupper($numberInput);

    $baseChars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $fromBaseChars = substr($baseChars, 0, $fromBaseInput);
    $toBaseChars   = substr($baseChars, 0, $toBaseInput);

    $number = str_split(strtoupper($numberInput), 1);

    foreach ($number as $digit) {
        if (strpos($fromBaseChars, $digit) === false) {
            return "Error: Dígito '$digit' no válido para base $fromBaseInput";
        }
    }

    $base10 = '0';
    $numberLen = count($number);
    for ($i = 0; $i < $numberLen; $i++) {
        $digitValue = strpos($fromBaseChars, $number[$i]);
        $base10 = bcadd($base10, bcmul($digitValue, bcpow($fromBaseInput, $numberLen - $i - 1)));
    }

    if ($toBaseInput == 10) return $base10;

    if (bccomp($base10, (string)$toBaseInput) == -1) return $toBaseChars[(int)$base10];

    $result = '';
    while (bccomp($base10, '0') == 1) {
        $remainder = bcmod($base10, $toBaseInput);
        $result = $toBaseChars[(int)$remainder] . $result;
        $base10 = bcdiv($base10, $toBaseInput, 0);
    }

    return $result;
}

// Función para calcular operaciones
function calcularOperacion($numero1, $base1, $numero2, $base2, $operacion) {
    $n1 = convBase($numero1, $base1, 10);
    $n2 = convBase($numero2, $base2, 10);

    if (strpos($n1, 'Error:') === 0) return $n1;
    if (strpos($n2, 'Error:') === 0) return $n2;

    switch ($operacion) {
        case 'suma': return bcadd($n1, $n2);
        case 'resta': return bcsub($n1, $n2);
        case 'multiplicacion': return bcmul($n1, $n2);
        case 'division':
            if (bccomp($n2, '0') == 0) return "Error: División por cero";
            return bcdiv($n1, $n2, 10);
        default: return "Error: Operación inválida";
    }
}

// Función para mostrar resultados
function mostrarResultado($resultado) {
    echo '<div>';
    echo '<strong>Resultado en todas las bases:</strong><br>';
    echo "• Binario (2): " . convBase($resultado, 10, 2) . "<br>";
    echo "• Octal (8): " . convBase($resultado, 10, 8) . "<br>";
    echo "• Decimal (10): " . $resultado . "<br>";
    echo "• Hexadecimal (16): " . convBase($resultado, 10, 16) . "<br>";
    echo '</div>';
}

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $numero1 = trim($_POST["numero1"] ?? '');
    $base1 = (int)($_POST["base1"] ?? 0);
    $numero2 = trim($_POST["numero2"] ?? '');
    $base2 = (int)($_POST["base2"] ?? 0);
    $operacion = trim($_POST["operacion"] ?? '');

    if (empty($numero1) || $base1 == 0 || empty($numero2) || $base2 == 0 || empty($operacion)) {
        echo '<div><strong>Error:</strong> Complete todos los campos</div>';
    } else {
        $resultado = calcularOperacion($numero1, $base1, $numero2, $base2, $operacion);
        if (strpos($resultado, 'Error:') === 0) {
            echo '<div><strong>' . $resultado . '</strong></div>';
        } else {
            mostrarResultado($resultado);
        }
    }
}
?>

</div>

<script>
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
    document.querySelector(".menu-button").style.display = "none";
}
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
    document.querySelector(".menu-button").style.display = "block";
}
</script>

<footer style="text-align:center; margin-top:30px;">
    <a href="../lab1/calc1.php" style="margin:5px; padding:8px 18px; background:#eee; color:#222; border:1px solid #bbb; border-radius:6px; text-decoration:none;">Lab 1</a>
    <a href="../lab2/calc1.php" style="margin:5px; padding:8px 18px; background:#eee; color:#222; border:1px solid #bbb; border-radius:6px; text-decoration:none;">Lab 2</a>
    <a href="calc1.php" style="margin:5px; padding:8px 18px; background:#eee; color:#222; border:1px solid #bbb; border-radius:6px; text-decoration:none;">Lab 3</a>
    <a href="../lab4/Comprobador.php" style="margin:5px; padding:8px 18px; background:#eee; color:#222; border:1px solid #bbb; border-radius:6px; text-decoration:none;">Lab 4</a>
    <a href="../lab5/index.php" style="margin:5px; padding:8px 18px; background:#eee; color:#222; border:1px solid #bbb; border-radius:6px; text-decoration:none;">Lab 5</a>
</footer>

</body>
</html>