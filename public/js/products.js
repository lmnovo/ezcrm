$(document).ready(function()
{
    $('#interesting').select2();
    $('#type').select2();
    $('#size').select2();

    var oTableProducts= $('#products').DataTable();

    //codigo para la edicion de la tabla
    ETable_products={
        "existingValue":"",
        "init":function(){
            $('#products').on('click','.original',function(){
                ETable_products.openEditable(this);
            });
            $('#products').on('blur','.editable',function(){
                var original = $(this).parent().parent().find('.original');
                ETable_products.saveNewData(this,original);
            });
        },
        "openEditable":function(elem){
            $(elem).addClass('hide');
            $(elem).siblings().removeClass('hide');
            $(elem).siblings().find('.editable').focus();
            oTableProducts.existingValue=$(elem).html();
        },
        "saveNewData":function(elem,original){
            var newVal=$(elem).val();
            var id=$(elem).data("id");

            //obtengo el index de la columna sobre la que estoy accionando
            var columnIdx = oTableProducts.cell( $(elem).parents('td')).index().column;

            original.text(newVal);
            $('#modal-loading').modal('show');

            $.ajax({
                url:  'editproduct',
                data: "type="+newVal+"&id="+id,
                type:  'get',
                dataType: 'json',
                success : function(data) {
                    $('#modal-loading').modal('hide');
                }
            });

            $('.editors').addClass('hide');
            $('.original').removeClass('hide');
        }
    };
    ETable_products.init();

    $(document).on("click","#btneliminar",function(e) {
        e.preventDefault();

        var item = $(this).data('id');
        var tr = $(this).closest('td').parent();

        $.ajax({
            url:  '../products/deletetype',
            data: '&id='+item,
            type:  'get',
            dataType: 'json',
            success : function(data) {
                //Eliminamos la fila de la vista
                swal('Deleted!', 'Delete selected successfully !', 'success');
                tr.hide();
            }
        });
    });

    $('#edit_interesting').on('click',function(){
        $('#newProductModal').modal('show');

        oTableProducts.clear().draw();
        $.ajax
        ({
            url: 'types',
            data: "",
            type: 'get',
            success: function(data)
            {
                for(var i=0;i<data.length;i++)
                {
                    oTableProducts.row.add([
                        '<span class="editors hide"><input class="col-md-12 col-sm-12 form-control editable" data-id="'+data[i].id+'" value="'+data[i].type+'"/></span>'+
                        '<span id="type" class="original" data-id="'+data[i].id+'">'+data[i].type,
                        '</span><button type="button" class="btn btn-warning btn-xs" id="btneliminar" data-id="'+data[i].id+'">'+
                        '<i class="fa fa-trash"></i>'+
                        '</button>'
                    ]).draw( false );
                }
            }
        });
    });

    $('#newProductModal').on('click','#newProduct',function(){
        var type = $('#product_name').val();
        $('#product_name').val('');

        if(type != '') {
            $.ajax({
                url: '../orders/addproduct',
                data: "type="+type,
                type:  'get',
                dataType: 'json',
                success : function(data) {
                    oTableProducts.clear().draw();
                    $.ajax
                    ({
                        url: 'types',
                        data: "",
                        type: 'get',
                        success: function(data)
                        {
                            for(var i=0;i<data.length;i++)
                            {
                                oTableProducts.row.add([
                                    '<span class="editors hide"><input class="col-md-12 col-sm-12 form-control editable" data-id="'+data[i].id+'" value="'+data[i].type+'"/></span>'+
                                    '<span id="type" class="original" data-id="'+data[i].id+'">'+data[i].type,
                                    '</span><button type="button" class="btn btn-warning btn-xs" id="btneliminar" data-id="'+data[i].id+'">'+
                                    '<i class="fa fa-trash"></i>'+
                                    '</button>'
                                ]).draw( false );
                            }
                        }
                    });
                }
            });
        }


    });

    //Agregando Nueva Categoría de Appliance
    $('#newProductModal').on('click','#addProduct',function(){
        var product = $('#product_name').val();
        $('#modal-loading').modal('show');

        $.ajax({
            url:  'addproductname',
            data: "&product="+product,
            type:  'get',
            dataType: 'json',
            success : function(data) {
                window.location.href = 'http://ezcrm.us/crm/products/add-product';
                $('#modal-loading').modal('hide');
                $('#newProductModal').modal('hide');
            }
        });
    });

    $('#saveProduct').on('click',function(){
        $('#modal-loading').modal('show');
        var size = $('#size').val();
        var type = $('#interesting').val();
        var state = $('#type').val();
        var price = $('#starting').val();

        $.ajax
        ({
            url: 'updateprice',
            data: "type="+type+"&size="+size+"&state="+state+"&price="+price,
            type: 'get',
            success: function(data)
            {
                $('#modal-loading').modal('hide');
                $('#newBuildout').removeAttrs('disabled');
            }
        });
    });

});