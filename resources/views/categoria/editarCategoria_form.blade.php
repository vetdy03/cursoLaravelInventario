<form id="guardarEditarCategoria" method="post" enctype="multipart/form-data" class="form-horizontal">

    @csrf
    <input type="hidden" name="idcategoria" value="<?php echo $obj->id ?>">

    <div class="form-group row">
        <label class="col-md-3 form-control-label" for="text-input">Categoría</label>
        <div class="col-md-9">
            <input type="text" name="nombre" class="form-control" placeholder="Nombre de categoría" value="<?php echo $obj->ca_nombre; ?>" required>
        </div>
    </div>
 
    <div class="modal-footer">
        <button type="submit" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times fa-2x"></i> Cerrar</button>
    </div>


</form>

<script>
$("#guardarEditarCategoria").submit(function(event) {
    event.preventDefault();
    // alert('hola')
    $.ajax({
        url:'/guardarEditarCategoria',
        type:'POST',
        data:$("form").serialize(),
        success:function(){

            alertify.alert("<b>datos enviado</b>", function () {

                window.location='/categoria';

            });
        }
    });
});
</script>