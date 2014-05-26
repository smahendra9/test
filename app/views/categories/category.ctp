<div id="content">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><?php echo $this->renderElement('leftmenu',$left); ?></td>
				
					
					<td valign="top" width="680"><? echo $html->image('home1.jpg',array('width'=>'680'))?>
					<div class="spacer"></div>
					<h2><? echo $find[0]['subcategories']['subcatname']?></h2>
					<p><? if(isset($home)) echo $home ?></p>
					<div class="spacer"></div>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<!--<tr>
							<td><h2>News</h2></td>
							<td><h2>Futured Work</h2></td>
							<td>&nbsp;</td>
						</tr>-->
							
						
						
						<tr>
						<? if(!empty($data)) 
						   {
						    $i=0;
						     foreach($data as $list)
							 {
						?>
							<td width="197"><? echo $html->link($html->image('../photos/'.$list['images']['photoname'],array('border'=>'0')),'project/'.$list['contents']['id'],null,null,false)?>
								<div class="spacer2"></div>
								<h2><? echo $list['contents']['title'] ?></h2>
								<p><? echo substr($list['contents']['matter'],0,400) ?></p>
								<div class="spacer2"></div></td>
								
						<?    $i++;
						     if(($i%3)==0)
							   echo "</tr><tr>";
						     } 
						      
						  }
						   ?>		
					</tr>				
							
					
					</table>			
				</td>		
			</tr>
		</table>
	</div>
	
	
	
	