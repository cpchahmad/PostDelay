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
                update_type : 'type_name',
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
                update_type : 'weight',
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

    var value = $(this).val();
    $.ajax(
        {
            type:'GET',
            url:'/order/status/update',
            data: {
                status:$(this).val(),
                order:$(this).data('order-id'),
            },
            success:function(data){
                if(value === 15){
                    alertify.success('Order Status Updated - Please go to "Set Additional Charges" Tab to set additional charges');
                    location.reload();
                }
                else{
                    alertify.success('Order Status Updated');
                }

            },
        });

});

$('body').on('click','.make_default_fee_button',function () {
    $.ajax(
        {
            type:'GET',
            url:'/post-delay-fee/default',
            data: {
                fee:$(this).data('id'),
                type:$(this).data('type'),
            },
            success:function(data){
                alertify.success('Default Fee Updated');
                setTimeout(function () {
                    location.reload();
                },300);

            },
        });
});

$('body').on('change','.fee_name-input',function () {


    $.ajax(
        {
            type:'GET',
            url:'/post-delay-fee/update',
            data: {
                type: 'name',
                name : $(this).val(),
                id:$(this).data('id'),

            },
            success:function(data){
                alertify.success('Fee Updated');
                $(this).val(data.name);
            }
        });

});

$('body').on('change','.fee_price-input',function () {


    $.ajax(
        {
            type:'GET',
            url:'/post-delay-fee/update',
            data: {
                type: 'price',
                price : $(this).val(),
                id:$(this).data('id'),

            },
            success:function(data){
                alertify.success('Fee Updated');
                $(this).val(data.price);
            }
        });

});

$('body').on('click','.fee_delete_button',function () {
    var id = $(this).data('id');
    $.ajax(
        {
            type:'GET',
            url:'/post-delay-fee/delete',
            data: {
                id:$(this).data('id'),
            },
            success:function(data){
                var row = '#fee_row_'+id;
                $(row).remove();
                alertify.error('Fee Deleted');
            }
        });

});

$('body').on('change','.fee_type-select',function () {


    $.ajax(
        {
            type:'GET',
            url:'/post-delay-fee/update',
            data: {
                type: 'type',
                fee_type : $(this).val(),
                id:$(this).data('id'),

            },
            success:function(data){
                alertify.success('Fee Updated');
                $(this).val(data.fee_type).change();
            }
        });

});

$('.single_order').ready(function(){

    if ($('body .single_order').length > 0)
    {
        multipleAddress()
    }

});

function multipleAddress(){

    setTimeout(function() {
        $('.AddressCountryNew').each(function(){
            var country = $(this).attr('data-country-select');
            var province = $(this).attr('data-province-select');
            console.log(country, province);
            if(country){
                $(this).val(country).change();
                changeCountry($(this));
            }
            if(province){
                $(this).parents('.row').find('.AddressProvinceNew').val(province).change();
            }
        });
    }, 500);
}

function changeCountry($this){
    var $parent = $this.parents();
    $parent.find('.AddressProvinceNew').empty();
    var data_provinces = $('option:selected', $this).attr('data-provinces');
    var provinces = JSON.parse(data_provinces);
    var length = provinces.length;
    if(length === 0){

    }
    else{
        $parent.find('.AddressProvinceNew').empty();
        for(var i=0; i<length; i++){
            $parent.find('.AddressProvinceNew').append(new Option(provinces[i][0],provinces[i][1]));
        }
    }
    return true;
}


$('body').on('change','.commision_type_change',function () {

    $.ajax(
        {
            type:'GET',
            url:'/type/update',
            data: {
                update_type : 'commision_type',
                type : $(this).val(),
                type_id:$(this).data('id'),

            },
            success:function(data){
                alertify.success('Commission Type Updated');
                $(this).val(data.commision_type);

            }
        });

});


$('body').on('change','.commision_change',function () {

    $.ajax(
        {
            type:'GET',
            url:'/type/update',
            data: {
                update_type : 'commision',
                type : $(this).val(),
                type_id:$(this).data('id'),

            },
            success:function(data){
                alertify.success('Commission Updated');
                $(this).val(data.commision);

            }
        });



});

$('.address_update_btn').click(function(e){
    e.preventDefault();
    var $this =  $('.update_address_admin');
    $.ajax(
        {
            type:$this.attr('method'),
            url:$this.attr('action'),
            data: $this.serialize(),
            success:function(data){
                alertify.success('Address Updated.');
            }
        });
});

$('.update_customer_details_form').submit(function(e){
    e.preventDefault();
    var $this =  $('.update_customer_details_form');
    $.ajax(
        {
            type:$this.attr('method'),
            url:$this.attr('action'),
            data: $this.serialize(),
            success:function(data){
                alertify.success('Information Updated.');
            }
        });
});

$('body').on('change','#customer_status',function () {

    $.ajax(
        {
            type:'GET',
            url:$(this).data('url'),
            data: {
                id : $(this).data('id'),
                customer_status : $(this).val(),
            },
            success:function(data){
                alertify.success('Customer '+data.status);
            }
        });

});

$('.delete_customer_class').click(function () {
    $(this).next().submit();
})
