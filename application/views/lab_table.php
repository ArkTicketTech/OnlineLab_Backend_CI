<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script src="<?php echo base_url('assets/bootstrap-table/bootstrap-table.min.js')?>"></script>
<link href="<?php echo base_url('assets/bootstrap-table/bootstrap-table.min.css')?>" rel="stylesheet">
<link href="<?php echo base_url('assets/calendar.css')?>" rel="stylesheet">
<div class="container">
	<table data-toggle="table">
	    <thead>
	    <tr>
	        <th>实验名称</th>
	        <th>实验说明</th>
	        <?php if($lab_time != null) echo "<th>".$lab_time."</th>"; ?>
	        <th>操作</th>
	    </tr>
	    </thead>
	    <tbody>
			<?php
				$count = 0;
				foreach ($list as $r) {
					$count++;
			?>
				<tr>
					<td style="display:none;" class="index"><?php echo $r['id']?></th>
					<td><?php echo $r["name"];?></td>
					<td><?php echo "<a href=".base_url("public/labnote")."/".$r['id'].">下载</a>";?></td>
					<?php if($lab_time != null) echo "<td>"."<span>".$r["start_time"]."</span>"."</td>";?>
					<td><?php if($type == 'all') echo "<a class='reserve btn btn-primary' onclick='init_cal(".$r['id'].")' data-toggle='modal' data-target='#myModal'>预约</a>"; if($type == 'reserved') echo "<a class='btn btn-primary' href='".base_url('lab/ongoing/')."/".$r['lab_id']."'>开始</a>"; if($type == 'finished') echo "<span class='upload btn btn-primary' onclick='upload(".$r['lab_id'].")' >上传实验报告</span>";?></td>
				</tr>
			<?php
				}
			?>
	    </tbody>
	</table>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
    <div class="modal-dialog modal-lg"> 
        <div class="modal-content"> 
            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
                <h4 class="modal-title" id="myModalLabel">预约实验</h4> 
            </div> 
            <div style="padding-left:20px;padding-right:20px;height:;">
            	<div id="calobj" class="calobj"></div>
            </div> 
            <div class="modal-footer"> 
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button> 
                	<form method="post" action="<?php echo base_url('lab/toreserve/')?>" style="display:none;">
											<input name="time" id="selecttime" />
											<input name="date" id="selectdate" />
											<input name="lab" id="selectlab" />
											<input type="submit" id="posttime"/>
									</form>
                <button type="button" class="btn btn-primary" onclick="posttime()">提交更改</button> 
            </div> 
        </div><!-- /.modal-content --> 
    </div><!-- /.modal --> 
</div>

<div class="modal fade" id="timeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
    <div class="modal-dialog modal-lg"> 
        <div class="modal-content"> 
            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
                <h4 class="modal-title" id="reserveDate">预约实验</h4> 
            </div> 
            <div style="padding-left:20px;padding-right:20px;height:1400px;">
            	<div id="caltime" class="linear"><dl class="cal_date"><dd class="cal_date_content"></dd></dl></div>
            </div> 
            <div class="modal-footer"> 
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button> 
                <button type="button" class="btn btn-primary">提交更改</button> 
            </div> 
        </div><!-- /.modal-content --> 
    </div><!-- /.modal --> 
</div>

	<form method="post" action="" enctype="multipart/form-data" id="upload_file" style="display:none;">
			<input type="file" name="file" id="selectfile" onchange='uploadChange()'/>
			<input type="submit" id="submitfile"/>
	</form>
</div>
<script>
	function upload($id) {
		$("#upload_file").attr("action", "<?php echo base_url('lab/upload_report/')?>"+$id);
		$("#selectfile").click();
	}
	function uploadChange(){
		$("#submitfile").click();
	}
	function init_cal($id){
		choicelab = $id;
		var myCalendar = Calendar();
		myCalendar.init({cal_id: 'calobj'});
	}

time_buf = new Array();
block_buf = new Array();
choicelab = -1;
var choicedate = undefined;

function posttime(){
	if(!(time_buf.length>0 && !!choicedate && choicelab>=0)){
		alert("请先选择时间日期");
		return
	}
	$("#selectdate").val(choicedate);
	$("#selecttime").val(time_buf[0]);
	$("#selectlab").val(choicelab);
	$("#posttime").click();
}

