<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tabla con jTable</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/jtable@2.6.0/lib/themes/metro/blue/jtable.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
</head>

<body>
    <style>
    .ui-widget-header {
        background: #4285F4 !important;
        color: #FFFFFF !important;
    }

    .ui-widget-content {
        background: #FFFFFF !important;
        color: #000000 !important;
    }
    </style>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjEVJ8K3nhi4t31Lkw1f0G8y4GTQYieJTy6PLNG5hBzmiZLqsrrfh_FWWyEjAF4lhRkSodHAPfHetuN7iX7ujOIIdkXNjfejaG_Z1mXS4lbnNeHrCO6OQnPeTu0JdQ9YLgkf0o3CNwnLtU/s1600/Logo_Ejercito.jpg"
                alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
            <a class="navbar-brand" href="/" style="padding:10px">Ejercito Argentino</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="/">Cargá tu licencia</a>
                    <a class="nav-link" href="/tabla" style="padding:10px">Tablas de licencias</a>
                </div>
            </div>
        </div>
    </nav>
    <div id="PartesVencidos"></div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jtable@2.6.0/lib/jquery.jtable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $(document).ready(function() {
        $('#PartesVencidos').jtable({
            title: 'Licencias de Suboficiales',
            paging: true,
            pageSize: 10,
            sorting: true,
            async: true,
            defaultSorting: 'fechaInicio',
            actions: {
                listAction: function(postData, jtParams) {
                    return $.Deferred(function($dfd) {
                        $.ajax({
                            type: 'GET',
                            url: 'http://localhost:5800/',
                            dataType: 'json',

                            success: function(data) {
                                $dfd.resolve({
                                    "Result": "OK",
                                    "Records": data
                                        .licencias, // Suponiendo que 'licencias' es el arreglo que contiene los datos en tu respuesta JSON
                                    "TotalRecordCount": data.licencias
                                        .length
                                });
                            },
                            error: function() {
                                $dfd.reject();
                            }
                        });
                    });
                },
                createAction: '/GettingStarted/CreatePerson',
                updateAction: function(postData) {
                    const url = new URLSearchParams(
                        postData
                    )

                    const obj = {}
                    for (const [key, value] of url.entries()) {

                        if (key === "fechaInicio" || key === "fechaFin") {
                            const newDate = value.split("T")[0];
                            obj[key] = newDate
                        } else {
                            obj[key] = value
                        }
                    }
                    console.log(obj);
                    return $.Deferred(function($dfd) {
                        // Mostrar una alerta personalizada con Sweet Alert
                        Swal.fire({
                            title: '¿Estás seguro?',
                            text: 'Esta acción editara la licencia. ¿Deseas continuar?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Sí, editar',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // El usuario confirmó, realizar la eliminación
                                $.ajax({
                                    type: 'POST',
                                    url: 'http://localhost:5800/update',

                                    dataType: 'json',
                                    data: obj,
                                    success: function(data) {
                                        // Mostrar mensaje de éxito personalizado
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Éxito',
                                            text: 'Licencia editada correctamente'
                                        });
                                        $dfd.resolve({
                                            "Result": "OK"
                                        });
                                    },
                                    error: function(e) {
                                        console.log(e);
                                        $dfd.reject();
                                    }
                                });
                            } else {
                                // El usuario canceló, rechazar la eliminación
                                $dfd.reject();
                            }
                        });
                    });

                },
                deleteAction: function(postData) {
                    return $.Deferred(function($dfd) {
                        // Mostrar una alerta personalizada con Sweet Alert
                        Swal.fire({
                            title: '¿Estás seguro?',
                            text: 'Esta acción eliminará la licencia. ¿Deseas continuar?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Sí, eliminar',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // El usuario confirmó, realizar la eliminación
                                $.ajax({
                                    type: 'DELETE',
                                    url: 'http://localhost:5800/delete/' +
                                        postData.id,
                                    headers: {
                                        'X-CSRF-TOKEN': document
                                            .getElementsByTagName(
                                                "meta")[2]
                                            .content,
                                        'Content-Type': 'application/json'
                                    },
                                    dataType: 'json',
                                    success: function(data) {
                                        // Mostrar mensaje de éxito personalizado
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Éxito',
                                            text: 'Licencia eliminada correctamente'
                                        });
                                        $dfd.resolve({
                                            "Result": "OK"
                                        });
                                    },
                                    error: function() {
                                        $dfd.reject();
                                    }
                                });
                            } else {
                                // El usuario canceló, rechazar la eliminación
                                $dfd.reject();
                            }
                        });
                    });
                }
            },

            fields: {
                dni: {
                    title: 'DNI',
                    width: '10%',
                    listClass: 'text-center',
                    key: true,
                    list: true,
                    sorting: false,
                },
                id: {
                    title: 'ID',
                    width: '10%',
                    listClass: 'text-center',
                    key: true,
                    list: true,
                    sorting: false
                },
                fechaInicio: {
                    listClass: 'text-center',
                    title: 'Fecha inicio',
                    width: '10%',
                    sorting: false,
                    display: function(data) {
                        // Formatear la fecha
                        return new Date(data.record.fechaInicio).toISOString().split('T')[0];
                    },
                    displayFormat: 'yy-mm-dd'
                },
                fechaFin: {
                    listClass: 'text-center',
                    title: 'Fecha fin',
                    width: '10%',
                    sorting: false,
                    display: function(data) {
                        // Formatear la fecha
                        return new Date(data.record.fechaFin).toISOString().split('T')[0];
                    },
                    displayFormat: 'yy-mm-dd'
                },
                tipo: {
                    title: 'Tipo de licencia',
                    listClass: 'text-center',
                    width: '10%',
                    sorting: false,
                },
                direccion: {
                    title: 'Direccion',
                    listClass: 'text-center',
                    width: '10%',
                    sorting: false,
                },
                provincia: {
                    listClass: 'text-center',
                    title: 'Provincia',
                    width: '12%',
                    sorting: false,
                },
                localidad: {
                    listClass: 'text-center',
                    title: 'Localidad',
                    sorting: false,
                    width: '12%',
                },
                direccion: {
                    listClass: 'text-center',
                    title: 'Dirección',
                    sorting: false,
                    width: '12%',
                },
                ordenDia: {
                    listClass: 'text-center',
                    width: '12%',
                    title: 'Orden del Dia',
                    sorting: false,
                },
            },

        });


        $('#PartesVencidos').jtable('load');
        $('#PartesVencidos').on('click', '.jtable-toolbar-item-add-record', function() {
            // Redirigir al usuario a la vista del formulario
            window.location.href =
                '/'; // Reemplaza '/ruta-de-tu-formulario' con la ruta correcta de tu formulario
        });
    })
    </script>
</body>

</html>