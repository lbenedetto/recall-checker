var proxy = 'https://cors-anywhere.herokuapp.com/';
//https://api.nhtsa.gov/vehicles/byVin?productDetail=all&data=none&vin=2GCEK133681303585&name=
$("#vin_input").on('keyup', function (e) {
    if (e.keyCode == 13) {
        var data = $('#vin_input').val();
	    $.get("https://vpic.nhtsa.dot.gov/api/vehicles/decodevin/" + data + "?format=json",
		    handleDecodedVin)
        $.get("https://api.nhtsa.gov/vehicles/byVin?productDetail=all&data=none&vin=" + data + "&name=",
	        handleRecallInfoNTSHA)
    }
});

function handleDecodedVin(response){
	var res = response["Results"];
	var make = res[5]["Value"];

}

function handleRecallInfoNTSHA(response){
    console.log(response);
}

//Ford
//https://owner.ford.com/sharedServices/decodevin.do?vin=1FTSW21R68EB99716
//https://owner.ford.com/sharedServices/recalls/query.do?country=USA&langscript=LATN&language=EN&region=US&vin=1FTSW21R68EB99716

//GM
//https://my.gm.com/services/2G1WF52E129159920/recalls