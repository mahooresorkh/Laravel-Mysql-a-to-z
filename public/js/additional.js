$(document).ready(function(){
    $('#dropdown_btn').click(function(){
        $('#dropdown_menu').slideToggle(150);
    });

    

/** Gregorian & Jalali (Hijri_Shamsi,Solar) Date Converter Functions
Author: JDF.SCR.IR =>> Download Full Version : http://jdf.scr.ir/jdf
License: GNU/LGPL _ Open Source & Free _ Version: 2.73 : [2019=1398]
--------------------------------------------------------------------
1461 = 365*4 + 4/4   &  146097 = 365*400 + 400/4 - 400/100 + 400/400
12053 = 365*33 + 32/4    &    36524 = 365*100 + 100/4 - 100/100   */

//januery number is 1
var clock = 0;
var today = 0; 

function gregorian_to_jalali(gy,gm,gd){
    var g_d_m,jy,jm,jd,gy2,days;
    g_d_m=[0,31,59,90,120,151,181,212,243,273,304,334];
    if(gy > 1600){
     jy=979;
     gy-=1600;
    }else{
     jy=0;
     gy-=621;
    }
    gy2=(gm > 2)?(gy+1):gy;
    days=(365*gy) +(parseInt((gy2+3)/4)) -(parseInt((gy2+99)/100)) +(parseInt((gy2+399)/400)) -80 +gd +g_d_m[gm-1];
    jy+=33*(parseInt(days/12053)); 
    days%=12053;
    jy+=4*(parseInt(days/1461));
    days%=1461;
    if(days > 365){
     jy+=parseInt((days-1)/365);
     days=(days-1)%365;
    }
    jm=(days < 186)?1+parseInt(days/31):7+parseInt((days-186)/30);
    jd=1+((days < 186)?(days%31):((days-186)%30));
    return `${jy}/${jm}/${jd}`;
   }
    
   setInterval(function(){
        d = new Date();
        today = gregorian_to_jalali(d.getFullYear(),d.getUTCMonth()+1,d.getDate())
        minutes = d.getMinutes();
        switch (minutes) {
            case 0:
                minutes = '00'
                break;
            case 1: 
                minutes = '01'
                break;
            case 2: 
                minutes = '02'
                break;
            case 3: 
                minutes = '03'
                break;
            case 4: 
                minutes = '04'
                break;
            case 5: 
                minutes = '05'
                break;    
            case 6: 
                minutes = '06'
                break;
            case 7: 
                minutes = '07'
                break;
            case 8: 
                minutes = '08'
                break;
            case 9: 
                minutes = '09'
                break;

            default:
                break;
        }
        clock = `${d.getHours()} : ${minutes}`
        $('#top_bar > h4').html(`${today} <br> ${clock}`)
   },1000);



 // set the elements to be in the center of the screen 
   var formHeight = $('.login_box').height();
   var browserHeight = $(window).height();
   if(browserHeight>formHeight){
    $('.login_box').css({'marginTop':((browserHeight-formHeight)/2)+'px'});
   }

   formHeight = $('.register_box').height();
   browserHeight = $(window).height();
   if(browserHeight>formHeight){
    $('.register_box').css({'marginTop':((browserHeight-formHeight)/2)+'px'});
   }

   formHeight = $('.verification_box').height();
   browserHeight = $(window).height();
   if(browserHeight>formHeight){
    $('.verification_box').css({'marginTop':((browserHeight-formHeight)/2)+'px'});
   }

   formHeight = $('.create_post_box').height();
   browserHeight = $(window).height();
   if(browserHeight>formHeight){
    $('.create_post_box').css({'marginTop':((browserHeight-formHeight)/2)+'px'});
   }

   formHeight = $('.edit_post_box').height();
   browserHeight = $(window).height();
   if(browserHeight>formHeight){
    $('.edit_post_box').css({'marginTop':((browserHeight-formHeight)/2)+'px'});
   }





// disable the upload_input if checkbox is checked 

   $('#disable_image_upload').click(function(event){
        console.log($( "#upload_post_image" ).prop( "disabled", event.target.checked ));
   });

   $('#disable_image_upload').click(function(event){
    console.log($( "#upload_profile_image" ).prop( "disabled", event.target.checked ));
   });


// ****************************************************************************
// when fetch method is launched we can't toggle toast_users_box instantly because
// the box will be shown and there is nothing in it 
// and after a while the fetched users list will pop into the box 
// and a lag will happen
// to prevent that an interval object called "tillFetchIsCompleted" is used 
// it checks once in 20 milliseconds to see if the fetch process is completed 
// and when it is (div with id = fetch_is_completed receives innerHTML of true)
// then a settimeout method is activated to ensure that all uesrslist has been placed in DOM 
// and the height of toast_users_box is fixed 
// after the above procedure it toggles toast_users_box 

   $('.user_search_btn').click(function(){
    options = { to: { width: 30, height: 20 } };

    var tillFetchIsCompleted = setInterval(function(){
        $('html').css({'cursor': 'wait'});
        if($('#fetch_is_completed').text()=='true'){

            setTimeout(function(){
                var toastHeight = $('.toast_users_box').height();
                var toastWidth = $('.toast_users_box').width();
                var browserWidth = $(window).width();     
                $('.toast_users_box').css({'top':((browserHeight-toastHeight)/2)+'px', 'left': ((browserWidth-toastWidth)/2)+'px'});
                $("#root > *").not("#root > .toast_users_box").css({'pointer-events': 'none'});
                $( ".toast_users_box" ).toggle('size', options, 500); 
                $('html').css({'cursor': 'default'});
            },1000);
            
                
            clearInterval(tillFetchIsCompleted);
        }    
    },20);

    });
    // ****************************************************************************


    $('.close_toast_users').click(function(){
    options = { to: { width: 30, height: 20 } };
    $( ".toast_users_box" ).toggle('size', options, 500);
    $('#fetch_is_completed').html('false');
    $("#root > *").not("#root > .toast_users_box").css({'pointer-events': 'auto'});
    });


    // just like the above for links of interested people
    // only the difference is: when interested-link elements are loaded in DOM their arrtibute still
    // has not set. therfore a setTimeOut method should be used 
    setTimeout(function(){
        $('.interested-link').click(function(){
            options = { to: { width: 30, height: 20 } };
        
            var tillFetchIsCompleted = setInterval(function(){
                $('html').css({'cursor': 'wait'});
                if($('#fetch_is_completed').text()=='true'){
        
                    setTimeout(function(){
                        var toastHeight = $('.toast_interested_box').height();
                        var toastWidth = $('.toast_interested_box').width();
                        var browserWidth = $(window).width();     
                        $('.toast_interested_box').css({'top':((browserHeight-toastHeight)/2)+'px', 'left': ((browserWidth-toastWidth)/2)+'px'});
                        $("#root > *").css({'pointer-events': 'none'});
                        $(".toast_interested_box").css({'pointer-events': 'auto'});
                        $( ".toast_interested_box" ).toggle('size', options, 500); 
                        $('html').css({'cursor': 'default'});
                    },1000);
                    
                        
                    clearInterval(tillFetchIsCompleted);
                }    
            },20);
        
            }
        
        );
    },2000);

    $('.close_toast_interested').click(function(){
        options = { to: { width: 30, height: 20 } };
        $( ".toast_interested_box" ).toggle('size', options, 500);
        $('#fetch_is_completed').html('false');
        $("#root > *").css({'pointer-events': 'auto'});
        });
    

        var leftTime = -25*60*1000;
                     countDown = setInterval(function(){
                        var d = new Date(leftTime);
                        var seconds = d.getSeconds();

                        switch (seconds) {
                            case 0:
                                seconds = '00'
                                break;
                            case 1:
                                seconds = '01'
                                break; 
                            case 2:
                                seconds = '02'
                                break;
                            case 3:
                                seconds = '03'
                                break;
                            case 4:
                                seconds = '04'
                                break;
                            case 5:
                                seconds = '05'
                                break;
                            case 6:
                                seconds = '06'
                                break;
                            case 7:
                                seconds = '07'
                                break;            
                            case 8:
                                seconds = '08'
                                break;
                            case 9:
                                seconds = '09'
                                break;
                                
                            default:
                                break;
                        }

                        $('#countdown').text('0' +  d.getMinutes() + ' : ' + seconds);
                        leftTime -= 1000;
                        if(d.getMinutes()==0 && d.getSeconds()==0 && d.getMilliseconds()==0){
                            location.reload();
                        }
                     },1000);



});






