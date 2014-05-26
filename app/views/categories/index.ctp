<div id="content">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><?php echo $this->renderElement('leftmenu',$left); ?></td>
				
					
					<td valign="top" width="680"><? echo $html->image('home1.jpg',array('width'=>'680'))?>
					<div class="spacer"></div>
					<h2>Welcome to the new Curedale.com</h2>
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Suspendisse varius felis nec ligula. Quisque hendrerit felis et orci. Aenean sit amet nunc. Cras tellus justo, dapibus eu, condimentum vitae, vestibulum molestie, justo. Donec nulla diam, tristique ac, porttitor non, laoreet a, risus. Proin lacinia, mauris ac pellentesque condimentum, nibh neque venenatis pede, vel ornare arcu neque eget enim. Proin eu felis. Mauris sodales sodales erat. Nullam eleifend, quam a ultricies pulvinar, quam nisl fringilla nulla, ac mattis leo quam id enim. Suspendisse consectetuer. Nullam augue. Phasellus eu augue. Ut fringilla risus at eros. Aliquam turpis libero, facilisis sollicitudin, pellentesque eget, rutrum ut, eros.<br />
						Aliquam erat volutpat. Suspendisse ut lacus. Sed fringilla consectetuer nunc. Aliquam viverra urna non sapien. Aliquam erat volutpat. Phasellus congue iaculis mauris. Phasellus at augue. Morbi ipsum pede, molestie sed, commodo ultrices, luctus et, eros. Integer risus elit, sagittis vel, ultricies eget, accumsan nec, magna. Vestibulum a nunc. Duis dignissim, purus non pharetra sodales, orci arcu scelerisque ligula, vitae viverra magna ligula at massa. Maecenas a quam non wisi laoreet consequat.</p>
					<div class="spacer"></div>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<!--<tr>
							<td><h2>News</h2></td>
							<td><h2>Futured Work</h2></td>
							<td>&nbsp;</td>
						</tr>-->
							
						
						
						<tr>
						<? 
						
						if(!empty($data)) 
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
	
	
	
	