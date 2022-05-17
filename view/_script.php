<!-- <script src="./assist/js/bundle.min.js"></script> -->

<script src="./assist/js/popper.min.js"></script>
<script src="./assist/js/bootstrap.min.js"></script>
<script src="./assist/js/jquery-3.6.0.min.js"></script>
<script src="./assist/js/select2.min.js"></script>
<script src="./assist/js/pwt-date.js"></script>
<script src="./assist/js/pwt-datepicker.js"></script>
<script src='./assist/js/highcharts.js'></script>
<script src="./assist/js/script.js"></script>
<script src="./assist/jquery-confirm/jquery-confirm.min.js"></script>

<script> 



$(document).ready(function() {

    // place this within dom ready function
    function showpanel() {     
        $('html, body').animate({
            scrollTop: $('.scroll').offset().top
        }, 20);
        return false;
   }
  
   // use setTimeout() to execute
   setTimeout(showpanel, 10)
  
  });

</script>


<script> 


jQuery(document).ready(function() {
    // Main.init();
    $(".select2").select2({allowClear:!0, height:'100%',dir:'rtl'});
});

   // For Date
   var dp;
    $(document).ready(function() {
        var options = {
            format : "YYYY-MM-DD",
            formatter : function(unix) {
                var pdate = new persianDate(unix);
                pdate.formatPersian = false;
                return pdate.format("YYYY-MM-DD");
                //return new persinDate(unix).format("YYYY/MM/DD");
            },
            daysTitleFormat : "YYYY MMMM",
            observer : true,
            sendOption : "p",
            //position : [2, 2],
            autoclose : true,
            toolbox : true,
            altField : "#alternateField",
            altFormat : "u",
            altFieldFormatter : function(unix) {
                var pdate = new persianDate(unix);
                pdate.formatPersian
                pdate.formatPersian = false;
                return pdate.format("YYYY-MM-DD");
            },
            onShow : function() {
                //console.log("user config onShow event ")
            },
            onHide : function() {
                //console.log("user config onHide event ")
            },
            onSelect : function(unix) {
               this.hide();
            }
        };
        $(".date").persianDatepicker(options);
        dp = $(".date").data("datepicker");
    });
    // $('.mdate').datepicker({format: 'yyyy-mm-dd'});



//  this code use for delete row in all system 
$(".deleted").click(function(e){
    e.preventDefault();
    const c_url =  $(this).attr('href');
    $.confirm({
        title: '<span class="bfont " > هشدار!   </span> ',
        content: '<span class="cfont " >  ریکارد مورد نظر حذف خواهد شد ؟  </span> ',
        rtl: true,
        closeIcon: true,
        animationBounce: 2, 
        backgroundDismissAnimation: 'glow',
        buttons: {
                confirm :  {
                text: '<span class="bfont"> تایید  </span>',
                action : function(){
                    window.location = c_url;
                }
            },
            cancel:  {
                text:'<span class="bfont"> لغو   </span>',
                action : function () {
                }
            }
        }
    });
});

$("form").submit(function(){
    $('button[type=submit]').attr('disabled', 'disabled');
    $('input[type=submit]').attr('disabled','disabled');
    $("form button[type='submit']").attr('disabled',true);
    $("form button[type='submit']").attr('type','button');
});


//  this code use for show and non show eye icon 

togg_icon = key => {

    if(key != ''){
        $.ajax({
            url : "ajax.php",
            method: 'post',
            data : {
                type: "CHANGE_IMG_ICON",
                key
            },success:function(response){
                //  nothing to do
            }
        });
    }
}

</script>

<?php if($SHOW_EYE == "HIDE"){ ?>
    <script> 
        $('.togg').toggleClass('priv');
        $('.eye_icon').toggleClass('priv');
    </script>
<?php } ?>

<!-- 
// END this code use for show and non show eye icon 
 -->