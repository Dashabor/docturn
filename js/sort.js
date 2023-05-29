//Функция сортировки
$(document).ready(function(){
    $("#sortDate").on('change', function(){
        var value = $(this).val();
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