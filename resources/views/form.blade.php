<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
    <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjEVJ8K3nhi4t31Lkw1f0G8y4GTQYieJTy6PLNG5hBzmiZLqsrrfh_FWWyEjAF4lhRkSodHAPfHetuN7iX7ujOIIdkXNjfejaG_Z1mXS4lbnNeHrCO6OQnPeTu0JdQ9YLgkf0o3CNwnLtU/s1600/Logo_Ejercito.jpg" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
      <a class="navbar-brand" href="#" style="padding:10px">Ejercito Argentino</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
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
  <h1 style="font-size: 25px; text-align: center;margin-top: 20px; font-family:Arial, Helvetica, sans-serif;">Licencias de suboficiales</h1>
    <form  class="row g-3" id="myForm" style="padding:60px;">
    @csrf   
      <div class="col-md-4">
          <label for="dni" class="form-label">DNI</label>
          <input type="text" class="form-control" id="dni" name="dni">
        </div>
        <div class="col-md-4">
          <label for="fecha" class="form-label">Fecha de inicio de licencia</label>
          <input type="date" class="form-control" id="fechaInicio" name="fechaInicio">
        </div>
        <div class="col-md-4">
          <label for="fecha" class="form-label">Fecha de fin de licencia</label>
          <input type="date" class="form-control" id="fechaFin" name="fechaFin">
        </div>
        <div class="col-md-6">
          <label for="inputState" class="form-label">Tipo de licencia</label>
          <select id="licencia" class="form-select" name="tipo">
            <option selected>Seleccione una opcion:</option>
            <option>Licencia ordinaria</option>
            <option>Licencia extraordinaria</option>
          </select>
        </div>
        <div class="col-md-6">
          <label for="inputState" class="form-label">Provincia:</label>
          <select id="provincia" class="form-select" name="provincia">
            <option selected>Seleccione una opcion:</option>
            <option>Buenos Aires</option>
            <option>Catamarca</option>
            <option>Chubut</option>
            <option>Chaco</option>
            <option>Cordoba</option>
            <option>Corrientes</option>
            <option>Entre Rios</option>
            <option>Formosa</option>
            <option>Jujuy</option>
            <option>La Pampa</option>
            <option>La Rioja</option>
            <option>Mendoza</option>
            <option>Misiones</option>
            <option>Neuquen</option>
            <option>Rio Negro</option>
            <option>Salta</option>
            <option>San Juan</option>
            <option>San Luis</option>
            <option>Santa Cruz</option>
            <option>Santa Fe</option>
            <option>Santiago del Estero</option>
            <option>Tierra del fuego</option>
            <option>Tucuman</option>
          </select>
        </div>
        <div class="col-12">
          <label for="inputAddress2" class="form-label">Direccion</label>
          <input type="text" class="form-control" id="direccion" name="direccion">
        </div>
        <div class="col-md-4">
          <label for="inputState" class="form-label">Localidad</label>
          <input type="text" class="form-control" id="localidad" name="localidad">
          </select>
        </div>
        <div class="col-md-4">
          <label for="inputZip" class="form-label">Orden del dia</label>
          <input type="text" class="form-control" id="ordendeldia" name="ordenDia">
        </div>
        <div class="col-12">
          <button type="submit" id="btnEnvio" class="btn btn-primary">Agregar licencia</button>
        </div>
      </form>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const inputs = document.querySelectorAll('#myForm input');
    $(document).ready(function(){
        $.validator.addMethod("fechaMenor", function(value, element, params) {
        var fechaInicio = new Date($('#fechaInicio').val());
        var fechaFin = new Date(value);
        return fechaFin > fechaInicio;
    }, "La fecha debe ser mayor que la fecha de inicio.");

    $("#myForm").validate({
        rules: {
            dni: {
                required:true,
                digits: true,
                minlength: 8,
                maxlength: 9
            },
            fechaInicio: {
              required: true
            },
            fechaFin: {
              required: true,
              fechaMenor: true
            },
            tipo: {
              required: true
            },
            provincia:{
              required: true
            },
            direccion:{
              required: true
            },
            localidad:{
              required: true
            },
            ordenDia:{
              required:true,
              minlength: 6,
              maxlength: 10
            }
        },
        messages: {
            dni: {
                required: "El DNI es requerido",
                digits: "El DNI debe tener solo dígitos",
                minlength: "El DNI debe tener al menos {0} dígitos",
                maxlength: "El DNI no debe exceder los {0} dígitos"
            },
            fechainicio: {
                required: "Debes seleccionar una fecha de inicio"
            },
            fechafin: {
                required: "Debes seleccionar una fecha de fin"
            },
            tipo: {
              required: "Debe seleccionar el tipo de licencia"
            },
            provincia:{
              required: "Debe seleccionar la provincia"
            },
            direccion:{
              required: "Debe indicar la direccion"
            },
            localidad:{
              required:"Debe indicar la localidad"
            },
            ordenDia:{
              required: "Debe indicar la orden del dia",
              minlength: "La orden del dia debe tener al menos 6 caracteres",
              maxlength: "La orden del dia no puede tener mas de 10 caracteres"
            }
        }
    });
    $('#btnEnvio').click(function(e){
        e.preventDefault(); 
        var formData = $('#myForm').serialize();
        console.log(formData);
       $.ajax({
          method: 'POST',
          url: 'http://localhost:5800/insert',
          dataType:'json',
          data: formData,
            success: function(data){
               
                console.log(data); 
                Swal.fire({
                icon: "success",
                 title: "Gracias!",
                  text: "Formulario enviado con exito",
                   
});
            },
            error: function(xhr, status, error){
                console.error('Hubo un error al enviar los datos: ' + error);
            }
        });
    });
});

</script>