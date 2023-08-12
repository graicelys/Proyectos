$(document).ready(function() {

        console.log("hola");
        var audio = $('#myaudio').get(0);
        var isPlayed = false;
        
        $(document).on('click',function() {
                               
                if (! isPlayed){
                audio.play();
                isPlayed = true;  
                }                          
        });
});