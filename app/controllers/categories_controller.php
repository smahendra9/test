<? 
class CategoriesController extends AppController
{
  var $helpers = array('Html', 'Javascript', 'Ajax'); 
  var $uses=array('Categories','Subcategories','Contents','Othercategories');
  var $components = array('RequestHandler');
  
  function index()
  {
     
	 $left=$this->leftmenu();
	 $this->set('left',$left);
	 $sql="SELECT contents. * , images.photoname
			FROM contents
			LEFT JOIN images ON images.subcat_id = contents.id
			AND images.imgorder =0
			
			WHERE contents.onhome = 'Y'
			ORDER BY catorder";
	 $data=$this->Contents->query($sql);
	 $this->set("data",$data);
  }
  
  function category($id=null)
  {
     
	 if(!isset($id))
	   $id=1;
	 $left=$this->leftmenu();
	 $this->set('left',$left);
	  
	   
	 $sql="select contents.*,images.photoname from contents left join images on images.subcat_id=contents.id 
	 and images.imgorder=0 where contents.categorie_id=".$id."  order by catorder";
	 $data=$this->Contents->query($sql);
	 $this->set("data",$data);
	 
	 /*******homedata**********/
	 $this->set('home',$this->hometext($id,'contents'));
	 
	 /**********for layout*********/
	 $sql="select categories.catname,subcategories.subcatname from categories join subcategories on categories.id=subcategories.category_id where subcategories.id=".$id;
	 $find=$this->Contents->query($sql);
	 $this->set('find',$find);
	// echo $find[0]['categories']['catname'];
	 if($find[0]['categories']['catname']=='Furniture')
	   $this->layout="brown";
	 elseif($find[0]['categories']['catname']=='Product Design')
	   $this->layout="orange";
	 elseif($find[0]['categories']['catname']=='Communication')
	   $this->layout="default";
	 else
	   $this->layout="pink";
	  
	
	 
  }
  
  function changeimage($image=null,$id=null)
  {
    $this->set("id",$id);
	$this->set('image',$image);
  }
  
  function project($id=null)
  {
     $left=$this->leftmenu();
	 $this->set('left',$left);
	 $sql="select contents.*,images.photoname from contents left join images on contents.id=images.subcat_id and images.imgorder!=0 where contents.id=".$id."  order by images.imgorder";
	 $data=$this->Contents->query($sql);
	 //print_r($data);
	 $this->set("data",$data);
  }
  function leftmenu()
  {
     $sql="SELECT categories.*,subcategories.id,subcategories.subcatname,subcategories.category_id FROM categories 
	 JOIN `subcategories` ON categories.id=subcategories.category_id WHERE subcategories.isactive='Y' AND categories.isactive='Y' ";
	 return $this->Categories->query($sql);
  }
  
  function othercategory($id=null)
  {
     $left=$this->leftmenu();
	 $this->set('left',$left);
	 $sql="select * from othercategories where catid=".$id." and catorder!=0 order by catorder";
	 $data=$this->Contents->query($sql);
	 $this->set("data",$data);
	 $this->set("id",$id);
	 $this->set('home',$this->hometext($id,'othercategories'));
  }
  
  function hometext($id=null,$tblname)
  {
    $sql="select matter from ".$tblname." where id=".$id." and catorder=0";
	$data=$this->Categories->query($sql);
	if(!empty($data))
	  return $data[0][$tblname]['matter'];
	  
  }
  
}




?>