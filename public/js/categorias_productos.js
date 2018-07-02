$(document).ready(function()
{
    var oTableCategorias= $('#categorias').DataTable();

    //codigo para la edicion de la tabla
    ETable_categorias={
        "existingValue":"",
        "init":function(){
            $('#categorias').on('click','.original',function(){
                ETable_categorias.openEditable(this);
            });
            $('#categorias').on('blur','.editable',function(){
                var original = $(this).parent().parent().find('.original');
                ETable_categorias.saveNewData(this,original);
            });
        },
        "openEditable":function(elem){
            $(elem).addClass('hide');
            $(elem).siblings().removeClass('hide');
            $(elem).siblings().find('.editable').focus();
            oTableCategorias.existingValue=$(elem).html();
        },
        "saveNewData":function(elem,original){
            var newVal=$(elem).val();
            var id=$(elem).data("id");

            //obtengo el index de la columna sobre la que estoy accionando
            var columnIdx = oTableCategorias.cell( $(elem).parents('td')).index().column;

            original.text(newVal);
            $('#modal-loading').modal('show');

            $.ajax({
                url:  'orders/editcategory',
                data: "valor="+newVal+"&id="+id,
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
    ETable_categorias.init();

    $(document).on("click","#btneliminarcategory",function(e) {
        e.preventDefault();

        var item = $(this).data('id');
        var tr = $(this).closest('td').parent();

        $.ajax({
            url:  'orders/deletecategoria',
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

    $('#newCategoryApplianceModal').on('click','#newCategoria',function(){
        var valor = $('#category_category_name').val();
        $('#category_category_name').val('');

        if(valor != '') {
            $.ajax({
                url: 'orders/addcategory',
                data: "valor="+valor,
                type:  'get',
                dataType: 'json',
                success : function(data) {
                    oTableCategorias.clear().draw();
                    $.ajax
                    ({
                        url: 'orders/appliances',
                        data: "",
                        type: 'get',
                        success: function(data)
                        {
                            for(var i=0;i<data.length;i++)
                            {
                                oTableCategorias.row.add([
                                    '<span class="editors hide"><input class="col-md-12 col-sm-12 form-control editable" data-id="'+data[i].id+'" value="'+data[i].category+'"/></span>'+
                                    '<span id="type" class="original" data-id="'+data[i].id+'">'+data[i].category,
                                    '</span><button type="button" class="btn btn-warning btn-xs" id="btneliminarcategory" data-id="'+data[i].id+'">'+
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

    $('#edit_appliance_new').on('click',function(){
        $('#newCategoryApplianceModal').modal('show');
        $('#newApplianceModal').modal('hide');

        oTableCategorias.clear().draw();
        $.ajax
        ({
            url: 'orders/appliancescategories',
            data: "",
            type: 'get',
            success: function(data)
            {
                for(var i=0;i<data.length;i++)
                {
                    oTableCategorias.row.add([
                        '<span class="editors hide"><input class="col-md-12 col-sm-12 form-control editable" data-id="'+data[i].id+'" value="'+data[i].category+'"/></span>'+
                        '<span id="type" class="original" data-id="'+data[i].id+'">'+data[i].category,
                        '</span><button type="button" class="btn btn-warning btn-xs" id="btneliminarcategory" data-id="'+data[i].id+'">'+
                        '<i class="fa fa-trash"></i>'+
                        '</button>'
                    ]).draw( false );
                }
            }
        });
    });


});