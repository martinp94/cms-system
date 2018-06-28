


$(() => {

if(document.querySelector("#editor")) {
	ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
}

if(document.querySelector("#selectAllBoxes")) {
	document.querySelector("#selectAllBoxes").addEventListener('change', selectAllBoxesHandler);

	function selectAllBoxesHandler(event) {

	    const boxes = document.querySelectorAll('.checkBoxes');

	    if(event.currentTarget.checked)
	        boxes.forEach(box => box.checked = true);
	    else
	        boxes.forEach(box => box.checked = false);
	}
}


const parser = new DOMParser();


const divBoxDomString = "<div id='load-screen'> <div id='loading'> </div> </div>";

const divBoxHtml = parser.parseFromString(divBoxDomString, 'text/html');

document.body.prepend(divBoxHtml.body.firstChild);

$("#load-screen").delay().fadeOut(600, () => $(this).remove());

function loadUsersOnline() {
	$.get("index.php?usersonline", function(data) {
		const displayUsersOnline = data.trim();
		console.log(displayUsersOnline);
		$(".users_online").html("Users Online: " + displayUsersOnline);
	});
}


setInterval(() => {
	loadUsersOnline();
}, 1000);





	

});
