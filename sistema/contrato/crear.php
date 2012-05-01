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
$medio_pago = new mediopago();
$plazo = new plazo();
$banco = new banco();

//$clientes = $cliente->listar();
$vendedores = $vendedor->vendedor_por_empresa($_SESSION['usuario']['empresa_id']);
$organismos = $organismo->listar();
$frecuencias = $frecuencia->listar();
$productos = $producto->productosConExistencia();
$tipo_medio_pago = $medio_pago->listar_tipo_medio_pagos();
$bancos = $banco -> listar();
$plazos = $plazo->listar();
$resultado = array("suceed" => false);
if (isset($_POST['submit'])) {
    $data = $_POST;
    unset($data['submit']);
    unset($data['disponible']);
    unset($data['costo']);
    unset($data['valor']);
    unset($data['sel_producto']);
    unset($data['sel_cantidad']);
    unset($data['producto']);
    unset($data['cantidad']);
    unset($data['medio_pago_id']);
    $resultado = $contrato->emitirContrato($data, $_POST['producto'], $_POST['cantidad'],$_POST['costo'],$_POST['medio_pago_id']);
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
        <script src="<?php echo ROOT; ?>/js/bootstrap-modal.js"></script>
        <script src="<?php echo ROOT; ?>/js/forms.js"></script>
        <script>
            $(document).ready(function() {
                $("#agregar_productos").validate();
                $("#registrarMedioPago").validate();
                $('a[href|=#registrarMedioPago]').click(function() {
                    if (!$("#cliente_id").valid()) {
                    return false;
                    }
                });
                $("#medio_pago_id").rules("add",{
                    required:true,
                    min:1,
                    messages:{
                        required:"Falta medio de pago.",
                        min:"Especifique el medio de pago."
                    }
                 });
                 $("#tipo_medio_pago_id").change(function() {
                    
                    if($(this).val()=="1"){
                        $("#banco_id").removeClass("required");
                        $("#numero_cuenta").removeClass("required");
                        $("#datosBanco").hide();
                    } else {
                        $("#banco_id").addClass("required");
                        $("#numero_cuenta").addClass("required");
                        $("#datosBanco").show();
                    }
                 });
                 $("#cliente_id").change(function(){
                    $("#usuario_id").attr('value',$(this).val());
                    $.getJSON('<?php echo ROOT; ?>/includes/json.php', {accion: 'listar_medio_pago',cliente:$(this).val()}, 
                        function(data){
                            if(data.suceed) {
                                $("#medio_pago_id option").remove();
                                $("<option value=\"\">&nbsp;</option>").appendTo("#medio_pago_id");
                                for(var elemento in data.data){
                                    if( typeof data.data[elemento] == "object"){
                                        $("<option value='"+ data.data[elemento].id + "'>"+ data.data[elemento].medio_pago  +"</option>")
                                        .appendTo("#medio_pago_id");
                                    }
                                }
                            }
                        });
                 });
                $("#organismo_id").change(function(){
                    $.getJSON('<?php echo ROOT; ?>/includes/json.php', {accion:'clientes_organismo', organismo:$(this).val()}, function(data){
                        $("#cliente_id option").remove();
                        $("#medio_pago_id option").remove();
                        if(data.suceed){
                            $("<option value=\"\">Seleccione Cliente</option>").appendTo("#cliente_id");
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
                    if($("#agregar_productos").valid()){
                        input_hidden = $("<input/>",{type:'hidden',name:'producto[]',value:$("#sel_producto").val()});
                        tdNombre = $("<td/>",{html:'<span>'+$("#sel_producto option:selected").text()+'</span>'}).append(input_hidden);
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
                        var monto = 0;
                        var total = 0;
                        $("input[name='costo[]']").each(function(){
                            monto = $(this).closest("tr").find("input[name='cantidad[]']").val() * $(this).val();
                            total += monto; 
                        });
                        $("#total_contrato").html(total);
                    }
                });
                $("#registrar").click(function(){
                    if($("#medio_pago").valid()){
                        $.getJSON('<?php echo ROOT; ?>/includes/json.php', 
                        {accion:'agregar_medio_pago',
                         tipo_medio_pago_id:$('#tipo_medio_pago_id').val(),
                         banco_id:$("#banco_id").val(),
                         numero_cuenta:$("#numero_cuenta").val(),
                         usuario_id:$("#usuario_id").val()
                        }, 
                        function(data){
                            if (data.suceed) {
                                $.getJSON('<?php echo ROOT; ?>/includes/json.php',{
                                    accion:'listar_medio_pago',
                                    cliente:$("#usuario_id").val()},
                                function(data){
                                   if (data.suceed) {
                                       $("#medio_pago_id option").remove();
                                       for(var elemento in data.data){
                                            if( typeof data.data[elemento] == "object"){
                                                $("<option value='"+ data.data[elemento].id + "'>"+ data.data[elemento].medio_pago +"</option>")
                                                .appendTo("#medio_pago_id");
                                            }
                                        }
                                   }
                                   $("#registrarMedioPago").modal('toggle');
                                });
                            } else {
                                alert(data.stats.error);
                            }
                        });
                    } 
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
                });
                $("#valor").rules("add",{
                    required:function(){
                        return ($("#productos").find("input[name='producto[]']").length==0);
                    },
                    messages:{
                        required:"Debe agregar al menos un producto para procesar un contrato."
                    }
                });
                $("#cantidad").rules("add", {
                   max:function() {
                       return ($("#disponible").val());
                   },
                   messages:{
                       max:"Cantidad mayor a lo disponible."
                   }
                });
                $(document).on("click",".danger",function(){
                    if(confirm("Realmente desea borrar este registro?"))
                    {
                        opcion = $("<option/>",{value:$(this).parents("tr:eq(0)").find("input[type='text']").val()}).html($(this).parents("tr:eq(0)").find("span").html());
                        console.dir(opcion);
                        $("#sel_producto").append(opcion);
                        $(this).closest("tr").remove();
                        $("#productos tfoot span:eq(1)").html($("#productos tbody tr").length);
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
                    <h1>Crear Contrato</h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="../usuario">Sistema</a><span class="divider">&raquo;</span></li>
                    <li><a href="listar.php">Contrato</a><span class="divider">&raquo;</span></li>
                    <li>Crear</li>
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
                                <input type="hidden" value="0" name="comision_vendedor" />
                                <input type="hidden" value="0" name="monto"/>
                                <input type="hidden" value="0" name="iva"/>
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
                                            <div class="clearfix">
                                                <label for="Plazo">Plazo (meses):<sup>*</sup></label>
                                                <div class="input">
                                                    <select name="plazo_id" id="plazo_id" class="required small">
                                                        <?php foreach ($plazos['data'] as $valor): ?>
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
                                                        <option value="">Seleccione</option>
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
                                                    <input type="hidden" value="<?php echo $vendedores['data'][0]['comision'] ?>" name="porcentaje_vendedor"/>
                                                </div>
                                                
                                            </div>
                                        </fieldset>
                                        <fieldset>
                                            <legend>Medio de Pago</legend>
                                            <div class="clearfix">
                                                <label for="medio_pago_id">Medio de Pago:<sup>*</sup></label>
                                                <div class="input">
                                                    <select name="medio_pago_id" class="required" id="medio_pago_id">
                                                    <option value="0">Seleccione un cliente</option>
                                                    </select>
                                                    <br />
                                                    <p><a class="btn info" data-toggle="modal" href="#registrarMedioPago">Agregar Medio de Pago</a> </p>
                                                </div>
                                                
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div id="fragment-2">
                                        
                                        <div>
                                            <p>
                                            <a class="btn info" data-toggle="modal" href="#myModal" >Agregar Productos</a>
                                            </p>
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
                                                                <div>
                                                                <span>Cantidad Productos: </span>
                                                                <span id="numero_productos">0</span></div>
                                                                <div><span style="font-weight: bold">Total Contrato Bs.: </span>
                                                                <span id="total_contrato" style="text-decoration: underline">0</span></div>
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
                            <div id="myModal" class="modal" style="display:none;">
                                <div class="modal-header">
                                    <a class="close" data-dismiss="modal">x</a>
                                    <h3>Productos disponibles</h3>
                                </div>
                                    <form id="agregar_productos" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <div class="row">
                                            <div class="span16">
                                                <fieldset>
                                                    <div class="clearfix">
                                                        <label for="sel_producto">Producto:</label>
                                                        <div class="input">
                                                            <select name="sel_producto" class="required" id="sel_producto">
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
                                                                <input type="text" name="disponible" id="disponible" class="required number small" readonly="readonly" value="0"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix">
                                                        <label for="costo">Costo:</label>
                                                        <div class="input">
                                                            <div class="input-append">
                                                                <input type="text" name="costo" id="costo" class="required number small" value="0"/>
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
                                                            <input type="button" name="agregar" id="agregar" name="agregar" value="Agregar Producto" class="btn primary"/>
                                                            <a class="btn" href="#" data-dismiss="modal">Cerrar</a>
                                                            
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <div id="registrarMedioPago" class="modal" style="display:none;">
                                    <div class="modal-header">
                                        <a class="close" data-dismiss="modal">x</a>
                                        <h3>Medios de Pago</h3>
                                    </div>
                                    <form id="medio_pago" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <div class="row">
                                            <div class="span16">
                                                <fieldset>
                                                    <div class="clearfix">
                                                        <label for="tipo_medio_pago_id">Tipo Medio Pago:</label>
                                                        <div class="input">
                                                            <select name="tipo_medio_pago_id" class="required" id="tipo_medio_pago_id">
                                                                <option value="">Seleccione Tipo</option>
                                                                <?php foreach ($tipo_medio_pago['data'] as $dato): ?>
                                                                    <option value="<?php echo $dato['id']; ?>"><?php echo $dato['nombre']; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div id="datosBanco">
                                                    <div class="clearfix">
                                                        <label for="banco_id">Banco:</label>
                                                        <div class="input">
                                                            <div class="input-append">
                                                                <select name="banco_id" class="required" id="banco_id">
                                                                    <option value="">Seleccione Banco</option>
                                                                    <?php foreach ($bancos['data'] as $dato): ?>
                                                                    <option value="<?php echo $dato['id']; ?>"><?php echo $dato['nombre']; ?></option>
                                                                <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix">
                                                        <label for="numero_cuenta">N&uacute;mero de Cuenta:</label>
                                                        <div class="input">
                                                            <div class="input-append">
                                                                <input type="text" name="numero_cuenta" id="numero_cuenta" class="required number"  value=""/>
                                                                <input type="hidden" name="usuario_id" id="usuario_id" value="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="clearfix">
                                                        <div class="input">
                                                            <input type="button" name="registrar" id="registrar" value="Registrar" class="btn primary"/>
                                                            <a class="btn" href="#" data-dismiss="modal">Cerrar</a>                                                                    
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </form>
                                </div>
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