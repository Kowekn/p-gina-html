/* cmd dentro da pasta node nomearquivo.js */


function ver_senha() {
    var x = document.getElementById("senha");
    if (x.type == "password") {
        x.type = "text";
    }else {
        x.type = "password";
    }
}




function ponto_cpf() {
    let x = document.getElementById("cpf");
    x.onkeydown = function() {
        if (event.keyCode == 8){
            x.value = "";
        }
    }
    if (x.value.length == 3 || x.value.length == 7 ) {
        
        x.value += ".";
        
    } else if (x.value.length == 11) {
        x.value += "-";
    }
}


function critdmgrange() {
    let critdmgrange = document.getElementById("critdmgrange").value;
    document.getElementById("critdmgtxt").value = critdmgrange;
}
function critdmgtxt() {
    let critdmgtxt = document.getElementById("critdmgtxt").value;
    document.getElementById("critdmgrange").value = critdmgtxt;
}

function critraterange() {
    let critraterange = document.getElementById("critraterange").value;
    document.getElementById("critratetxt").value = critraterange;
}
function critratetxt() {
    let critratetxt = document.getElementById("critratetxt").value;
    document.getElementById("critraterange").value = critratetxt;
}

function displaycritvalue() {
    let critvalue = 0;
    let critdmg = document.getElementById("critdmgrange").value;
    let critrate = document.getElementById("critraterange").value;
    /*let critdmgv = critdmg / 100;
    critvalue = critrate * critdmgv; */
    critrate *= 2;
    critvalue = +critdmg + +critrate; //unary operator (mesmo que Number() nesse caso mas o "-" transforma em Number() e o nega (negativo))
    
    document.getElementById("critvalue").innerHTML = "Crit Value: " + "</br>" + critvalue.toFixed(2);
}