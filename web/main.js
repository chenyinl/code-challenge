/**
 * JavaScript file for sending the username/password to REST API
 */

/**
 * Register the submit button to an Ajax call
 */
$(window).on('load', function() {
    $("#loginForm").submit(function(e) {
        
        // avoid to execute the actual submit of the form.
        e.preventDefault();
        
        // update the message box
        $("#messagebox").text("Please wait");
        
        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            success: function(returndata)
            {
                displayResult(returndata);
            }
        });
    });
});

/**
 * Display the result to the message box
 */
function displayResult(resultObj){
     
   if(resultObj.result=="success"){
       $("#messagebox").text(resultObj.public_message);
   }else{
       // if fails, Wait for 3 second to show the result
       setTimeout(function() { 
           $("#messagebox").text(resultObj.public_message) 
       }, 3000);
   }
}
