$(document).ready(function(){
    $('#residentbtn').click(function(){
        $('.log-in-card').hide();
        $('.submit-button').click(function(event){
            event.preventDefault();
            let resident_id = $('#name').val();
            let resident_password = $('#email').val();

            $.ajax("backend/login.php", {
                type: "POST",
                data: {
                    residentID: resident_id,
                    residentPass: resident_password
                }
            }
            ).done(function(response){
                console.log(response);
                if(response === "<script> alert('User not found');</script>"){
                    $('#alertbox').html(response);
                    $('.w-form-fail').show();
                } if(response === "<script>alert('Logged in successfully!');</script>") {
                    $('#alertbox').html(response);
                    window.location.replace("confirmation.php");
                } if(response === "<script>alert('Username or password incorrect!');</script>"){
                    $('#alertbox').html(response);
                    $('.w-form-fail').show();
                } /*else {
                    //$('#alertbox').html(response);
                    $('.w-form-fail').show();
                }*/
            }
            ).fail(function(response){
                alert('Something went wrong with a request to the server');
            });
        });
    });

    $('#continue-button').click(function(){
        window.location.replace("old-home.php");
    });

    $('.sign-out').click(function(){
        window.location.replace("index.php");
    });
});