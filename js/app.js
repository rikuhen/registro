$(document).ready(function() {

    var $nombre = $('#nombre');
    var $apellido = $('#apellido');
    var $edad = $('#edad');
    var $genero = $('#genero');
    var $fechaNacimiento = $('#fecha_nacimiento');

    $('#cedula').on('keydown', function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            var _this = $(this);
            if (!_this.val() || _this.val().length < 10) return false;
            if (!validarCedula(_this.val())) {
                alert("Cedula Inválida");
                return false;
            }
            $("#loader").css('display', 'block')
            buscarPersona(_this.val()).done(function(data) {
                _this.prop('readonly', 'readonly');
                $nombre.val(data.nombres);
                $apellido.val(data.apellidos);
                $edad.val(data.edad);
                $genero.val(data.genero == 'MALE' ? 'Masculino' : 'Femenino');
                $fechaNacimiento.val(data.nacimiento);
                $('.campo-llenar').removeAttr('disabled').removeAttr('readonly');
                $("#celular").focus();
                
                $(".btn-reset").css('display','block');
                $(".btn-search").css('display','none');

                $('.btn-procesar').removeAttr('disabled')
            }).fail(function(reason) {
                alert(reason.message);
            }).always(function() {
                $("#loader").css('display', 'none')
            });
        }
    });


    $('.btn-search').on('click', function(event) {
        var _this = $(this);
        var $cedula = $('#cedula');
        if (!$cedula.val() || $cedula.val().length < 10) return false;
        if (!validarCedula($cedula.val())) {
            alert("Cedula Inválida");
            return false;
        }
        $("#loader").css('display', 'block')
        buscarPersona($cedula.val()).done(function(data) {
                $cedula.prop('readonly', 'readonly');
                _this.prop('readonly', 'readonly');
                $nombre.val(data.nombres);
                $apellido.val(data.apellidos);
                $edad.val(data.edad);
                $genero.val(data.genero == 'MALE' ? 'Varón' : 'Mujer');
                $fechaNacimiento.val(data.nacimiento);
                $('.campo-llenar').removeAttr('disabled').removeAttr('readonly');
                $("#celular").focus();
                
                $(".btn-reset").css('display','block');
                $(".btn-search").css('display','none');

                $('.btn-procesar').removeAttr('disabled')
            })
            .fail(function(reason) {
                alert(reason.message);
            })
            .always(function() {
                $("#loader").css('display', 'none')
            });
    });


    $('#provincia').on('change', function(event) {
        var optVal = $(this).val();
        var ciudadCombo = $('#ciudad');
        ciudadCombo.find('option').remove();
        $.ajax({
                url: 'lib/controllers/carga-ciudades.php?provincia=' + optVal,
                type: 'GET',
                dataType: 'JSON',
            })
            .done(function(result) {
                var $html = "";
                for (var i = 0; i < result.length; i++) {
                    $html += "<option value='" + result[i].id + "'>";
                    $html += result[i].nombre;
                    $html += "</option>";
                }

                ciudadCombo.append($html);

            })
            .always(function() {
                ciudadCombo.removeAttr('disabled');
            });

    });


    $("#ciudad").on('change', function(event) {

        var optVal = $(this).val();
        var parroquiaCombo = $('#parroquia');
        parroquiaCombo.find('option').remove();
        parroquiaCombo.append('<option value="">Seleccione</option>');


        $.ajax({
                url: 'lib/controllers/carga-parroquias.php?ciudad=' + optVal,
                type: 'GET',
                dataType: 'JSON',
            })
            .done(function(result) {
                var $html = "";
                for (var i = 0; i < result.length; i++) {
                    $html += "<option value='" + result[i].id + "'>";
                    $html += result[i].nombre;
                    $html += "</option>";
                }

                parroquiaCombo.append($html);

            })
            .always(function() {
                parroquiaCombo.removeAttr('disabled');
            });
    });


    $('#tiene-hijos').on('click', function(e) {
        var check = $(e.currentTarget).is(':checked');
        var $txtHijos = $("#cantidad-hijos");

        if (check) {
            $txtHijos.val('').removeAttr('readonly')
        } else {
            $txtHijos.val('').prop('readonly', 'readonly')
        }

    })



    $('.btn-procesar').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $("#loader").css('display', 'block')
        $.ajax({
                url: 'lib/controllers/procesar.php',
                type: 'POST',
                data: $('form').serialize(),

            })
            .done(function(data) {
                alert(data.message);
            })
            .fail(function(reason) {
                alert(reason.message);
            })
            .always(function() {
                $("#loader").css('display', 'block');
                location.reload();
            });

    });


    $('.btn-reset').on('click',function() {
        location.reload();
    })

});



var buscarPersona = function(cedula) {
    var deferred = jQuery.Deferred();
    $.ajax({
            url: 'lib/controllers/buscar-persona.php?cedula=' + cedula,
            type: 'GET',
            dataType: "json",
            crossDomain: true,
            contentType: 'application/json'
        })
        .done(function(data) {
            deferred.resolve(data);
        })
        .fail(function(error) {
            var error = JSON.parse(error.responseText);
            deferred.reject(error);
        })

    return deferred.promise()
}

var validarCedula = function(value) {
    var cad = value.trim();
    var total = 0;
    var longitud = cad.length;
    var longcheck = longitud - 1;

    if (cad !== "" && longitud === 10) {
        for (i = 0; i < longcheck; i++) {
            if (i % 2 === 0) {
                var aux = cad.charAt(i) * 2;
                if (aux > 9) aux -= 9;
                total += aux;
            } else {
                total += parseInt(cad.charAt(i));
            }
        }

        total = total % 10 ? 10 - total % 10 : 0;

        if (cad.charAt(longitud - 1) == total) {
            return true;
        } else {
            return false;
        }
    }
}