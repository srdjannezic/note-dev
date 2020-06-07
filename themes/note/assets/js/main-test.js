$('.book-next').click(function(){
    var stepNum = $(this).data('nx');
    var nextStep = '.step-' + stepNum;
    //find all input
    var x = $(this).closest('.step-wrapper').find('.required');

    var next = true;
    x.each(function() {
        if(x.val() == '') {
            $(this).addClass("errorInput");
            next = false;
            return;
        }
        else {
            x.removeClass("errorInput");
        }
    });
   
    if(next) {
        $(this).closest('.step').addClass('hideMove');
        $(nextStep).addClass('moveIt');
    }

  
});