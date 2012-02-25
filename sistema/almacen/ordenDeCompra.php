<?php
// <editor-fold defaultstate="collapsed" desc="php">
require '../../includes/constants.php';
$usuario = new usuario();
$usuario->confirmar_miembro();
$almacen = new almacen();
$producto = new producto();
$almacenes = $almacen->listarPorEmpresa($_SESSION['usuario']['empresa_id']);
$productos = $producto->listar();

// <editor-fold defaultstate="collapsed" desc="Orden de Compra">
if (isset($_POST['procesar'])) {
    $resultado = $almacen->ordenDeCompra($_POST['producto'], $_POST['cantidad'], $_POST['costo'], $_POST['almacen_id']);
// </editor-fold>
}
// </editor-fold>
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo TITULO; ?> - Orden de Compra</title>
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Le styles -->
        <link href="<?php echo ROOT; ?>/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="<?php echo ROOT; ?>/css/style.css" rel="stylesheet"/>
        <link href="<?php echo ROOT; ?>/css/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
        <script src="<?php echo ROOT; ?>/js/jquery-1.7.1.min.js"></script>
        <script src="<?php echo ROOT; ?>/js/jquery-ui-1.8.16.custom.min.js"></script>
        <script src="<?php echo ROOT; ?>/js/jquery-validate/jquery.validate.pack.js"></script>
        <script src="<?php echo ROOT; ?>/js/jquery-validate/localization/messages_es.js"></script>
        <script src="<?php echo ROOT; ?>/js/forms.js"></script>
        <script src="<?php echo ROOT; ?>/js/combobox.js"></script>
        <script>
            $(document).ready(function(){
                $("#agregar_productos").validate();
                $("#almacen_id").combobox();
                $("#producto").combobox();
                
                $("#agregar").click(function(){
                    if($("#agregar_productos").valid()){
                        input_hidden = $("<input/>",{type:'hidden',name:'producto[]',value:$("#producto").val()});
                        tdNombre = $("<td/>",{html:'<span>'+$("#producto option:selected").text()+'</span>'}).append(input_hidden);
                        input_cantidad = $("<input/>",{"class":"mini",type:"text",readOnly:true,name:"cantidad[]",value:$("#cantidad").val()});
                        tdCantidad = $("<td/>").append(input_cantidad);
                        input_costo = $("<input/>",{"class":"mini",type:"text",readOnly:true,name:"costo[]",value:$("#costo").val()});
                        tdCosto = $("<td/>").append(input_costo);
                        tdOperaciones = $("<td/>",{html:'<a href="#" class="btn danger small">Eliminar</a>'});
                        tr = $("<tr/>");
                        tr.append(tdNombre).append(tdCantidad).append(tdCosto).append(tdOperaciones);
                        $("#productos tbody").append(tr);
                        $("#productos_agregados").valid();
                        
                        $("#producto option:selected").remove();
                        $(".ui-autocomplete-input:eq(1)").val("");
                        
                        $("#numero_productos").html($("#productos tbody tr").length);
                    }
                });
                $(document).on("click",".danger",function(){
                    if(confirm("Realmente desea borrar este registro?"))
                    {
                        opcion = $("<option/>",{value:$(this).parents("tr:eq(0)").find("input[type='text']").val()}).html($(this).parents("tr:eq(0)").find("span").html());
                        console.dir(opcion);
                        $("#producto").append(opcion);
                        $(this).closest("tr").remove();
                        $("#productos tfoot span:eq(1)").html($("#productos tbody tr").length);
                    }
                });
                $("#valor").rules("add",{
                    required:function(){
                        return ($("#productos").find("input[name='producto[]']").length==0);
                    },
                    messages:{
                        required:"Debe agregar al menos un producto para realizar una orden de compra."
                    }
                });
            });    
        </script>
    </head>
    <body>
        <?php include TEMPLATE . 'topbar.php'; ?>
        <div class="container">
            <div class="content">
                <div class="page-header">
                    <h1>Orden de Compra <small>Realice órdenes de compra para un almacen determinado</small></h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="../usuario">Sistema</a><span class="divider">&raquo;</span></li>
                    <li><a href="listar.php">Almacen</a><span class="divider">&raquo;</span></li>
                    <li>Orden de Compra</li>
                </ul>
                <?php if (isset($_POST['procesar'])): ?>
                    <?php if (isset($resultado) && $resultado['suceed']): ?>
                        <div class="alert-message block-message success">
                            <a class="close" href="#">×</a>
                            <p>Orden de compra realizada con <strong>&Eacute;xito.</strong></p>
                            <a class="btn small" href="../usuario">Volver al men&uacute;.</a>
                        </div>
                    <?php else: ?>
                        <div class="alert-message block-message error">
                            <a class="close" href="#">×</a>
                            <p>Ha ocurrido un error al realizar el traspaso.</p>
                            <?php if (DEBUG): ?>
                                <pre><?php var_dump($resultado); ?></pre>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div>
                        <form id="agregar_productos" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="row">
                                <div class="span16">
                                    <fieldset>
                                        <legend>Seleccione los productos</legend>
                                        <div class="clearfix">
                                            <label for="producto">Producto:</label>
                                            <div class="input">
                                                <select name="producto" class="required" id="producto">
                                                    <?php foreach ($productos['data'] as $dato): ?>
                                                        <option value="<?php echo $dato['id']; ?>"><?php echo $dato['nombre']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="costo">Costo:</label>
                                            <div class="input">
                                                <div class="input-append">
                                                    <input type="text" name="costo" id="costo" class="required number small"/>
                                                    <span class="add-on">Bsf.</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix">
                                            <label for="cantidad">Cantidad:</label>
                                            <div class="input">
                                                <input type="text" name="cantidad" id="cantidad" placeholder="0" class="mini required" />
                                            </div>
                                            <div class="input">
                                                <input type="button" name="agregar" id="agregar" name="agregar" value="Agregar Producto" class="btn info"/>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </form>
                    </div>
                    <h2>Productos Agregados</h2>
                    <form name="productos_agregados" id="productos_agregados" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div>
                            <fieldset>
                                <legend>Seleccione Almacen</legend>
                                <div class="clearfix">
                                    <label for="almacen_id">Almacen:</label>
                                    <div class="input">
                                        <select name="almacen_id" id="almacen_id" class="required">
                                            <?php foreach ($almacenes['data'] as $registro): ?>
                                                <option value="<?php echo $registro['id']; ?>"><?php echo $registro['nombre']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="help-block">Seleccione el almacen al que cargará los productos</span>
                                    </div>
                                </div>
                            </fieldset>
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
                        <div class="actions">
                            <input class="btn primary" id="procesar" type="submit" name="procesar" value="Procesar"/>
                            <input class="btn" type="reset" name="reset" value="Resetear"/>
                        </div>
                    </form>
                    <footer class="footer">
                        <div class="container">
                            <p>&copy; Aled Multimedia Solutions <?php echo date('Y'); ?> </p>
                        </div>
                    </footer>
                </div>
            <?php endif; ?>
        </div>
    </body>
</html>
