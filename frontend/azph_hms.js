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

    $('#log-issue').click(function(){
        window.location.replace("log-issue.php");
    });

    /*$('.w-nav-menu').click(function(){
        $('.w-nav-menu').show();
    });*/

    $('#submit-issue').click(function(event){

    });

    //DOWN HERE
    $('.dropdown-toggle').click(function(){
        $('.w-dropdown-list').show();
        $('.dropdown-toggle').addClass('w-dropdown-toggle');
        $('.w-dropdown-toggle').removeClass('dropdown-toggle');
    });

    $('.w-dropdown-toggle').click(function(){
        console.log('hih');
        $('.w-dropdown-list').hide();
        $('.w-dropdown-toggle').addClass('dropdown-toggle');
        $('.dropdown-toggle').removeClass('w-dropdown-toggle');
    });
});