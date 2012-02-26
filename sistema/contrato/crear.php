<?php
// <editor-fold defaultstate="collapsed" desc="php">
require '../../includes/constants.php';
$usuario = new usuario();
$usuario->confirmar_miembro();
$contrato = new contrato();
$vendedor = new vendedor();
//$cliente = new cliente();
$organismo = new organismo();
$frecuencia = new frecuencia();
$producto = new producto();

//$clientes = $cliente->listar();
$vendedores = $vendedor->vendedor_por_empresa($_SESSION['usuario']['empresa_id']);
$organismos = $organismo->listar();
$frecuencias = $frecuencia->listar();
$productos = $producto->productosConExistencia();

$resultado = array("suceed" => false);
if (isset($_POST['submit'])) {
    $data = $_POST;
    unset($data['submit']);
    unset($data['disponible']);
    unset($data['costo']);
    unset($data['valor']);
    unset($data['sel_producto']);
    unset($data['sel_cantidad']);
    //$detalle = Array($_POST['producto'],$_POST['cantidad']);
    unset($data['producto']);
    unset($data['cantidad']);

    $resultado = $contrato->emitirContrato($data, $_POST['producto'], $_POST['cantidad']);
    var_dump($resultado);
    die("fin");
    //$resultado = $contrato->emitirContrato($contrato,$detalle);
}
// </editor-fold>
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title><?php echo TITULO; ?></title>
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Le styles -->
        <link href="<?php echo ROOT; ?>/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="<?php echo ROOT; ?>/css/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
        <script src="<?php echo ROOT; ?>/js/jquery-1.7.1.min.js"></script>
        <script src="<?php echo ROOT; ?>/js/jquery-ui-1.8.16.custom.min.js"></script>
        <script src="<?php echo ROOT; ?>/js/jquery-validate/jquery.validate.pack.js"></script>
        <script src="<?php echo ROOT; ?>/js/jquery-validate/localization/messages_es.js"></script>
        <script src="<?php echo ROOT; ?>/js/forms.js"></script>
        <script>
            $(document).ready(function() {
                $("#organismo_id").change(function(){
                    $.getJSON('<?php echo ROOT; ?>/includes/json.php', {accion:'clientes_organismo', organismo:$(this).val()}, function(data){
                        $("#cliente_id option").remove();
                        if(data.suceed){
                            for(var elemento in data.data){
                                if( typeof data.data[elemento] == "object"){
                                    $("<option value='"+ data.data[elemento].id + "'>"+ data.data[elemento].Nombre +" "+data.data[elemento].Apellido+"</option>")
                                    .appendTo("#cliente_id");
                                }
                            }
                        }
                    })
                });
                $("#tabs").tabs();
                $("#agregar").click(function(){
                    input_hidden = $("<input/>",{type:'hidden',name:'producto[]',value:$("#sel_producto").val()});
                    tdNombre = $("<td/>",{html:'<span>'+$("#producto option:selected").text()+'</span>'}).append(input_hidden);
                    input_cantidad = $("<input/>",{"class":"mini",type:"text",readOnly:true,name:"cantidad[]",value:$("#cantidad").val()});
                    tdCantidad = $("<td/>").append(input_cantidad);
                    input_costo = $("<input/>",{"class":"mini",type:"text",readOnly:true,name:"costo[]",value:$("#costo").val()});
                    tdCosto = $("<td/>").append(input_costo);
                    tdOperaciones = $("<td/>",{html:'<a href="#" class="btn danger small">Eliminar</a>'});
                    tr = $("<tr/>");
                    tr.append(tdNombre).append(tdCantidad).append(tdCosto).append(tdOperaciones);
                    $("#productos tbody").append(tr);
                    $("#sel_producto option:selected").remove();
                    $("#numero_productos").html($("#productos tbody tr").length);
                });
                $("#sel_producto").change(function() {
                    
                    $.getJSON('<?php echo ROOT; ?>/includes/json.php', {accion:'producto_existencia', id:$(this).val()}, 
                    function(data){
                        $("#disponible").attr("value",0);
                        $("#costo").attr("value",0);
                        $("#cantidad").attr("value",0);
                        if(data.suceed){
                            $("#disponible").attr("value",data.data[0].disponible );
                            $("#costo").attr("value",data.data[0].precio_venta);
                        }
                    });
                    /*$.get("productosDisponibles.php",{id: this.value},
                    function(data) {
                        var producto = data.split("|");
                        $("#disponible").attr("value",producto[0]);
                        $("#costo").attr("value",producto[1])
                    });*/
                });

            });
        </script>
    </head>
    <body>
        <?php include TEMPLATE . 'topbar.php'; ?>
        <div class="container">
            <div class="content">
                <div class="page-header">
                    <h1>Crear Contrato</h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="../usuario">Sistema</a><span class="divider">&raquo;</span></li>
                    <li>Contrato</li>
                </ul>
                <?php if (isset($_POST) && $resultado['suceed'] == true): ?>
                    <div class="alert-message block-message success">
                        <a class="close" href="#">×</a>
                        <p>Contrato creado con <strong>&Eacute;xito.</strong></p>
                        <a class="btn small primary" href="listar.php">Volver al listado.</a>
                        <a class="btn small" href="../usuario">Volver al men&uacute;.</a>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <div class="hide">
                            <h3>Ayuda</h3>
                            <p>Ingrese los datos para crear un Contrato</p>
                        </div>
                        <div class="span16">
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <input type="hidden" value="<?php echo $_SESSION['usuario']['empresa_id']; ?>" name="empresa_id" />
                                <input type="hidden" value="1" name="status_contrato_id" />
                                <input type="hidden" value="50" name="comision_vendedor" />
                                <input type="hidden" value="1" name="plazo_id" />
                                <input type="hidden" value="50" name="porcentaje_vendedor"/>
                                <input type="hidden" value="1000" name="monto"/>
                                <input type="hidden" value="12" name="iva"/>
                                <div id="tabs">
                                    <ul>
                                        <li><a href="#fragment-1"><span>Datos Generales</span></a></li>
                                        <li><a href="#fragment-2"><span>Productos</span></a></li>
                                    </ul>
                                    <div id="fragment-1">
                                        <fieldset>
                                            <legend>Contrato</legend>
                                            <div class="clearfix">
                                                <label for="nombre">Número:<sup>*</sup></label>
                                                <div class="input">
                                                    <input class="required" type="text" name="numero" id="numero"/> 
                                                </div>
                                            </div>
                                            <div class="clearfix">
                                                <label for="frecuencia">Frecuencia:<sup>*</sup></label>
                                                <div class="input">
                                                    <select name="frecuencia_id" id="frecuencia_id" class="required">
                                                        <?php foreach ($frecuencias['data'] as $valor): ?>
                                                            <option value="<?php echo $valor['id']; ?>"><?php echo $valor['nombre'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset>
                                            <legend>Cliente</legend>
                                            <div class="clearfix">
                                                <label for="organismo_id">Organismo:<sup>*</sup></label>
                                                <div class="input">
                                                    <select name="organismo_id" id="organismo_id" class="required">
                                                        <option>Seleccione</option>
                                                        <?php foreach ($organismos['data'] as $valor): ?>
                                                            <option value="<?php echo $valor['id']; ?>"><?php echo $valor['nombre'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="clearfix">
                                                <label for="cliente_id">Cliente:<sup>*</sup></label>
                                                <div class="input">
                                                    <select name="cliente_id" id="cliente_id" class="required">
                                                        <option value="">Seleccione un organismo</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset>
                                            <legend>Vendedor</legend>
                                            <div class="clearfix">
                                                <label for="vendedor_id">Vendedor:<sup>*</sup></label>
                                                <div class="input">
                                                    <select name="vendedor_id" class="requiered">
                                                        <?php foreach ($vendedores['data'] as $valor): ?>
                                                            <option value="<?php echo $valor['id']; ?>"><?php echo $valor['Nombre'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div id="fragment-2">
                                        <div>
                                            <div class="row">
                                                <div class="span16">
                                                    <fieldset>
                                                        <div class="clearfix">
                                                            <label for="producto">Producto:</label>
                                                            <div class="input">
                                                                <select name="sel_producto" class="" id="sel_producto">
                                                                    <option value="">Seleccione un producto</option>
                                                                    <?php foreach ($productos['data'] as $dato): ?>
                                                                        <option value="<?php echo $dato['id']; ?>"><?php echo $dato['nombre']; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix">
                                                            <label for="disponible">Disponible:</label>
                                                            <div class="input">
                                                                <div class="input-append">
                                                                    <input type="text" name="disponible" id="disponible" class="number small" readonly="readonly" value="0"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix">
                                                            <label for="costo">Costo:</label>
                                                            <div class="input">
                                                                <div class="input-append">
                                                                    <input type="text" name="costo" id="costo" class="number small" readonly="readonly" value="0"/>
                                                                    <span class="add-on">Bsf.</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix">
                                                            <label for="cantidad">Cantidad:</label>
                                                            <div class="input">
                                                                <input type="text" name="cantidad" id="cantidad" placeholder="0" class="mini required" />
                                                            </div>
                                                        </div>
                                                        <div class="clearfix">
                                                            <div class="input">
                                                                <input type="button" name="agregar" id="agregar" name="agregar" value="Agregar Producto" class="btn info"/>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <table class="bordered-table zebra-striped" id="productos">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Cantidad</th>
                                                        <th>Costo</th>
                                                        <th>Operaciones</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="4" align="right">
                                                            <div class="clearfix">
                                                                <span>Cantidad Productos: </span>
                                                                <span id="numero_productos">0</span>
                                                                <input id="valor" type="hidden" name="valor" value=""/>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <fieldset>
                                    <div class="actions">
                                        <input class="btn primary" type="submit" name="submit" value="Crear"/>
                                        <input class="btn" type="reset" name="reset" value="Borrar"/>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
                <footer class="footer">
                    <div class="container">
                        <p>&copy; Aled Multimedia Solutions <?php echo date('Y'); ?> </p>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>