$(document).ready(function(){
    $("#sortDate").on('change', function(){
        var value = $(this).val();
        //alert(value);

        $.ajax({
            url:"sort.php",
            type:"POST",
            data:'request=' + value,
            success:function(){
                location.reload();
            }
        });
    });
});