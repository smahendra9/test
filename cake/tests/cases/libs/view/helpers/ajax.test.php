<?php
/* SVN FILE: $Id: ajax.test.php 5422 2007-07-09 05:23:06Z phpnut $ */
/**
 * Short description for file.
 *
 * Long description for file
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) Tests <https://trac.cakephp.org/wiki/Developement/TestSuite>
 * Copyright 2005-2007, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 *  Licensed under The Open Group Test Suite License
 *  Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright 2005-2007, Cake Software Foundation, Inc.
 * @link				https://trac.cakephp.org/wiki/Developement/TestSuite CakePHP(tm) Tests
 * @package			cake.tests
 * @subpackage		cake.tests.cases.libs.view.helpers
 * @since			CakePHP(tm) v 1.2.0.4206
 * @version			$Revision: 5422 $
 * @modifiedby		$LastChangedBy: phpnut $
 * @lastmodified	$Date: 2007-07-09 00:23:06 -0500 (Mon, 09 Jul 2007) $
 * @license			http://www.opensource.org/licenses/opengroup.php The Open Group Test Suite License
 */
if (!defined('CAKEPHP_UNIT_TEST_EXECUTION')) {
	define('CAKEPHP_UNIT_TEST_EXECUTION', 1);
}

require_once CAKE.'app_helper.php';
uses('controller'.DS.'controller', 'model'.DS.'model', 'view'.DS.'helper', 'view'.DS.'helpers'.DS.'ajax',
	'view'.DS.'helpers'.DS.'html', 'view'.DS.'helpers'.DS.'form', 'view'.DS.'helpers'.DS.'javascript');

class AjaxTestController extends Controller {
	var $name = 'AjaxTest';
	var $uses = null;
}

class PostAjaxTest extends Model {
	var $primaryKey = 'id';
	var $useTable = false;

	function loadInfo() {
		return new Set(array(
			array('name' => 'id', 'type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'),
			array('name' => 'name', 'type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
			array('name' => 'created', 'type' => 'date', 'null' => '1', 'default' => '', 'length' => ''),
			array('name' => 'updated', 'type' => 'datetime', 'null' => '1', 'default' => '', 'length' => null)));
	}
}


/**
 * Short description for class.
 *
 * @package		cake.tests
 * @subpackage	cake.tests.cases.libs.view.helpers
 */
class AjaxTest extends UnitTestCase {

	function setUp() {
		Router::reload();
		$this->Ajax = new AjaxHelper();
		$this->Ajax->Html = new HtmlHelper();
		$this->Ajax->Form = new FormHelper();
		$this->Ajax->Javascript = new JavascriptHelper();
		$this->Ajax->Form->Html =& $this->Ajax->Html;
		$view = new View(new AjaxTestController());
		ClassRegistry::addObject('view', $view);
		ClassRegistry::addObject('PostAjaxTest', new PostAjaxTest());
	}

	function testEvalScripts() {
		$result = $this->Ajax->link('Test Link', '/', array('id' => 'link1', 'update' => 'content', 'evalScripts' => false));
		$expected = '<a href="/"  id="link1" onclick=" return false;">Test Link</a><script type="text/javascript">Event.observe(\'link1\', \'click\', function(event) { new Ajax.Updater(\'content\',\'/\', {asynchronous:true, evalScripts:false, requestHeaders:[\'X-Update\', \'content\']}) }, false);</script>';
		$this->assertEqual($result, $expected);

		$result = $this->Ajax->link('Test Link', '/', array('id' => 'link1', 'update' => 'content'));
		$expected = '<a href="/"  id="link1" onclick=" return false;">Test Link</a><script type="text/javascript">Event.observe(\'link1\', \'click\', function(event) { new Ajax.Updater(\'content\',\'/\', {asynchronous:true, evalScripts:true, requestHeaders:[\'X-Update\', \'content\']}) }, false);</script>';
		$this->assertEqual($result, $expected);
	}

	function testAutoComplete() {
		$result = $this->Ajax->autoComplete('PostAjaxTest/title' , '/posts', array('minChars' => 2));

		$this->assertPattern('/^<input[^<>]+name="data\[PostAjaxTest\]\[title\]"[^<>]+autocomplete="off"[^<>]+\/>/', $result);
		$this->assertPattern('/<div[^<>]+id="PostAjaxTestTitle_autoComplete"[^<>]*><\/div>/', $result);
		$this->assertPattern('/<div[^<>]+class="auto_complete"[^<>]*><\/div>/', $result);
		$this->assertPattern('/<\/div>\s+<script type="text\/javascript">new Ajax\.Autocompleter\(\'PostAjaxTestTitle\', \'PostAjaxTestTitle_autoComplete\', \'\/posts\',/', $result);
		$this->assertPattern('/<script(.*)>(.*) {minChars:2}\);/', $result);
		$this->assertPattern('/<\/script>$/', $result);
	}

	function testAsynchronous() {
		$result = $this->Ajax->link('Test Link', '/', array('id' => 'link1', 'update' => 'content', 'type' => 'synchronous'));
		$expected = '<a href="/"  id="link1" onclick=" return false;">Test Link</a><script type="text/javascript">Event.observe(\'link1\', \'click\', function(event) { new Ajax.Updater(\'content\',\'/\', {asynchronous:false, evalScripts:true, requestHeaders:[\'X-Update\', \'content\']}) }, false);</script>';
		$this->assertEqual($result, $expected);
	}

	function testDraggable() {
		$result = $this->Ajax->drag('id', array('handle' => 'other_id'));
		$expected = '<script type="text/javascript">new Draggable(\'id\', {handle:\'other_id\'});</script>';
		$this->assertEqual($result, $expected);
	}

	function testDroppable() {
		$result = $this->Ajax->drop('droppable', array('accept' => 'crap'));
		$expected = '<script type="text/javascript">Droppables.add(\'droppable\', {accept:\'crap\'});</script>';
		$this->assertEqual($result, $expected);

		$result = $this->Ajax->dropRemote('droppable', array('accept' => 'crap'), array('url' => '/posts'));
		$expected = '<script type="text/javascript">Droppables.add(\'droppable\', {accept:\'crap\', onDrop:function(element, droppable) {new Ajax.Request(\'/posts\', {asynchronous:true, evalScripts:true})}});</script>';
		$this->assertEqual($result, $expected);
	}

	function testSortable() {
		$result = $this->Ajax->sortable('ull', array('constraint'=>false,'ghosting'=>true));
		$expected = '<script type="text/javascript">Sortable.create(\'ull\', {constraint:false, ghosting:true});</script>';
		$this->assertEqual($result, $expected);

		$result = $this->Ajax->sortable('ull', array('constraint'=>'false','ghosting'=>'true'));
		$expected = '<script type="text/javascript">Sortable.create(\'ull\', {constraint:false, ghosting:true});</script>';
		$this->assertEqual($result, $expected);
	}

	function testSubmitWithIndicator() {
		$result = $this->Ajax->submit('Add', array('div' => false, 'url' => "/controller/action", 'indicator' => 'loading', 'loading' => "doSomething()", 'complete' => 'doSomethingElse() '));
		$this->assertPattern('/onLoading:function\(request\) {doSomething\(\);\s+Element.show\(\'loading\'\);}/', $result);
		$this->assertPattern('/onComplete:function\(request, json\) {doSomethingElse\(\) ;\s+Element.hide\(\'loading\'\);}/', $result);
	}

	function tearDown() {
		unset($this->Ajax);
	}
}
?>