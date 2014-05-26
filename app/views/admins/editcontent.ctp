<form method="post" action="<? echo $html->url('editcontent') ?>" > 
<table>
<? echo $form->hidden('Contents.id',array('value'=>$data[0]['contents']['id']))?>
<? echo $form->hidden('Contents.type',array('value'=>'contents'))?>
<tr><td>Title</td><td><? echo $form->input('Contents.title',array('label'=>false,'value'=>$data[0]['contents']['title']))?></td></tr>
<tr><td>Content</td><td><? echo $form->textarea('Contents.matter',array('label'=>false,'value'=>$data[0]['contents']['matter']))?></td></tr>
<tr><td>Isactive</td><td>
<select name="data[Contents][isactive]" id="ContentsIsactive">
<option value="Y" <? if($data[0]['contents']['isactive']=='Y') echo "Selected"; ?>>Yes</option>
<option value="N" <? if($data[0]['contents']['isactive']=='N') echo "Selected"; ?>>No</option>
</select>

</td></tr>
<tr><td>Catorder</td><td><? echo $form->input('Contents.catorder',array('label'=>false,'value'=>$data[0]['contents']['catorder']))?></td></tr>
<tr><td>Isactive</td><td>
<select name="data[Contents][onhome]" id="ContentsIsactive">
<option value="Y" <? if($data[0]['contents']['onhome']=='Y') echo "Selected"; ?>>Yes</option>
<option value="N" <? if($data[0]['contents']['onhome']=='N') echo "Selected"; ?>>No</option>
</select>

</td></tr>
<tr><td colspan="=2"><? echo $form->Submit('Update') ?></td></tr>
</table>
</form>


<form method="post" action="<? echo $html->url('editcontents') ?>" > 
<table>
<? echo $form->hidden('Images.id',array('value'=>$data[0]['contents']['id']))?>
<? echo $form->hidden('Contents.type',array('value'=>'images'))?>
<tr><td>Home Image</td><td><?php echo $form->file('Images.photoname0', array('size' => '40'));?></td></tr>
<tr><td>Inner Big Image</td><td><?php echo $form->file('Images.photoname1', array('size' => '40'));?></td></tr>
<tr><td>Inner 1 thumbnail</td><td>
<?php echo $form->file('Images.photoname2', array('size' => '40'));?>

</td></tr>
<tr><td>Inner 2 thumbnail</td><td><?php echo $form->file('Images.photoname3', array('size' => '40'));?></td></tr>
<tr><td>Inner 3 thumbnail</td><td>
<?php echo $form->file('Images.photoname4', array('size' => '40'));?>

</td></tr>
<tr><td colspan="=2"><? echo $form->Submit('Update') ?></td></tr>
</table>
</form>