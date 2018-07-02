$(document).ready(function()
{
    var oTableSubCategorias= $('#subcategorias').DataTable();

    //codigo para la edicion de la tabla
    ETable_subcategorias={
        "existingValue":"",
        "init":function(){
            $('#subcategorias').on('click','.original',function(){
                ETable_subcategorias.openEditable(this);
            });
            $('#subcategorias').on('blur','.editable',function(){
                var original = $(this).parent().parent().find('.original');
                ETable_subcategorias.saveNewData(this,original);
            });
        },
        "openEditable":function(elem){
            $(elem).siblings().removeClass('hide');

            //verifico si es la categoria
            if($(elem).attr('id')==='tbl_category')
            {
                //lleno el combo de las categorias
                $.ajax({
                    url: "orders/appliances",
                    type:  'get',
                    dataType: 'json',
                    success : function(data) {
                        $(elem).siblings().find('.editable').html('');
                        for(var i=0;i<data.length;i++)
                        {
                            $(elem).siblings().find('.editable').append('<option data-id="'+data[i].id+'" value="'+data[i].id+'">'+data[i].category+'</option>');
                        }
                        $(elem).siblings().find('option:contains("'+$(elem).html()+'")').prop('selected', true);
                    },
                    complete:function(){}
                });

                $(elem).hide();
                $(elem).siblings().show();
                $(elem).siblings().find('.editable').focus();
            }else {
                $(elem).hide();
                $(elem).siblings().show();
                $(elem).siblings().find('.editable').focus();
            }

            oTableSubCategorias.existingValue=$(elem).html();
        },
        "saveNewData":function(elem,original){
            var newVal=$(elem).val();
            var texto="";
            var id_appliance_inside = null;
            var appliance_name = null;

            if($(elem).hasClass('combo')) {
                texto = $(elem).find('option:selected').text();
                $(elem).parent().siblings().html(texto);
                id_appliance_inside = $(elem).parents('tr').find('td:eq("2")').children().val();
                appliance_name = $(elem).parents('tr').find('td:eq("0") .originals').text();

                //Guardamos en BD
                $.ajax({
                    url: 'orders/updateapplianceinside',
                    data: "id="+id_appliance_inside+"&id_appliance="+newVal,
                    type:  'get',
                    dataType: 'json',
                    success : function(data) {
                        $('#modal-loading').modal('hide');
                    }
                });
            }
            else {
                $(elem).parent().siblings().html(newVal);
                id_appliance_inside = $(elem).parents('tr').find('td:eq("2")').children().val();
                appliance_name = $(elem).parents('tr').find('td:eq("0") .originals').text();

                //Guardamos en BD
                $.ajax({
                    url: 'orders/updateapplianceonlyname',
                    data: "id="+id_appliance_inside+"&name="+newVal,
                    type:  'get',
                    dataType: 'json',
                    success : function(data) {
                        $('#modal-loading').modal('hide');
                    }
                });

            }

            //obtengo el index de la columna sobre la que estoy accionando
            var columnIdx = oTableSubCategorias.cell( $(elem).parents('td')).index().column;
            $('#modal-loading').modal('show');


            $('#modal-loading').modal('hide');
            $('.editors').hide();
            $('.original').show();

        }
    };
    ETable_subcategorias.init();

    $(document).on("click","#btneliminarsubcategory",function(e) {
        e.preventDefault();

        var item = $(this).data('id');
        var tr = $(this).closest('td').parent();

        $.ajax({
            url:  'orders/deletesubcategoria',
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

    $('#newSubCategoryApplianceModal').on('click','#newSubCategoria',function(){
        var valor = $('#subcategory_name').val();
        var categoria_select = $('#appliance_subcategory option:selected').val();

        if(valor != '' && categoria_select !='') {
            $.ajax({
                url: 'orders/addsubcategory',
                data: "subcategoria="+valor+"&categoria="+categoria_select,
                type:  'get',
                dataType: 'json',
                success : function(data) {
                    oTableSubCategorias.clear().draw();
                    $.ajax
                    ({
                        url: 'orders/subcategoriascategoria',
                        data: "",
                        type: 'get',
                        success: function(data)
                        {
                            $('#subcategory_name').val('');

                            for(var i=0;i<data.length;i++)
                            {
                                oTableSubCategorias.row.add([
                                    '<span class="editors hide"><input class="col-md-12 col-sm-12 form-control editable" data-id="'+data[i].id+'" value="'+data[i].name+'"/></span>'+
                                    '<span id="type" class="original" data-id="'+data[i].id+'">'+data[i].name,
                                    '<span class="editors hide"><select class="col-md-12 col-sm-12 editable form-control combo" ></select></span><span class="original" id="tbl_category">'+data[i].category+'</span>',
                                    '</span><button type="button" value="'+data[i].id+'" class="btn btn-warning btn-xs" id="btneliminarsubcategory" data-id="'+data[i].id+'">'+
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

    $('#edit_product_new').on('click',function(){
        $('#newSubCategoryApplianceModal').modal('show');
        $('#appliance_subcategory').html('');
        $('#select2-appliance_subcategory-container').html('**Select Data**');
        $('#subcategory_name').val('');
        $('#newApplianceModal').modal('hide');

        $.ajax({
            url: 'orders/appliancescategories/',
            data: '',
            type:  'get',
            dataType: 'json',
            success : function(data) {
                $('#appliance_subcategory').append('<option value=""></option>');
                for(var i=0;i<data.length;i++)
                {
                    $('#appliance_subcategory').append('<option value="'+data[i].id+'">'+data[i].category+'</option>');
                }

                $('#newSubCategoryApplianceModal').modal('show')

                //Ahora llenamos el listado de subcategorias
                oTableSubCategorias.clear().draw();
                $.ajax
                ({
                    url: 'orders/subcategoriascategoria',
                    data: "",
                    type: 'get',
                    success: function(data)
                    {
                        for(var i=0;i<data.length;i++)
                        {
                            oTableSubCategorias.row.add([
                                '<span class="editors hide"><input class="col-md-12 col-sm-12 form-control editable" data-id="'+data[i].id+'" value="'+data[i].name+'"/></span>'+
                                '<span id="type" class="original" data-id="'+data[i].id+'">'+data[i].name,
                                '<span class="editors hide"><select class="col-md-12 col-sm-12 editable form-control combo" ></select></span><span class="original" id="tbl_category">'+data[i].category+'</span>',
                                '</span><button type="button" value="'+data[i].id+'" class="btn btn-warning btn-xs" id="btneliminarsubcategory" data-id="'+data[i].id+'">'+
                                '<i class="fa fa-trash"></i>'+
                                '</button>'
                            ]).draw( false );
                        }
                    }
                });

            }
        });


    });



});