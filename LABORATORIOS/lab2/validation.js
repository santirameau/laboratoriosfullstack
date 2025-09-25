// VALIDACION DE FORMULARIO CALC1

document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("formNumeros");
  const operadorSelect = form.querySelector("select[name='operador']");

  form.addEventListener("submit", function (e) {
    // VALIDAR QUE SE HAYA SELECCIONADO UN VALOR
    
    const valor = operadorSelect.value;

    // VALIDAR QUE EL VALOR ESTE ENTRE 1 Y 10
    const numero = parseInt(valor);

    if (numero < 1 || numero > 10) {


      alert("El valor debe estar entre 1 y 10.");

      
      e.preventDefault();
      return;
    }


    function validarform(){

      
    }

    // SI TODO ESTA BIEN, SE ENVIA
    // No se hace nada, el formulario se envia normalmente
  });
});
// validacion para 5 de oro calc2
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("formNumeros");
    const errorMsg = document.getElementById("errorMsg");

    if (form) {
        form.addEventListener("submit", function (e) {
            errorMsg.innerHTML = "";
            let errores = [];
            let valores = [];

            // Capturar valores y validar
            for (let i = 1; i <= 5; i++) {
                const input = document.getElementById(`num${i}`);
                const valor = parseInt(input.value);

                if (isNaN(valor)) {
                    errores.push(`⚠️ El número ${i} no es válido.`);
                } else if (valor < 1 || valor > 48) {
                    errores.push(`⚠️ El número ${i} (${valor}) debe estar entre 1 y 48.`);
                } else {
                    valores.push(valor);
                }
            }

            // Evitar envío si hay errores
            if (errores.length > 0) {
                e.preventDefault();
                errorMsg.innerHTML = errores.join("<br>");
            }
        });
    }
});



//validacion para factorial calc3

document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("formNumeros");
  const input = document.getElementById("num1");
  const errorDiv = document.getElementById("errorMsg");

  form.addEventListener("submit", function (e) {
    const valor = parseInt(input.value);

    if (isNaN(valor) || valor < 0 || !Number.isInteger(valor)) {
      e.preventDefault(); // Evita el envío
      errorDiv.textContent = "Por favor ingrese un número entero positivo.";
    } else {
      errorDiv.textContent = ""; // Limpia el mensaje si todo está bien
    }
  });
});


