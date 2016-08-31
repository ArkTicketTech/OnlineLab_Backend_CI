<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script src="<?php echo base_url('assets/bootstrap-table/bootstrap-table.min.js')?>"></script>
<link href="<?php echo base_url('assets/bootstrap-table/bootstrap-table.min.css')?>" rel="stylesheet">
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
					<td><?php if($type == 'all') echo "<a class='reserve btn btn-primary'>预约</a>"; if($type == 'reserved') echo "<a class='btn btn-primary' href='".base_url('lab')."/".$r['lab_id']."'>开始</a>"; if($type == 'finished') echo "<span class='upload btn btn-primary' onclick='upload(".$r['lab_id'].")' >上传实验报告</span>";?></td>
				</tr>
			<?php
				}
			?>
	    </tbody>
	</table>


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
</script>

</body>
</html>