<style>
#box1{
    border: solid red;
}
</style>

<div id="box1">testscreen</div>

<script src="js/jquery-1.11.3.js"></script>
<script>
    var w = window,
        d = document,
        e = d.documentElement,
        g = d.getElementsByTagName('body')[0],
        screenWidth = (w.innerWidth || e.clientWidth || g.clientWidth)-20,
        screenHeight = (w.innerHeight|| e.clientHeight|| g.clientHeight)-40;
    $(document).ready(function(){
        $("#box1").css("width", screenWidth);
        $("#box1").css("height", screenHeight);
    })

</script>
