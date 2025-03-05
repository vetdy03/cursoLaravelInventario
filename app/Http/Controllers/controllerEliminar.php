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

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema Compras-Ventas con Laravel y Vue Js- webtraining-it.com">
    <meta name="keyword" content="Sistema Compras-Ventas con Laravel y Vue Js">
    <title>Proyecto</title>
    <!-- Icons -->
    <link href="<?php echo asset('admin') ?>/vendors/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo asset('admin') ?>/vendors/css/simple-line-icons.min.css" rel="stylesheet">
    <!-- Main styles for this application -->
    <link href="<?php echo asset('admin') ?>/vendors/css/style.css" rel="stylesheet">

    <script src="<?php echo asset('admin') ?>/vendors/js/jquery.min.js"></script>

    <script type="text/javascript" src="<?php echo asset('alert') ?>/lib/alertify.js"></script>
    <link rel="stylesheet" href="<?php echo asset('alert') ?>/themes/alertify.core.css" />
    <link rel="stylesheet" href="<?php echo asset('alert') ?>/themes/alertify.default.css" />

</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
<header class="app-header navbar">
        <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <!--PONER LOGO-->
        <!--<a class="navbar-brand" href="#"></a>-->
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="nav navbar-nav d-md-down-none">
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Dashbord</a>
            </li>
           
        </ul>
        <ul class="nav navbar-nav ml-auto">

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img src="vendors/img/avatars/6.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                    <span class="d-md-down-none">usuario </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>Cuenta</strong>
                    </div>
                    <a class="dropdown-item" href="" 
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-lock"></i> Cerrar sesión</a>

                    <form id="logout-form" action="" method="POST" style="display: none;">
                      
                    </form>
                </div>
            </li>
        </ul>
    </header>

    <div class="app-body">

       <div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="icon-speedometer"></i> Dashbord</a>
                    </li>
                    <li class="nav-title">
                        Menú
                    </li>

                   
                    <li class="nav-item">
                        <a class="nav-link" href="/categoria"><i class="fa fa-list"></i> Categorías</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="/producto"><i class="fa fa-tasks"></i> Productos</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="/graficos"><i class="fa fa-shopping-cart"></i> GRAFI</a>
                    </li>
            
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-shopping-cart"></i> Compras</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-users"></i> Proveedores</a>
                    </li>
                       
                   
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-suitcase"></i> Ventas</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-users"></i> Clientes</a>
                    </li>
                        
                    
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-user"></i> Usuarios</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-list"></i> Roles</a>
                    </li>
                        
                    
                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>

        <!-- Contenido Principal -->
       <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="/">BACKEND - SISTEMA DE COMPRAS - VENTAS</a></li>
            </ol>

            @yield('contenido')

            
           
            
        </main>
        <!-- /Fin del contenido principal -->
    </div>   

    <footer class="app-footer">
        <span><a href="http://www.webtraining-it.com/">webtraining-it.com</a> &copy; 2019</span>
        <span class="ml-auto">Desarrollado por <a href="http://www.webtraining-it.com/">webtraining-it.com</a></span>
    </footer>

    <!-- Bootstrap and necessary plugins -->
    
    <script src="<?php echo asset('admin') ?>/vendors/js/popper.min.js"></script>
    <script src="<?php echo asset('admin') ?>/vendors/js/bootstrap.min.js"></script>
    <script src="<?php echo asset('admin') ?>/vendors/js/pace.min.js"></script>
    <!-- Plugins and scripts required by all views -->
    <script src="<?php echo asset('admin') ?>/vendors/js/Chart.min.js"></script>
    <!-- GenesisUI main scripts -->
    <script src="<?php echo asset('admin') ?>/vendors/js/template.js"></script>
</body>

</html>