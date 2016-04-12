/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {

    $('#product-add').submit(function () {
        $('[name^="size[name]"').each(function (index) {
            if ($(this).val() == '') {
                $(this).parent().remove();
            }
        });
        $('[name^="size[sale_price]"]').each(function () {
            if ($(this).val() == '') {
                $(this).remove();
            }
        });
    });

    $('input:radio[name="price_option"]').each(function () {
        if ($(this).is(':checked')) {
            $('#price_options_container > div').hide();
            $('#' + $(this).data('id')).show();
        }
    });
    $('input:radio[name="price_option"]').change(function () {
        if ($(this).is(':checked')) {
            $('#price_options_container > div').hide();
            $('#' + $(this).data('id')).show();
        }
    });

    $('#add-sizes').click(function () {
        $('.sizes_container').append('<div class="size_container"><input type="text" class="textbox inline width-35" name="size[name][]" placeholder="Size / Slice Name"><input type="text" class="textbox inline width-16" name="size[price][]" placeholder="Price"><input type="text" class="textbox inline width-16" name="size[sale_price][]" placeholder="Sale Price"><input type="text" class="textbox inline width-9" name="size[stock][]" placeholder="Stock"></div>');
    });


    //Load partnered vendors of partners
    $('table.partners .partneredvendors').click(function () {
        $("#partnered-vendors").load('partners/get_partner_vendors/'+$(this).data('pid'))
                .dialog({
                    modal: true,
                    height: $(window).height()*80/100,
                    width: $(window).width()*80/100,
                    title: "Partnered Vendors"
                }).dialog('open');
        return false;
    });

});