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
<script src="validation.js"></script>

<!-- Sidebar -->
<div class="w3-sidebar w3-bar-block" style="display:none;z-index:5" id="mySidebar">
    <button class="w3-bar-item w3-button w3-xxlarge" onclick="w3_close()">Close &times;</button>
    <a href="calc1.php" class="w3-bar-item w3-button">Conversión de Bases</a>
    <a href="calc2.php" class="w3-bar-item w3-button">Calculadora de Bases</a>
</div>

<div class="w3-overlay" onclick="w3_close()" style="cursor:pointer" id="myOverlay"></div>

<div>
    <button class="w3-button w3-white w3-xxlarge menu-button" onclick="w3_open()">&#9776;</button>
</div>

<div class="formClass">
    <h1>Calculadora de Bases Numéricas</h1>
    
    <div>
        <strong>Información sobre bases:</strong><br>
        • Binario (base 2): usa dígitos 0-1<br>
        • Octal (base 8): usa dígitos 0-7<br>
        • Decimal (base 10): usa dígitos 0-9<br>
        • Hexadecimal (base 16): usa dígitos 0-9,A-F<br>
    </div>

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
function convertirBase($numero, $baseOrigen, $baseDestino) {
    $basesPermitidas = [2, 8, 10, 16];
    
    if (!in_array($baseOrigen, $basesPermitidas) || !in_array($baseDestino, $basesPermitidas)) {
        return "Error: Solo se permiten bases: 2, 8, 10, 16";
    }
    
    if ($baseOrigen == $baseDestino) return $numero;

    // Validar dígitos del número
    $caracteresValidos = substr('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', 0, $baseOrigen);
    $digitos = str_split(strtoupper($numero));
    
    foreach ($digitos as $digito) {
        if (strpos($caracteresValidos, $digito) === false) {
            return "Error: Dígito '$digito' no válido para base $baseOrigen";
        }
    }

    // Convertir a decimal primero
    $decimal = base_convert($numero, $baseOrigen, 10);
    
    // Convertir de decimal a la base destino
    return base_convert($decimal, 10, $baseDestino);
}

function calcularOperacion($numero1, $base1, $numero2, $base2, $operacion) {
    // Convertir ambos números a decimal
    $n1 = convertirBase($numero1, $base1, 10);
    $n2 = convertirBase($numero2, $base2, 10);
    
    // Verificar si hubo errores en la conversión
    if (strpos($n1, 'Error:') === 0) return $n1;
    if (strpos($n2, 'Error:') === 0) return $n2;
    
    switch ($operacion) {
        case 'suma':
            return bcadd($n1, $n2);
        case 'resta':
            return bcsub($n1, $n2);
        case 'multiplicacion':
            return bcmul($n1, $n2);
        case 'division':
            if ($n2 == '0') {
                return "Error: División por cero no permitida";
            }
            return bcdiv($n1, $n2, 10);
        default:
            return "Error: Operación inválida";
    }
}

function mostrarResultado($numero1, $base1, $numero2, $base2, $operacion, $resultado) {
    $simbolos = [
        'suma' => '+',
        'resta' => '-',
        'multiplicacion' => '×',
        'division' => '÷'
    ];
    
    echo '<div>';
    echo '<strong>Resultado del cálculo:</strong><br>';
    echo "Operación: $numero1 (base $base1) {$simbolos[$operacion]} $numero2 (base $base2)<br><br>";
    echo '<strong>Resultado en todas las bases:</strong><br>';
    echo "• Binario (base 2): " . convertirBase($resultado, 10, 2) . "<br>";
    echo "• Octal (base 8): " . convertirBase($resultado, 10, 8) . "<br>";
    echo "• Decimal (base 10): " . $resultado . "<br>";
    echo "• Hexadecimal (base 16): " . convertirBase($resultado, 10, 16) . "<br>";
    echo '</div>';
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $numero1 = trim($_POST["numero1"] ?? '');
    $base1 = (int)($_POST["base1"] ?? 0);
    $numero2 = trim($_POST["numero2"] ?? '');
    $base2 = (int)($_POST["base2"] ?? 0);
    $operacion = trim($_POST["operacion"] ?? '');
    
    if (empty($numero1) || $base1 == 0 || empty($numero2) || $base2 == 0 || empty($operacion)) {
        echo '<div>';
        echo '<strong>Error:</strong> Por favor complete todos los campos';
        echo '</div>';
    } else {
        $resultado = calcularOperacion($numero1, $base1, $numero2, $base2, $operacion);
        
        if (strpos($resultado, 'Error:') === 0) {
            echo '<div>';
            echo '<strong>' . $resultado . '</strong>';
            echo '</div>';
        } else {
            mostrarResultado($numero1, $base1, $numero2, $base2, $operacion, $resultado);
        }
    }
}
?>

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
    <a href="../lab1/calc1.php" style="display:inline-block; margin:5px; padding:8px 18px; background:#eee; color:#222; border:1px solid #bbb; border-radius:6px; text-decoration:none;">Lab 1 </a>
    <a href="../lab2/calc1.php" style="display:inline-block; margin:5px; padding:8px 18px; background:#eee; color:#222; border:1px solid #bbb; border-radius:6px; text-decoration:none;">Lab 2 </a>
    <a href="../lab3/calc1.php" style="display:inline-block; margin:5px; padding:8px 18px; background:#eee; color:#222; border:1px solid #bbb; border-radius:6px; text-decoration:none;">Lab 3 </a>
    <a href="../lab4/Comprobador.php" style="display:inline-block; margin:5px; padding:8px 18px; background:#eee; color:#222; border:1px solid #bbb; border-radius:6px; text-decoration:none;">Lab 4 </a>
    <a href="../lab5/index.php" style="display:inline-block; margin:5px; padding:8px 18px; background:#eee; color:#222; border:1px solid #bbb; border-radius:6px; text-decoration:none;">Lab 5 </a>
</footer>
</body>
</html>