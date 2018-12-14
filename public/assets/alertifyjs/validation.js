function formatNum(input)
{
    var num = input.value;
    if(isNaN(num)){
        alertify.alert("Solo se permiten números.", function(){
            input.value = input.value.replace(/[^\d\.]*/g,'');
            alertify.message('Ingrese datos correctos');
        });
    }
}

function formatLetters(input)
{
    var lett = input.value;
    var result = /[0-9]/.test(lett);
    if(result){
        alertify.alert("Solo se permiten letras.", function(){
            input.value = input.value.replace(/[0-9]*/g,'');
            alertify.message('Ingrese datos correctos');
        });
    }
}

function validateFormSignup()
{
    var result = false;
    var name = document.getElementById('name').value.trim();
    var lname = document.getElementById('lname').value.trim();
    var codsis = document.getElementById('codsis').value.trim();
    var ci = document.getElementById('ci').value.trim();
    var email = document.getElementById('email').value.trim();
    var user = document.getElementById('user').value.trim();
    var pwd = document.getElementById('pwd').value.trim();
    var pwdc = document.getElementById('pwdc').value.trim();

    if(name === '' || lname === '' || codsis === '' || ci === '' || email === '' || user === '' || pwd === '' || pwdc === ''){
        alertify.alert("Todos los campos deben ser llenados.", function(){
            alertify.message('Ingrese datos correctos');
        });
    }else{
        var email = document.getElementById('email').value.trim();
        var resultemail = /\w+@\w+\.+[a-z]/.test(email);
        if(!resultemail){
            alertify.alert("El correo no es válido.", function(){
                alertify.message('Ingrese datos correctos');
            });
        } else {
            result = true;
        }
    }
    return result;
}

function validateFormSignin()
{
    var username = document.getElementById('username').value.trim();
    var password = document.getElementById('password').value.trim();
    if(username === '' || password === ''){
        alertify.alert("Todos los campos deben ser llenados.", function(){
            alertify.message('Ingrese datos correctos');
        });
        return false;
    }else{
        return true;
    }
}

function validateFormConfigAdmin()
{
    var auxname = document.getElementById('auxname').value.trim();
    var auxlname = document.getElementById('auxlname').value.trim();
    var auxmlname = document.getElementById('auxmlname').value.trim();
    var auxci = document.getElementById('auxci').value.trim();
    var auxemail = document.getElementById('auxemail').value.trim();
    var auxaddress = document.getElementById('auxaddress').value.trim();
    var auxphone = document.getElementById('auxphone').value.trim();

    var name = document.getElementById('name').value.trim();
    var lname = document.getElementById('lname').value.trim();
    var mlname = document.getElementById('mlname').value.trim();
    var ci = document.getElementById('ci').value.trim();
    var email = document.getElementById('email').value.trim();
    var address = document.getElementById('address').value.trim();
    var phone = document.getElementById('phone').value.trim();
    var pwd = document.getElementById('pwd').value.trim();

    var result = false;

    if (auxname != name || auxlname != lname || auxmlname != mlname || auxci != ci || auxemail != email || auxaddress != address || auxphone != phone || pwd != "" ){
        if (name === '' || lname === '' || ci === '' || email === '') {
            alertify.alert('Nombre, apellido, ci y email son obligatorios.', function(){
                alertify.message('Ingrese datos correctos');
            });
        } else {
            var result = /\w+@\w+\.+[a-z]/.test(email);
            if(!result){
                alertify.alert("El correo no es válido.", function(){
                    alertify.message('Ingrese correo válido');
                });
            } else {
                result = true;
            }
        }
        
    }
    return result;
}

function validateFormCrudArea ()
{
    var name = document.getElementById('name').value.trim();
    var result = false
    if(name === ''){
        alertify.alert("Los campos deben ser llenados correctamente. \n Obligatorio: nombre de área. \n Opcional: descripción de área.", function(){
            alertify.message('Ingrese datos correctos');
        });
    }else{
        result = confirm("Los datos se guardaran en la Base de Datos. \n ¿Está seguro de continuar?");
    }
    return result;
}


function validateFormConfigPUmss()
{
    var email = document.getElementById('email').value.trim();
    var result = /\w+@\w+\.+[a-z]/.test(email);
    if(!result){
        alertify.alert("El correo no es válido.", function(){
            alertify.message('Ingrese datos correctos');
        });
        return false;
    } else {
        var name = document.getElementById('name').value.trim();
        var lname = document.getElementById('lname').value.trim();
        var codsis = document.getElementById('codsis').value.trim();
        var ci = document.getElementById('ci').value.trim();
        var email = document.getElementById('email').value.trim();
       
        if(name === '' || lname === '' || codsis === '' || ci === '' || email === ''){
            alertify.alert("Nombre, apellido, cod-sis, ci y email son obligatorios.", function(){
                alertify.message('Ingrese datos correctos');
            });
            return false;
        }else{
            var result = false;
            result = confirm('Los cambios se guardarán, ¿está seguro de continuar?');
            return result;
        }
    }
}




function validateFormEssence()
{
    var title = document.getElementById('title').value.trim();
    var gobj = document.getElementById('gobj').value.trim();
    var sobj = document.getElementById('sobj').value.trim();
    var dcptn = document.getElementById('dcptn').value.trim();

    if(title === '' || gobj === '' || sobj === '' || dcptn === ''){
        alertify.alert("Todos los campos deben ser llenados.", function(){
            alertify.message('Ingrese datos correctamente');
        });
        return false;
    }else{
        return true;
    }
}




function validateFormConfigEtn()
{
    var email = document.getElementById('email').value.trim();
    var result = /\w+@\w+\.+[a-z]/.test(email);
    if(!result){
        alertify.alert("El correo no es válido.", function(){
            alertify.message('Ingrese datos correctos');
        });
        return false;
    } else {
        var name = document.getElementById('name').value.trim();
        var lname = document.getElementById('lname').value.trim();
        var ci = document.getElementById('ci').value.trim();
        var email = document.getElementById('email').value.trim();
       
        if(name === '' || lname === '' || ci === '' || email === ''){
            alertify.alert("Nombre, apellido, ci y email son obligatorios.", function(){
                alertify.message('Ingrese datos correctos');
            });
            return false;
        }else{
            var result = false;
            result = confirm('Los cambios se guardarán, ¿está seguro de continuar?');
            return result;
        }
    }
}


/************************************************************************/
function validateFormforget()
{
    var email = document.getElementById('email').value.trim();
    var result = /\w+@\w+\.+[a-z]/.test(email);
    if(!result){
        alertify.alert("El correo no es válido.", function(){
            alertify.message('Ingrese datos correctos');
        });
        return false;
    } else {
        var email = document.getElementById('email').value.trim();
        var ci = document.getElementById('ci').value.trim();
       
        if(ci === '' || email === ''){
            alertify.alert("Email y CI son obligatorios.", function(){
                alertify.message('Ingrese datos correctos');
            });
            return false;
        }else{
            return true;
        }
    }
}

function validateSearch()
{
    var title = document.getElementById('title').value.trim();
    
    if(title === ''){
        alertify.alert("Debe ingresar el título del Proyecto.", function(){
            alertify.message('Ingrese datos correctos');
        });
        return false;
    }else{
        return true;
    }
    
}
