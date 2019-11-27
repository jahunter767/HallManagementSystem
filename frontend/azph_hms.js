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
            }).done(function(response){
                //console.log(response);
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
            }).fail(function(){
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
        event.preventDefault();
        let clust = $('#cluster').val();
        let cat = $('#classification').val();
        let desc = $('#Issue-description').val();
        let idN = $('#IDapp').val();
        /*console.log(clust);
        console.log(cat);*/
        //console.log(desc);
        //console.log(idN);
        $.ajax("backend/res-sub-issue.php", {
            type: "POST",
            data: {
                residentID: idN,
                cluster: clust,
                classification: cat,
                description: desc
            } 
        }).done(function(response){
            console.log(response);
            if(response === "FAILED"){
                $('.w-form-fail').show();
            } else {
                $('.w-form-done').show();
                window.location.replace("../old-home.php");
            }
        }).fail(function(){
            alert('Something went wrong with a request to the server');
            $('.w-form-fail').show();
        });
    });
});