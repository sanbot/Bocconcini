/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    $('#topnavbar').affix({
        offset: {
            top: $('#banner').height()
        }   
    });
    /** JS Menu **/
    jQuery(document).on('click', '.mega-dropdown', function(e) {
      e.stopPropagation();
    });
    $('.banner-img-product').click(function(){
        $('#modal-container-26505').modal('show');
    });
    
    /** JS INVENTORY **/
    $('#inventory-productid').change(function(){
        $.ajax({
            url: URL_INVENTORY_QUANTITY,
            type: 'POST',
            data: {productid:$(this).val()},
            success: function(data){
                data = jQuery.parseJSON(data);
                if(data.error){
                    console.log(data);
                }else{
                    $('#inventory-quantity').val(data.quantity);
                    $('#inventory-observation').val(data.observation);
                    $('#inventory-quantity').focus();
                }
            }
        });
    });
});

