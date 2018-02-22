<?php
if(!defined('_PS_VERSION_'))
exit;
class newmodule extends Module
{
	public function __construct()
	{
		$this->name = 'newmodule';
		$this->tab = 'others';
		$this->version = '0.2';
		$this->author = 'Jakub Biesek';
		$this->need_instance = 0;
		$this->secure_key = Tools::encrypt($this->name);
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
		$this->bootstrap = true;
		parent::__construct();

		 $this->displayName = $this->l('ProductComments and Grades');
	   $this->description = $this->l('This module allow you to place comments and grades on products');

    $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
  }

	public function install()
	{
		if(!parent::install())
		return false;
		if(!$this->registerHook('leftColumn'))return false;
		if(!$this->registerHook('displayHome'))return false;
		if (!$this->registerHook('displayProductTabContent'))
			return false;
		if(!$this->registerHook('displayBackOfficeHeader'))return false;
		 $sql_file = dirname(__FILE__).'/install/install.sql';

		if(!$this->loadSQLFile($sql_file))
			return false;
		if (!$this->installTab('AdminCatalog', 'AdminMyModComments', 'Comments and Grades'))
		 return false;
		if(!$this->registerHook('displayProductTabContent'))
		 return false;
		if(!$this->registerHook('displayAdminProductsExtra') ||
		!$this->registerHook('ModuleRoutes')|| !$this->registerHook('displayHeader'))
			return false;

	 		Configuration::updateValue('MYMOD_GRADES', '1');
	 		Configuration::updateValue('MYMOD_COMMENTS', '1');
	  return true;
	}

	public function uninstall(){
		if(!parent::uninstall())
		return false;

		$sql_file= dirname(__FILE__).'/install/uninstall.sql';
		if(!$this->loadSQLFile($sql_file))
			return  false;

		if(!$this->uninstallTab('AdminMyModComments'))
			return false;

			Configuration::deleteByName('MYMOD_GRADES');
			Configuration::deleteByName('MYMOD_COMMENTS');
			return true;
	}

	public function installTab($parent, $class_name, $name){
		// Create new admin tab
		$tab = new Tab();
		$tab->id_parent = (int)Tab::getIdFromClassName($parent);
		$tab->name = array();
		foreach (Language::getLanguages(true) as $lang)
		$tab->name[$lang['id_lang']] = $name;
		$tab->class_name = $class_name;
		$tab->module = $this->name;
		$tab->active = 1;
		return $tab->add();
	}

	public function uninstallTab($class_name){
		$id_tab = (int)Tab::getIdFromClassName($class_name);
		$tab = new Tab((int)$id_tab);
		return $tab->delete();
	}

	public function procesConf(){
		if(Tools::isSubmit('mymod_pc_form'))
		{
			$enable_grades = Tools::getValue('enable_grades');
			$enable_comments = Tools::getValue('enable_comments');
			Configuration::updateValue('MYMOD_GRADES',$enable_grades);
			Configuration::updateValue('MYMOD_COMMENTS',$enable_comments);
			$this->context->smarty->assign('confirmation','ok');
		}
	}

	public function run(){
		$id_product = Tools::getValue('id_product');
		$comments = 'SELECT * FROM '._DB_PREFIX_.'newmodule_comment WHERE id_product = '.(int)$id_product.' ORDER BY `date_add`DESC';
		$run = Db::getInstance()->executeS($comments);
		$this->context->smarty->assign('comments',$run);
			 return $this->display(__FILE__,'displayAdminProductsExtra.tpl');
	}

	public function hookDisplayAdminProductsExtra($params){
		return $this->run();
	}

	public function processProductTabContent(){
		if(Tools::isSubmit('newmodule_pc_submit_comment')){
			$id_product = Tools::getValue('id_product');
			$firstname = Tools::getValue('firstname');
			$lastname = Tools::getValue('lastname');
			$email = Tools::getValue('email');
			$grade = Tools::getValue('grade');
			$comment = Tools::getValue('comment');
			$insert = array(
				'id_product' => (int)$id_product,
				'firstname' => pSQL($firstname),
				'lastname' => pSQL($lastname),
				'email' => pSQL($email),
				'grade' => (int)$grade,
				'comment' => pSQL($comment),
				'date_add' => date('Y-m-d H:i:s'), );

			  	Db::getInstance()->insert('newmodule_comment', $insert);
			 $this->context->smarty->assign('newmodule_posted',true);
		}
	}

	public function assignProductTabContent(){
		$enable_comments = Configuration::get('MYMOD_COMMENTS');
		$enable_grades = Configuration::get('MYMOD_GRADES');
		$id_product = Tools::getValue('id_product');
		$comments = Db::getInstance()->executeS('SELECT * FROM '._DB_PREFIX_.'newmodule_comment WHERE id_product = '.(int)$id_product.' ORDER BY `date_add`');
			$this->context->smarty->assign('enable_grades',$enable_grades);
			$this->context->smarty->assign('enable_comments',$enable_comments);
			$this->context->smarty->assign('comments',$comments);
	}

	public function  hookDisplayProductTabContent($params){
			$this->processProductTabContent();
			$this->assignProductTabContent();
				return $this->display(__FILE__,'displayProdutTab.tpl');
	}

	public function hookDisplayHeader($params)
  {
		$this->context->controller->addCSS($this->_path.'views/css/newmodulecomment.css','	all');
		$this->context->controller->addJS($this->_path .'views/js/newmodulecomment.js');
  }

	public function assignConfValues(){
			$enable_grades = Configuration::get('MYMOD_GRADES');
			$enable_comments = Configuration::get('MYMOD_COMMENTS');
			$this->context->smarty->assign('enable_grades',$enable_grades);
			$this->context->smarty->assign('enable_comments',$enable_comments);
		}

	public function getContent(){
		$this->procesConf();
		$this->assignConfValues();
		 return  $this->display(__FILE__,'getContent.tpl');
	}

	public function loadSQLFile($sql_file){
		$sql_content = file_get_contents($sql_file);
		$sql_content = str_replace('PREFIX_', _DB_PREFIX_, $sql_content);
		$sql_requests = preg_split("/;\s*[\r\n]+/", $sql_content);
		$result = true;
			foreach($sql_requests as $request)
			{
				if(!empty($request))
				$result &=Db::getInstance()->execute(trim($request));
				return $result;
			}
		}

	public function hookLeftColumn($params){
		if($this->context->customer->logged){
			$id_customer = ($this->context->customer->id);
		}

		$customer = new Customer($id_customer);
		$this->context->smarty->assign(array(
			'customer'=>$customer));
	      return $this->display(__FILE__, 'newmodule.tpl', $this->getCacheId('newmodule'));
	}

	public function hookdisplayHome (){
		return $this->hookLeftColumn($params);
	}

	public function onClickOption($type,$href = false){
		$confirm_reset = $this->l('Reseting this module will delete all comments from your database, are you sure  you want to reset it ?');
		$reset_callback = "retun newmodule_reset('".addslashes($confirm_reset)."');";
		$matchType = array(
			'reset' => $reset_callback,
			'delete' => "return confirm('confirm delete');",
			'disable' => "return confirm('confirm disable')",
			);
		if(isset($matchType[$type]))
			return $matchType[$type];
		return'';
	}

	public function displayBackOfficeHeader($params){
		if(Tools::getValue('controller')!='AdminModules')
		return '';
		//assign module base dir
		$this->context->smarty->assign('pc_base_dir',__PS_BASE_URI__.'modules/'.$this->name.'/');
		//display template
		return $this->display(__FILE__,'displayBackOfficeHeader.tpl');
	}
}
?>
