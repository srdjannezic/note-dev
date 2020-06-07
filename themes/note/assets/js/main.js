//-------------------------
//----------- MAIN JS
//-------------------------

$(document).ready(function(){
      var last = $('.filterTours').attr('data-last');
      if(last <= 1) $('.load-more').hide();
      else $('.load-more').show();
      $('.tour-name').attr('value',$('.tour-title').html());
});

//-- Mobile menu

$('.ham-menu-btn').click(function(){
	$(this).toggleClass('is-active');
	$('.side-nav').toggleClass('open');
	if($(window).width() < 767) {
		$('.logo-in-menu').toggleClass('showUp');
	} 
});

//-- Header shadow

// $(window).scroll(function() {     
//     var scroll = $(window).scrollTop();
//     if (scroll > 0) {
//         $(".header").addClass("shade");
//     }
//     else {
//         $(".header").removeClass("shade");
//     }
// });

//-- Filters

$('.filter__btn').click(function(){
  $('.note-filter').toggleClass('showFilter');
});

$('.filter-word').click(function(){
  $('.note-filter').removeClass('showFilter');
});

//-- FAQ accordion

$('.acc-header').click(function(){
    $(this).closest('.acc-row').toggleClass('expand');
});

//SEARCH FORM

$('.search-submit').click(initSearch);
$('#suggestionContainer').on('keypress', '.search-text', function(e){
    // var keycode = (e.keyCode ? e.keyCode : e.which);
    if(e.which == 13){
        initSearch(e);   
    }
});

if($(window).width() > 767) {



$(document).on('click touchstart', function(event) {
      if (!$(event.target).find('.resultsData').length) {
          // Hide the menus.

         $('.resultsData').hide(); 
      }
  });

}

function initSearch(e, value=''){
   if(value == '') window.location.href = $('.search-form').attr('action') + $('.search-text').get(0).value;
   else window.location.href = $('.search-form').attr('action') + value;
    e.preventDefault();
}

// $(document).ready(function(){
//     $.get('https://www.instagram.com/explore/tags/budapest/?__a=1', function (data, status) {
//     for(var i = 0; i < 8; i++) {
//         var $this = data.graphql.hashtag.edge_hashtag_to_media.edges[i].node;
//         $('.home-social').find('.section-content').append('<img src="'+  $this.thumbnail_resources[2].src +'">');
//     }
//     });

//     let tour_title = $('.tour-title').html();
//     $('.tour-name').attr('value',tour_title);
// });

$('.book-now').click(function(e){
  e.preventDefault();
    $('.book-pay').addClass('showPopup');
    // $('.site-wrapper').toggleClass('overlay');
});

$('.book-close').click(function(){
    $('.book-pay').removeClass('showPopup');
});

$('.book-demand').click(function(){
    $('.book-popup-default').addClass('showPopup');
    // $('.site-wrapper').toggleClass('overlay');
});

$('.book-close').click(function(){
    $('.book-popup-default').removeClass('showPopup');
});

$('body').on('click','.submit-cancel',function(event){
  $(this).closest('form').request('onCancel',{
    data:{
      confirmationCode : $('.code').val(),
      note: $('.reason').val(),
      email: $('.email').val()
    },
    success: function(resp){
      //console.log(resp);
      if(resp.result == 'OK'){
        location.replace('/cancelled');
      }
      else{
        location.replace('/error');
      }

    }
  });
  event.preventDefault(); 
});

$('body').on('change','select[name="group_type"]',function(){
  console.log('test');
  if($(this).val() == 'Public'){
    if($("#rent_date").children("option[value='10.00']").length !== 0)
    {
      $('select[name="rent_date"]').val('10.00');
      $('select[name="rent_date"]').attr('disabled','disabled');
      $('select[name="rent_date"]').addClass('disabled');
    }
    else{
      $('select[name="rent_date"]').removeAttr('disabled');
      $('select[name="rent_date"]').removeClass('disabled');
    }

  }
  else{
    $('select[name="rent_date"]').removeAttr('disabled');
    $('select[name="rent_date"]').removeClass('disabled');
  }
});

