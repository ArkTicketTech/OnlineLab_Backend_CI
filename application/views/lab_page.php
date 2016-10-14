<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script src="<?php echo base_url('assets/bootstrap-table/bootstrap-table.min.js')?>"></script>
<link href="<?php echo base_url('assets/bootstrap-table/bootstrap-table.min.css')?>" rel="stylesheet">
<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
<script src="http://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>

<style>
h1 {
    font-family:"微软雅黑";
    font-size:40px;
    margin:20px 0;
    border-bottom:solid 1px #ccc;
    padding-bottom:20px;
    letter-spacing:2px;
}
.time-item strong {
    background:#C71C60;
    color:#fff;
    line-height:49px;
    font-size:36px;
    font-family:Arial;
    padding:0 10px;
    margin-right:10px;
    border-radius:5px;
    box-shadow:1px 1px 3px rgba(0,0,0,0.2);
}
#day_show {
    float:left;
    line-height:49px;
    color:#c71c60;
    font-size:32px;
    margin:0 10px;
    font-family:Arial,Helvetica,sans-serif;
}
.item-title .unit {
    background:none;
    line-height:49px;
    font-size:24px;
    padding:0 10px;
    float:left;
}
</style>
<div class="time-item">
    <strong id="hour_show">0时</strong>
    <strong id="minute_show">0分</strong>
    <strong id="second_show">0秒</strong>
</div>
<div class="container">
<object width="100%" height="100%">
    <param name="lab" value="<?php echo base_url('public/weblab.swf')?>">
    <embed src="<?php echo base_url('public/weblab.swf')?>" width="100%" height="100%">
    </embed>
</object>
<a type="button" class="btn btn-primary" href="<?php echo base_url('lab/finished')?>">完成</a> 

</div>


<script type="text/javascript">
var intDiff = parseInt(3600);//倒计时总秒数量
function timer(intDiff){
    window.setInterval(function(){
    var day=0,
        hour=0,
        minute=0,
        second=0;//时间默认值        
    if(intDiff > 0){
        day = Math.floor(intDiff / (60 * 60 * 24));
        hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
        minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
        second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
    } else {
    	alert("时间到");
    	window.location.href="<?php echo base_url('lab/finished')?>";  
    }
    if (minute <= 9) minute = '0' + minute;
    if (second <= 9) second = '0' + second;
    $('#hour_show').html('<s id="h"></s>'+hour+'时');
    $('#minute_show').html('<s></s>'+minute+'分');
    $('#second_show').html('<s></s>'+second+'秒');
    intDiff--;
    }, 1000);
} 
$(function(){
    timer(intDiff);
});    
</script>

</body>
</html>