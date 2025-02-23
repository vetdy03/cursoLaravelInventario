<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Categoria;
use App\Models\Producto;

use DB;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Codedge\Fpdf\Fpdf\Fpdf;

class ControllerSistema extends Controller
{
    //

    public function ejemplo1(){
        // echo "hola mundo....";
        $n1=20;
        $n2=25;
        $s=($n1+$n2);
        echo "Suma:".$s;

    }
    public function ejemplo2(){
        $n1=20;
        $n2=25;
        if($n1>$n2){
            $r=$n1;
        }else{
            $r=$n2;
        }
        echo "Nro. es:".$r;
    }



    // modulo categoria
        public function categoria(){
            // SELECT * FROM categorias WHERE ca_estado!='ELIMINADO'
            $categoria=DB::table('categorias')->where('ca_estado','!=','ELIMINADO')->get();

            //dd($categoria); die;
            return view('categoria.categoria_index',compact('categoria'));
        }
        public function guardarNuevoCategoria(Request $request){
            /*echo mb_strtoupper($request->post('nombre'),'utf-8');
            exit;*/
            // die();

            $obj=new Categoria();
            $obj->ca_nombre=mb_strtoupper($request->post('nombre'),'utf-8');
            $obj->save();
        }
        public function cambiarEstadoCat(Request $request){
            $id=$request->post('id');
            $ca_estado=$request->post('ca_estado');

            if($ca_estado=='ACTIVO'){
                $estado='INACTIVO';
            }else{
                $estado='ACTIVO';
            }

            $obj=Categoria::find($id);
            $obj->ca_estado=$estado;
            $obj->save();
        }

        public function editarCategoria(Request $request){
            
            $obj=DB::table('categorias')->where('id','=',$request->post('id'))->first();
            // dd($obj); exit();
            return view('categoria.editarCategoria_form',compact('obj'));
        }
        public function guardarEditarCategoria(Request $request){
            $idcategoria=$request->post('idcategoria');

            /*echo $request->post('nombre');
            die;*/

            $obj=Categoria::find($idcategoria);
            $obj->ca_nombre=mb_strtoupper($request->post('nombre'),'utf-8');
            $obj->save();
        }

    // modulo categoria






    // modulo producto
        public function producto(){
            $categoria=DB::table('categorias')->where('ca_estado','=','ACTIVO')->get();

            $producto=DB::table('productos')
            ->select('productos.id','categorias.ca_nombre','productos.pr_imagen','productos.pr_nombre','productos.pr_descripcion','productos.pr_stock','productos.pr_fecha_reg','productos.categoria_id','productos.pr_estado')
            ->join('categorias','productos.categoria_id','=','categorias.id')
            ->where('productos.pr_estado','!=','ELIMINADO')->get();

            // dd($producto); die;

            return view('producto.producto_index',compact('categoria','producto'));
        }
        public function guardarNuevoProducto(Request $request){

            if($request->hasFile('imagen')){
                $imagen=$request->file('imagen');
                $nombreimagen=Str::slug(date('ymdHs')).".".$imagen->guessExtension();
                $ruta=public_path('img_producto/');
                $imagen->move($ruta,$nombreimagen);
            }else{
                $nombreimagen='';
            }
           
            $obj=new Producto();
            $obj->pr_imagen=$nombreimagen;
            $obj->pr_nombre=mb_strtoupper($request->post('nombre_producto'),'utf-8');
            $obj->pr_descripcion=mb_strtoupper($request->post('descripcion'),'utf-8');
            $obj->pr_stock=$request->post('stok');
            $obj->pr_fecha_reg=date('Y-m-d');
            $obj->categoria_id=$request->post('idcategoria');
            $obj->save();
        }
        public function estadoProducto(Request $request){
            $id=$request->post('id');
            $pr_estado=$request->post('pr_estado');

            if($pr_estado=='ACTIVO'){
                $estado='INACTIVO';
            }else{
                $estado='ACTIVO';
            }
            $obj=Producto::find($id);
            $obj->pr_estado=$estado;
            $obj->save();
        }

        public function editarProducto(Request $request){
            $id=$request->post('id');

            $categoria=DB::table('categorias')->where('ca_estado','=','ACTIVO')->get();
            // SELECT * FROM productos WHERE productos.id='2'
            $obj=DB::table('productos')->select('productos.*')->where('productos.id','=',$id)->first();

            // dd($producto); die;
            return view('producto.editarProducto_form',compact('categoria','obj'));
        }
    // modulo producto
    public function guardarEditarProducto(Request $request){
        $id=$request->post('idproducto');
        $pr_imagen=$request->post('pr_imagen');
        if($request->hasFile('imagen')){

            Storage::disk('public')->delete('/img_producto/'.$pr_imagen);

            $imagen=$request->file('imagen');
            $nombreimagen=Str::slug(date('ymdHs')).".".$imagen->guessExtension();
            $ruta=public_path('img_producto/');
            $imagen->move($ruta,$nombreimagen);
        }else{
            $nombreimagen=$pr_imagen;
        }
        $obj=Producto::find($id);
        $obj->pr_imagen=$nombreimagen;
        $obj->pr_nombre=mb_strtoupper($request->post('nombre_producto'),'utf-8');
        $obj->pr_descripcion=mb_strtoupper($request->post('descripcion'),'utf-8');
        $obj->pr_stock=$request->post('stok');
        $obj->categoria_id=$request->post('idcategoria');
        $obj->save();
    }
    
