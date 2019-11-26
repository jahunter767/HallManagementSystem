$(document).ready(function(){
    $('#residentbtn').click(function(){
        $('.log-in-card').hide();
        $('.submit-button').click(function(event){
            event.preventDefault();
            let resident_id = $('#name').val();
            let resident_password = $('#email').val();

            $.ajax("backend/azph_hms.php", {
                type: "POST",
                data: {
                    residentID: resident_id,
                    residentPass: resident_password
                }
            }
            ).done(function(response){
                //console.log(response);
                if(response === "<script> alert('User not found');</script>"){
                    $('.w-form-fail').show();
                } else {
                    $('body').html(response);
                }
            }
            ).fail(function(response){
                alert('Something went wrong with a request to the server');
            });
        });
    });
});