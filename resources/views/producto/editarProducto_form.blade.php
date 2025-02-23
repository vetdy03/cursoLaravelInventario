<?php 
    //print_r($obj);

?>

<form id="guardarEditarProducto" method="post" enctype="multipart/form-data" class="form-horizontal">
    @csrf
    <input type= "hidden" name="idproducto" value="<?php echo $obj->id?>">
    <input type= "hidden" name="pr_imagen" value="<?php echo $obj->pr_imagen?>">

    <div class="form-group row">
        <label class="col-md-3 form-control-label" >SELECCIONAR CATEGORIA</label>
        <div class="col-md-9">
            <select name="idcategoria"  class="form-control" required>
                <option></option>
                <?php foreach ($categoria as $obj1) { ?>
                    <option value="<?php echo $obj1->id; ?>" <?php if($obj1->id==$obj->categoria_id) echo "selected"; ?> ><?php echo $obj1->ca_nombre; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-3 form-control-label" >IMAGEN</label>
        <div class="col-md-9">

        <input type="file" name="imagen"  class="form-control" accept="image/*" >
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-3 form-control-label"  >NOMBRE PRODUCTO</label>
        <div class="col-md-9">
        <input type="text" name="nombre_producto" value="<?php ?>"class="form-control" placeholder="Ingresar..." required>
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

<script>
$("#guardarEditarProducto").submit(function(event) {
  event.preventDefault();
  var formData=new FormData($("#guardarEditarProducto")[0]);
  $.ajax({
      url:'/guardarEditarProducto',
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
</script>