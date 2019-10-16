$('body').on('change','.shape-input',function () {

    $.ajax(
        {
        type:'GET',
        url:'/shape/update',
        data: {
            shape : $(this).val(),
            shape_id:$(this).data('id'),

        },
        success:function(data){
            alertify.success('Shape Updated');
           $(this).val(data.shape);
        }
    });

});

$('body').on('click','.shape_delete_button',function () {
    var shape_id=$(this).data('id');
    $.ajax(
        {
            type:'GET',
            url:'/shape/delete',
            data: {
                shape_id:$(this).data('id'),
            },
            success:function(data){
                var row = '#shape_row_'+shape_id;
                $(row).remove();
                alertify.error('Shape Deleted');
            }
        });

});

$('body').on('change','.type-input',function () {

    $.ajax(
        {
            type:'GET',
            url:'/type/update',
            data: {
                update_weight : 'no',
                type : $(this).val(),
                type_id:$(this).data('id'),

            },
            success:function(data){
                alertify.success('Post-Type Updated');
                $(this).val(data.type);
            }
        });

});

$('body').on('change','.weight-input',function () {

    $.ajax(
        {
            type:'GET',
            url:'/type/update',
            data: {
                update_weight : 'yes',
                weight : $(this).val(),
                type_id:$(this).data('id'),

            },
            success:function(data){
                alertify.success('Post-Type Updated');
                $(this).val(data.weight);
            }
        });

});



$('body').on('click','.type_delete_button',function () {
    var type_id = $(this).data('id');
    $.ajax(
        {
            type:'GET',
            url:'/type/delete',
            data: {
                type_id:$(this).data('id'),
            },
            success:function(data){
                var row = '#type_row_'+type_id;
                $(row).remove();
                alertify.error('Post-Type Deleted');
            }
        });

});

$('body').on('change','.scale-input',function () {


    $.ajax(
        {
            type:'GET',
            url:'/scale/update',
            data: {
                scale : $(this).val(),
                scale_id:$(this).data('id'),

            },
            success:function(data){
                alertify.success('Unit of Measure Updated');
                $(this).val(data.type);
            }
        });

});


$('body').on('click','.scale_delete_button',function () {
    var scale_id = $(this).data('id');
    $.ajax(
        {
            type:'GET',
            url:'/scale/delete',
            data: {
                scale_id:$(this).data('id'),
            },
            success:function(data){
                var row = '#scale_row_'+scale_id;
                $(row).remove();
                alertify.error('Unit of Measure Deleted');
            }
        });

});

$('body').on('click','.location_delete_button',function () {
    var location_id = $(this).data('id');
    $.ajax(
        {
            type:'GET',
            url:'/location/delete',
            data: {
                location_id:$(this).data('id'),
            },
            success:function(data){
                var row = '#location_row_'+location_id;
                $(row).remove();
                alertify.error('Location Deleted');
            }
        });

});

$('body').on('submit','#location_update_form',function (e) {
    e.preventDefault();

    var form = $(this);

    $.ajax(
        {
            type:form.attr('method'),
            url:form.attr('action'),
            data: form.serialize(),
            success:function(data){
                alertify.success('Location Updated');
            }
        });

});


$('body').on('change','#change_order_status',function (e) {
    e.preventDefault();
    $.ajax(
        {
            type:'GET',
            url:'/order/status/update',
            data: {
                status:$(this).val(),
                order:$(this).data('order-id'),
            },
            success:function(data){
                alertify.success('Order Status Updated');
            },
        });

})
