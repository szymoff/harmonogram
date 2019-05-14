jQuery( document ).ready( function( $ ) {

    $('.accordion-menu').each(function() { 
        var curr_acc = $(this).find('a'); 
        $(this).on("click", function(){
            if(curr_acc.hasClass('open open-selected')){
                curr_acc.find('i').removeClass('fa fa-angle-up');
                curr_acc.find('i').addClass('fa fa-angle-down');
                
                // Hide clicked accordion
                curr_acc.removeClass('open open-selected');
                curr_acc.siblings('div').slideUp('normal');
            }else{
                // Show clicked accordion
                curr_acc.find('i').removeClass('fa fa-angle-down');
                curr_acc.find('i').addClass('fa fa-angle-up');
                curr_acc.addClass('open open-selected');
                curr_acc.siblings('div').slideDown('normal');
                
                // Close another accordions in row
                var elseAcc = $(this).siblings('div').find('a');
                elseAcc.find('i').removeClass();
                elseAcc.find('i').addClass('fa fa-angle-down');
                elseAcc.removeClass('open open-selected');
                elseAcc.siblings('div').slideUp('normal');
                
            }
        });
        // Hide on start noactive accordions
        if(! curr_acc.hasClass('open open-selected')){
            curr_acc.siblings('div').hide();
        }
        // var hourHeight = curr_acc.find('.acc-title').height();
        // curr_acc.find('.hour').height(hourHeight);
        // curr_acc.find('.hour').css("line-height", hourHeight+'px');  
        // console.log(hourHeight); 
    }); 
    } );