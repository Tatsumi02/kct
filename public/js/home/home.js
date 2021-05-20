$(()=>{

    $('#but').click(()=>{
        $('#not').html('<img src="'+ $('#jax').val() +'" />')
    })
    
    $('#text_var').html('<span style="background:black; color:white; padding:5px; opacity:0.8;">Ameliorer votre creativité</span>').show('slow').css('padding','1%');
    temps = 30;
    let compteur = setInterval(()=>{
        --temps;
        if(temps == 20)  $('#text_var').html('<span style="background:orange; padding:5px; color:white; opacity:0.8;">Des univers extrats</span>').show('slow');
        if(temps == 10) $('#text_var').html('<span style="background:rgb(55,155,255); color:white; padding:5px; opacity:0.8;">Des communautés de passionnés</span>').show('slow');
        if(temps == 0) { 
            $('#text_var').html('<span style="background:black; color:white; padding:5px; opacity:0.8;">Ameliorer votre creativité</span>').show('slow').css('padding','1%');
            temps = 30;
         }
    },300);

    
})