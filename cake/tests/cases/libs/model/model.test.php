<?php
/* SVN FILE: $Id: model.test.php 5422 2007-07-09 05:23:06Z phpnut $ */
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
 * @subpackage		cake.tests.cases.libs.model
 * @since			CakePHP(tm) v 1.2.0.4206
 * @version			$Revision: 5422 $
 * @modifiedby		$LastChangedBy: phpnut $
 * @lastmodified	$Date: 2007-07-09 00:23:06 -0500 (Mon, 09 Jul 2007) $
 * @license			http://www.opensource.org/licenses/opengroup.php The Open Group Test Suite License
 */
if (!defined('CAKEPHP_UNIT_TEST_EXECUTION')) {
	define('CAKEPHP_UNIT_TEST_EXECUTION', 1);
}
uses('model'.DS.'model', 'model'.DS.'datasources'.DS.'datasource', 'model'.DS.'datasources'.DS.'dbo_source',
	'model'.DS.'datasources'.DS.'dbo'.DS.'dbo_mysql');
/**
 * Short description for class.
 *
 * @package		cake.tests
 * @subpackage	cake.tests.cases.libs.model
 */
class Test extends Model {
	var $useTable = false;
	var $name = 'Test';

	function loadInfo() {
		return new Set(array(
			array('name' => 'id', 'type' => 'integer', 'null' => '', 'default' => '1', 'length' => '8'),
			array('name' => 'name', 'type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
			array('name' => 'email', 'type' => 'string', 'null' => '1', 'default' => '', 'length' => '155'),
			array('name' => 'notes', 'type' => 'text', 'null' => '1', 'default' => 'write some notes here', 'length' => ''),
			array('name' => 'created', 'type' => 'date', 'null' => '1', 'default' => '', 'length' => ''),
			array('name' => 'updated', 'type' => 'datetime', 'null' => '1', 'default' => '', 'length' => null)
		));
	}
}

/**
 * Short description for class.
 *
 * @package		cake.tests
 * @subpackage	cake.tests.cases.libs.model
 */
class TestValidate extends Model {
	var $useTable = false;
	var $name = 'TestValidate';

	function validateNumber($value, $options) {
		$options = am(array(
			'min' => 0,
			'max' => 100
		), $options);

		$valid = ($value >= $options['min'] && $value <= $options['max']);

		return $valid;
	}

	function validateTitle($title) {
		if (!empty($title) && strpos(low($title), 'title-') === 0) {
			return true;
		}

		return false;
	}

	function loadInfo() {
		return new Set(array(
			array('name' => 'id', 'type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'),
			array('name' => 'title', 'type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
			array('name' => 'body', 'type' => 'string', 'null' => '1', 'default' => '', 'length' => ''),
			array('name' => 'number', 'type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'),
			array('name' => 'created', 'type' => 'date', 'null' => '1', 'default' => '', 'length' => ''),
			array('name' => 'modified', 'type' => 'datetime', 'null' => '1', 'default' => '', 'length' => null)
		));
	}
}

/**
 * Short description for class.
 *
 * @package		cake.tests
 * @subpackage	cake.tests.cases.libs.model
 */
class User extends CakeTestModel {
	var $name = 'User';
	var $validate = array(
		'user' => VALID_NOT_EMPTY,
		'password' => VALID_NOT_EMPTY
	);
}
/**
 * Short description for class.
 *
 * @package		cake.tests
 * @subpackage	cake.tests.cases.libs.model
 */
class Article extends CakeTestModel {
	var $name = 'Article';
	var $belongsTo = array('User');
	var $hasMany = array(
		'Comment' => array('className'=>'Comment', 'dependent' => true)
	);
	var $hasAndBelongsToMany = array('Tag');
	var $validate = array(
		'user_id' => VALID_NUMBER,
		'title' => array('allowEmpty' => false, 'rule' => VALID_NOT_EMPTY),
		'body' => VALID_NOT_EMPTY
	);
}
/**
 * Short description for class.
 *
 * @package		cake.tests
 * @subpackage	cake.tests.cases.libs.model
 */
class ArticleFeatured extends CakeTestModel {
	var $name = 'ArticleFeatured';
	var $belongsTo = array('User', 'Category');
	var $hasOne = array('Featured');
	var $hasMany = array(
		'Comment' => array('className'=>'Comment', 'dependent' => true)
	);
	var $hasAndBelongsToMany = array('Tag');
	var $validate = array(
		'user_id' => VALID_NUMBER,
		'title' => VALID_NOT_EMPTY,
		'body' => VALID_NOT_EMPTY
	);
}
/**
 * Short description for class.
 *
 * @package		cake.tests
 * @subpackage	cake.tests.cases.libs.model
 */
class Featured extends CakeTestModel {
	var $name = 'Featured';
	var $belongsTo = array(
		'ArticleFeatured'=> array('className' => 'ArticleFeatured'),
		'Category'=> array('className' => 'Category')
	);
}

/**
 * Short description for class.
 *
 * @package		cake.tests
 * @subpackage	cake.tests.cases.libs.model
 */
class Tag extends CakeTestModel {
	var $name = 'Tag';
}
/**
 * Short description for class.
 *
 * @package		cake.tests
 * @subpackage	cake.tests.cases.libs.model
 */
class Comment extends CakeTestModel {
	var $name = 'Comment';
	var $belongsTo = array('Article', 'User');
	var $hasOne = array(
		'Attachment' => array('className'=>'Attachment', 'dependent' => true)
	);
}
/**
 * Short description for class.
 *
 * @package		cake.tests
 * @subpackage	cake.tests.cases.libs.model
 */
class Attachment extends CakeTestModel {
	var $name = 'Attachment';
}
/**
 * Short description for class.
 *
 * @package		cake.tests
 * @subpackage	cake.tests.cases.libs.model
 */
class Category extends CakeTestModel {
	var $name = 'Category';
}
/**
 * Short description for class.
 *
 * @package		cake.tests
 * @subpackage	cake.tests.cases.libs.model
 */
class CategoryThread extends CakeTestModel {
	var $name = 'CategoryThread';
	var $belongsTo = array(
		'ParentCategory' => array(
			'className' => 'CategoryThread',
			'foreignKey' => 'parent_id'
		)
	);
}
/**
 * Short description for class.
 *
 * @package		cake.tests
 * @subpackage	cake.tests.cases.libs.model
 */
class Apple extends CakeTestModel {
	var $name = 'Apple';
	var $validate = array('name' => VALID_NOT_EMPTY);
	var $hasOne = array('Sample');
	var $hasMany = array('Child' => array(
		'className' => 'Apple',
		'dependent' => true
	));
	var $belongsTo = array('Parent' => array(
		'className' => 'Apple',
		'foreignKey' => 'apple_id'
	));
}
/**
 * Short description for class.
 *
 * @package		cake.tests
 * @subpackage	cake.tests.cases.libs.model
 */
class Sample extends CakeTestModel {
	var $name = 'Sample';
	var $belongsTo = 'Apple';
}
/**
 * Short description for class.
 *
 * @package		cake.tests
 * @subpackage	cake.tests.cases.libs.model
 */
class AnotherArticle extends CakeTestModel {
	var $name = 'AnotherArticle';
	var $hasMany = 'Home';
}
/**
 * Short description for class.
 *
 * @package		cake.tests
 * @subpackage	cake.tests.cases.libs.model
 */
class Advertisement extends CakeTestModel {
	var $name = 'Advertisement';
	var $hasMany = 'Home';
}
/**
 * Short description for class.
 *
 * @package		cake.tests
 * @subpackage	cake.tests.cases.libs.model
 */
class Home extends CakeTestModel {
	var $name = 'Home';
	var $belongsTo = array('AnotherArticle', 'Advertisement');
}
/**
 * Short description for class.
 *
 * @package		cake.tests
 * @subpackage	cake.tests.cases.libs.model
 */
class Post extends CakeTestModel {
	var $name = 'Post';
	var $belongsTo = array('Author');
}
/**
 * Short description for class.
 *
 * @package		cake.tests
 * @subpackage	cake.tests.cases.libs.model
 */
class Author extends CakeTestModel {
	var $name = 'Author';
	var $hasMany = array('Post');

	function afterFind($results) {
		$results[0]['Author']['test'] = 'working';
		return $results;
	}
}
/**
 * Short description for class.
 *
 * @package		cake.tests
 * @subpackage	cake.tests.cases.libs.model
 */
class ModelTest extends CakeTestCase {

	var $fixtures = array(
		'core.category', 'core.category_thread', 'core.user', 'core.article', 'core.featured',
		'core.article_featured', 'core.tag', 'core.articles_tag', 'core.comment', 'core.attachment',
		'core.apple', 'core.sample', 'core.another_article', 'core.advertisement', 'core.home', 'core.post', 'core.author'
	);

	function start() {
		parent::start();
		Configure::write('debug', 2);
	}

	function end() {
		parent::end();
		Configure::write('debug', DEBUG);
	}

	function testFindAllRecursiveSelfJoin() {
		$this->model =& new Home();

		$this->model->recursive = 2;
		$result = $this->model->findAll();
		$expected = array (
			array (
				'Home' => array (
					'id' => '1', 'another_article_id' => '1', 'advertisement_id' => '1', 'title' => 'First Home',  'created' => '2007-03-18 10:39:23', 'updated' => '2007-03-18 10:41:31'
				),
				'AnotherArticle' => array (
					'id' => '1', 'title' => 'First Article', 'created' => '2007-03-18 10:39:23', 'updated' => '2007-03-18 10:41:31',
					'Home' => array (
						array (
							'id' => '1', 'another_article_id' => '1', 'advertisement_id' => '1', 'title' => 'First Home', 'created' => '2007-03-18 10:39:23', 'updated' => '2007-03-18 10:41:31'
						)
					)
				),
				'Advertisement' => array (
					'id' => '1', 'title' => 'First Ad', 'created' => '2007-03-18 10:39:23', 'updated' => '2007-03-18 10:41:31',
					'Home' => array (
						array (
							'id' => '1', 'another_article_id' => '1', 'advertisement_id' => '1', 'title' => 'First Home', 'created' => '2007-03-18 10:39:23', 'updated' => '2007-03-18 10:41:31'
						),
						array (
							'id' => '2', 'another_article_id' => '3', 'advertisement_id' => '1', 'title' => 'Second Home', 'created' => '2007-03-18 10:41:23', 'updated' => '2007-03-18 10:43:31'
						)
					)
				)
			),
			array (
				'Home' => array (
					'id' => '2', 'another_article_id' => '3', 'advertisement_id' => '1', 'title' => 'Second Home', 'created' => '2007-03-18 10:41:23', 'updated' => '2007-03-18 10:43:31'
				),
				'AnotherArticle' => array (
					'id' => '3', 'title' => 'Third Article', 'created' => '2007-03-18 10:43:23', 'updated' => '2007-03-18 10:45:31',
					'Home' => array (
						array (
							'id' => '2', 'another_article_id' => '3', 'advertisement_id' => '1', 'title' => 'Second Home', 'created' => '2007-03-18 10:41:23', 'updated' => '2007-03-18 10:43:31'
						)
					)
				),
				'Advertisement' => array (
					'id' => '1', 'title' => 'First Ad', 'created' => '2007-03-18 10:39:23', 'updated' => '2007-03-18 10:41:31',
					'Home' => array (
						array (
							'id' => '1', 'another_article_id' => '1', 'advertisement_id' => '1', 'title' => 'First Home', 'created' => '2007-03-18 10:39:23', 'updated' => '2007-03-18 10:41:31'
						),
						array (
							'id' => '2', 'another_article_id' => '3', 'advertisement_id' => '1', 'title' => 'Second Home', 'created' => '2007-03-18 10:41:23', 'updated' => '2007-03-18 10:43:31'
						)
					)
				)
			)
		);

		$this->assertEqual($result, $expected);
	}

	function testIdentity() {
		$this->model =& new Test();
		$result = $this->model->name;
		$expected = 'Test';
		$this->assertEqual($result, $expected);
	}

