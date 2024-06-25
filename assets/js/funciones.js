document.addEventListener("DOMContentLoaded", function () {
    $('#tbl').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
        "order": [
            [0, "desc"]
        ]
    });
    $(".confirmar").submit(function (e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Desea eliminar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        })
    })

    
    

    $("#defunum").autocomplete({
        minLength: 3,
        source: function (request, response) {
            $.ajax({
                url: "ajax.php",
                dataType: "json",
                data: {
                    def: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            $("#id").val(ui.item.id);
            $("#defunum").val(ui.item.value);
            $("#precio").val(ui.item.precio);
            $("#fecha").val(ui.item.fecha);
        }
    })

    $("#matrinum").autocomplete({
        minLength: 3,
        source: function (request, response) {
            $.ajax({
                url: "ajax.php",
                dataType: "json",
                data: {
                    mat: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            $("#id").val(ui.item.id);
            $("#matrinum").val(ui.item.value);
            $("#precio").val(ui.item.precio);
            $("#fecha").val(ui.item.fecha);
        }
    })

    $("#divonum").autocomplete({
        minLength: 3,
        source: function (request, response) {
            $.ajax({
                url: "ajax.php",
                dataType: "json",
                data: {
                    div: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            $("#id").val(ui.item.id);
            $("#divonum").val(ui.item.value);
            $("#precio").val(ui.item.precio);
            $("#fecha").val(ui.item.fecha);
        }
    })

    $("#reconum").autocomplete({
        minLength: 3,
        source: function (request, response) {
            $.ajax({
                url: "ajax.php",
                dataType: "json",
                data: {
                    rec: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            $("#id").val(ui.item.id);
            $("#reconum").val(ui.item.value);
            $("#precio").val(ui.item.precio);
            $("#fecha").val(ui.item.fecha);
        }
    })

    $("#nacinum").autocomplete({
        minLength: 3,
        source: function (request, response) {
            $.ajax({
                url: "ajax.php",
                dataType: "json",
                data: {
                    nac: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            $("#id").val(ui.item.id);
            $("#nacinum").val(ui.item.value);
            $("#precio").val(ui.item.precio);
            $("#fecha").val(ui.item.fecha);
        }
    })

    $("#numero").autocomplete({
        minLength: 3,
        source: function (request, response) {
            $.ajax({
                url: "ajax.php",
                dataType: "json",
                data: {
                    dig: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            $("#id").val(ui.item.id);
            $("#folio").val(ui.item.folio);
            $("#numero").val(ui.item.value);
            $("#tipo").val(ui.item.tipo);
            $("#libro").val(ui.item.libro);
            $("#año").val(ui.item.año);
            $("#pdf").val(ui.item.pdf);
        }
    })

    $("tipo_acta").autocomplete({
        minLength: 3,
        source: function (request, response) {
            $.ajax({
                url: "ajax.php",
                dataType: "json",
                data: {
                    con: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            $("#id").val(ui.item.id);
            $("#tipo_acta").val(ui.item.tipo_acta);
            $("#precio").val(ui.item.value);
            $("#fecha").val(ui.item.fecha);
        }
    })

    
})



function btnCambiar(e) {
    e.preventDefault();
    const actual = document.getElementById('actual').value;
    const nueva = document.getElementById('nueva').value;
    if (actual == "" || nueva == "") {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Los campos estan vacios',
            showConfirmButton: false,
            timer: 2000
        })
    } else {
        const cambio = 'pass';
        $.ajax({
            url: "ajax.php",
            type: 'POST',
            data: {
                actual: actual,
                nueva: nueva,
                cambio: cambio
            },
            success: function (response) {
                if (response == 'ok') {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Contraseña modificado',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    document.querySelector('#frmPass').reset();
                    $("#nuevo_pass").modal("hide");
                } else if (response == 'dif') {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'La contraseña actual incorrecta',
                        showConfirmButton: false,
                        timer: 2000
                    })
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Error al modificar la contraseña',
                        showConfirmButton: false,
                        timer: 2000
                    })
                }
            }
        });
    }
}



function editarUsuario(id) {
    const action = "editarUsuario";
    $.ajax({
        url: 'ajax.php',
        type: 'GET',
        async: true,
        data: {
            editarUsuario: action,
            id: id
        },
        success: function (response) {
            const datos = JSON.parse(response);
            $('#nombre').val(datos.nombre);
            $('#usuario').val(datos.usuario);
            $('#correo').val(datos.correo);
            $('#id').val(datos.idusuario);
            $('#btnAccion').val('Actualizar');
        },
        error: function (error) {
            console.log(error);

        }
    });
}


function editarDefuncion(id) {
    const action = "editarDefuncion";
    $.ajax({
        url: 'ajax.php',
        type: 'GET',
        async: true,
        data: {
            editarDefuncion: action,
            id: id
        },
        success: function (response) {
            const datos = JSON.parse(response);
            $('#codigo').val(datos.codigo);
            $('#defunum').val(datos.numero);
            $('#precio').val(datos.precio);
            $('#fecha').val(datos.fecha);
            $('#id').val(datos.coddefuncion);
            $('#btnAccion').val('Actualizar');
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function editarMatrimonio(id) {
    const action = "editarMatrimonio";
    $.ajax({
        url: 'ajax.php',
        type: 'GET',
        async: true,
        data: {
            editarMatrimonio: action,
            id: id
        },
        success: function (response) {
            const datos = JSON.parse(response);
            $('#codigo').val(datos.codigo);
            $('#matrinum').val(datos.numero);
            $('#precio').val(datos.precio);
            $('#fecha').val(datos.fecha);
            $('#id').val(datos.codmatrimonio);
            $('#btnAccion').val('Actualizar');
        },
        error: function (error) {
            console.log(error);

        }
    });
}

function editarDivorcio(id) {
    const action = "editarDivorcio";
    $.ajax({
        url: 'ajax.php',
        type: 'GET',
        async: true,
        data: {
            editarDivorcio: action,
            id: id
        },
        success: function (response) {
            const datos = JSON.parse(response);
            $('#codigo').val(datos.codigo);
            $('#divonum').val(datos.numero);
            $('#precio').val(datos.precio);
            $('#fecha').val(datos.fecha);
            $('#id').val(datos.coddivorcio);
            $('#btnAccion').val('Actualizar');
        },
        error: function (error) {
            console.log(error);

        }
    });
}

function editarReconocimiento(id) {
    const action = "editarReconocimiento";
    $.ajax({
        url: 'ajax.php',
        type: 'GET',
        async: true,
        data: {
            editarReconocimiento: action,
            id: id
        },
        success: function (response) {
            const datos = JSON.parse(response);
            $('#codigo').val(datos.codigo);
            $('#reconum').val(datos.numero);
            $('#precio').val(datos.precio);
            $('#fecha').val(datos.fecha);
            $('#id').val(datos.codreco);
            $('#btnAccion').val('Actualizar');
        },
        error: function (error) {
            console.log(error);

        }
    });
}

function editarNacimiento(id) {
    const action = "editarNacimiento";
    $.ajax({
        url: 'ajax.php',
        type: 'GET',
        async: true,
        data: {
            editarNacimiento: action,
            id: id
        },
        success: function (response) {
            const datos = JSON.parse(response);
            $('#codigo').val(datos.codigo);
            $('#nacinum').val(datos.numero);
            $('#precio').val(datos.precio);
            $('#fecha').val(datos.fecha);
            $('#id').val(datos.codnacimiento);
            $('#btnAccion').val('Actualizar');
        },
        error: function (error) {
            console.log(error);

        }
    });
}

function editarDigital(id) {
    const action = "editarDigital";
    $.ajax({
        url: 'ajax.php',
        type: 'GET',
        async: true,
        data: {
            editarDigital: action,
            id: id
        },
        success: function (response) {
            const datos = JSON.parse(response);
            $('#folio').val(datos.folio);
            $('#numero').val(datos.numero);
            $('#tipo').val(datos.tipo);
            $('#libro').val(datos.libro);
            $('#año').val(datos.año);
            $('#pdf').val(datos.pdf);
            $('#id').val(datos.codnacimiento);
            $('#btnAccion').val('Actualizar');
        },
        error: function (error) {
            console.log(error);

        }
    });
}



function limpiar() {
    $('#formulario')[0].reset();
    $('#id').val('');
    $('#btnAccion').val('Registrar');
}

function generarPDF() {
    // Redirigir a la página PHP que genera el PDF
    window.location.href = 'reportes_constancias.php';
}