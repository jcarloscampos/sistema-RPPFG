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
        var user = document.getElementById('user').value.trim();
        var pwd = document.getElementById('pwd').value.trim();
        var pwdc = document.getElementById('pwdc').value.trim();
        if(name === '' || lname === '' || codsis === '' || ci === '' || email === '' || user === '' || pwd === '' || pwdc === ''){
            alertify.alert("Todos los campos deben ser llenados.", function(){
                alertify.message('Ingrese datos correctos');
            });
            return false;
        }else{
            return true;
        }
    }
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
            alertify.alert('Nombre, apellido, ci y email son obligatorios.', function(){
                alertify.message('Ingrese datos correctos');
            });
            return false;
        }else{
            return true;
        }
    }
}

function validateFormCrudArea ()
{
    var name = document.getElementById('name').value.trim();
    if(name === ''){
        alertify.alert("Nombre de área debe ser llenado.", function(){
            alertify.message('Ingrese datos correctos');
        });
        return false;
    }else{
        return true;
    }
}

function validateFormAddAccount()
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
            alertify.alert('Todos los campos deben ser llenados.', function(){
                alertify.message('Ingrese datos correctos');
            });
            return false;
        }else{
            return true;
        }
    }
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
            return true;
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
            return true;
        }
    }
}


