$("#vin_input").on('keyup', function (e) {
    if (e.keyCode == 13) {
        var data = $('#vin_input').val();
        $.get("https://vpic.nhtsa.dot.gov/api/vehicles/decodevin/" + data + "?format=json",
            handleDecodedVin)
    }
});
function handleDecodedVin(response){
    var make, model, year;
    var res = response["Results"];
    for(var i =0; i < res.length; i++){
        var resi = res[i];
        var name = resi["Variable"];
        switch(name){
            case "Make"://5
                make = resi["Value"];
                break;
            case "Model"://7
                model = resi["Value"];
                break;
            case "Model Year"://8
                year = resi["Value"]
        }
    }
    console.log(data);
}