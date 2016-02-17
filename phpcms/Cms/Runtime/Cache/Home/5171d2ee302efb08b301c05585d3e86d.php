<?php if (!defined('THINK_PATH')) exit();?><table width="100%">
<tr>
	<td colspan="2">
		<form action="/index.php/Home/Admin/ddel" method="post">
			<table width="100%"  class="cont tr_color">
				<tr>
					<th><a href="/index.php/Home/Admin/ajaxPage/ow/<?php  if($_GET['ow']=='desc'){ echo 'asc'; }else{ echo 'desc'; } ?>">排序</a></th>
					<th>管理员名称</th>
					<th>所属角色</th>                                                     
					<th>操作</th>
				</tr>
				<?php foreach($users as $v){?>
				<tr align="center" class="d">
					<td>
					<?php if($v['a_id']!=1){?>
					<input type="checkbox" name="ids[]" value="<?php echo $v['a_id']?>" class="sel"/>
					<?php }?>
					
					<?php echo $v['a_id']?></td>
					<td><?php echo $v['a_username']?></td>
					<td><?php echo $v['r_name']?></td>                                                       
					<td>
					<?php if($v['a_id']!=1){?>
					<a href="/index.php/Home/Admin/edit/id/<?php echo $v['a_id']?>">编辑</a> | <a href="/index.php/Home/Admin/del/id/<?php echo $v['a_id']?>"> 删除</a>                                                        
					<?php }?>
					</td>
				</tr>
				<?php }?>
				<tr><td align="center"><input type="checkbox" id="selall"/>全选</td><td colspan="3"><input type="submit" value="删除所选"/></td></tr>
				<tr><td align='center' colspan='4'>
				<?php echo $page;?>
				</td></tr>
			</table>
		</form>
	</td>
</tr>
</table>