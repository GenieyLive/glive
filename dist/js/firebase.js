var geniey_host="https://geniey.firebaseio.com";
var geniey_auth="?auth=QMkHCLWoe8NhhWl9nF6CSzn4jTcKNTKBGriXLRAV";
function firebasePUT(source_url,source_data)
{
	var source_obj = JSON.stringify(source_data);
	$.ajax({
	method: "PUT",
	async:true,
	crossDomain:true,
	url: geniey_host+source_url+geniey_auth,
	data:source_obj,
	headers: {
		    "cache-control": "no-cache",
		  },
	success: function(data) {
		return data;
	},
	error: function (error) {
		console.log(error);
		return -1;
	}
	});
}

function firebaseGET(source_url,source_data)
{
	$.get( "test.cgi", { name: "John", time: "2pm" } )
  .done(function( data ) {
    alert( "Data Loaded: " + data );
  });
}