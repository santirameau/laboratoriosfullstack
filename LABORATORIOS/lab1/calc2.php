<html>
<title>laboratorio 1</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
<link rel="stylesheet" href="estilos.css">
<body>
<script src="calc2HideForm.js"></script>
<!-- Sidebar -->
<div class="w3-sidebar w3-bar-block" style="display:none;z-index:5" id="mySidebar">
  <button class="w3-bar-item w3-button w3-xxlarge" onclick="w3_close()">Close &times;</button>
  <a href="calc1.php" class="w3-bar-item w3-button">Calculadora Normal</a>
  <a href="calc2.php" class="w3-bar-item w3-button">Calculadora Geométrica</a>
  <a href="calc3.php" class="w3-bar-item w3-button">Calculadora Ecuaciones Cuadráticas</a>
</div>



<?php include 'calc2HideForm.php'; ?>


<!-- Page Content -->
<div class="w3-overlay" onclick="w3_close()" style="cursor:pointer" id="myOverlay"></div>

<div>
  <button class="w3-button w3-white w3-xxlarge menu-button" onclick="w3_open()">&#9776;</button>
</div>

<div class="formClass">
    <h1>Calculadora geométrica</h1>

    <!--formulario -->
    <form action="calc2.php" method="post" id="formNumeros">
      <select name="operador" id="figuraSelect" onchange="mostrarCampos()">
        <option value="">elija una opcion</option>
        <option value="areaCuad">Cuadrado - Área</option>
        <option value="areaRec">Rectangulo - Área</option>
        <option value="areaCir">Circunferencia - Área</option>
        <option value="areaTri">Triangulo   - Área</option>

</select>

 <!-- cuadrado -->
<div id="campos-areaCuad" class="input-field">
  <input type="number" name="lado" placeholder="Ingrese el lado del cuadrado" step="any" >
</div>

<!-- rectangulo -->
<div id="campos-areaRec" class="input-field">
    <input type="number" name="base" placeholder="Ingrese base" step="any" >
    <input type="number" name="altura" placeholder="Ingrese altura" step="any" >
</div>

<!-- circulo -->
<div id="campos-areaCir" class="input-field">
    <input type="number" name="radio" placeholder="Ingrese radio" step="any" >
</div>

<!-- rectangulo -->
<div id="campos-areaTri" class="input-field">
    <input type="number" name="base" placeholder="Ingrese base" step="any" >
    <input type="number" name="altura" placeholder="Ingrese altura" step="any" >
</div>

<button type="submit" id="submitbtn">Enviar</button>

    </form>

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
<script src="validation.js"></script>

<?php

//--------------------------------
//FUNCIONES CALC2
//--------------------------------



//deben reestructurar este codigo, no imprimir eetiquetas de html en un return
function areaCuad($lado) {
    if (!is_numeric($lado)) {
        return false;
    }

    $resultado = $lado * $lado;

    return "<BR><span style='font-size:24px; color:green; font-weight:bold; background-color:lightgrey; margin:15px; padding:20px; border-radius:20px; font-family:arial;'>$resultado</span>";
}


function areaRec($base, $altura) {
if (!is_numeric($base) || !is_numeric($altura)){
        return "<span style='color:red;'>Error: el valor debe ser numérico.</span>";
    }

    $resultado = $base * $altura;

    return "<BR><span style='font-size:24px; color:green; font-weight:bold; background-color:lightgrey; margin:15px; padding:20px; border-radius:20px; font-family:arial;'>$resultado</span>";
}

function areaCir($radio) {
    if (!is_numeric($radio)) {
        return "<span style='color:red;'>Error: el valor debe ser numérico.</span>";
    }

$resultado = pi() * $radio * $radio; 

    return "<BR><span style='font-size:24px; color:green; font-weight:bold; background-color:lightgrey; margin:15px; padding:20px; border-radius:20px; font-family:arial;'>$resultado</span>";
}
function areaTri($base, $altura) {
if (!is_numeric($base) || !is_numeric($altura)){
        return "<span style='color:red;'>Error: el valor debe ser numérico.</span>";
    }

    $resultado = ($base * $altura)/2;

    return "<BR><span style='font-size:24px; color:green; font-weight:bold; background-color:lightgrey; margin:15px; padding:20px; border-radius:20px; font-family:arial;'>$resultado</span>";
}

// Ejemplo de uso con datos del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
$operador = $_POST["operador"]; // Tomar el operador del select


    switch($operador)
    {
        case "areaCuad":
            $lado = $_POST["lado"] ?? null;
            echo areaCuad($lado);
            break;
        case "areaRec":
            $base = $_POST["base"] ?? null;
            $altura = $_POST["altura"] ?? null;
            echo areaRec($base, $altura);
            break;
        case "areaCir":
            $radio = $_POST["radio"] ?? null;
            echo areaCir($radio);
            break;
        case "areaTri":
            $base = $_POST["base"] ?? null;
            $altura = $_POST["altura"] ?? null;
            echo areaTri($base, $altura);
            break;
        default:
            echo "Operador invalido ". $operador;
    }
}
?>
</body>
</html>