	function testCreation() {
		$this->model =& new Test();
		$result = $this->model->create();
		$expected = array('Test' => array('notes' => 'write some notes here'));
		$this->assertEqual($result, $expected);

		$this->model =& new User();
		$result = $this->model->_tableInfo->value;

		$db =& ConnectionManager::getDataSource('test_suite');
		if (isset($db->columns['primary_key']['length'])) {
			$intLength = $db->columns['primary_key']['length'];
		} elseif (isset($db->columns['integer']['length'])) {
			$intLength = $db->columns['integer']['length'];
		} else {
			$intLength = 11;
		}

		$expected = array (
			array('name' => 'id', 		'type' => 'integer',	'null' => false, 'default' => null,	'length' => $intLength),
			array('name' => 'user', 	'type' => 'string',		'null' => false, 'default' => '',	'length' => 255),
			array('name' => 'password',	'type' => 'string',		'null' => false, 'default' => '',	'length' => 255),
			array('name' => 'created',	'type' => 'datetime',	'null' => true, 'default' => null,	'length' => null),
			array('name' => 'updated',	'type' => 'datetime',	'null' => true, 'default' => null,	'length' => null)
		);
		$this->assertEqual($result, $expected);

		$this->model =& new Article();
		$result = $this->model->create();
		$expected = array ('Article' => array('published' => 'N'));
		$this->assertEqual($result, $expected);
	}

	function testReadFakeThread() {
		$this->model =& new CategoryThread();

		$this->db->fullDebug = true;
		$this->model->recursive = 6;
		$this->model->id = 7;
		$result = $this->model->read();
		$expected = array('CategoryThread' => array('id' => 7, 'parent_id' => 6, 'name' => 'Category 2.1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31'),
		'ParentCategory' => array('id' => 6, 'parent_id' => 5, 'name' => 'Category 2', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31',
		'ParentCategory' => array('id' => 5, 'parent_id' => 4, 'name' => 'Category 1.1.1.1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31',
		'ParentCategory' => array('id' => 4, 'parent_id' => 3, 'name' => 'Category 1.1.2', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31',
		'ParentCategory' => array('id' => 3, 'parent_id' => 2, 'name' => 'Category 1.1.1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31',
		'ParentCategory' => array('id' => 2, 'parent_id' => 1, 'name' => 'Category 1.1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31',
		'ParentCategory' => array('id' => 1, 'parent_id' => 0, 'name' => 'Category 1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31')))))));
		$this->assertEqual($result, $expected);
	}

	function testFindFakeThread() {
		$this->model =& new CategoryThread();

		$this->db->fullDebug = true;
		$this->model->recursive = 6;
		$result = $this->model->find(array('CategoryThread.id' => 7));

		$expected = array('CategoryThread' => array('id' => 7, 'parent_id' => 6, 'name' => 'Category 2.1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31'),
		'ParentCategory' => array('id' => 6, 'parent_id' => 5, 'name' => 'Category 2', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31',
		'ParentCategory' => array('id' => 5, 'parent_id' => 4, 'name' => 'Category 1.1.1.1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31',
		'ParentCategory' => array('id' => 4, 'parent_id' => 3, 'name' => 'Category 1.1.2', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31',
		'ParentCategory' => array('id' => 3, 'parent_id' => 2, 'name' => 'Category 1.1.1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31',
		'ParentCategory' => array('id' => 2, 'parent_id' => 1, 'name' => 'Category 1.1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31',
		'ParentCategory' => array('id' => 1, 'parent_id' => 0, 'name' => 'Category 1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31')))))));
		$this->assertEqual($result, $expected);
	}

