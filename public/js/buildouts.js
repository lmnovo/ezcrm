$(document).ready(function()
{
    var oTable= $('#buildouts').DataTable();

    //codigo para la edicion de la tabla
    ETable_buildouts={
        "existingValue":"",
        "init":function(){
            $('#buildouts').on('click','.original',function(){
                ETable_buildouts.openEditable(this);
            });
            $('#buildouts').on('blur','.editable',function(){
                var original = $(this).parent().parent().find('.original');
                ETable_buildouts.saveNewData(this,original);
            });
        },
        "openEditable":function(elem){
            $(elem).addClass('hide');
            $(elem).siblings().removeClass('hide');
            $(elem).siblings().find('.editable').focus();
            oTable.existingValue=$(elem).html();
        },
        "saveNewData":function(elem,original){
            var newVal=$(elem).val();
            var id=$(elem).data("id");

            //obtengo el index de la columna sobre la que estoy accionando
            var columnIdx = oTable.cell( $(elem).parents('td')).index().column;

            //Si fue seleccionado el nombre
            if(columnIdx == 0) {
                original.text(newVal);
                $('#modal-loading').modal('show');

                $.ajax({
                    url:  'editbuildout',
                    data: "nombre="+newVal+"&id="+id,
                    type:  'get',
                    dataType: 'json',
                    success : function(data) {
                        $('#modal-loading').modal('hide');
                    }
                });
            }

            //Si fue seleccionado el precio
            if(columnIdx == 2) {
                original.text(newVal);
                $('#modal-loading').modal('show');

                $.ajax({
                    url:  'editbuildout',
                    data: "precio="+newVal+"&id="+id,
                    type:  'get',
                    dataType: 'json',
                    success : function(data) {
                        $('#modal-loading').modal('hide');
                    }
                });
            }

            $('.editors').addClass('hide');
            $('.original').removeClass('hide');
        }
    };
    ETable_buildouts.init();

    $(document).on("click","#btneliminarbuildout",function(e) {
        e.preventDefault();

        var item = $(this).data('id');
        console.log(item);
        var tr = $(this).closest('td').parent();

        $.ajax({
            url:  '../products/deletebuildout',
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

    //Botón para agregar nuevo BuildOut en modal
    $('#newBuildout').on('click',function(){
        $('#nombreba').val('');
        $('#descriptionba').html('');
        $('#descriptionba').val('');
        $('#descriptionba').removeAttr('title');
        //$('.note-editing-area').html('');
        //$('.note-editable').html('');
        $('#price2ba').val('');
        $('#Build_OutGModal').modal('show');
    });

    //Abrir el Modal para Agregar Nuevo Buildout
    $('#Build_OutGModal').on('click','#savebuilout',function(){
        //Cargando variables del modal

        var tipo = $('#interesting').val();

        //Si es un TRUCK
        if(tipo == 1) {
            var name = 'Build Out - '+$('#nombreba').val();
        }
        else if(tipo == 2) { // Si es un TRAILER
            var name = $('#size option:selected').html()+' '+$('#nombreba').val();
        }

        var description = $('#descriptionba').summernote('code');
        var price = $('#price2ba').val();
        $('#buildout_name').html('');

        var type = $('#interesting').val();
        var size = $('#size').val();
        $('#buildout_description').html('');
        //$('.note-editing-area:nth-child(3)').html('');

        $.ajax({
            url: '../orders/addbuildout',
            data: "name="+name+"&description="+description+"&price="+price+"&tipo="+tipo,
            type:  'get',
            dataType: 'json',
            success : function(data) {
                $('#Build_OutGModal').modal('hide');
                oTable.clear().draw();

                $.ajax
                ({
                    url: 'buildout',
                    data: "interesting="+type+"&size="+size,
                    type: 'get',
                    success: function(datas)
                    {
                        for(var i=0;i<datas.length;i++)
                        {
                            oTable.row.add([
                                '<span class="editors hide"><input class="col-md-12 col-sm-12 form-control editable" data-id="'+datas[i].id+'" value="'+datas[i].nombre+'"/></span>'+
                                '<span id="nombre" class="original">'+datas[i].nombre,
                                '</span>' +
                                '<span class="editors hide"><textarea class="col-md-12 col-sm-12 form-control editable">"'+datas[i].descripcion+'"</textarea></span>'+
                                '<span class="original">'+datas[i].descripcion,
                                '</span>' +
                                '<span class="editors hide"><input class="col-md-12 col-sm-12 form-control number editable" data-id="'+datas[i].id+'" value="'+datas[i].precio+'"/></span>'+
                                '<span id="precio_buildout" data-id="'+datas[i].id+'" class="original">'+datas[i].precio,
                                '</span>' +
                                '<div class="btn-group" role="group" aria-label="..." id="'+datas[0].id+'">'+
                                '<div class="btn-group" role="group" aria-label="..." id="'+datas[0].id+'">'+
                                '<button type="button" class="btn btn-xs btn-warning btn-delete" data-id="'+datas[i].id+'" id="btneliminarbuildout">'+
                                '<span class="fa fa-trash"></span>'+
                                '</button>'+
                                '</div>'
                            ]).draw( false );

                            $('#newBuildout').removeAttrs('disabled');
                        }

                    }
                });
            }
        });


    });

    $('#interesting').on('change',function(){
        var id_interesting = $('#interesting').val();
        $('#type').html('');
        $('#size').html('');
        $('#size').removeAttr('title');
        $('#select2-type-container').html('**Select Data**');
        $('#select2-size-container').html('**Select Data**');
        $('#starting').val('0.00');
        $('#saveProduct').attr('disabled', 'disabled');
        $('#modal-loading').modal('show');
        oTable.clear().draw();
        $('#newBuildout').attr('disabled', 'disabled');

        $.ajax
        ({
            //url: '../orders/types/'+id_interesting,
            url: '../orders/estadolist',
            data: '',
            type: 'get',
            success: function(data)
            {
                $('#type').append('<option value="">**Select Data**</option>');
                for(var i=0;i<data.length;i++)
                {
                    $('#type').append('<option value="'+data[i].id+'">'+data[i].state+'</option>');
                }

                $('#modal-loading').modal('hide');
            }
        });
    });

    $('#type').on('change',function(){
        var type = $('#interesting').val();
        $('#size').html('');
        $('#select2-size-container').html('**Select Data**');
        $('#starting').val('0.00');
        $('#saveProduct').attr('disabled', 'disabled');
        $('#modal-loading').modal('show');
        oTable.clear().draw();
        $('#newBuildout').attr('disabled', 'disabled');

        $.ajax({
            //url: '../orders/sizes/'+type,
            url: '../orders/sizeslist',
            data: '',
            type:  'get',
            dataType: 'json',
            success : function(data) {
                $('#size').append('<option value="">**Select Data**</option>');
                for(var i=0;i<data.length;i++)
                {
                    $('#size').append('<option value="'+data[i].id+'">'+data[i].size+'</option>');
                }

                $('#modal-loading').modal('hide');

            }
        });
    });

    $('#size').on('change',function(){
        $('#price').val('0.00');
        var type = $('#interesting').val();
        var size = $('#size').val();
        var state = $('#type').val();
        $('#modal-loading').modal('show');
        $('#saveProduct').removeAttrs('disabled');
        oTable.clear().draw();

        if($('#type').val() !=='' && $('#size').val() !== '') {
            $.ajax({
                url: '../orders/prices',
                data: "type="+type+"&size="+size+"&state="+state,
                type:  'get',
                dataType: 'json',
                success : function(data) {
                    var precio = new Number(data[0].price).toFixed(2);
                    $('#starting').val(precio);
                    $('#modal-loading').modal('hide');

                    $.ajax
                    ({
                        url: 'buildout',
                        data: "interesting="+type+"&size="+size,
                        type: 'get',
                        success: function(datas)
                        {
                            for(var i=0;i<datas.length;i++)
                            {
                                oTable.row.add([
                                    '<span class="editors hide"><input class="col-md-12 col-sm-12 form-control editable" data-id="'+datas[i].id+'" value="'+datas[i].nombre+'"/></span>'+
                                    '<span id="nombre" class="original">'+datas[i].nombre,
                                    '</span>' +
                                    '<span class="editors hide"><textarea class="col-md-12 col-sm-12 form-control editable">"'+datas[i].descripcion+'"</textarea></span>'+
                                    '<span class="original">'+datas[i].descripcion,
                                    '</span>' +
                                    '<span class="editors hide"><input class="col-md-12 col-sm-12 form-control number editable" data-id="'+datas[i].id+'" value="'+datas[i].precio+'"/></span>'+
                                    '<span id="precio_buildout" data-id="'+datas[i].id+'" class="original">'+datas[i].precio,
                                    '</span>' +
                                    '<div class="btn-group" role="group" aria-label="..." id="'+datas[0].id+'">'+
                                    '<div class="btn-group" role="group" aria-label="..." id="'+datas[0].id+'">'+
                                    '<button type="button" class="btn btn-xs btn-warning btn-delete" data-id="'+datas[i].id+'" id="btneliminarbuildout">'+
                                    '<span class="fa fa-trash"></span>'+
                                    '</button>'+
                                    '</div>'
                                ]).draw( false );

                                $('#newBuildout').removeAttrs('disabled');
                            }

                        }
                    });
                }
            });

        }

    });

});