$(document).ready(function()
{
    var oTableEstados= $('#estados').DataTable();

    //codigo para la edicion de la tabla
    ETable_estados={
        "existingValue":"",
        "init":function(){
            $('#estados').on('click','.original',function(){
                ETable_estados.openEditable(this);
            });
            $('#estados').on('blur','.editable',function(){
                var original = $(this).parent().parent().find('.original');
                ETable_estados.saveNewData(this,original);
            });
        },
        "openEditable":function(elem){
            $(elem).addClass('hide');
            $(elem).siblings().removeClass('hide');
            $(elem).siblings().find('.editable').focus();
            oTableEstados.existingValue=$(elem).html();
        },
        "saveNewData":function(elem,original){
            var newVal=$(elem).val();
            var id=$(elem).data("id");

            //obtengo el index de la columna sobre la que estoy accionando
            var columnIdx = oTableEstados.cell( $(elem).parents('td')).index().column;

            original.text(newVal);
            $('#modal-loading').modal('show');

            $.ajax({
                url:  'editestado',
                data: "estado="+newVal+"&id="+id,
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
    ETable_estados.init();

    $(document).on("click","#btneliminarestado",function(e) {
        e.preventDefault();

        var item = $(this).data('id');
        var tr = $(this).closest('td').parent();

        $.ajax({
            url:  '../products/deleteestado',
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

    $('#newEstadoModal').on('click','#newEstado',function(){
        var estado = $('#estado_name').val();
        $('#estado_name').val('');

        if(estado != '') {
            $.ajax({
                url: '../orders/addestado',
                data: "estado="+estado,
                type:  'get',
                dataType: 'json',
                success : function(data) {
                    oTableEstados.clear().draw();
                    $.ajax
                    ({
                        url: 'estados',
                        data: "",
                        type: 'get',
                        success: function(data)
                        {
                            for(var i=0;i<data.length;i++)
                            {
                                oTableEstados.row.add([
                                    '<span class="editors hide"><input class="col-md-12 col-sm-12 form-control editable" data-id="'+data[i].id+'" value="'+data[i].estado+'"/></span>'+
                                    '<span id="type" class="original" data-id="'+data[i].id+'">'+data[i].estado,
                                    '</span><button type="button" class="btn btn-warning btn-xs" id="btneliminarestado" data-id="'+data[i].id+'">'+
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

    $('#edit_type').on('click',function(){
        $('#newEstadoModal').modal('show');

        oTableEstados.clear().draw();
        $.ajax
        ({
            url: 'estados',
            data: "",
            type: 'get',
            success: function(data)
            {
                for(var i=0;i<data.length;i++)
                {
                    oTableEstados.row.add([
                        '<span class="editors hide"><input class="col-md-12 col-sm-12 form-control editable" data-id="'+data[i].id+'" value="'+data[i].estado+'"/></span>'+
                        '<span id="type" class="original" data-id="'+data[i].id+'">'+data[i].estado,
                        '</span><button type="button" class="btn btn-warning btn-xs" id="btneliminarestado" data-id="'+data[i].id+'">'+
                        '<i class="fa fa-trash"></i>'+
                        '</button>'
                    ]).draw( false );
                }
            }
        });
    });


});