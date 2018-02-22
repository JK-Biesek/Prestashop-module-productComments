<?php
class AdminMyModCommentsController extends ModuleAdminController{

public function __construct(){
  //set variables
  $this->table = 'newmodule_comment';
  $this->class_name = 'newmodule_comment';
  $this->fields_list = array(
     'id_newmodule_comment' => array('title' => $this->l('ID'),
      'align' => 'center', 'width' => 25),
        'product_name' => array('title' => $this->l('Product'),'width' => 100, 'filter_key' => 'pl!name'),
         'firstname' => array('title' => $this->l('Firstname'),
          'width' => 120),
          'lastname' => array('title' => $this->l('Lastname'), 'width'=> 140),
            'email' => array('title' => $this->l('E-mail'), 'width' =>150),
              'grade' => array('title' => $this->l('Grade'), 'align' =>'right', 'width' => 80 ,'filter_key' => 'a!grade'),
                'comment' => array('title' => $this->l('Comment'), 'search'=> false),
                  'date_add' => array('title' => $this->l('Date add'), 'type' => 'date'),
                    //filter_key is construct sql - WHERE CONDITION
                   );
                   $this->bootstrap = true;
                    // Call of the parent constructor method
                     parent::__construct();
                     $this->addRowAction('delete');
                     $this->bulk_actions = array(
                      'delete' => array(
                        'text' => $this->l('Delete selected'),
                        'confirm' => $this->l('Would you like to delete the selected items?'),
                      ),
                 'myaction' => array('text'=>$this->l('My action'),
                 'confirm'=>$this->l('are you sure?')
                 ),
                 );
          $this->_select = "pl.`name` as product_name, CONCAT(a.`grade`,'/5') as grade";
          $this->_join = 'LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON  (pl.`id_product` = a.`id_product` AND pl.`id_lang` ='.(int)$this->context->language->id.')';

          $this->meta_title = $this->l('Comments on product');
          $this->toolbar_title[] = $this->meta_title;
    }
  protected function processBulkMyAction(){
   Tools::dieObject($this->boxes);
  }
}
 ?>