	function testFindAllFakeThread() {
		$this->model =& new CategoryThread();

		$this->db->fullDebug = true;
		$this->model->recursive = 6;
		$result = $this->model->findAll(null, null, 'CategoryThread.id ASC');

		$expected = array(
			array(
				'CategoryThread' => array('id' => 1, 'parent_id' => 0, 'name' => 'Category 1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31'),
				'ParentCategory' => array('id' => null, 'parent_id' => null, 'name' => null, 'created' => null, 'updated' => null)
			),
			array(
				'CategoryThread' => array('id' => 2, 'parent_id' => 1, 'name' => 'Category 1.1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31'),
				'ParentCategory' => array('id' => 1, 'parent_id' => 0, 'name' => 'Category 1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31')
			),
			array(
				'CategoryThread' => array('id' => 3, 'parent_id' => 2, 'name' => 'Category 1.1.1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31'),
				'ParentCategory' => array('id' => 2, 'parent_id' => 1, 'name' => 'Category 1.1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31',
				'ParentCategory' => array('id' => 1, 'parent_id' => 0, 'name' => 'Category 1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31'))
			),
			array(
				'CategoryThread' => array('id' => 4, 'parent_id' => 3, 'name' => 'Category 1.1.2', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31'),
				'ParentCategory' => array('id' => 3, 'parent_id' => 2, 'name' => 'Category 1.1.1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31',
				'ParentCategory' => array('id' => 2, 'parent_id' => 1, 'name' => 'Category 1.1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31',
				'ParentCategory' => array('id' => 1, 'parent_id' => 0, 'name' => 'Category 1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31')))
			),
			array(
				'CategoryThread' => array('id' => 5, 'parent_id' => 4, 'name' => 'Category 1.1.1.1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31'),
				'ParentCategory' => array('id' => 4, 'parent_id' => 3, 'name' => 'Category 1.1.2', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31',
				'ParentCategory' => array('id' => 3, 'parent_id' => 2, 'name' => 'Category 1.1.1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31',
				'ParentCategory' => array('id' => 2, 'parent_id' => 1, 'name' => 'Category 1.1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31',
				'ParentCategory' => array('id' => 1, 'parent_id' => 0, 'name' => 'Category 1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31'))))
			),
			array(
				'CategoryThread' => array('id' => 6, 'parent_id' => 5, 'name' => 'Category 2', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31'),
				'ParentCategory' => array('id' => 5, 'parent_id' => 4, 'name' => 'Category 1.1.1.1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31',
				'ParentCategory' => array('id' => 4, 'parent_id' => 3, 'name' => 'Category 1.1.2', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31',
				'ParentCategory' => array('id' => 3, 'parent_id' => 2, 'name' => 'Category 1.1.1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31',
				'ParentCategory' => array('id' => 2, 'parent_id' => 1, 'name' => 'Category 1.1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31',
				'ParentCategory' => array('id' => 1, 'parent_id' => 0, 'name' => 'Category 1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31')))))
			),
			array(
				'CategoryThread' => array('id' => 7, 'parent_id' => 6, 'name' => 'Category 2.1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31'),
				'ParentCategory' => array('id' => 6, 'parent_id' => 5, 'name' => 'Category 2', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31',
				'ParentCategory' => array('id' => 5, 'parent_id' => 4, 'name' => 'Category 1.1.1.1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31',
				'ParentCategory' => array('id' => 4, 'parent_id' => 3, 'name' => 'Category 1.1.2', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31',
				'ParentCategory' => array('id' => 3, 'parent_id' => 2, 'name' => 'Category 1.1.1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31',
				'ParentCategory' => array('id' => 2, 'parent_id' => 1, 'name' => 'Category 1.1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31',
				'ParentCategory' => array('id' => 1, 'parent_id' => 0, 'name' => 'Category 1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31'))))))
			)
		);
		$this->assertEqual($result, $expected);
	}

	function testFindAll() {
		$this->model =& new User();

		$result = $this->model->findAll();
		$expected = array(
			array ( 'User' => array ( 'id' => '1', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31')),
			array ( 'User' => array ( 'id' => '2', 'user' => 'nate', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:18:23', 'updated' => '2007-03-17 01:20:31')),
			array ( 'User' => array ( 'id' => '3', 'user' => 'larry', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:20:23', 'updated' => '2007-03-17 01:22:31')),
			array ( 'User' => array ( 'id' => '4', 'user' => 'garrett', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:22:23', 'updated' => '2007-03-17 01:24:31'))
		);
		$this->assertEqual($result, $expected);

		$result = $this->model->findAll('User.id > 2');
		$expected = array(
			array ( 'User' => array ( 'id' => '3', 'user' => 'larry', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:20:23', 'updated' => '2007-03-17 01:22:31')),
			array ( 'User' => array ( 'id' => '4', 'user' => 'garrett', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:22:23', 'updated' => '2007-03-17 01:24:31'))
		);
		$this->assertEqual($result, $expected);

		$result = $this->model->findAll(array('User.id' => '!= 0', 'User.user' => 'LIKE %arr%'));
		$expected = array(
			array ( 'User' => array ( 'id' => '3', 'user' => 'larry', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:20:23', 'updated' => '2007-03-17 01:22:31')),
			array ( 'User' => array ( 'id' => '4', 'user' => 'garrett', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:22:23', 'updated' => '2007-03-17 01:24:31'))
		);
		$this->assertEqual($result, $expected);

		$result = $this->model->findAll(array('User.id' => '0'));
		$expected = array();
		$this->assertEqual($result, $expected);

		$result = $this->model->findAll(array('or' => array('User.id' => '0', 'User.user' => 'LIKE %a%')));
		$expected = array(
			array ( 'User' => array ( 'id' => '1', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31')),
			array ( 'User' => array ( 'id' => '2', 'user' => 'nate', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:18:23', 'updated' => '2007-03-17 01:20:31')),
			array ( 'User' => array ( 'id' => '3', 'user' => 'larry', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:20:23', 'updated' => '2007-03-17 01:22:31')),
			array ( 'User' => array ( 'id' => '4', 'user' => 'garrett', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:22:23', 'updated' => '2007-03-17 01:24:31'))
		);
		$this->assertEqual($result, $expected);

		$result = $this->model->findAll(null, 'User.id, User.user');
		$expected = array(
			array ( 'User' => array ( 'id' => '1', 'user' => 'mariano')),
			array ( 'User' => array ( 'id' => '2', 'user' => 'nate')),
			array ( 'User' => array ( 'id' => '3', 'user' => 'larry')),
			array ( 'User' => array ( 'id' => '4', 'user' => 'garrett'))
		);
		$this->assertEqual($result, $expected);

		$result = $this->model->findAll(null, 'User.user', 'User.user ASC');
		$expected = array(
			array ( 'User' => array ( 'user' => 'garrett')),
			array ( 'User' => array ( 'user' => 'larry')),
			array ( 'User' => array ( 'user' => 'mariano')),
			array ( 'User' => array ( 'user' => 'nate'))
		);
		$this->assertEqual($result, $expected);

		$result = $this->model->findAll(null, 'User.user', 'User.user ASC');
		$expected = array(
			array ( 'User' => array ( 'user' => 'garrett')),
			array ( 'User' => array ( 'user' => 'larry')),
			array ( 'User' => array ( 'user' => 'mariano')),
			array ( 'User' => array ( 'user' => 'nate'))
		);
		$this->assertEqual($result, $expected);

		$result = $this->model->findAll(null, 'User.user', 'User.user DESC');
		$expected = array(
			array ( 'User' => array ( 'user' => 'nate')),
			array ( 'User' => array ( 'user' => 'mariano')),
			array ( 'User' => array ( 'user' => 'larry')),
			array ( 'User' => array ( 'user' => 'garrett'))
		);
		$this->assertEqual($result, $expected);

		$result = $this->model->findAll(null, null, null, 3, 1);
		$expected = array(
			array ( 'User' => array ( 'id' => '1', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31')),
			array ( 'User' => array ( 'id' => '2', 'user' => 'nate', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:18:23', 'updated' => '2007-03-17 01:20:31')),
			array ( 'User' => array ( 'id' => '3', 'user' => 'larry', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:20:23', 'updated' => '2007-03-17 01:22:31'))
		);
		$this->assertEqual($result, $expected);

		$result = $this->model->findAll(null, null, null, 3, 2);
		$expected = array(
			array ( 'User' => array ( 'id' => '4', 'user' => 'garrett', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:22:23', 'updated' => '2007-03-17 01:24:31'))
		);
		$this->assertEqual($result, $expected);

		$result = $this->model->findAll(null, null, null, 3, 3);
		$expected = array();
		$this->assertEqual($result, $expected);
	}

	function testGenerateList() {
		$this->model =& new Article();
		$this->model->displayField = 'title';

		$result = $this->model->generateList(null, 'Article.title ASC');
		$expected = array(
			1 => 'First Article',
			2 => 'Second Article',
			3 => 'Third Article'
		);
		$this->assertEqual($result, $expected);

		$result = $this->model->generateList(null, 'Article.title ASC', null, '{n}.Article.id');
		$expected = array(
			1 => 'First Article',
			2 => 'Second Article',
			3 => 'Third Article'
		);
		$this->assertEqual($result, $expected);

		$result = $this->model->generateList(null, 'Article.title ASC', null, '{n}.Article.id', '{n}.Article');
		$expected = array(
			1 => array(
				'id' => 1,
				'user_id' => 1,
				'title' => 'First Article',
				'body' => 'First Article Body',
				'published' => 'Y',
				'created' => '2007-03-18 10:39:23',
				'updated' => '2007-03-18 10:41:31'
			),
			2 => array(
				'id' => 2,
				'user_id' => 3,
				'title' => 'Second Article',
				'body' => 'Second Article Body',
				'published' => 'Y',
				'created' => '2007-03-18 10:41:23',
				'updated' => '2007-03-18 10:43:31'
			),
			3 => array(
				'id' => 3,
				'user_id' => 1,
				'title' => 'Third Article',
				'body' => 'Third Article Body',
				'published' => 'Y',
				'created' => '2007-03-18 10:43:23',
				'updated' => '2007-03-18 10:45:31'
			)
		);
		$this->assertEqual($result, $expected);

		$result = $this->model->generateList(null, 'Article.title ASC', null, '{n}.Article.id', '{n}.Article.title');
		$expected = array(
			1 => 'First Article',
			2 => 'Second Article',
			3 => 'Third Article'
		);
		$this->assertEqual($result, $expected);

		$result = $this->model->generateList(null, 'Article.title ASC', null, '{n}.Article.id', '{n}.Article', '{n}.Article.user_id');
		$expected = array(
			1 => array(
				1 => array(
					'id' => 1,
					'user_id' => 1,
					'title' => 'First Article',
					'body' => 'First Article Body',
					'published' => 'Y',
					'created' => '2007-03-18 10:39:23',
					'updated' => '2007-03-18 10:41:31'
				),
				3 => array(
					'id' => 3,
					'user_id' => 1,
					'title' => 'Third Article',
					'body' => 'Third Article Body',
					'published' => 'Y',
					'created' => '2007-03-18 10:43:23',
					'updated' => '2007-03-18 10:45:31'
				)
			),
			3 => array(
				2 => array(
					'id' => 2,
					'user_id' => 3,
					'title' => 'Second Article',
					'body' => 'Second Article Body',
					'published' => 'Y',
					'created' => '2007-03-18 10:41:23',
					'updated' => '2007-03-18 10:43:31'
				)
			)
		);
		$this->assertEqual($result, $expected);

		$result = $this->model->generateList(null, 'Article.title ASC', null, '{n}.Article.id', '{n}.Article.title', '{n}.Article.user_id');
		$expected = array(
			1 => array(
				1 => 'First Article',
				3 => 'Third Article'
			),
			3 => array(
				2 => 'Second Article'
			)
		);
		$this->assertEqual($result, $expected);
	}

	function testFindField() {
		$this->model =& new User();

		$this->model->id = 1;
		$result = $this->model->field('user');
		$this->assertEqual($result, 'mariano');

		$result = $this->model->field('User.user');
		$this->assertEqual($result, 'mariano');

		$this->model->id = false;
		$result = $this->model->field('user', array('user' => 'mariano'));
		$this->assertEqual($result, 'mariano');

		$result = $this->model->field('COUNT(*) AS count', true);
		$this->assertEqual($result, 4);

		$result = $this->model->field('COUNT(*)', true);
		$this->assertEqual($result, 4);
	}

	function testBindUnbind() {
		$this->model =& new User();

		$result = $this->model->hasMany;
		$expected = array();
		$this->assertEqual($result, $expected);

		$result = $this->model->bindModel(array('hasMany' => array('Comment')));
		$this->assertTrue($result);

		$result = $this->model->findAll(null, 'User.id, User.user');
		$expected = array(
			array ( 'User' => array ( 'id' => '1', 'user' => 'mariano'), 'Comment' => array(
				array( 'id' => '3', 'article_id' => '1', 'user_id' => '1', 'comment' => 'Third Comment for First Article', 'published' => 'Y', 'created' => '2007-03-18 10:49:23', 'updated' => '2007-03-18 10:51:31'),
				array( 'id' => '4', 'article_id' => '1', 'user_id' => '1', 'comment' => 'Fourth Comment for First Article', 'published' => 'N', 'created' => '2007-03-18 10:51:23', 'updated' => '2007-03-18 10:53:31'),
				array( 'id' => '5', 'article_id' => '2', 'user_id' => '1', 'comment' => 'First Comment for Second Article', 'published' => 'Y', 'created' => '2007-03-18 10:53:23', 'updated' => '2007-03-18 10:55:31')
			)),
			array ( 'User' => array ( 'id' => '2', 'user' => 'nate'), 'Comment' => array(
				array( 'id' => '1', 'article_id' => '1', 'user_id' => '2', 'comment' => 'First Comment for First Article', 'published' => 'Y', 'created' => '2007-03-18 10:45:23', 'updated' => '2007-03-18 10:47:31'),
				array( 'id' => '6', 'article_id' => '2', 'user_id' => '2', 'comment' => 'Second Comment for Second Article', 'published' => 'Y', 'created' => '2007-03-18 10:55:23', 'updated' => '2007-03-18 10:57:31')
			)),
			array ( 'User' => array ( 'id' => '3', 'user' => 'larry'), 'Comment' => array()),
			array ( 'User' => array ( 'id' => '4', 'user' => 'garrett'), 'Comment' => array(
				array( 'id' => '2', 'article_id' => '1', 'user_id' => '4', 'comment' => 'Second Comment for First Article', 'published' => 'Y', 'created' => '2007-03-18 10:47:23', 'updated' => '2007-03-18 10:49:31')
			))
		);
		$this->assertEqual($result, $expected);

		$this->model->__resetAssociations();
		$result = $this->model->hasMany;
		$this->assertEqual($result, array());

		$result = $this->model->bindModel(array('hasMany' => array('Comment')), false);
		$this->assertTrue($result);

		$result = $this->model->findAll(null, 'User.id, User.user');
		$expected = array(
			array ( 'User' => array ( 'id' => '1', 'user' => 'mariano'), 'Comment' => array(
				array( 'id' => '3', 'article_id' => '1', 'user_id' => '1', 'comment' => 'Third Comment for First Article', 'published' => 'Y', 'created' => '2007-03-18 10:49:23', 'updated' => '2007-03-18 10:51:31'),
				array( 'id' => '4', 'article_id' => '1', 'user_id' => '1', 'comment' => 'Fourth Comment for First Article', 'published' => 'N', 'created' => '2007-03-18 10:51:23', 'updated' => '2007-03-18 10:53:31'),
				array( 'id' => '5', 'article_id' => '2', 'user_id' => '1', 'comment' => 'First Comment for Second Article', 'published' => 'Y', 'created' => '2007-03-18 10:53:23', 'updated' => '2007-03-18 10:55:31')
			)),
			array ( 'User' => array ( 'id' => '2', 'user' => 'nate'), 'Comment' => array(
				array( 'id' => '1', 'article_id' => '1', 'user_id' => '2', 'comment' => 'First Comment for First Article', 'published' => 'Y', 'created' => '2007-03-18 10:45:23', 'updated' => '2007-03-18 10:47:31'),
				array( 'id' => '6', 'article_id' => '2', 'user_id' => '2', 'comment' => 'Second Comment for Second Article', 'published' => 'Y', 'created' => '2007-03-18 10:55:23', 'updated' => '2007-03-18 10:57:31')
			)),
			array ( 'User' => array ( 'id' => '3', 'user' => 'larry'), 'Comment' => array()),
			array ( 'User' => array ( 'id' => '4', 'user' => 'garrett'), 'Comment' => array(
				array( 'id' => '2', 'article_id' => '1', 'user_id' => '4', 'comment' => 'Second Comment for First Article', 'published' => 'Y', 'created' => '2007-03-18 10:47:23', 'updated' => '2007-03-18 10:49:31')
			))
		);
		$this->assertEqual($result, $expected);

		$result = $this->model->hasMany;
		$expected = array( 'Comment' => array('className' => 'Comment', 'foreignKey' => 'user_id', 'conditions' => null, 'fields' => null, 'order' => null, 'limit' => null, 'offset' => null, 'dependent' => null, 'exclusive' => null, 'finderQuery' => null, 'counterQuery' => null) );
		$this->assertEqual($result, $expected);

		$result = $this->model->unbindModel(array('hasMany' => array('Comment')));
		$this->assertTrue($result);

		$result = $this->model->hasMany;
		$expected = array();
		$this->assertEqual($result, $expected);

		$result = $this->model->findAll(null, 'User.id, User.user');
		$expected = array(
			array ( 'User' => array ( 'id' => '1', 'user' => 'mariano')),
			array ( 'User' => array ( 'id' => '2', 'user' => 'nate')),
			array ( 'User' => array ( 'id' => '3', 'user' => 'larry')),
			array ( 'User' => array ( 'id' => '4', 'user' => 'garrett'))
		);
		$this->assertEqual($result, $expected);

		$result = $this->model->findAll(null, 'User.id, User.user');
		$expected = array(
			array ( 'User' => array ( 'id' => '1', 'user' => 'mariano'), 'Comment' => array(
				array( 'id' => '3', 'article_id' => '1', 'user_id' => '1', 'comment' => 'Third Comment for First Article', 'published' => 'Y', 'created' => '2007-03-18 10:49:23', 'updated' => '2007-03-18 10:51:31'),
				array( 'id' => '4', 'article_id' => '1', 'user_id' => '1', 'comment' => 'Fourth Comment for First Article', 'published' => 'N', 'created' => '2007-03-18 10:51:23', 'updated' => '2007-03-18 10:53:31'),
				array( 'id' => '5', 'article_id' => '2', 'user_id' => '1', 'comment' => 'First Comment for Second Article', 'published' => 'Y', 'created' => '2007-03-18 10:53:23', 'updated' => '2007-03-18 10:55:31')
			)),
			array ( 'User' => array ( 'id' => '2', 'user' => 'nate'), 'Comment' => array(
				array( 'id' => '1', 'article_id' => '1', 'user_id' => '2', 'comment' => 'First Comment for First Article', 'published' => 'Y', 'created' => '2007-03-18 10:45:23', 'updated' => '2007-03-18 10:47:31'),
				array( 'id' => '6', 'article_id' => '2', 'user_id' => '2', 'comment' => 'Second Comment for Second Article', 'published' => 'Y', 'created' => '2007-03-18 10:55:23', 'updated' => '2007-03-18 10:57:31')
			)),
			array ( 'User' => array ( 'id' => '3', 'user' => 'larry'), 'Comment' => array()),
			array ( 'User' => array ( 'id' => '4', 'user' => 'garrett'), 'Comment' => array(
				array( 'id' => '2', 'article_id' => '1', 'user_id' => '4', 'comment' => 'Second Comment for First Article', 'published' => 'Y', 'created' => '2007-03-18 10:47:23', 'updated' => '2007-03-18 10:49:31')
			))
		);
		$this->assertEqual($result, $expected);

		$result = $this->model->unbindModel(array('hasMany' => array('Comment')), false);
		$this->assertTrue($result);

		$result = $this->model->findAll(null, 'User.id, User.user');
		$expected = array(
			array ( 'User' => array ( 'id' => '1', 'user' => 'mariano')),
			array ( 'User' => array ( 'id' => '2', 'user' => 'nate')),
			array ( 'User' => array ( 'id' => '3', 'user' => 'larry')),
			array ( 'User' => array ( 'id' => '4', 'user' => 'garrett'))
		);
		$this->assertEqual($result, $expected);

		$result = $this->model->hasMany;
		$expected = array();
		$this->assertEqual($result, $expected);

		$result = $this->model->bindModel(array('hasMany' => array('Comment' => array('className' => 'Comment', 'conditions' => 'Comment.published = \'Y\'') )));
		$this->assertTrue($result);

		$result = $this->model->findAll(null, 'User.id, User.user');
		$expected = array(
			array ( 'User' => array ( 'id' => '1', 'user' => 'mariano'), 'Comment' => array(
				array( 'id' => '3', 'article_id' => '1', 'user_id' => '1', 'comment' => 'Third Comment for First Article', 'published' => 'Y', 'created' => '2007-03-18 10:49:23', 'updated' => '2007-03-18 10:51:31'),
				array( 'id' => '5', 'article_id' => '2', 'user_id' => '1', 'comment' => 'First Comment for Second Article', 'published' => 'Y', 'created' => '2007-03-18 10:53:23', 'updated' => '2007-03-18 10:55:31')
			)),
			array ( 'User' => array ( 'id' => '2', 'user' => 'nate'), 'Comment' => array(
				array( 'id' => '1', 'article_id' => '1', 'user_id' => '2', 'comment' => 'First Comment for First Article', 'published' => 'Y', 'created' => '2007-03-18 10:45:23', 'updated' => '2007-03-18 10:47:31'),
				array( 'id' => '6', 'article_id' => '2', 'user_id' => '2', 'comment' => 'Second Comment for Second Article', 'published' => 'Y', 'created' => '2007-03-18 10:55:23', 'updated' => '2007-03-18 10:57:31')
			)),
			array ( 'User' => array ( 'id' => '3', 'user' => 'larry'), 'Comment' => array()),
			array ( 'User' => array ( 'id' => '4', 'user' => 'garrett'), 'Comment' => array(
				array( 'id' => '2', 'article_id' => '1', 'user_id' => '4', 'comment' => 'Second Comment for First Article', 'published' => 'Y', 'created' => '2007-03-18 10:47:23', 'updated' => '2007-03-18 10:49:31')
			))
		);
		$this->assertEqual($result, $expected);
	}

	function testFindCount() {
		$this->model =& new User();
		$result = $this->model->findCount();
		$this->assertEqual($result, 4);

		$this->db->fullDebug = true;
		$this->model->order = 'User.id';
		$result = $this->model->findCount();
		$this->assertEqual($result, 4);

		$this->assertTrue(isset($this->db->_queriesLog[0]['query']));
		$this->assertNoPattern('/ORDER\s+BY/', $this->db->_queriesLog[0]['query']);

		$this->db->_queriesLog = array();
		$this->db->fullDebug = false;
	}

	function testFindMagic() {
		$this->model =& new User();

		$result = $this->model->findByUser('mariano');
		$expected = array ( 'User' => array (
			'id' => '1', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31'
		));
		$this->assertEqual($result, $expected);

		$result = $this->model->findByPassword('5f4dcc3b5aa765d61d8327deb882cf99');
		$expected = array ( 'User' => array (
			'id' => '1', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31'
		));
		$this->assertEqual($result, $expected);
	}

	function testRead() {
		$this->model =& new User();

		$result = $this->model->read();
		$this->assertFalse($result);

		$this->model->id = 2;
		$result = $this->model->read();
		$expected = array('User' => array ( 'id' => '2', 'user' => 'nate', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:18:23', 'updated' => '2007-03-17 01:20:31'));
		$this->assertEqual($result, $expected);

		$result = $this->model->read(null, 2);
		$expected = array('User' => array ( 'id' => '2', 'user' => 'nate', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:18:23', 'updated' => '2007-03-17 01:20:31'));
		$this->assertEqual($result, $expected);

		$this->model->id = 2;
		$result = $this->model->read(array('id', 'user'));
		$expected = array('User' => array ( 'id' => '2', 'user' => 'nate'));
		$this->assertEqual($result, $expected);

		$result = $this->model->read('id, user', 2);
		$expected = array('User' => array ( 'id' => '2', 'user' => 'nate'));
		$this->assertEqual($result, $expected);

		$result = $this->model->bindModel(array('hasMany' => array('Article')));
		$this->assertTrue($result);

		$this->model->id = 1;
		$result = $this->model->read('id, user');
		$expected = array(
			'User' => array ( 'id' => '1', 'user' => 'mariano'),
			'Article' => array(
				array( 'id' => '1', 'user_id' => '1', 'title' => 'First Article', 'body' => 'First Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:39:23', 'updated' => '2007-03-18 10:41:31' ),
				array( 'id' => '3', 'user_id' => '1', 'title' => 'Third Article', 'body' => 'Third Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:43:23', 'updated' => '2007-03-18 10:45:31' )
			)
		);
		$this->assertEqual($result, $expected);
	}

	function testRecursiveRead() {
		$this->model =& new User();

		$result = $this->model->bindModel(array('hasMany' => array('Article')), false);
		$this->assertTrue($result);

		$this->model->recursive = 0;
		$result = $this->model->read('id, user', 1);
		$expected = array(
			'User' => array ( 'id' => '1', 'user' => 'mariano'),
		);
		$this->assertEqual($result, $expected);

		$this->model->recursive = 1;
		$result = $this->model->read('id, user', 1);
		$expected = array(
			'User' => array ( 'id' => '1', 'user' => 'mariano'),
			'Article' => array(
				array( 'id' => '1', 'user_id' => '1', 'title' => 'First Article', 'body' => 'First Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:39:23', 'updated' => '2007-03-18 10:41:31' ),
				array( 'id' => '3', 'user_id' => '1', 'title' => 'Third Article', 'body' => 'Third Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:43:23', 'updated' => '2007-03-18 10:45:31' )
			)
		);
		$this->assertEqual($result, $expected);

		$this->model->recursive = 2;
		$result = $this->model->read('id, user', 3);
		$expected = array(
			'User' => array ( 'id' => '3', 'user' => 'larry'),
			'Article' => array(
				array(
					'id' => '2', 'user_id' => '3', 'title' => 'Second Article', 'body' => 'Second Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:41:23', 'updated' => '2007-03-18 10:43:31',
					'User' => array (
						'id' => '3', 'user' => 'larry', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:20:23', 'updated' => '2007-03-17 01:22:31'
					),
					'Comment' => array(
						array( 'id' => '5', 'article_id' => '2', 'user_id' => '1', 'comment' => 'First Comment for Second Article', 'published' => 'Y', 'created' => '2007-03-18 10:53:23', 'updated' => '2007-03-18 10:55:31'),
						array( 'id' => '6', 'article_id' => '2', 'user_id' => '2', 'comment' => 'Second Comment for Second Article', 'published' => 'Y', 'created' => '2007-03-18 10:55:23', 'updated' => '2007-03-18 10:57:31')
					),
					'Tag' => array(
						array( 'id' => '1', 'tag' => 'tag1', 'created' => '2007-03-18 12:22:23', 'updated' => '2007-03-18 12:24:31'),
						array( 'id' => '3', 'tag' => 'tag3', 'created' => '2007-03-18 12:26:23', 'updated' => '2007-03-18 12:28:31'),
					)
				)
			)
		);
		$this->assertEqual($result, $expected);
	}

	function testRecursiveFindAll() {
		$this->model =& new Article();

		$result = $this->model->findAll(array('Article.user_id' => 1));
		$expected = array (
			array (
				'Article' => array (
					'id' => '1', 'user_id' => '1', 'title' => 'First Article', 'body' => 'First Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:39:23', 'updated' => '2007-03-18 10:41:31'
				),
				'User' => array (
					'id' => '1', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31'
				),
				'Comment' => array (
					array ( 'id' => '1', 'article_id' => '1', 'user_id' => '2', 'comment' => 'First Comment for First Article', 'published' => 'Y', 'created' => '2007-03-18 10:45:23', 'updated' => '2007-03-18 10:47:31'),
					array ( 'id' => '2', 'article_id' => '1', 'user_id' => '4', 'comment' => 'Second Comment for First Article', 'published' => 'Y', 'created' => '2007-03-18 10:47:23', 'updated' => '2007-03-18 10:49:31'),
					array ( 'id' => '3', 'article_id' => '1', 'user_id' => '1', 'comment' => 'Third Comment for First Article', 'published' => 'Y', 'created' => '2007-03-18 10:49:23', 'updated' => '2007-03-18 10:51:31'),
					array ( 'id' => '4', 'article_id' => '1', 'user_id' => '1', 'comment' => 'Fourth Comment for First Article', 'published' => 'N', 'created' => '2007-03-18 10:51:23', 'updated' => '2007-03-18 10:53:31')
				),
				'Tag' => array (
					array ( 'id' => '1', 'tag' => 'tag1', 'created' => '2007-03-18 12:22:23', 'updated' => '2007-03-18 12:24:31'),
					array ( 'id' => '2', 'tag' => 'tag2', 'created' => '2007-03-18 12:24:23', 'updated' => '2007-03-18 12:26:31')
				)
			),
			array (
				'Article' => array (
					'id' => '3', 'user_id' => '1', 'title' => 'Third Article', 'body' => 'Third Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:43:23', 'updated' => '2007-03-18 10:45:31'
				),
				'User' => array (
					'id' => '1', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31'
				),
				'Comment' => array ( ),
				'Tag' => array ( )
			)
		);
		$this->assertEqual($result, $expected);

		$result = $this->model->findAll(array('Article.user_id' => 3), null, null, null, 1, 2);
		$expected = array (
			array (
				'Article' => array (
					'id' => '2', 'user_id' => '3', 'title' => 'Second Article', 'body' => 'Second Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:41:23', 'updated' => '2007-03-18 10:43:31'
				),
				'User' => array (
					'id' => '3', 'user' => 'larry', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:20:23', 'updated' => '2007-03-17 01:22:31'
				),
				'Comment' => array (
					array (
						'id' => '5', 'article_id' => '2', 'user_id' => '1', 'comment' => 'First Comment for Second Article', 'published' => 'Y', 'created' => '2007-03-18 10:53:23', 'updated' => '2007-03-18 10:55:31',
						'Article' => array (
							'id' => '2', 'user_id' => '3', 'title' => 'Second Article', 'body' => 'Second Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:41:23', 'updated' => '2007-03-18 10:43:31'
						),
						'User' => array (
							'id' => '1', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31'
						),
						'Attachment' => array(
							'id' => '1', 'comment_id' => 5, 'attachment' => 'attachment.zip', 'created' => '2007-03-18 10:51:23', 'updated' => '2007-03-18 10:53:31'
						)
					),
					array (
						'id' => '6', 'article_id' => '2', 'user_id' => '2', 'comment' => 'Second Comment for Second Article', 'published' => 'Y', 'created' => '2007-03-18 10:55:23', 'updated' => '2007-03-18 10:57:31',
						'Article' => array (
							'id' => '2', 'user_id' => '3', 'title' => 'Second Article', 'body' => 'Second Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:41:23', 'updated' => '2007-03-18 10:43:31'
						),
						'User' => array (
							'id' => '2', 'user' => 'nate', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:18:23', 'updated' => '2007-03-17 01:20:31'
						),
						'Attachment' => false
					)
				),
				'Tag' => array (
					array ( 'id' => '1', 'tag' => 'tag1', 'created' => '2007-03-18 12:22:23', 'updated' => '2007-03-18 12:24:31'),
					array ( 'id' => '3', 'tag' => 'tag3', 'created' => '2007-03-18 12:26:23', 'updated' => '2007-03-18 12:28:31')
				)
			)
		);
		$this->assertEqual($result, $expected);

		$this->Featured = new Featured();

		$this->Featured->recursive = 2;
		$this->Featured->bindModel(array(
			'belongsTo' => array(
				'ArticleFeatured' => array(
					'conditions' => 'ArticleFeatured.published = \'Y\'',
					'fields' => 'id, title, user_id, published'
				)
			)
		));

		$this->Featured->ArticleFeatured->unbindModel(array(
			'hasMany' => array('Attachment', 'Comment'),
			'hasAndBelongsToMany'=>array('Tag'))
		);

		$orderBy = 'ArticleFeatured.id ASC';
		$result = $this->Featured->findAll(null, null, $orderBy, 3);

		$expected = array (
			array (
				'Featured' => array (
					'id' => '1',
					'article_featured_id' => '1',
					'category_id' => '1',
					'published_date' => '2007-03-31 10:39:23',
					'end_date' => '2007-05-15 10:39:23',
					'created' => '2007-03-18 10:39:23',
					'updated' => '2007-03-18 10:41:31'
				),
				'ArticleFeatured' => array (
					'id' => '1',
					'title' => 'First Article',
					'user_id' => '1',
					'published' => 'Y',
					'User' => array (
						'id' => '1',
						'user' => 'mariano',
						'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
						'created' => '2007-03-17 01:16:23',
						'updated' => '2007-03-17 01:18:31'
					),
					'Category' => array(),
					'Featured' => array (
						'id' => '1',
						'article_featured_id' => '1',
						'category_id' => '1',
						'published_date' => '2007-03-31 10:39:23',
						'end_date' => '2007-05-15 10:39:23',
						'created' => '2007-03-18 10:39:23',
						'updated' => '2007-03-18 10:41:31'
					)
				),
				'Category' => array (
					'id' => '1',
					'parent_id' => '0',
					'name' => 'Category 1',
					'created' => '2007-03-18 15:30:23',
					'updated' => '2007-03-18 15:32:31'
				)
			),
			array (
				'Featured' => array (
					'id' => '2',
					'article_featured_id' => '2',
					'category_id' => '1',
					'published_date' => '2007-03-31 10:39:23',
					'end_date' => '2007-05-15 10:39:23',
					'created' => '2007-03-18 10:39:23',
					'updated' => '2007-03-18 10:41:31'
				),
				'ArticleFeatured' => array (
					'id' => '2',
					'title' => 'Second Article',
					'user_id' => '3',
					'published' => 'Y',
					'User' => array (
						'id' => '3',
						'user' => 'larry',
						'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
						'created' => '2007-03-17 01:20:23',
						'updated' => '2007-03-17 01:22:31'
					),
					'Category' => array(),
					'Featured' => array (
						'id' => '2',
						'article_featured_id' => '2',
						'category_id' => '1',
						'published_date' => '2007-03-31 10:39:23',
						'end_date' => '2007-05-15 10:39:23',
						'created' => '2007-03-18 10:39:23',
						'updated' => '2007-03-18 10:41:31'
					)
				),
				'Category' => array (
					'id' => '1',
					'parent_id' => '0',
					'name' => 'Category 1',
					'created' => '2007-03-18 15:30:23',
					'updated' => '2007-03-18 15:32:31'
				)
			)
		);

		$this->assertEqual($result, $expected);
	}

function testRecursiveFindAllWithLimit() {
		$this->model =& new Article();

		$this->model->hasMany['Comment']['limit'] = 2;

		$result = $this->model->findAll(array('Article.user_id' => 1));
		$expected = array (
			array (
				'Article' => array (
					'id' => '1', 'user_id' => '1', 'title' => 'First Article', 'body' => 'First Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:39:23', 'updated' => '2007-03-18 10:41:31'
				),
				'User' => array (
					'id' => '1', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31'
				),
				'Comment' => array (
					array ( 'id' => '1', 'article_id' => '1', 'user_id' => '2', 'comment' => 'First Comment for First Article', 'published' => 'Y', 'created' => '2007-03-18 10:45:23', 'updated' => '2007-03-18 10:47:31'),
					array ( 'id' => '2', 'article_id' => '1', 'user_id' => '4', 'comment' => 'Second Comment for First Article', 'published' => 'Y', 'created' => '2007-03-18 10:47:23', 'updated' => '2007-03-18 10:49:31'),
				),
				'Tag' => array (
					array ( 'id' => '1', 'tag' => 'tag1', 'created' => '2007-03-18 12:22:23', 'updated' => '2007-03-18 12:24:31'),
					array ( 'id' => '2', 'tag' => 'tag2', 'created' => '2007-03-18 12:24:23', 'updated' => '2007-03-18 12:26:31')
				)
			),
			array (
				'Article' => array (
					'id' => '3', 'user_id' => '1', 'title' => 'Third Article', 'body' => 'Third Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:43:23', 'updated' => '2007-03-18 10:45:31'
				),
				'User' => array (
					'id' => '1', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31'
				),
				'Comment' => array ( ),
				'Tag' => array ( )
			)
		);
		$this->assertEqual($result, $expected);

		$this->model->hasMany['Comment']['limit'] = 1;

		$result = $this->model->findAll(array('Article.user_id' => 3), null, null, null, 1, 2);
		$expected = array (
			array (
				'Article' => array (
					'id' => '2', 'user_id' => '3', 'title' => 'Second Article', 'body' => 'Second Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:41:23', 'updated' => '2007-03-18 10:43:31'
				),
				'User' => array (
					'id' => '3', 'user' => 'larry', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:20:23', 'updated' => '2007-03-17 01:22:31'
				),
				'Comment' => array (
					array (
						'id' => '5', 'article_id' => '2', 'user_id' => '1', 'comment' => 'First Comment for Second Article', 'published' => 'Y', 'created' => '2007-03-18 10:53:23', 'updated' => '2007-03-18 10:55:31',
						'Article' => array (
							'id' => '2', 'user_id' => '3', 'title' => 'Second Article', 'body' => 'Second Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:41:23', 'updated' => '2007-03-18 10:43:31'
						),
						'User' => array (
							'id' => '1', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31'
						),
						'Attachment' => array(
							'id' => '1', 'comment_id' => 5, 'attachment' => 'attachment.zip', 'created' => '2007-03-18 10:51:23', 'updated' => '2007-03-18 10:53:31'
						)
					)
				),
				'Tag' => array (
					array ( 'id' => '1', 'tag' => 'tag1', 'created' => '2007-03-18 12:22:23', 'updated' => '2007-03-18 12:24:31'),
					array ( 'id' => '3', 'tag' => 'tag3', 'created' => '2007-03-18 12:26:23', 'updated' => '2007-03-18 12:28:31')
				)
			)
		);
		$this->assertEqual($result, $expected);
	}

	function testAssociationAfterFind() {
		$this->model =& new Post();
		$result = $this->model->findAll();
		$expected = array(
			array(
				'Post' => array('id' => '1', 'author_id' => '1', 'title' => 'First Post', 'body' => 'First Post Body', 'published' => 'Y', 'created' => '2007-03-18 10:39:23', 'updated' => '2007-03-18 10:41:31'),
				'Author' => array('id' => '1', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31', 'test' => 'working'),
			), array(
				'Post' => array ('id' => '2', 'author_id' => '3', 'title' => 'Second Post', 'body' => 'Second Post Body', 'published' => 'Y', 'created' => '2007-03-18 10:41:23', 'updated' => '2007-03-18 10:43:31'),
				'Author' => array('id' => '3', 'user' => 'larry', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:20:23', 'updated' => '2007-03-17 01:22:31', 'test' => 'working'),
			), array(
				'Post' => array('id' => '3', 'author_id' => '1', 'title' => 'Third Post', 'body' => 'Third Post Body', 'published' => 'Y', 'created' => '2007-03-18 10:43:23', 'updated' => '2007-03-18 10:45:31'),
				'Author' => array('id' => '1', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31', 'test' => 'working')
			)
		);
		$this->assertEqual($result, $expected);
	}

	function testValidatesBackwards() {
		$this->model =& new TestValidate();

		$this->model->validate = array(
			'user_id' => VALID_NUMBER,
			'title' => VALID_NOT_EMPTY,
			'body' => VALID_NOT_EMPTY
		);

		$data = array('TestValidate' => array('user_id' => '1', 'title' => '', 'body' => ''));
		$result = $this->model->create($data);
		$this->assertTrue($result);
		$result = $this->model->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array('user_id' => '1', 'title' => 'title', 'body' => ''));
		$result = $this->model->create($data);
		$this->assertTrue($result);
		$result = $this->model->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array('user_id' => '', 'title' => 'title', 'body' => 'body'));
		$result = $this->model->create($data);
		$this->assertTrue($result);
		$result = $this->model->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array('user_id' => 'not a number', 'title' => 'title', 'body' => 'body'));
		$result = $this->model->create($data);
		$this->assertTrue($result);
		$result = $this->model->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array('user_id' => '1', 'title' => 'title', 'body' => 'body'));
		$result = $this->model->create($data);
		$this->assertTrue($result);
		$result = $this->model->validates();
		$this->assertTrue($result);
	}

	function testValidates() {
		$this->model =& new TestValidate();

		$this->model->validate = array(
			'user_id' => VALID_NUMBER,
			'title' => array('allowEmpty' => false, 'rule' => VALID_NOT_EMPTY),
			'body' => VALID_NOT_EMPTY
		);

		$data = array('TestValidate' => array('user_id' => '1', 'title' => '', 'body' => 'body'));
		$result = $this->model->create($data);
		$this->assertTrue($result);
		$result = $this->model->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array('user_id' => '1', 'title' => 'title', 'body' => 'body'));
		$result = $this->model->create($data) && $this->model->validates();
		$this->assertTrue($result);

		$data = array('TestValidate' => array('user_id' => '1', 'title' => '0', 'body' => 'body'));
		$result = $this->model->create($data);
		$this->assertTrue($result);
		$result = $this->model->validates();
		$this->assertTrue($result);

		$data = array('TestValidate' => array('user_id' => '1', 'title' => 0, 'body' => 'body'));
		$result = $this->model->create($data);
		$this->assertTrue($result);
		$result = $this->model->validates();
		$this->assertTrue($result);

		$this->model->validate['modified'] = array('allowEmpty' => true, 'rule' => 'date');

		$data = array('TestValidate' => array('user_id' => '1', 'title' => 0, 'body' => 'body', 'modified' => ''));
		$result = $this->model->create($data);
		$this->assertTrue($result);
		$result = $this->model->validates();
		$this->assertTrue($result);

		$data = array('TestValidate' => array('user_id' => '1', 'title' => 0, 'body' => 'body', 'modified' => '2007-05-01'));
		$result = $this->model->create($data);
		$this->assertTrue($result);
		$result = $this->model->validates();
		$this->assertTrue($result);

		$data = array('TestValidate' => array('user_id' => '1', 'title' => 0, 'body' => 'body', 'modified' => 'invalid-date-here'));
		$result = $this->model->create($data);
		$this->assertTrue($result);
		$result = $this->model->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array('user_id' => '1', 'title' => 0, 'body' => 'body', 'modified' => 0));
		$result = $this->model->create($data);
		$this->assertTrue($result);
		$result = $this->model->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array('user_id' => '1', 'title' => 0, 'body' => 'body', 'modified' => '0'));
		$result = $this->model->create($data);
		$this->assertTrue($result);
		$result = $this->model->validates();
		$this->assertFalse($result);

		$this->model->validate['slug'] = array('allowEmpty' => false, 'rule' => array('maxLength', 45));

		$data = array('TestValidate' => array('user_id' => '1', 'title' => 0, 'body' => 'body', 'slug' => ''));
		$result = $this->model->create($data);
		$this->assertTrue($result);
		$result = $this->model->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array('user_id' => '1', 'title' => 0, 'body' => 'body', 'slug' => 'slug-right-here'));
		$result = $this->model->create($data);
		$this->assertTrue($result);
		$result = $this->model->validates();
		$this->assertTrue($result);

		$data = array('TestValidate' => array('user_id' => '1', 'title' => 0, 'body' => 'body', 'slug' => 'abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz'));
		$result = $this->model->create($data);
		$this->assertTrue($result);
		$result = $this->model->validates();
		$this->assertFalse($result);

		$this->model->validate = array(
			'number' => array(
				'rule' => 'validateNumber',
				'min' => 3,
				'max' => 5
			),
			'title' => array('allowEmpty' => false, 'rule' => VALID_NOT_EMPTY)
		);

		$data = array('TestValidate' => array('title' => 'title', 'number' => '0'));
		$result = $this->model->create($data);
		$this->assertTrue($result);
		$result = $this->model->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array('title' => 'title', 'number' => 0));
		$result = $this->model->create($data);
		$this->assertTrue($result);
		$result = $this->model->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array('title' => 'title', 'number' => '3'));
		$result = $this->model->create($data);
		$this->assertTrue($result);
		$result = $this->model->validates();
		$this->assertTrue($result);

		$data = array('TestValidate' => array('title' => 'title', 'number' => 3));
		$result = $this->model->create($data);
		$this->assertTrue($result);
		$result = $this->model->validates();
		$this->assertTrue($result);

		$this->model->validate = array(
			'number' => array(
				'rule' => 'validateNumber',
				'min' => 5,
				'max' => 10
			),
			'title' => array('allowEmpty' => false, 'rule' => VALID_NOT_EMPTY)
		);

		$data = array('TestValidate' => array('title' => 'title', 'number' => '3'));
		$result = $this->model->create($data);
		$this->assertTrue($result);
		$result = $this->model->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array('title' => 'title', 'number' => 3));
		$result = $this->model->create($data);
		$this->assertTrue($result);
		$result = $this->model->validates();
		$this->assertFalse($result);

		$this->model->validate = array(
			'title' => array('allowEmpty' => false, 'rule' => 'validateTitle')
		);

		$data = array('TestValidate' => array('title' => ''));
		$result = $this->model->create($data);
		$this->assertTrue($result);
		$result = $this->model->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array('title' => 'new title'));
		$result = $this->model->create($data);
		$this->assertTrue($result);
		$result = $this->model->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array('title' => 'title-new'));
		$result = $this->model->create($data);
		$this->assertTrue($result);
		$result = $this->model->validates();
		$this->assertTrue($result);

		$this->model->validate = array(
			'title' => array('allowEmpty' => true, 'rule' => 'validateTitle')
		);

		$data = array('TestValidate' => array('title' => ''));
		$result = $this->model->create($data);
		$this->assertTrue($result);
		$result = $this->model->validates();
		$this->assertTrue($result);
	}

	function testSaveField() {
		$this->model =& new Article();

		$this->model->id = 1;
		$result = $this->model->saveField('title', 'New First Article');
		$this->assertTrue($result);

		$this->model->recursive = -1;
		$result = $this->model->read(array('id', 'user_id', 'title', 'body'), 1);
		$expected = array('Article' => array (
			'id' => '1', 'user_id' => '1', 'title' => 'New First Article', 'body' => 'First Article Body'
		));

		$this->model->id = 1;
		$result = $this->model->saveField('title', '');
		$this->assertTrue($result);

		$this->model->recursive = -1;
		$result = $this->model->read(array('id', 'user_id', 'title', 'body'), 1);
		$expected = array('Article' => array (
			'id' => '1', 'user_id' => '1', 'title' => '', 'body' => 'First Article Body'
		));

		$this->model->id = 1;
		$result = $this->model->saveField('title', 'First Article');
		$this->assertTrue($result);

		$this->model->recursive = -1;
		$result = $this->model->read(array('id', 'user_id', 'title', 'body'), 1);
		$expected = array('Article' => array (
			'id' => '1', 'user_id' => '1', 'title' => 'First Article', 'body' => 'First Article Body'
		));

		$this->model->id = 1;
		$result = $this->model->saveField('title', '', true);
		$this->assertFalse($result);
	}

	function testSaveWithCreate() {
		$this->model =& new User();

		$data = array('User' => array('user' => 'user', 'password' => ''));
		$result = $this->model->save($data);
		$this->assertFalse($result);
		$this->assertTrue(!empty($this->model->validationErrors));

		$this->model =& new Article();

		$data = array('Article' => array('user_id' => '', 'title' => '', 'body' => ''));
		$result = $this->model->create($data) && $this->model->save();
		$this->assertFalse($result);
		$this->assertTrue(!empty($this->model->validationErrors));

		$data = array('Article' => array('id' => 1, 'user_id' => '1', 'title' => 'New First Article', 'body' => ''));
		$result = $this->model->create($data) && $this->model->save();
		$this->assertFalse($result);

		$data = array('Article' => array('id' => 1, 'title' => 'New First Article'));
		$result = $this->model->create() && $this->model->save($data, false);
		$this->assertTrue($result);

		$this->model->recursive = -1;
		$result = $this->model->read(array('id', 'user_id', 'title', 'body', 'published'), 1);
		$expected = array('Article' => array (
			'id' => '1', 'user_id' => '1', 'title' => 'New First Article', 'body' => 'First Article Body', 'published' => 'N'
		));
		$this->assertEqual($result, $expected);

		$data = array('Article' => array('id' => 1, 'user_id' => '2', 'title' => 'First Article', 'body' => 'New First Article Body', 'published' => 'Y'));
		$result = $this->model->create() && $this->model->save($data, true, array('title', 'published'));
		$this->assertTrue($result);

		$this->model->recursive = -1;
		$result = $this->model->read(array('id', 'user_id', 'title', 'body', 'published'), 1);
		$expected = array('Article' => array (
			'id' => '1', 'user_id' => '1', 'title' => 'First Article', 'body' => 'First Article Body', 'published' => 'Y'
		));
		$this->assertEqual($result, $expected);

		$data = array(
			'Article' => array(
				'user_id' => '2', 'title' => 'New Article', 'body' => 'New Article Body', 'created' => '2007-03-18 14:55:23', 'updated' => '2007-03-18 14:57:31'
			),
			'Tag' => array(
				'Tag' => array(1, 3)
			)
		);
		$result = $this->model->create() && $this->model->save($data);
		$this->assertTrue($result);

		$this->model->recursive = 2;
		$result = $this->model->read(null, 4);
		$expected = array (
			'Article' => array (
				'id' => '4', 'user_id' => '2', 'title' => 'New Article', 'body' => 'New Article Body', 'published' => 'N', 'created' => '2007-03-18 14:55:23', 'updated' => '2007-03-18 14:57:31'
			),
			'User' => array(
				'id' => '2', 'user' => 'nate', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:18:23', 'updated' => '2007-03-17 01:20:31'
			),
			'Comment' => array ( ),
			'Tag' => array (
				array ( 'id' => '1', 'tag' => 'tag1', 'created' => '2007-03-18 12:22:23', 'updated' => '2007-03-18 12:24:31'),
				array ( 'id' => '3', 'tag' => 'tag3', 'created' => '2007-03-18 12:26:23', 'updated' => '2007-03-18 12:28:31')
			)
		);
		$this->assertEqual($result, $expected);

		$data = array('Comment' => array(
				'article_id' => '4', 'user_id' => '1', 'comment' => 'Comment New Article', 'published' => 'Y', 'created' => '2007-03-18 14:57:23', 'updated' => '2007-03-18 14:59:31'
		));
		$result = $this->model->Comment->create() && $this->model->Comment->save($data);
		$this->assertTrue($result);

		$data = array('Attachment' => array(
				'comment_id' => '7', 'attachment' => 'newattachment.zip', 'created' => '2007-03-18 15:02:23', 'updated' => '2007-03-18 15:04:31'
		));
		$result = $this->model->Comment->Attachment->save($data);
		$this->assertTrue($result);

		$this->model->recursive = 2;
		$result = $this->model->read(null, 4);
		$expected = array (
			'Article' => array (
				'id' => '4', 'user_id' => '2', 'title' => 'New Article', 'body' => 'New Article Body', 'published' => 'N', 'created' => '2007-03-18 14:55:23', 'updated' => '2007-03-18 14:57:31'
			),
			'User' => array(
				'id' => '2', 'user' => 'nate', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:18:23', 'updated' => '2007-03-17 01:20:31'
			),
			'Comment' => array (
				array (
					'id' => '7', 'article_id' => '4', 'user_id' => '1', 'comment' => 'Comment New Article', 'published' => 'Y', 'created' => '2007-03-18 14:57:23', 'updated' => '2007-03-18 14:59:31',
					'Article' => array (
						'id' => '4', 'user_id' => '2', 'title' => 'New Article', 'body' => 'New Article Body', 'published' => 'N', 'created' => '2007-03-18 14:55:23', 'updated' => '2007-03-18 14:57:31'
					),
					'User' => array (
						'id' => '1', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31'
					),
					'Attachment' => array(
						'id' => '2', 'comment_id' => '7', 'attachment' => 'newattachment.zip', 'created' => '2007-03-18 15:02:23', 'updated' => '2007-03-18 15:04:31'
					)
				)
			),
			'Tag' => array (
				array ( 'id' => '1', 'tag' => 'tag1', 'created' => '2007-03-18 12:22:23', 'updated' => '2007-03-18 12:24:31'),
				array ( 'id' => '3', 'tag' => 'tag3', 'created' => '2007-03-18 12:26:23', 'updated' => '2007-03-18 12:28:31')
			)
		);
		$this->assertEqual($result, $expected);
	}

	function testSaveWithSet() {
		$this->model =& new Article();

		// Create record we will be updating later

		$data = array('Article' => array('user_id' => '1', 'title' => 'Fourth Article', 'body' => 'Fourth Article Body', 'published' => 'Y'));
		$result = $this->model->create() && $this->model->save($data);
		$this->assertTrue($result);

		// Check record we created

		$this->model->recursive = -1;
		$result = $this->model->read(array('id', 'user_id', 'title', 'body', 'published'), 4);
		$expected = array('Article' => array (
			'id' => '4', 'user_id' => '1', 'title' => 'Fourth Article', 'body' => 'Fourth Article Body', 'published' => 'Y'
		));
		$this->assertEqual($result, $expected);

		// Create new record just to overlap Model->id on previously created record

		$data = array('Article' => array('user_id' => '4', 'title' => 'Fifth Article', 'body' => 'Fifth Article Body', 'published' => 'Y'));
		$result = $this->model->create() && $this->model->save($data);
		$this->assertTrue($result);

		$this->model->recursive = -1;
		$result = $this->model->read(array('id', 'user_id', 'title', 'body', 'published'), 5);
		$expected = array('Article' => array (
			'id' => '5', 'user_id' => '4', 'title' => 'Fifth Article', 'body' => 'Fifth Article Body', 'published' => 'Y'
		));
		$this->assertEqual($result, $expected);

		// Go back and edit the first article we created, starting by checking it's still there

		$this->model->recursive = -1;
		$result = $this->model->read(array('id', 'user_id', 'title', 'body', 'published'), 4);
		$expected = array('Article' => array (
			'id' => '4', 'user_id' => '1', 'title' => 'Fourth Article', 'body' => 'Fourth Article Body', 'published' => 'Y'
		));
		$this->assertEqual($result, $expected);

		// And now do the update with set()

		$data = array('Article' => array('id' => '4', 'title' => 'Fourth Article - New Title', 'published' => 'N'));

		$result = $this->model->set($data) && $this->model->save();

		// THIS WORKS, but it just looks awful and should not be needed
		// $result = $this->model->set($data) && $this->model->save($data);

		// THIS WORKS, but should not be used for editing since create() uses default DB values for fields I am not editing:
		// $result = $this->model->create() && $this->model->save($data);

		$this->assertTrue($result);

		// And see if it got edited

		$this->model->recursive = -1;
		$result = $this->model->read(array('id', 'user_id', 'title', 'body', 'published'), 4);
		$expected = array('Article' => array (
			'id' => '4', 'user_id' => '1', 'title' => 'Fourth Article - New Title', 'body' => 'Fourth Article Body', 'published' => 'N'
		));
		$this->assertEqual($result, $expected);

		// Make sure article we created to overlap is still intact

		$this->model->recursive = -1;
		$result = $this->model->read(array('id', 'user_id', 'title', 'body', 'published'), 5);
		$expected = array('Article' => array (
			'id' => '5', 'user_id' => '4', 'title' => 'Fifth Article', 'body' => 'Fifth Article Body', 'published' => 'Y'
		));
		$this->assertEqual($result, $expected);

		// Edit new this overlapped article

		$data = array('Article' => array('id' => '5', 'title' => 'Fifth Article - New Title 5'));

		$result = $this->model->set($data) && $this->model->save();
		$this->assertTrue($result);

		// Check it's now updated

		$this->model->recursive = -1;
		$result = $this->model->read(array('id', 'user_id', 'title', 'body', 'published'), 5);
		$expected = array('Article' => array (
			'id' => '5', 'user_id' => '4', 'title' => 'Fifth Article - New Title 5', 'body' => 'Fifth Article Body', 'published' => 'Y'
		));
		$this->assertEqual($result, $expected);

		// And now do a final check on all article titles

		$this->model->recursive = -1;
		$result = $this->model->findAll(null, array('id', 'title'));
		$expected = array(
			array('Article' => array( 'id' => 1, 'title' => 'First Article' )),
			array('Article' => array( 'id' => 2, 'title' => 'Second Article' )),
			array('Article' => array( 'id' => 3, 'title' => 'Third Article' )),
			array('Article' => array( 'id' => 4, 'title' => 'Fourth Article - New Title' )),
			array('Article' => array( 'id' => 5, 'title' => 'Fifth Article - New Title 5' ))
		);
		$this->assertEqual($result, $expected);
	}

	function testSaveHabtm() {
		$this->model =& new Article();

		$result = $this->model->findById(2);
		$expected = array(
			'Article' => array(
				'id' => '2', 'user_id' => '3', 'title' => 'Second Article', 'body' => 'Second Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:41:23', 'updated' => '2007-03-18 10:43:31'
			),
			'User' => array (
				'id' => '3', 'user' => 'larry', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:20:23', 'updated' => '2007-03-17 01:22:31'
			),
			'Comment' => array(
				array( 'id' => '5', 'article_id' => '2', 'user_id' => '1', 'comment' => 'First Comment for Second Article', 'published' => 'Y', 'created' => '2007-03-18 10:53:23', 'updated' => '2007-03-18 10:55:31'),
				array( 'id' => '6', 'article_id' => '2', 'user_id' => '2', 'comment' => 'Second Comment for Second Article', 'published' => 'Y', 'created' => '2007-03-18 10:55:23', 'updated' => '2007-03-18 10:57:31')
			),
			'Tag' => array(
				array( 'id' => '1', 'tag' => 'tag1', 'created' => '2007-03-18 12:22:23', 'updated' => '2007-03-18 12:24:31'),
				array( 'id' => '3', 'tag' => 'tag3', 'created' => '2007-03-18 12:26:23', 'updated' => '2007-03-18 12:28:31')
			)
		);
		$this->assertEqual($result, $expected);

		// Save with parent model data

		$data = array(
			'Article' => array( 'id' => '2', 'title' => 'New Second Article' ),
			'Tag' => array(
				'Tag' => array( 1, 2 )
			)
		);

		$result = $this->model->set($data);
		$this->assertTrue($result);

		$result = $this->model->save();
		$this->assertTrue($result);

		$this->model->unbindModel(array(
			'belongsTo' => array('User'),
			'hasMany' => array('Comment')
		));
		$result = $this->model->find(array('Article.id'=>2), array('id', 'user_id', 'title', 'body'));
		$expected = array(
			'Article' => array(
				'id' => '2', 'user_id' => '3', 'title' => 'New Second Article', 'body' => 'Second Article Body'
			),
			'Tag' => array(
				array( 'id' => '1', 'tag' => 'tag1', 'created' => '2007-03-18 12:22:23', 'updated' => '2007-03-18 12:24:31'),
				array( 'id' => '2', 'tag' => 'tag2', 'created' => '2007-03-18 12:24:23', 'updated' => '2007-03-18 12:26:31')
			)
		);
		$this->assertEqual($result, $expected);

		// Setting just parent ID

		$data = array(
			'Article' => array( 'id' => '2' ),
			'Tag' => array(
				'Tag' => array( 2, 3 )
			)
		);

		$result = $this->model->set($data);
		$this->assertTrue($result);

		$result = $this->model->save();
		$this->assertTrue($result);

		$this->model->unbindModel(array(
			'belongsTo' => array('User'),
			'hasMany' => array('Comment')
		));
		$result = $this->model->find(array('Article.id'=>2), array('id', 'user_id', 'title', 'body'));
		$expected = array(
			'Article' => array(
				'id' => '2', 'user_id' => '3', 'title' => 'New Second Article', 'body' => 'Second Article Body'
			),
			'Tag' => array(
				array( 'id' => '2', 'tag' => 'tag2', 'created' => '2007-03-18 12:24:23', 'updated' => '2007-03-18 12:26:31'),
				array( 'id' => '3', 'tag' => 'tag3', 'created' => '2007-03-18 12:26:23', 'updated' => '2007-03-18 12:28:31')
			)
		);
		$this->assertEqual($result, $expected);

		// Setting no parent data

		$data = array(
			'Tag' => array(
				'Tag' => array( 1, 2, 3 )
			)
		);

		$result = $this->model->set($data);
		$this->assertTrue($result);

		$result = $this->model->save();
		$this->assertTrue($result);

		$this->model->unbindModel(array(
			'belongsTo' => array('User'),
			'hasMany' => array('Comment')
		));
		$result = $this->model->find(array('Article.id'=>2), array('id', 'user_id', 'title', 'body'));
		$expected = array(
			'Article' => array(
				'id' => '2', 'user_id' => '3', 'title' => 'New Second Article', 'body' => 'Second Article Body'
			),
			'Tag' => array(
				array( 'id' => '1', 'tag' => 'tag1', 'created' => '2007-03-18 12:22:23', 'updated' => '2007-03-18 12:24:31'),
				array( 'id' => '2', 'tag' => 'tag2', 'created' => '2007-03-18 12:24:23', 'updated' => '2007-03-18 12:26:31'),
				array( 'id' => '3', 'tag' => 'tag3', 'created' => '2007-03-18 12:26:23', 'updated' => '2007-03-18 12:28:31')
			)
		);
		$this->assertEqual($result, $expected);

		$data = array(
			'Tag' => array(
				'Tag' => array( )
			)
		);

		$result = $this->model->set($data);
		$this->assertTrue($result);

		$result = $this->model->save();
		$this->assertTrue($result);

		$this->model->unbindModel(array(
			'belongsTo' => array('User'),
			'hasMany' => array('Comment')
		));
		$result = $this->model->find(array('Article.id'=>2), array('id', 'user_id', 'title', 'body'));
		$expected = array(
			'Article' => array(
				'id' => '2', 'user_id' => '3', 'title' => 'New Second Article', 'body' => 'Second Article Body'
			),
			'Tag' => array()
		);
		$this->assertEqual($result, $expected);

		$data = array(
			'Tag' => array(
				'Tag' => array( 2, 3 )
			)
		);

		$result = $this->model->set($data);
		$this->assertTrue($result);

		$result = $this->model->save();
		$this->assertTrue($result);

		$this->model->unbindModel(array(
			'belongsTo' => array('User'),
			'hasMany' => array('Comment')
		));
		$result = $this->model->find(array('Article.id'=>2), array('id', 'user_id', 'title', 'body'));
		$expected = array(
			'Article' => array(
				'id' => '2', 'user_id' => '3', 'title' => 'New Second Article', 'body' => 'Second Article Body'
			),
			'Tag' => array(
				array( 'id' => '2', 'tag' => 'tag2', 'created' => '2007-03-18 12:24:23', 'updated' => '2007-03-18 12:26:31'),
				array( 'id' => '3', 'tag' => 'tag3', 'created' => '2007-03-18 12:26:23', 'updated' => '2007-03-18 12:28:31')
			)
		);
		$this->assertEqual($result, $expected);

		// Parent data after HABTM data

		$data = array(
			'Tag' => array(
				'Tag' => array( 1, 2 )
			),
			'Article' => array( 'id' => '2', 'title' => 'New Second Article' ),
		);

		$result = $this->model->set($data);
		$this->assertTrue($result);

		$result = $this->model->save();
		$this->assertTrue($result);

		$this->model->unbindModel(array(
			'belongsTo' => array('User'),
			'hasMany' => array('Comment')
		));
		$result = $this->model->find(array('Article.id'=>2), array('id', 'user_id', 'title', 'body'));
		$expected = array(
			'Article' => array(
				'id' => '2', 'user_id' => '3', 'title' => 'New Second Article', 'body' => 'Second Article Body'
			),
			'Tag' => array(
				array( 'id' => '1', 'tag' => 'tag1', 'created' => '2007-03-18 12:22:23', 'updated' => '2007-03-18 12:24:31'),
				array( 'id' => '2', 'tag' => 'tag2', 'created' => '2007-03-18 12:24:23', 'updated' => '2007-03-18 12:26:31')
			)
		);
		$this->assertEqual($result, $expected);

		$data = array(
			'Tag' => array(
				'Tag' => array( 1, 2 )
			),
			'Article' => array( 'id' => '2', 'title' => 'New Second Article Title' ),
		);

		$result = $this->model->set($data);
		$this->assertTrue($result);

		$result = $this->model->save();
		$this->assertTrue($result);

		$this->model->unbindModel(array(
			'belongsTo' => array('User'),
			'hasMany' => array('Comment')
		));
		$result = $this->model->find(array('Article.id'=>2), array('id', 'user_id', 'title', 'body'));
		$expected = array(
			'Article' => array(
				'id' => '2', 'user_id' => '3', 'title' => 'New Second Article Title', 'body' => 'Second Article Body'
			),
			'Tag' => array(
				array( 'id' => '1', 'tag' => 'tag1', 'created' => '2007-03-18 12:22:23', 'updated' => '2007-03-18 12:24:31'),
				array( 'id' => '2', 'tag' => 'tag2', 'created' => '2007-03-18 12:24:23', 'updated' => '2007-03-18 12:26:31')
			)
		);
		$this->assertEqual($result, $expected);

		$data = array(
			'Tag' => array(
				'Tag' => array( 2, 3 )
			),
			'Article' => array( 'id' => '2', 'title' => 'Changed Second Article' ),
		);

		$result = $this->model->set($data);
		$this->assertTrue($result);

		$result = $this->model->save();
		$this->assertTrue($result);

		$this->model->unbindModel(array(
			'belongsTo' => array('User'),
			'hasMany' => array('Comment')
		));
		$result = $this->model->find(array('Article.id'=>2), array('id', 'user_id', 'title', 'body'));
		$expected = array(
			'Article' => array(
				'id' => '2', 'user_id' => '3', 'title' => 'Changed Second Article', 'body' => 'Second Article Body'
			),
			'Tag' => array(
				array( 'id' => '2', 'tag' => 'tag2', 'created' => '2007-03-18 12:24:23', 'updated' => '2007-03-18 12:26:31'),
				array( 'id' => '3', 'tag' => 'tag3', 'created' => '2007-03-18 12:26:23', 'updated' => '2007-03-18 12:28:31')
			)
		);
		$this->assertEqual($result, $expected);

		$data = array(
			'Tag' => array(
				'Tag' => array( 1, 3 )
			),
			'Article' => array( 'id' => '2' ),
		);

		$result = $this->model->set($data);
		$this->assertTrue($result);

		$result = $this->model->save();
		$this->assertTrue($result);

		$this->model->unbindModel(array(
			'belongsTo' => array('User'),
			'hasMany' => array('Comment')
		));
		$result = $this->model->find(array('Article.id'=>2), array('id', 'user_id', 'title', 'body'));
		$expected = array(
			'Article' => array(
				'id' => '2', 'user_id' => '3', 'title' => 'Changed Second Article', 'body' => 'Second Article Body'
			),
			'Tag' => array(
				array( 'id' => '1', 'tag' => 'tag1', 'created' => '2007-03-18 12:22:23', 'updated' => '2007-03-18 12:24:31'),
				array( 'id' => '3', 'tag' => 'tag3', 'created' => '2007-03-18 12:26:23', 'updated' => '2007-03-18 12:28:31')
			)
		);
		$this->assertEqual($result, $expected);
	}

	function testDel() {
		$this->model =& new Article();

		$result = $this->model->del(2);
		$this->assertTrue($result);

		$result = $this->model->read(null, 2);
		$this->assertFalse($result);

		$this->model->recursive = -1;
		$result = $this->model->findAll(null, array('id', 'title'));
		$expected = array(
			array('Article' => array( 'id' => 1, 'title' => 'First Article' )),
			array('Article' => array( 'id' => 3, 'title' => 'Third Article' ))
		);
		$this->assertEqual($result, $expected);

		$result = $this->model->del(3);
		$this->assertTrue($result);

		$result = $this->model->read(null, 3);
		$this->assertFalse($result);

		$this->model->recursive = -1;
		$result = $this->model->findAll(null, array('id', 'title'));
		$expected = array(
			array('Article' => array( 'id' => 1, 'title' => 'First Article' ))
		);
		$this->assertEqual($result, $expected);
	}

	function testDeleteAll() {
		$this->model =& new Article();

		// Add some more articles

		$data = array('Article' => array('user_id' => 2, 'id' => 4, 'title' => 'Fourth Article', 'published' => 'N'));
		$result = $this->model->set($data) && $this->model->save();
		$this->assertTrue($result);

		$data = array('Article' => array('user_id' => 2, 'id' => 5, 'title' => 'Fifth Article', 'published' => 'Y'));
		$result = $this->model->set($data) && $this->model->save();
		$this->assertTrue($result);

		$data = array('Article' => array('user_id' => 1, 'id' => 6, 'title' => 'Sixth Article', 'published' => 'N'));
		$result = $this->model->set($data) && $this->model->save();
		$this->assertTrue($result);

		$this->model->recursive = -1;
		$result = $this->model->findAll(null, array('id', 'user_id', 'title', 'published'));
		$expected = array(
			array('Article' => array( 'id' => 1, 'user_id' => 1, 'title' => 'First Article', 'published' => 'Y' )),
			array('Article' => array( 'id' => 2, 'user_id' => 3, 'title' => 'Second Article', 'published' => 'Y' )),
			array('Article' => array( 'id' => 3, 'user_id' => 1, 'title' => 'Third Article', 'published' => 'Y' )),
			array('Article' => array( 'id' => 4, 'user_id' => 2, 'title' => 'Fourth Article', 'published' => 'N' )),
			array('Article' => array( 'id' => 5, 'user_id' => 2, 'title' => 'Fifth Article', 'published' => 'Y' )),
			array('Article' => array( 'id' => 6, 'user_id' => 1, 'title' => 'Sixth Article', 'published' => 'N' ))
		);
		$this->assertEqual($result, $expected);

		// Delete with conditions

		$result = $this->model->deleteAll(array('Article.published' => 'N'));
		$this->assertTrue($result);

		$this->model->recursive = -1;
		$result = $this->model->findAll(null, array('id', 'user_id', 'title', 'published'));
		$expected = array(
			array('Article' => array( 'id' => 1, 'user_id' => 1, 'title' => 'First Article', 'published' => 'Y' )),
			array('Article' => array( 'id' => 2, 'user_id' => 3, 'title' => 'Second Article', 'published' => 'Y' )),
			array('Article' => array( 'id' => 3, 'user_id' => 1, 'title' => 'Third Article', 'published' => 'Y' )),
			array('Article' => array( 'id' => 5, 'user_id' => 2, 'title' => 'Fifth Article', 'published' => 'Y' ))
		);
		$this->assertEqual($result, $expected);

		$result = $this->model->deleteAll(array('Article.user_id' => array(2, 3)));
		$this->assertTrue($result);

		$this->model->recursive = -1;
		$result = $this->model->findAll(null, array('id', 'user_id', 'title', 'published'));
		$expected = array(
			array('Article' => array( 'id' => 1, 'user_id' => 1, 'title' => 'First Article', 'published' => 'Y' )),
			array('Article' => array( 'id' => 3, 'user_id' => 1, 'title' => 'Third Article', 'published' => 'Y' ))
		);
		$this->assertEqual($result, $expected);
	}

	function testRecursiveDel() {
		$this->model =& new Article();

		$result = $this->model->del(2);
		$this->assertTrue($result);

		$this->model->recursive = 2;
		$result = $this->model->read(null, 2);
		$this->assertFalse($result);

		$result = $this->model->Comment->read(null, 5);
		$this->assertFalse($result);

		$result = $this->model->Comment->read(null, 6);
		$this->assertFalse($result);

		$result = $this->model->Comment->Attachment->read(null, 1);
		$this->assertFalse($result);

		$result = $this->model->findCount();
		$this->assertEqual($result, 2);

		$result = $this->model->Comment->findCount();
		$this->assertEqual($result, 4);

		$result = $this->model->Comment->Attachment->findCount();
		$this->assertEqual($result, 0);
	}

	function testFindAllThreaded() {
		$this->model =& new Category();

		$result = $this->model->findAllThreaded();
		$expected = array (
			array (
				'Category' => array ( 'id' => '1', 'parent_id' => '0', 'name' => 'Category 1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31'),
				'children' => array (
					array (
						'Category' => array ( 'id' => '2', 'parent_id' => '1', 'name' => 'Category 1.1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31'),
						'children' => array ( )
					),
					array (
						'Category' => array ( 'id' => '3', 'parent_id' => '1', 'name' => 'Category 1.2', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31'),
						'children' => array ( )
					)
				)
			),
			array (
				'Category' => array ( 'id' => '4', 'parent_id' => '0', 'name' => 'Category 2', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31'),
				'children' => array ( )
			),
			array (
				'Category' => array ( 'id' => '5', 'parent_id' => '0', 'name' => 'Category 3', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31'),
				'children' => array (
					array (
						'Category' => array ( 'id' => '6', 'parent_id' => '5', 'name' => 'Category 3.1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31'),
						'children' => array ( )
					)
				)
			)
		);
		$this->assertEqual($result, $expected);

		$result = $this->model->findAllThreaded(array('Category.name' => 'LIKE Category 1%'));
		$expected = array (
			array (
				'Category' => array ( 'id' => '1', 'parent_id' => '0', 'name' => 'Category 1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31'),
				'children' => array (
					array (
						'Category' => array ( 'id' => '2', 'parent_id' => '1', 'name' => 'Category 1.1', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31'),
						'children' => array ( )
					),
					array (
						'Category' => array ( 'id' => '3', 'parent_id' => '1', 'name' => 'Category 1.2', 'created' => '2007-03-18 15:30:23', 'updated' => '2007-03-18 15:32:31'),
						'children' => array ( )
					)
				)
			)
		);
		$this->assertEqual($result, $expected);

		$result = $this->model->findAllThreaded(null, 'id, parent_id, name');
		$expected = array (
			array (
				'Category' => array ( 'id' => '1', 'parent_id' => '0', 'name' => 'Category 1'),
				'children' => array (
					array (
						'Category' => array ( 'id' => '2', 'parent_id' => '1', 'name' => 'Category 1.1'),
						'children' => array ( )
					),
					array (
						'Category' => array ( 'id' => '3', 'parent_id' => '1', 'name' => 'Category 1.2'),
						'children' => array ( )
					)
				)
			),
			array (
				'Category' => array ( 'id' => '4', 'parent_id' => '0', 'name' => 'Category 2'),
				'children' => array ( )
			),
			array (
				'Category' => array ( 'id' => '5', 'parent_id' => '0', 'name' => 'Category 3'),
				'children' => array (
					array (
						'Category' => array ( 'id' => '6', 'parent_id' => '5', 'name' => 'Category 3.1'),
						'children' => array ( )
					)
				)
			)
		);
		$this->assertEqual($result, $expected);
	}

	function testFindNeighbours() {
		$this->model =& new Article();

		$result = $this->model->findNeighbours(null, 'Article.id', '2');
		$expected = array(
			'prev' => array(
				'Article' => array('id' => 1)
			),
			'next' => array(
				'Article' => array('id' => 3)
			)
		);
		$this->assertEqual($result, $expected);

		$result = $this->model->findNeighbours(null, 'Article.id', '3');
		$expected = array(
			'prev' => array(
				'Article' => array('id' => 2)
			),
			'next' => array()
		);
		$this->assertEqual($result, $expected);
	}

	function testFindCombinedRelations() {
		$this->model =& new Apple();

		$result = $this->model->findAll();

		$expected = array (
			array (
				'Apple' => array (
					'id' => '1',
					'apple_id' => '2',
					'color' => 'Red 1',
					'name' => 'Red Apple 1',
					'created' => '2006-11-22 10:38:58',
					'date' => '1951-01-04',
					'modified' => '2006-12-01 13:31:26'
				),
				'Parent' => array (
					'id' => '2',
					'apple_id' => '1',
					'color' => 'Bright Red 1',
					'name' => 'Bright Red Apple',
					'created' => '2006-11-22 10:43:13',
					'date' => '2014-01-01',
					'modified' => '2006-11-30 18:38:10'
				),
				'Sample' => array (
					'id' => null,
					'apple_id' => null,
					'name' => null
				),
				'Child' => array (
					array (
						'id' => '2',
						'apple_id' => '1',
						'color' => 'Bright Red 1',
						'name' => 'Bright Red Apple',
						'created' => '2006-11-22 10:43:13',
						'date' => '2014-01-01',
						'modified' => '2006-11-30 18:38:10'
					)
				)
			),
			array (
				'Apple' => array (
					'id' => '2',
					'apple_id' => '1',
					'color' => 'Bright Red 1',
					'name' => 'Bright Red Apple',
					'created' => '2006-11-22 10:43:13',
					'date' => '2014-01-01',
					'modified' => '2006-11-30 18:38:10'
				),
				'Parent' => array (
					'id' => '1',
					'apple_id' => '2',
					'color' => 'Red 1',
					'name' => 'Red Apple 1',
					'created' => '2006-11-22 10:38:58',
					'date' => '1951-01-04',
					'modified' => '2006-12-01 13:31:26'
				),
				'Sample' => array (
					'id' => '2',
					'apple_id' => '2',
					'name' => 'sample2'
				),
				'Child' => array (
					array (
						'id' => '1',
						'apple_id' => '2',
						'color' => 'Red 1',
						'name' => 'Red Apple 1',
						'created' => '2006-11-22 10:38:58',
						'date' => '1951-01-04',
						'modified' => '2006-12-01 13:31:26'
					),
					array (
						'id' => '3',
						'apple_id' => '2',
						'color' => 'blue green',
						'name' => 'green blue',
						'created' => '2006-12-25 05:13:36',
						'date' => '2006-12-25',
						'modified' => '2006-12-25 05:23:24'
					),
					array (
						'id' => '6',
						'apple_id' => '2',
						'color' => 'Blue Green',
						'name' => 'Test Name',
						'created' => '2006-12-25 05:23:36',
						'date' => '2006-12-25',
						'modified' => '2006-12-25 05:23:36'
					)
				)
			),
			array (
				'Apple' => array (
					'id' => '3',
					'apple_id' => '2',
					'color' => 'blue green',
					'name' => 'green blue',
					'created' => '2006-12-25 05:13:36',
					'date' => '2006-12-25',
					'modified' => '2006-12-25 05:23:24'
				),
				'Parent' => array (
					'id' => '2',
					'apple_id' => '1',
					'color' => 'Bright Red 1',
					'name' => 'Bright Red Apple',
					'created' => '2006-11-22 10:43:13',
					'date' => '2014-01-01',
					'modified' => '2006-11-30 18:38:10'
				),
				'Sample' => array (
					'id' => '1',
					'apple_id' => '3',
					'name' => 'sample1'
				),
				'Child' => array ( )
			),
			array (
				'Apple' => array (
					'id' => '6',
					'apple_id' => '2',
					'color' => 'Blue Green',
					'name' => 'Test Name',
					'created' => '2006-12-25 05:23:36',
					'date' => '2006-12-25',
					'modified' => '2006-12-25 05:23:36'
				),
				'Parent' => array (
					'id' => '2',
					'apple_id' => '1',
					'color' => 'Bright Red 1',
					'name' => 'Bright Red Apple',
					'created' => '2006-11-22 10:43:13',
					'date' => '2014-01-01',
					'modified' => '2006-11-30 18:38:10'
				),
				'Sample' => array (
					'id' => '3',
					'apple_id' => '6',
					'name' => 'sample3'
				),
				'Child' => array (
					array (
						'id' => '8',
						'apple_id' => '6',
						'color' => 'My new appleOrange',
						'name' => 'My new apple',
						'created' => '2006-12-25 05:29:39',
						'date' => '2006-12-25',
						'modified' => '2006-12-25 05:29:39'
					)
				)
			),
			array (
				'Apple' => array (
					'id' => '7',
					'apple_id' => '7',
					'color' => 'Green',
					'name' => 'Blue Green',
					'created' => '2006-12-25 05:24:06',
					'date' => '2006-12-25',
					'modified' => '2006-12-25 05:29:16'
				),
				'Parent' => array (
					'id' => '7',
					'apple_id' => '7',
					'color' => 'Green',
					'name' => 'Blue Green',
					'created' => '2006-12-25 05:24:06',
					'date' => '2006-12-25',
					'modified' => '2006-12-25 05:29:16'
				),
				'Sample' => array (
					'id' => '4',
					'apple_id' => '7',
					'name' => 'sample4'
				),
				'Child' => array (
					array (
						'id' => '7',
						'apple_id' => '7',
						'color' => 'Green',
						'name' => 'Blue Green',
						'created' => '2006-12-25 05:24:06',
						'date' => '2006-12-25',
						'modified' => '2006-12-25 05:29:16'
					)
				)
			),
			array (
				'Apple' => array (
					'id' => '8',
					'apple_id' => '6',
					'color' => 'My new appleOrange',
					'name' => 'My new apple',
					'created' => '2006-12-25 05:29:39',
					'date' => '2006-12-25',
					'modified' => '2006-12-25 05:29:39'
				),
				'Parent' => array (
					'id' => '6',
					'apple_id' => '2',
					'color' => 'Blue Green',
					'name' => 'Test Name',
					'created' => '2006-12-25 05:23:36',
					'date' => '2006-12-25',
					'modified' => '2006-12-25 05:23:36'
				),
				'Sample' => array (
					'id' => null,
					'apple_id' => null,
					'name' => null
				),
				'Child' => array (
					array (
						'id' => '9',
						'apple_id' => '8',
						'color' => 'Some wierd color',
						'name' => 'Some odd color',
						'created' => '2006-12-25 05:34:21',
						'date' => '2006-12-25',
						'modified' => '2006-12-25 05:34:21'
					)
				)
			),
			array (
				'Apple' => array (
					'id' => '9',
					'apple_id' => '8',
					'color' => 'Some wierd color',
					'name' => 'Some odd color',
					'created' => '2006-12-25 05:34:21',
					'date' => '2006-12-25',
					'modified' => '2006-12-25 05:34:21'
				),
				'Parent' => array (
					'id' => '8',
					'apple_id' => '6',
					'color' => 'My new appleOrange',
					'name' => 'My new apple',
					'created' => '2006-12-25 05:29:39',
					'date' => '2006-12-25',
					'modified' => '2006-12-25 05:29:39'
				),
				'Sample' => array (
					'id' => null,
					'apple_id' => null,
					'name' => null
				),
				'Child' => array ( )
			)
		);

		$this->assertEqual($result, $expected);
	}

	/*function testBasicValidation() {
		$this->model =& new ValidationTest();
		$this->model->set(array('title' => '', 'published' => 1));
		$this->assertEqual($this->model->invalidFields(), array('title' => 'This field cannot be left blank'));

		$this->model->create();
		$this->model->set(array('title' => 'Hello', 'published' => 0));
		$this->assertEqual($this->model->invalidFields(), array('published' => 'This field cannot be left blank'));

		$this->model->create();
		$this->model->testing = true;
		$this->model->set(array('title' => 'Hello', 'published' => 1, 'body' => ''));
		$this->assertEqual($this->model->invalidFields(), array('body' => 'This field cannot be left blank'));
	}*/

	function testMultipleValidation() {
		$this->model =& new ValidationTest();
	}
}
/**
 * Short description for class.
 *
 * @package		cake.tests
 * @subpackage	cake.tests.cases.libs.model
 */
class ValidationTest extends CakeTestModel {
	var $name = 'ValidationTest';
	var $useTable = false;

	var $validate = array(
		'title' => VALID_NOT_EMPTY,
		'published' => 'customValidationMethod',
		'body' => array(
			VALID_NOT_EMPTY,
			'/^.{5,}$/s' => 'no matchy',
			'/^[0-9A-Za-z \\.]{1,}$/s'
		)
	);

	function customValidationMethod($data) {
		return $data === 1;
	}

	function loadInfo() {
		return new Set();
	}
}

?>