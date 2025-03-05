@extends('plantilla')

@section('contenido')

<div class="container-fluid">
<!-- Ejemplo de tabla Listado -->
    <div class="card">
        <div class="card-header">

           <h2>Listado de Productos</h2><br/>
          
            <button class="btn btn-primary btn-lg" type="button" data-toggle="modal" data-target="#abrirmodal">
                <i class="fa fa-plus fa-2x"></i>&nbsp;&nbsp;Agregar Categoría
            </button>
            <a href="/reporteProductoPdf" class="btn btn-warning btn-lg " target="_blank" ><i class="fa fa-file-pdf-o"></i> reporte pdf </a>
            <a href="/reporteProductoExcel" class="btn btn-success btn-lg " target="_blank"> <i class="fa fa-file-excel-o"></i>  reporte excel </a>

        </div>
        <div class="card-body">
            <div class="form-group row">
                
            </div>
            <table class="table table-bordered table-striped table-sm">
                <thead>
                    <tr class="bg-primary">
                        <th>#</th>
                        <th>CATEGORIA</th>
                        <th>IMAGEN</th>
                        <th>NOMBRE PRODUCTO</th>
                        <th>DESCRIPCION</th>
                        <th>STOCK</th>
                        <th>ESTADO</th>
                        <th>FECHA REG</th>
                        <th>ACCION</th>
                    </tr>
                </thead>
                <tbody>
                   <?php $con=1;
                   foreach ($producto as  $value) { ?>
                    <tr>
                        <td><?php echo $con++; ?></td>
                        <td><?php echo $value->ca_nombre ?></td>
                        <td><img width="70" src="/img_producto/<?php echo $value->pr_imagen ?>" ></td>
                        <td><?php echo $value->pr_nombre ?></td>
                        <td><?php echo $value->pr_descripcion ?></td>
                        <td><?php echo $value->pr_stock ?></td>

                        <td>
                            <?php if($value->pr_estado=='ACTIVO'){ ?>
                                <button type="button" class="btn btn-success btn-md">
                                  <i class="fa fa-check fa-2x"></i> Activo
                                </button>
                            <?php }else{ ?>
                                <button type="button" class="btn btn-danger btn-md">
                                  <i class="fa fa-check fa-2x"></i> Inactivo
                                </button>
                            <?php } ?>
                        </td>
                        <td><?php echo $value->pr_fecha_reg ?></td>

                        <td>
                            <button type="button" class="btn btn-info btn-md" onclick="editarProducto('<?php echo $value->id ?>')">
                              <i class="fa fa-edit fa-2x"></i> EDITAR
                            </button> &nbsp;
                            
                            <button type="button" class="btn btn-danger btn-sm" onclick="estadoProducto('<?php echo $value->id ?>','<?php echo $value->pr_estado ?>')">
                                <i class="fa fa-lock fa-2x"></i> ESTADO
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


<!--Inicio del modal agregar-->
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
                

                <form id="guardarNuevoProducto" method="post" enctype="multipart/form-data" class="form-horizontal">

                    @csrf
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label" >SELECCIONAR CATEGORIA</label>
                        <div class="col-md-9">
                            <select name="idcategoria"  class="form-control" required>
                                <option></option>
                                <?php foreach ($categoria as $obj) { ?>
                                    <option value="<?php echo $obj->id; ?>"><?php echo $obj->ca_nombre; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label" >IMAGEN</label>
                        <div class="col-md-9">
                        <input type="file" name="imagen" class="form-control" accept="image/*" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label"  >NOMBRE PRODUCTO</label>
                        <div class="col-md-9">
                        <input type="text" name="nombre_producto" class="form-control" placeholder="Ingresar..." required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 form-control-label"  >DESCRIPCION</label>
                        <div class="col-md-9">
                        <input type="text" name="descripcion" class="form-control" placeholder="Ingrese descripcion">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label" >STOCK</label>
                        <div class="col-md-9">
                        <input type="text" name="stok" class="form-control" onkeypress="return solonumeros(event);"  placeholder="Ingrese descripcion" required>
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





<!--Inicio del modal agregar-->
<div class="modal fade" id="editarmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-primary modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">MODIFICAR PRODUCTO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
            </div>
           
            <div class="modal-body" id="ver_productos">
                
            </div>
        </div>
    </div>
</div>
<!--Fin del modal-->


<script>
$("#guardarNuevoProducto").submit(function(event) {
  event.preventDefault();
  var formData=new FormData($("#guardarNuevoProducto")[0]);
  $.ajax({
      url:'/guardarNuevoProducto',
      type:'POST',
      data:formData,
      cache:false,
      processData:false,
      contentType:false,
      success:function(){ 
        alertify.success("<b>Datos enviados...</b>"); 
        alertify.alert("<b style='color: #008000;'>Datos enviados</b> ", function () { 
          window.location='';
        }); 
      }
  });
});


function solonumeros(evt){
  var code = (evt.which) ? evt.which : evt.keyCode;
  if(code==8) { // backspace.
    return true;
  } else if(code>=48 && code<=57) { // is a number.
    return true;
  } else{ // other keys.
    return false;
  }
}
function estadoProducto(id,pr_estado){
    // alert(id+' '+pr_estado)
    $.post('/estadoProducto', {id,pr_estado}, function() {
        alertify.alert("<b style='color: #008000;'>Datos enviados</b> ", function () { 
          window.location='';
        });
    });
}
function editarProducto(id){
    $("#editarmodal").modal('show');
    $.post('/editarProducto', {id}, function(datos) {
        $("#ver_productos").html(datos)
    });
}

</script>



@endsection