<? 
class AdminsController extends AppController
{
  var $helpers = array('Html', 'Javascript', 'Ajax'); 
  var $uses=array('Categories','Subcategories','Contents','Othercategories','Admins');
  var $components = array('RequestHandler','Functions');
  
  function login()
  {
         if(!empty($this->data))
		 {
			 $username=$this->data['admin']['username'];
			 $password=$this->data['admin']['password'];
			 $findadmin=$this->Admins->findAll("username='".$username."' and password='".$password."'");
			 if(count($findadmin)!=0)
			 {
				//$this->Session->write('User', $someone['User']);
				$this->Session->write("Admin", $findadmin[0]['Admins']);
				//echo $findadmin[0]['Admin'];
				$this->redirect('index');
				exit;			
			 }
			 else
			 {
			   $this->set('Error','<font color=red>Invalid Username or Password</font>');
			 }
		 }
  }
  
  function index()
  {
     $left=$this->leftmenu();
	 $this->set('left',$left);
  }
  
   function category($id=null) 
   {
      $left=$this->leftmenu();
	  $this->set('left',$left);
	  $sql="select contents.*,images.photoname from contents left join images on images.subcat_id=contents.id 
		 and images.imgorder=0 where contents.categorie_id=".$id."  order by catorder";
	  $data=$this->Contents->query($sql);
	  $this->set("data",$data);
   }
   
   function editcontent($id=null) 
   {
      $left=$this->leftmenu();
	  $this->set('left',$left);
	  
	 
	  if(!empty($this->data) && $this->data['Contents']['type']=='contents')
	  {	    
		$this->Contents->save($this->data['Contents']);
	  }
	  if(!empty($this->data) && $this->data['Contents']['type']=='images')
	  {	    
		$this->Contents->save($this->data['Contents']);
	  }
	  $sql="select contents.*,images.photoname from contents left join images on contents.id=images.subcat_id  where contents.id=".$id."  order by images.imgorder";
	  $data=$this->Contents->query($sql);
	  $this->set("data",$data);
   }
  
  function leftmenu()
  {
     $sql="SELECT categories.*,subcategories.id,subcategories.subcatname,subcategories.category_id FROM categories 
	 JOIN `subcategories` ON categories.id=subcategories.category_id WHERE subcategories.isactive='Y' AND categories.isactive='Y' ";
	 return $this->Categories->query($sql);
  }
  
  
}  
?>