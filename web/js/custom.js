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
});