var tour_counter = 2;
$('body').on('click','.load-more',function(){
    var page = $(this).attr('href');
    var fields = getFilterFields();
    var values = fieldsToArray(fields,true);
    var sort = $('.sort-box > select').val();
    console.log(values);

    $('.blog-loader').show();
    $('.load-more').hide();
    $('.preloader-more').show();

    event.preventDefault(); 
    if ($(this).attr('href') != '#') {
        //$("html, body").animate({scrollTop: 0}, "slow");
        $('body').find('form.filterTours').request('onFilterTours', {  
            data: {
              page: page,
              type:'filter',
              values:values,
              sort:sort,
			  pagination:true,
            },
            update:{
                'tours/tours':'.itemList',
            },
            success: function(response){
               $('.preloader-more').hide();
              tour_counter ++;
              $.each(response, function(index, element) {
                  $('.itemList').append(element);
              });
              let last = $('form.filterTours').data('last');

              $('.load-more').attr('href','?page='+tour_counter);
              if(tour_counter <= last){
                $('.load-more').show();
              }
            },
        });
    }
});

//-- Dropdown search destination
//TOGGLING NESTED ul
$(".drop-down-dest .selected a").click(function(e) {
    e.preventDefault();
    $(this).closest(".drop-down-dest").find(".options .list-wrapper").toggle();
    // $(".drop-down-dest .options ul").toggle();
});

//SELECT OPTIONS AND HIDE OPTION AFTER SELECTION
$(".drop-down-dest .options ul li a").click(function(e) {
    e.preventDefault();
    var text = $(this).html();
    $(this).closest(".drop-down-dest").find(".selected a span").html(text);
    //$(".drop-down-dest .selected a span").html(text);
     $(this).closest(".drop-down-dest").find(".options .list-wrapper").hide();
}); 


//HIDE OPTIONS IF CLICKED ANYWHERE ELSE ON PAGE
$(document).on('click touchstart', function(e) {
    var $clicked = $(e.target);
    if (! $clicked.parents().hasClass("drop-down-dest"))
        $(".drop-down-dest .options .list-wrapper").hide();
});



$('body').on('click','.rent-start',function(){
  var bikeid = $('#bike_type').val();
  console.log(bikeid);

  $('body').find('form.form-rent').request('onRentBike', {
      data: {
        bikeid: bikeid,
      },
      success: function(response){
        alert(response);
      },    
  });  
});

$(document).ready(function(){
  $('.side-nav').show();
  if(!$('main').hasClass('pg-home')){
    var url = window.location.pathname, 
        urlRegExp = new RegExp(url.replace(/\/$/,'') + "$"); // create regexp to match current url pathname and remove trailing slash if present as it could collide with the link in navigation in case trailing slash wasn't present there
        // now grab every link from the navigation
        $('.item a').each(function(){
            // and test its normalized href against the url pathname regexp
            if(urlRegExp.test(this.href.replace(/\/$/,''))){
                $(this).closest('li').addClass('active');
            }
        });
  }
});

//-- SEARCH

if ($(window).width() < 767) {
  $('.search-wrapper').click(function(){
    $('.search').addClass('wideSearch'); 
    $('body').addClass('with-wideSearch');  
  });
  $(document, $('.close-search')).on('click touchstart', function(event) {
      if (!$(event.target).closest('.search-wrapper').length && $(event.target) !== $('.resultsData').length) {
          // Hide the menus.
         $('.search').removeClass('wideSearch'); 
         $('body').removeClass('with-wideSearch'); 
         $('.resultsData').hide(); 
      }
      else {
        return;
      }
  });

}

//------ BOOK NOW steps

$('.required').change(function() {
    var x = $(this).closest('.step-wrapper').find('.required');
    var xcheck = $(this).closest('.step-wrapper').find('.required-check');
    $stepBtn = $(this).closest('.step-wrapper').find('.book-next');
    if($stepBtn.hasClass('step-click')) {
         x.each(function() {
          if(!$(this).val()) {
              $(this).parent().addClass("errorInput");
              next = false;
          }
          else {
               $(this).parent().removeClass("errorInput");
          }
          xcheck.each(function() {
              if($('.check-wrapper input:checked').length == 0) {
                  $(this).parent().addClass("errorInput");
                  next = false;
              }
              else {
                   $(this).parent().removeClass("errorInput");
              }
          });
      });
    }
    else {
      return;
    }
   
});

