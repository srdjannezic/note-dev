$(document).ready(function(){

});

//filter
$('.note-filter').on('click','.filter__box__list > li',function(){
	$(this).toggleClass('active');
	filterTours(getFilterFields());
});

$('.note-filter').on('change','.styles',function(){
	$(this).toggleClass('active');
	filterTours(getFilterFields());
});

$('.sort-box').on('change','select',function(){
	filterTours(getFilterFields());
});

// Range slider
$(".js-range-slider").ionRangeSlider({
    type: "double",
    min: 0,
    max: 500,
    onFinish: function (data) {
    	$(".js-range-slider").attr('data-pricerange',data.from + '-' + data.to)
    	filterTours(getFilterFields(data.from + '-' + data.to));
    },
});

$("body").on('click','.dest-option > a',function(e){
	document.getElementById('hidden-dest').value = $(this).data('dest');
});

$("body").on('click','.many-option > a',function(e){
	document.getElementById('hidden-many').value = $(this).data('many');
});

function getFilterFields(price="0-99999999"){
	var actives = [];
	if(price == "0-99999999" && $(".js-range-slider").attr('data-pricerange')){
		price = $(".js-range-slider").attr('data-pricerange');
	}
	actives['destinations'] = $('.filter-dest > li.active').get();
	actives['durations'] = $('.filter-dur > li.active').get();
	actives['transportations'] = $('.filter-trans > li.active').get();
	actives['types'] = $('.filter-type > li.active').get();
	actives['numpp'] = $('.filter-numpp > li.active').get();
	actives['styles'] = $('.styles:checked').get();
	actives['price'] = [price];
	//sort
	actives['sort'] = $('.sort-box > select').get(0).value;
	return actives;
}



function filterTours(filter){
	var values = fieldsToArray(filter);
	console.log(filter['sort']);
	$('body').find('form.form-filter').request('onFilterTours', {
	  data: {
	  	type:'filter',
	  	values:values,
	  	sort:filter['sort']
	  },
      update:{
        'tours/tours':'.itemList',
      },
	  success: function(response){
	  	$('.res-count').html(response.length);
	  	$('.filterTours').attr('data-last',response.last);
	  	if(response.last <= 1) $('.load-more').hide();
	  	else $('.load-more').show();
	  	console.log(response);	
	  	$('.itemList').html(response['tours/tours']);
	  },    
	});  

}

function removeLocationHash(){
    var noHashURL = window.location.href.replace('#', '');
    window.history.replaceState('', document.title, noHashURL) 
}

function fieldsToArray(fields){
	var values = {};
	history.pushState("", document.title, window.location.pathname);

	values['destinations'] = {};
	values['durations'] = {};
	values['transportations'] = {};
	values['types'] = {};
	values['numpp'] = {};
	values['styles'] = {};
	values['price'] = {};
	values['sort'] = {};
	var url = '?filter';
	for (var arrayIndex in fields) {
		for(var subarray in fields[arrayIndex]){
			var val;
			if(arrayIndex == 'price'){
				val = fields[arrayIndex][subarray];
			}
			else{
				val = $(fields[arrayIndex][subarray]).data('item');
			}
			values[arrayIndex][subarray] = val;
			
			if(typeof val !== 'undefined'){
				url += '&'+arrayIndex+'[]'+'='+val;
			}
		}  		
	}
	window.location.hash = url;
	removeLocationHash();
	return values;
}
