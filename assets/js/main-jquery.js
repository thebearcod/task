$(function() {

    $(document).on('submit', '.form-serf', function (event) {
        event.preventDefault();
        const start = new Date().getTime();
        const link = $('form .link').val();
        const vendor = $('form .vendor').val();
        const model = $('form .model').val();
        let count = 0;
        //console.log(link,vendor,model);

        let i = 65; //94
        function ajaxwithi(i) {
            link2 = link+'&page='+i;
            console.log(link2);

            jQuery.ajax({
                type: 'POST',
                url: 'assets/components/ajax/parsing.php',
                data: {
                    link: link2,
                    vendor: vendor,
                    model: model,
                    iteration: i
                },
                success: function(res) {
                    res = JSON.parse(res);
                    console.log(res);
                    count = count + res.count;
                    $('.result').prepend('<p>'+res.result+'<b>  Общее кол-во: '+count+'</b></p>');
                    if (i < 95) {
                        ajaxwithi(i + 1);
                    } else {
                        const end = new Date().getTime();
                        let timePars = Math.floor((end-start)/60000);
                        $('.result').append('<p><b>Парсинг закончен</b></p>');
                        $('.result-title').append('<p><b style="color: red;">Парсинг закончен!</b></p>');
                        $('.result-title').append('<p><b style="color: red;">Затраченное время: '+timePars+' мин.</b></p>');

                    }
                }
            });
        }

        ajaxwithi(i);

    });

}); // $(function()