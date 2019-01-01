jQuery(document).ready(function($){
    $('#subscriber-form').submit(function(e){
        e.preventDefault();

        let subscriberData = $('#subscriber-form').serialize(); //Pega os dados do form

        $.ajax({

            type: 'post',
            url: $('#subscriber-form').attr('action'),
            data: subscriberData

        }).done(function(response){

            $('div#form-msg').text(response);
            $('#name').val('');
            $('#email').val('');

        }).fail(function(data){
            $('div#form-msg').text("Não foi possível se inscrever");
            return;

            if(data.response !== ''){
                $('div#form-msg').text(data.response);
            } else {
                $('div#form-msg').text('A mensagem não foi enviada!');                
            }

        });

    });
});