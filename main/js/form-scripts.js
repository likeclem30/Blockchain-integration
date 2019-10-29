$("#SigninForm").validator().on("submit", function (event) {
    if (event.isDefaultPrevented()) {
        // handle the invalid form...
        formError();
        submitMSG(false, "Did you fill in the form properly?");
    } else {
        // everything looks good!
        event.preventDefault();
        submitForm();
    }
});


function submitForm(){
    // Initiate Variables With Form Content
    var semail = $("#semail").val();
    var spassword = $("#spassword").val();
    var cpassword = $("#cpassword").val();

    $.ajax({
        type: "POST",
        url: "http://192.168.64.2/blockchain/application/main/php/form-process.php",
        data: "semail=" + semail + "&spassword=" + spassword + "&cpassword=" + cpassword,
        success : function(text){
            if (text == "success"){
                formSuccess();
            } else {
                formError();
                submitMSG(false,text);
            }
        }
    });
}

function formSuccess(){
    $("#SigninForm")[0].reset();
    submitMSG(true, "Message Submitted!")
}

function formError(){
    $("#SigninForm").removeClass().addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
        $(this).removeClass();
    });
}

function submitMSG(valid, msg){
    if(valid){
        var msgClasses = "h3 text-center tada animated text-success";
    } else {
        var msgClasses = "h3 text-center text-danger";
    }
    $("#msgSubmit").removeClass().addClass(msgClasses).text(msg);
}