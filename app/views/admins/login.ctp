
<?
if(isset($Error))
echo $Error;
?>
<form method="post" action="<? echo $html->url('/admin/login') ?>" > 
<table align="center">
<tr><td>Username</td><td><? echo $form->input("admin/username",array('label'=>false,'size'=>'15'))?></td></tr>
<tr><td>Password</td><td><? echo $form->password("admin/password",array('label'=>false,'size'=>'15'))?></td></tr>
<tr><td colspan="2"><? echo $form->submit("Login")?></td></tr>
</table>
</form>