<div id="content">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><?php echo $this->renderElement('leftmenu',$left); ?></td>
				
					
					<td valign="top" width="680">
					<div class="spacer"></div>
					<table width="100%" border="0" >
						  <tr bgcolor="#CCCCCC">
							<td align="center">Title</td>
							<td align="center">Content</td>
							<td align="center">IsActive</td>
							<td align="center">OnHome</td>
							<td align="center">Order</td>
							<td align="center">Action</td>
						  </tr>
						  <? if(!empty($data)){
						  foreach($data as $list) { ?>
						  <tr>
							<td><? echo $list['contents']['title'] ?></td>
							<td><? echo substr($list['contents']['matter'],0,50) ?></td>
							<td><? echo $list['contents']['isactive'] ?></td>
							<td><? echo $list['contents']['onhome'] ?></td>
							<td><? echo $list['contents']['catorder'] ?></td>
							<td><? echo  $html->link('EDIT',"editcontent/".$list['contents']['id'])?> | <? echo $html->link('DELETE',"deletecategory/".$list['contents']['id'])?></td>
						  </tr>
						  <? } 
						  }else{?>
						  <tr><td colspan="6" align="center">No Record found</td></tr>
						  <? } ?> 
					</table>

					<div class="spacer"></div>
					</td>
			</tr>
		</table>
</div>					