$('.book-next,.book-start').click(function(){
    
    // Save it!

    var stepNum = $(this).data('nx');
    var nextStep = '.step-' + stepNum;
    //find all input
    var x = $(this).closest('.step-wrapper').find('.required');
    var xcheck = $(this).closest('.step-wrapper').find('.required-check');
    $(this).addClass('step-click');
    var next = true;
    x.each(function() {
        if(!$(this).val()) {
            $(this).parent().addClass("errorInput");
            next = false;
        }
        else {
             $(this).parent().removeClass("errorInput");
        }
    });
    xcheck.each(function() {
        if($('.check-wrapper input:checked').length == 0) {
            $(this).parent().addClass("errorInput");
            next = false;
        }
        else {
             $(this).parent().removeClass("errorInput");
        }
    });
    //console.log($('.book-pay').find('#rent_date').children('option:selected').attr('data-id'));
    if(next) {
        if($(this).hasClass('book-start')){
          if (confirm('Are you sure?')) {
            var $this = $(this);
            var tourid = $('.book-pay').find('#tourid').val();
            var name = $('.book-pay').find('#name').val();
            var phone = $('.book-pay').find('#phone').val();
            var num_people = $('.book-pay').find('#num_people').val();
            var email = $('.book-pay').find('#email').val();
            var when = $('.book-pay').find('#when').get(0).value;
            var rent_date = $('.book-pay').find('#rent_date').val();
            var hear_from = $('.book-pay').find('#hear_from').val();
            var group_type = $('.book-pay').find('#group_type').val();
            var other = $('.book-pay').find('#other').val();
            var requests = $('.book-pay').find('#requests').val();
            var rateid = $('.book-pay').find('#rateid').val();
            var pricingid = $('.book-pay').find('#group_type').children('option:selected').attr('data-id');
            var startid = $('.book-pay').find('#rent_date').children('option:selected').attr('data-id');

            console.log(pricingid);
            
            var price = $('.book-pay').find('#tourprice').val();
            var payment = '';

            if($this.data('payment') == 'paypal'){ // pay now
              payment = 'paypal'; 
            }
            else{ //pay later
              payment = 'later';
            }
            console.log(payment);
            $('.preloader-paypal').fadeIn();
            $('body').find('form.form-book').request('onBook', { //book now
                data: {
                  book_id: tourid,
                  name:name,
                  phone:phone,
                  num_people:num_people,
                  email:email,
                  when:when,
                  rent_date:rent_date,
                  hear_from:hear_from,
                  group_type:group_type,
                  other:other,
                  requests:requests,
                  rateid:rateid,
                  pricingid:pricingid,
                  startid:startid,
                  payment:payment,
                  price:price 
                },
                success: function(response){
                  console.log(response);
                  $('.preloader-paypal img').hide();
                  $('.preloader-paypal').fadeOut();
                  if(response.result){
                    location.replace(response.result);
                  }
                  else{
                    location.replace(response);
                  }
                },  
                error: function(x,y,z){
                  console.log(x,y,z);
                  $('.preloader-paypal img').hide();
                  $('.preloader-paypal').fadeOut();
                  location.replace('/error');
                }      

            });     
          }       
        }
        else{
            $(this).closest('.step').addClass('hideMove');
            $(nextStep).addClass('moveIt'); 
        }
    }
});

$('.book-prev').click(function(){
    var stepNum = $(this).data('pr');
    var backStep = '.step-' + (stepNum - 1);
    $(this).closest('.step').removeClass('moveIt');
    $(backStep).removeClass('hideMove');
});

$('input[name="payment"]').change(function(){
  $('.check-wrapper').removeClass('errorInput');
  if ($('input[id=p-now]:checked').length > 0) {
      // do something header
      $(this).closest('.step-wrapper').find('.book-next').attr("data-payment", "paypal");
  }
  else {
    //---
  }
});


//-- Search click scroll to top
if($(window).width() < 767) {
  $('.input-date-wrapper, .pick-number').click(function(){
    console.log(111222);
   $('html, body').animate({
      scrollTop: $(".note-search").offset().top - 100
    }, 'slow');
          return false;
  });
}



$('.drop-down-num').click(function(){
  $('#note-datepicker').hide();
});

$('.input-date-wrapper, .drop-where').click(function(){
  $('.drop-down-num .options .list-wrapper').hide();
});




$('.step-3 .input-wrapper').click(function(){
  console.log( $('.step-3 .step-wrapper').scrollTop)
  $('.step-3 .step-wrapper').scrollTop = -10;
});