    public function reporteProductoPdf(){
        //$pdf = new FPDF('P','mm',array(100,150)); //Formato de pagina personalizado en 100x150mm
        //$pdf = new FPDF('P','mm','letter'); //Hoja tamaño carta
        //$pdf = new FPDF('L','mm','legal'); //

        $fpdf= new Fpdf();
        $fpdf-> AddPage();
        $fpdf->Image('alert/minedu.png', 10, 5, 60, 20, 'png');

        $fpdf->ln(15);
        $fpdf->SetTextColor(0,51,102); //color de texto
        $fpdf->SetFillColor(221,220,220); //color de fondo

        $fpdf-> SetFont('Arial', 'B', '11');
        $fpdf-> cell(10, 8, '#', 1, 0, 'C',1);
        $fpdf-> cell(27, 8, 'CATEGORIA', 1, 0, 'C',1);
        $fpdf-> cell(50, 8, 'NOMBRE PRODUCTOS', 1, 0, 'C',1);
        $fpdf-> cell(70, 8, 'DESCRIPCION', 1, 0, 'C',1);
        $fpdf-> cell(14, 8, 'STOCK', 1, 0, 'C',1);
        $fpdf-> cell(20, 8, 'FECHA', 1, 1, 'C',1);

        $producto=DB::table('productos')
            ->select('productos.id','categorias.ca_nombre','productos.pr_imagen','productos.pr_nombre','productos.pr_descripcion','productos.pr_stock','productos.pr_fecha_reg','productos.categoria_id','productos.pr_estado')
            ->join('categorias','productos.categoria_id','=','categorias.id')
            ->where('productos.pr_estado','!=','ELIMINADO')->get();

        $fpdf-> SetFont('Arial', 'B', '11');
        $con=1;
        foreach($producto as $value){
            
            $fpdf-> cell(10, 7, $con++, 1, 0, 'C');
            $fpdf-> cell(27, 7, $value->ca_nombre, 1, 0, 'C');
            $fpdf-> cell(50, 7, $value->pr_nombre, 1, 0, 'C');
            $fpdf-> cell(70, 7, $value->pr_descripcion, 1, 0, 'C');
            $fpdf-> cell(14, 7, $value->pr_stock, 1, 0, 'C');
            $fpdf-> cell(20, 7, $value->pr_fecha_reg, 1, 1, 'C');
        }
            

        $fpdf->Output();
        exit;
    }

    public function reporteProductoExcel(){
        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
            header("Content-Disposition: attachment; filename=reporteAdminEstudianteExcel".date('Y-m-dHs').".xlsx");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo "\xEF\xBB\xBF";

            $producto=DB::table('productos')
            ->select('productos.id','categorias.ca_nombre','productos.pr_imagen','productos.pr_nombre','productos.pr_descripcion','productos.pr_stock','productos.pr_fecha_reg','productos.categoria_id','productos.pr_estado')
            ->join('categorias','productos.categoria_id','=','categorias.id')
            ->where('productos.pr_estado','!=','ELIMINADO')->get();

            echo '<table border="1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>CATEGORIA</th>
                        <th>NOMBRE PRODUCTO</th>
                        <th>DESCRIPCION</th>
                        <th>STOCK</th>
                        <th>FECHA REG</th>
                    </tr>
                </thead>
                <tbody>';
                    $con=1;
                    foreach ($producto as  $value) {
                    echo '<tr>
                        <td>'.$con++.'</td>
                        <td>'.$value->ca_nombre.'</td>
                        <td>'.$value->pr_nombre.'</td>
                        <td>'.$value->pr_descripcion.'</td>
                        <td>'.$value->pr_stock.'</td>
                        <td>'.$value->pr_fecha_reg.'</td>
                    </tr>';
                    }
                echo '</tbody>
            </table>';

    }


    //modulo de grafi
    public function graficos(){

        return view('graficos.graficos_index');
    }
    //fin modulo grafi

    //modulo de mostrar reporte
    public function mostrarReporteGrafico(){
        // SELECT COUNT(*) as total FROM productos
        // WHERE pr_estado='INACTIVO'

        $total_a=DB::table('productos')
        ->where('pr_estado','=','ACTIVO')
        ->count();

        $total_i=DB::table('productos')
        ->where('pr_estado','=','INACTIVO')
        ->count();

        $total_e=DB::table('productos')
        ->where('pr_estado','=','ELIMINADO')
        ->count();

        $data=array(
            0=>$total_a,
            1=>$total_i,
            2=>$total_e
        );
        echo json_encode($data);
    }
    //fin modulo mostrar reporte
}
