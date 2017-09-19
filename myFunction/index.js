/**
 * Created by User on 15/9/2560.
 */

var w = window,
    d = document,
    e = d.documentElement,
    g = d.getElementsByTagName('body')[0],
    screenWidth = (w.innerWidth || e.clientWidth || g.clientWidth),
    screenHeight = (w.innerHeight|| e.clientHeight|| g.clientHeight)-90;
$(document).ready(function(){
    $("div#main_div").css("width", screenWidth+10);
    $("div#main_div").css("height", screenHeight);
    $(".vstdate_h").css("height", screenHeight-85);
    $(".content_history").css("height", screenHeight-50);
    $(".content_history").css("width", screenWidth-230);



})

