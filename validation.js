function onlyLetters(event) {
    const pressedKey = event.key;
    const letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
        'N', 'Ñ', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        'Á', 'É', 'Í', 'Ó', 'Ú',
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
        'n', 'ñ', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        'á', 'é', 'í', 'ó', 'ú',' '];

    if (!letters.includes(pressedKey)){
        return false
    }    
}

function onlyNumbers(event) {
    const pressedKey = event.key;
    const numbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    if (!numbers.includes(pressedKey)){
        return false
    }    
}

function validarCorreo() {
    const correo = document.getElementById("correo").value.trim();

    const regexCorreo = /^[a-zA-Z0-9._%+\-ñÑáéíóúÁÉÍÓÚ]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/;

    if (!regexCorreo.test(correo)) {
        alert("Por favor, introduce un correo electrónico válido.");
        return false; 
    }

    return true; 
}