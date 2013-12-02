$(function(){
	$("#add-term").load("ajax-add-term.php").effect("highlight");
	$("#dashboard").load("ajax-dashboard.php").effect("highlight");
});

function term(id){
	$("#term").load("ajax-term.php?termID="+ id).effect("highlight");
}

function show_tweets(id){
	$("#tweets").load("ajax-show-tweets.php?termID="+ id).effect("highlight");
}

function vote(id,type){
	$.ajax({
		type: "POST",
		url: "ajax-vote.php",
		data: "termID=" + id + "&vote=" + type,
		success: function(msg){
			$(".booth-"+ id).html("thx!").effect("highlight");
		}
	});
}

$(function(){
	$("#find").autocomplete({
		source: function(request, response){
			$.getJSON("ajax-search.php?term="+ request.term,function (data){
				response(data);
			});
		},
		select: function( event, ui ) {
			$("#term").load("ajax-term.php?termID="+ ui.item.value).effect("highlight");
			$("#find").val(ui.item.label);
		}
	})
});
