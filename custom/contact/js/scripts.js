function ShowPopup(){
    window.open('pop_up.php','mywindow','width=400,height=200');
}



function Close(){
    window.close();
}


function sendEmail(){
    if ( $("#send-message-form").valid() ){
        //alert("Ok");
        var from_email=$("#email").val();
        var subject=$("#subject").val();
        var message=$("#message").val();
        var response;
        
        $("#send").attr({
            disabled: "disabled"
        });        
        
        $.get("include/send_message.php?from_email=" + from_email + "&subject=" + subject + "&message=" + message, function(result) {		
                $("#result_send").hide("fast");

                if ( result ){
                    response="<h2><font color='green'>The message has been successfully sended!</font></h2>";
                    $("#result_send").html(response);
                    $("#result_send").slideDown(800);

                    setTimeout("window.close()",2000);
                }
                else{
                    $("#send").attr({
                        disabled: ""
                    });                    
                    response="<h2><font color='red'>An unexpected error occured. Please try again later!</font></h2>";
                    $("#result_send").html(response);
                    $("#result_send").slideDown(800);
                }                
	});
    }    
}


