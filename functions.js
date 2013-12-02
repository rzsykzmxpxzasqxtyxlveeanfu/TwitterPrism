$(function(){
	$("#add-term").load("add-term.php").effect("highlight");
	$("#dashboard").load("dashboard.php").effect("highlight");
});

function term(id){
	$("#term").load("term.php?termID="+ id).effect("highlight");
}

function show_tweets(id){
	$("#tweets").load("show_tweets.php?termID="+ id).effect("highlight");
}

function vote(id,type){
	$.ajax({
		type: "POST",
		url: "vote.php",
		data: "termID=" + id + "&vote=" + type,
		success: function(msg){
			$(".booth-"+ id).html("thx!").effect("highlight");
		}
	});
}

$(function(){
	$("#find").autocomplete({
		source: function(request, response){
			$.getJSON("search.php?term="+ request.term,function (data){
				response(data);
			});
		},
		select: function( event, ui ) {
			$("#term").load("term.php?termID="+ ui.item.value).effect("highlight");
			$("#find").val(ui.item.label);
		}
	})
});