Calendar = function(){
	//变量声明
	var wk = [' ', '日', '一', '二', '三', '四', '五', '六'];
	var html_content = '<div class="cal_title"><a href="javascript:;" class="cal_bt_year_left">&lt;&lt;</a><a href="javascript:;" class="cal_bt_month_left">&lt;</a><a href="javascript:;" class="cal_bt_month_right">&gt;</a><a href="javascript:;" class="cal_bt_year_right">&gt;&gt;</a><span class="cal_month"></span></div><dl class="cal_date"><dt class="cal_top"></dt><dd class="cal_date_content"></dd></dl>';
	var text_top = '';
	for(x in wk){
		text_top += '<span>' + wk[x] + '</span>';
	}
	now = new Date();
	var cur_year = now.getFullYear();
	var cur_month = now.getMonth();
	trans_buf = new Array();
	//此处有预留与HTML通信
	config = {
		cal_id : '',
	};
	return {
		init: function(customConfig){
			var that = this;
			$.extend(true, config, customConfig);
			$('#' + config.cal_id).append(html_content);
			$('#' + config.cal_id).addClass("linear");
			$('#' + config.cal_id + ' .cal_top').html(text_top);
			$('#' + config.cal_id + ' .cal_bt_month_left').bind('click',function(){
				if(--cur_month<0){
					cur_month=11;
					--cur_year;
				}
				that.getDateList();
			});
			$('#' + config.cal_id + ' .cal_bt_month_right').bind('click',function(){
				if(++cur_month==12){
					cur_month=0;
					++cur_year;
				}
				that.getDateList();
			});
			//notice relative:getDateList 'not standard'
			$('#' + config.cal_id + ' .cal_bt_year_left').bind('click',function(){
				that.getDateList(--cur_year);
			});
			$('#' + config.cal_id + ' .cal_bt_year_right').bind('click',function(){
				that.getDateList(++cur_year);
			});
			this.getDateList();
		},
		//warning to add parameter relative:getDateList
		getDateList: function() {
			var strCont ='';
			var pre_month = cur_month - 1;
			var pre_year = cur_year; //here the year means the year of next month or pre month
			if(pre_month<0){
				pre_month = pre_month + 12;
				pre_year--;
			}
			var nxt_month = cur_month + 1;
			var nxt_year = cur_year;
			if(nxt_month>11){
				nxt_month = pre_month - 12;
				nxt_year++;
			}
			var pre_monthdays = new Date(pre_year, pre_month+1, 0).getDate();
			var nxt_monthdays = new Date(nxt_year, nxt_month+1, 0).getDate();
			var monthdays = new Date(cur_year,cur_month+1,0).getDate();
			var lastday = new Date(cur_year,cur_month,monthdays).getDay();
			
			for (j=-new Date(cur_year,cur_month,1).getDay();j;j++) {
				strCont += '<span class="cal_date_gone">' + (pre_monthdays+j+1) + '</span>';
			}
			while(++j<= monthdays){
				strCont += '<span data-toggle="modal" data-target="#timeModal">' + j + '</span>';
			}
			if(lastday!=6)
			{
				for(j=1;j<=(6-lastday);j++)
					strCont += '<span class="cal_date_coming">' + j + '</span>';
			}
			
			$('#' + config.cal_id + ' .cal_date_content').html(strCont);
			var dateelements = $('#' + config.cal_id + ' .cal_date_content span').not('.cal_date_gone');
			//title line
			$('#' + config.cal_id + ' .cal_month').html(cur_year + "年" + (cur_month+1) + "月 " );
			//sign today
			if (now.getFullYear() == cur_year && now.getMonth() == cur_month) {
				dateelements.filter(':contains(' + now.getDate() + ')').eq(0).attr("class", "cal_date_now");
			}
			//read trans_buf data & display it;sort it may be more efficient but seems unnecessary
			for(x in trans_buf){
				if(trans_buf[x].getFullYear()==cur_year&&trans_buf[x].getMonth()==cur_month){
					dateelements[trans_buf[x].getDate()-1].className+=' cal_date_choice';
				}
			}
			//delete next two lines to disable the hover
			dateelements.bind('mouseenter', function(){
				$(this).addClass('cal_date_hover');
			});
			dateelements.bind('mouseleave', function(){
				dateelements.removeClass('cal_date_hover');
			});
			dateelements.bind('click', function(){
				$('#reserveDate').html(new Date(cur_year,cur_month,parseInt($(this).text())));
				var tmp ='';
				choicedate = new Date(cur_year,cur_month,parseInt($(this).text()));
				for (i=0;i<24;i++) {
					tmp +=  '<span style="font-size:15px;" class="region">'+i+':00~'+(i+1)+':00'+'</span>';
					tmp += '<span class="cal_timespan cal_'+i+'_'+j+'" time="'+i+'"></span>';
				}
				$('#caltime .cal_date_content').html(tmp);
				$('.cal_timespan').bind('click',function(){
					if($(this).hasClass('cal_date_block')) return;
					if(!$(this).hasClass('cal_date_choice')){
						$(this).parent().children().each(function() {
							if($(this).hasClass('cal_date_choice')){
								$(this).removeClass('cal_date_choice');
							}
						});
						time_buf = [];
						$(this).addClass('cal_date_choice');
						time_buf.push($(this).attr('time'));
					}else{
						$(this).removeClass('cal_date_choice');
						time_buf = new Array();
					}
				});

			});
		}
	}
}	

</script>

</body>
</html>