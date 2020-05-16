function validarComentario(form) {
	if (form.comentar.value.length==0) {
		alert("Inserte al menos un caracter");
		return false;
	}
	return true;
}

function validarRegistro(form){
	var errores ='';

	if(!form.email.value.includes("@")){
		//errores += '<li>Ingrese una direccion de email valida.</li>';
		alert('Ingrese un correo valido');
	}

	if ((form.nombre.value=='') || (!soloAlfabeticos(form.nombre.value))){
		//errores +='<li>Ingrese un nombre valido</li>';
		alert('Ingrese un nombre valido');
	}

	if ((form.apellido.value=='') || (!soloAlfabeticos(form.apellido.value))){
		//errores +='<li>Ingrese un apellido valido</li>';
		alert('Ingrese un apellido valido');
	}
	if (form.nombreusuario.value.length <6) {
		//errores += '<li>El nombre de usuario debe tener 6 o mas caracteres</li>';
		alert('El nombre de usuario debe tener 6 o mas caracteres');
	}
	if (!esAlfaNumerico(form.nombreusuario.value)) {
		//errores +='<li>El nombre de usuario solo acepta alfanumericos</li>';
		alert('El nombre de usuario solo acepta alfanumericos');
	}
	if (!validarPassword(form.contrasenia.value)){
		//errores += '<li>Ingrese una contrasenia valida</li>';
		alert('Ingrese una contrasenia valida');
	}
	if (form.contrasenia.value != form.contraseniarep.value) {
		//errores += '<li>Las contraseñas no coinciden.</li>';
		alert ('Las contraseñas no coinciden');
	}

	if(errores){
		return false;
	}
	return true;

}
function validarLogin(form){
	if (form.nombreusuario.value =="" || form.contrasenia.value =="" ){
		alert('Por favor complete los campos');
		return false;
	}
	return true;

}
function tieneNumero(str){
	return (/[0-9]/.test(str));
}
function tieneMinuscula(str){
	return (/[a-z]/.test(str));
}
function tieneMayuscula(str) {
	return (/[A-Z]/.test(str));
}
function tieneSimbolo(str){
	return str.includes('@') || 
				 str.includes('#') || 
				 str.includes('%') || 
				 str.includes('$') ||
				 str.includes('&') ||
				 str.includes('!');
}
function validarPassword(pass){
	return (pass.length >= 6) && tieneMayuscula(pass) && tieneMinuscula(pass) && (tieneSimbolo(pass) || tieneNumero(pass));
}

function soloAlfabeticos(str){
	return (/^[A-Za-z\s]+$/.test(str));
}
function esAlfaNumerico(str){
	return (/^[A-Za-z0-9\s]+$/.test(str));
}