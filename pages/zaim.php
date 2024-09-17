<div class="brown_body">
    <header class="header header_white">
            <div class="container">
                <div class="row align__items__center justify__content__between">
                    <div class="row align__items__center">
                        <a href="#"><div ><div ><img src="img/menu_gray.svg" class="header_menu_zaim" alt=""></div></div></a>
                        <a href="#"><div ><div ><img src="img/logo.png" class="" alt=""></div></div></a>
                    </div>
                
                    <a href="#"><div ><div ><img src="img/user.png" class="header_user" alt=""></div></div></a> 
                </div>
            </div>
    </header>
    <section class="section">
        <div class="container">
            <div class="col-10">
            
                <div class="zaim_title">Получи займ до зарплаты с автоматическим погашением под 0,8% в день</div>
            
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <div class="white_block col-10 ">
                <div class="zaim flex_column justify__content__between" zaim-info = "zaim_sum">
                    <div class="row justify__content__between align__items__center">
                            <div class="zaim_lil_title">Сумма займа:</div>
                            <div class="zaim_block " >
                                <input class="zaim_input" type="text" >
                                <div class="zaim_placeholder"><span class="blue_text">1000</span> руб</div>
                            </div>
                    </div>
                    <div><input type="range" class="slider" id="slider" min="1000" max="30000" value="1000"></div>
                    <text class="zaim_description">Займ можно взять на сумму от 1 до 30 тыс руб</text>
                </div>
                <div class="zaim zaim_big flex_column justify__content__between" zaim-info = "zaim_date">
                    <div class="row justify__content__between align__items__center">
                        <div class="zaim_lil_title">Срок займа</div>
                        <div class="zaim_block " >
                                <input class="zaim_input" type="text" >
                                <div class="zaim_placeholder"><span class="blue_text">14</span> дней</div>
                            </div>
                    </div>
                    <div>
                        <input type="range" class="slider" id="slider" min="14" max="56" value="14">
                        <div class="row justify__content__between align__items__center">
                            <div>14 дней</div>
                            <div>35 дней</div>
                            <div>56 дней</div>
                        </div>
                    </div>
                
                    <div class="zaim_description">Займ будет автоматически погашен из первой зарплаты</div>
                </div>
            <div class="flex_column align__items__center">
                    <div class="zaim_btn justify__content__center">Получить деньги</div>
                </div>
        
            </div>
            <div class="col-10 brown_block ">
                <div class="row justify__content__between">
                    <div>Вы берете:</div>
                    <div><b id="zaim_sum">1000 </b> <b>руб</b></div>
                </div>
                <div class="row justify__content__between">
                    <div>Вы вернете:</div>
                    <div><b id="zaim_date">05 июля 2024</b></div>
                </div>
            </div>
        
        </div>
    </section>
</div>

<script>
    $(document).ready(function() {


        $(".zaim_block").click(function() {
            var zaim_block = $(this).find(".zaim_block");
            var zaim_input = $(this).find(".zaim_input");
            var placeholder = $(this).find(".zaim_placeholder");

            placeholder.hide();
            zaim_input.show();
            zaim_input.focus();
        });

 
});
$(".zaim_input").on('input', function() {
        var currentValue = $(this).val();
        

        var parentZaim = $(this).closest('.zaim');
        var slider = parentZaim.find(".slider");
        var infoZaim = parentZaim.attr("zaim-info");

        slider.val(currentValue).change();

        if(infoZaim == "zaim_date"){
            let dataZaim = getDateZaim(currentValue);
            $("#"+infoZaim).text(dataZaim);
        }else{
            $("#"+infoZaim).text(currentValue);
        }


});

$(".slider").on('input', function() {
    var currentValue = $(this).val();

    var parentZaim = $(this).closest('.zaim');
    var zaim_input = parentZaim.find(".zaim_input");
    var blue_text = parentZaim.find(".blue_text");
    var infoZaim = parentZaim.attr("zaim-info");

    
    zaim_input.val(currentValue).change();
    blue_text.text(currentValue).change();


    if(infoZaim == "zaim_date"){
        let dataZaim = getDateZaim(currentValue);
        $("#"+infoZaim).text(dataZaim);
    }else{
        $("#"+infoZaim).text(currentValue);
    }

   
});

function getDateZaim(days){
    var currentDate = new Date();
    
    currentDate.setDate(currentDate.getDate() + Number(days));
   
    var day = currentDate.getDate();
        var month = currentDate.toLocaleString('ru-RU', { month: 'long' }); 
        var year = currentDate.getFullYear();
        return `${day} ${month} ${year}`;
}



</script>