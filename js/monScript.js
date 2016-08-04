 var id = 0;
$(document).ready( function() {

setInterval(checkMessage,1000);
$("#formchat").submit(function () {
$.ajax({
    type: "POST",
    url: "utilities/minichattest.php",
    data: "pseudo="+$("#pseudo").val()+"&message="+$("#message").val()
});
return false;
});
});

function checkMessage() {
$.ajax({
    type: "POST",
    dataType: 'json',
    url: "utilities/minichatgetMessages.php",
    data: "id="+id,
    success: function(d) {
        id = d.id;
        $("#messages").prepend(d.message);
    }
});

}