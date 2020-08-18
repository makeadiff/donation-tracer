var api_base_url = 'http://localhost/MAD/api/index.php/v1/';
if(location.href.search('makeadiff.in') != -1) {
	api_base_url = "http://makeadiff.in/api/v1/";
	if(location.href.search('https') != -1) {
		api_base_url = "https://makeadiff.in/api/v1/";
	}
}
else if(location.href.search('makeadiff') != -1) { //Set up for Rohit's System
	api_base_url = "http://localhost/makeadiff/api/v1/";
}


function init() {
    console.log("Open")
	$(".delete").click(deleteDonation);
}

function basicAuth(xhr) {
    xhr.setRequestHeader ("Authorization", "Basic " + btoa("sulu.simulation@makeadiff.in:pass"));
}

function deleteDonation(e) {
    var ele = e.target;
    var donation_id = $(ele).attr('data-donation-id');

    console.log(donation_id)

    if(confirm("Are you sure you want to delete this donation?")) {
        $.ajax({
			"url": api_base_url + "donations/" + donation_id,
			"method": "DELETE",
			"beforeSend": basicAuth
		}).done(function (data) {
            alert("Donation Deleted")
            // document.location.reload();
        });
    }
}