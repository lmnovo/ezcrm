$(document).ready(function()
{
    var oTableSizes= $('#sizes_list').DataTable();

    //codigo para la edicion de la tabla
    ETable_sizes={
        "existingValue":"",
        "init":function(){
            $('#sizes_list').on('click','.original',function(){
                ETable_sizes.openEditable(this);
            });
            $('#sizes_list').on('blur','.editable',function(){
                var original = $(this).parent().parent().find('.original');
                ETable_sizes.saveNewData(this,original);
            });
        },
        "openEditable":function(elem){
            $(elem).addClass('hide');
            $(elem).siblings().removeClass('hide');
            $(elem).siblings().find('.editable').focus();
            oTableSizes.existingValue=$(elem).html();
        },
        "saveNewData":function(elem,original){
            var newVal=$(elem).val();
            var id=$(elem).data("id");

            //obtengo el index de la columna sobre la que estoy accionando
            var columnIdx = oTableSizes.cell( $(elem).parents('td')).index().column;

            original.text(newVal);
            $('#modal-loading').modal('show');

            $.ajax({
                url:  'editsize',
                data: "size="+newVal+"&id="+id,
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
    ETable_sizes.init();

    $(document).on("click","#btneliminarsize",function(e) {
        e.preventDefault();

        var item = $(this).data('id');
        var tr = $(this).closest('td').parent();

        $.ajax({
            url:  '../products/deletesize',
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

    $('#newSizeModal').on('click','#newSize',function(){
        var size = $('#size_name').val();
        $('#size_name').val('');

        if(size != '') {
            $.ajax({
                url: '../orders/addsize',
                data: "size="+size,
                type:  'get',
                dataType: 'json',
                success : function(data) {
                    oTableSizes.clear().draw();
                    $.ajax
                    ({
                        url: 'sizes',
                        data: "",
                        type: 'get',
                        success: function(data)
                        {
                            for(var i=0;i<data.length;i++)
                            {
                                oTableSizes.row.add([
                                    '<span class="editors hide"><input class="col-md-12 col-sm-12 form-control editable" data-id="'+data[i].id+'" value="'+data[i].size+'"/></span>'+
                                    '<span id="type" class="original" data-id="'+data[i].id+'">'+data[i].size,
                                    '</span><button type="button" class="btn btn-warning btn-xs" id="btneliminarsize" data-id="'+data[i].id+'">'+
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

    $('#edit_size').on('click',function(){
        $('#newSizeModal').modal('show');

        oTableSizes.clear().draw();
        $.ajax
        ({
            url: 'sizes',
            data: "",
            type: 'get',
            success: function(data)
            {
                for(var i=0;i<data.length;i++)
                {
                    oTableSizes.row.add([
                        '<span class="editors hide"><input class="col-md-12 col-sm-12 form-control editable" data-id="'+data[i].id+'" value="'+data[i].size+'"/></span>'+
                        '<span id="type" class="original" data-id="'+data[i].id+'">'+data[i].size,
                        '</span><button type="button" class="btn btn-warning btn-xs" id="btneliminarsize" data-id="'+data[i].id+'">'+
                        '<i class="fa fa-trash"></i>'+
                        '</button>'
                    ]).draw( false );
                }
            }
        });
    });


});