@extends('plantilla')

@section('contenido')

<div class="container-fluid">
<!-- Ejemplo de tabla Listado -->
    <div class="card">
        <div class="card-header">

           <h2>Listado de Categorías</h2><br/>
          
            <button class="btn btn-primary btn-lg" type="button" data-toggle="modal" data-target="#abrirmodal">
                <i class="fa fa-plus fa-2x"></i>&nbsp;&nbsp;Agregar Categoría
            </button>
        </div>
        <div class="card-body">
            <div class="form-group row">
              
            </div>
            <table class="table table-bordered table-striped table-sm">
                <thead>
                    <tr class="bg-primary">
                       
                        <th>#</th>
                        <th>Nombre categoria</th>
                        <th>Fecha registro</th>
                        <th>Estado</th>
                        <th>Editar</th>
                        <th>Cambiar Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $con=1;
                    foreach ($categoria as $listar) {  ?>
                        <tr>
                            <td><?php echo $con++; ?></td>
                            <td><?php echo $listar->ca_nombre; ?></td>
                            <td><?php echo $listar->created_at; ?></td>
                            <td>
                                <?php if($listar->ca_estado=='ACTIVO'){ ?>
                                    <button type="button" class="btn btn-success btn-md">
                                      <i class="fa fa-check fa-2x"></i> Activo
                                    </button>
                                <?php }else{ ?>
                                    <button type="button" class="btn btn-danger btn-md">
                                      <i class="fa fa-check fa-2x"></i> Inactivo
                                    </button>
                                <?php } ?>
                                
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-md"  onclick="editarCategoria('<?php echo $listar->id ?>')" >
                                  <i class="fa fa-edit fa-2x"></i> Editar
                                </button> &nbsp;
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" onclick="cambiarEstadoCat('<?php echo $listar->id ?>','<?php echo $listar->ca_estado ?>')">
                                    <i class="fa fa-lock fa-2x"></i> Cambiar estado
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                   
                </tbody>
            </table>
           
        </div>
    </div>
    <!-- Fin ejemplo de tabla Listado -->
</div>



<!--Inicio del modal agregar/actualizar-->
<div class="modal fade" id="abrirmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-primary modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Agregar categoría</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
            </div>
           
            <div class="modal-body">
                
                <div class="form-group row div-error">
                    
                    <div class="text-center text-error">
                        
                        <div></div>

                    </div>
                
                </div>
                 

                <form id="guardarNuevoCategoria" method="post" enctype="multipart/form-data" class="form-horizontal">

                    @csrf
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label" for="text-input">Categoría</label>
                        <div class="col-md-9">
                            <input type="text" name="nombre" class="form-control" placeholder="Nombre de categoría" required>
                        </div>
                    </div>
                 
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                    </div>


                </form>

            </div>



        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Fin del modal-->







<!--Inicio del modal agregar/actualizar-->
<div class="modal fade" id="editarmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-primary modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modificar categoría</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="ver_datos">
                
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Fin del modal-->


<script>
$("#guardarNuevoCategoria").submit(function(event) {
    event.preventDefault();
    // alert('hola')
    $.ajax({
        url:'/guardarNuevoCategoria',
        type:'POST',
        data:$("form").serialize(),
        success:function(){

            alertify.alert("<b>datos enviado</b>", function () {

                window.location='/categoria';

            });
        }
    });
});

function cambiarEstadoCat(id,ca_estado){
    // alert(id+' '+ca_estado)
    $.post('/cambiarEstadoCat', {id,ca_estado}, function() {
        alertify.alert("<b>datos enviado</b>", function () {

            window.location='/categoria';

        });
    });
}

function editarCategoria(id){
    $("#editarmodal").modal('show');
    $.post('/editarCategoria', {id}, function(datos) {
        $("#ver_datos").html(datos)
    });
}
</script>

@endsection