@extends('plantilla')
@section('contenido')

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
           <h2>REPORTE GRAFICOS</h2><br/>
        </div>
        <div class="card-body">
            <div class="form-group row" id="graph">
              
            </div>
        </div>
    </div>
</div>

<script>
$.post('/mostrarReporteGrafico', {}, function(datos) {
    var valores= eval(datos);
    
    Morris.Donut({
    element: 'graph',
    data: [
        {value: valores[0], label: 'ACTIVO'},
        {value: valores[1], label: 'INACTIVO'},
        {value: valores[2], label: 'ELIMINADO'}
    ],
    formatter: function (x) { return x + "%"}
    }).on('click', function(i, row){
    console.log(i, row);
    });
});

</script>


@endsection