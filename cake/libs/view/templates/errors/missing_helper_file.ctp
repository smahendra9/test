<?php
/* SVN FILE: $Id: missing_helper_file.ctp 4605 2007-03-09 23:26:37Z phpnut $ */
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2005-2007, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright 2005-2007, Cake Software Foundation, Inc.
 * @link				http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package			cake
 * @subpackage		cake.cake.libs.view.templates.errors
 * @since			CakePHP(tm) v 0.10.0.1076
 * @version			$Revision: 4605 $
 * @modifiedby		$LastChangedBy: phpnut $
 * @lastmodified	$Date: 2007-03-09 17:26:37 -0600 (Fri, 09 Mar 2007) $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
?>
<h1><?php __('Missing Helper File'); ?></h1>
<p class="error"><?php echo sprintf(__("You are seeing this error because the view helper file %s can not be found or does not exist.", true), APP_DIR.DS."views".DS."helpers".DS.$file);?></p>
<p><span class="notice"><strong><?php __('Notice'); ?>: </strong>
<?php echo sprintf(__('If you want to customize this error message, create %s', true), APP_DIR.DS."views/errors/missing_helper_file.ctp");?></span></p>
<p><span class="notice"><strong><?php __('Fatal'); ?>: </strong>
<?php echo sprintf(__('Create the class below in file: %s', true), APP_DIR.DS."views".DS."helpers".DS.$file);?></span></p>
<p>&lt;?php<br />
class <?php echo $helperClass;?> extends Helper {<br />
}<br />
?&gt;<br />
</p>