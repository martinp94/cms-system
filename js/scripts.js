$(() => {

ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );


function loadUsersOnline() {
	$.get("/cms/index/usersonline", function(data) {
		const displayUsersOnline = data.trim();
		console.log(displayUsersOnline);
		$(".users_online").html("Users Online: " + displayUsersOnline);
	});
}


setInterval(() => {
	loadUsersOnline();
}, 1000);
	



});

