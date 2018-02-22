<?php
class Search extends SearchCore{
//override
public static function find($id_lang, $expr, $page_number = 1,$page_size = 1, $order_by = 'position', $order_way = 'desc',$ajax = false, $use_cookie = true, Context $context = null){
//call parent method
$find = parent::find($id_lang, $expr, $page_number, $page_size,$order_by, $order_way, $ajax, $use_cookie, $context);
 // Return products

if(isset($find['result']) && !empty($find['result']) &&  Module::isInstalled('newmodule')){
  $products = $find['result'];
  $id_product_list = array();
  foreach ($products as $p)
    $id_product_list[] = (int)$p['id_product'];
    $grades_comments = Db::getInstance()->executeS( 'SELECT `id_product`, AVG(`grade`) as grade_avg,
    count(`id_newmodule_comment`) as nb_comments
    FROM `'._DB_PREFIX_.'newmodule_comment`
    WHERE `id_product` IN ('.implode(',', $id_product_list).')
    GROUP BY `id_product`');

      foreach($products as $kp => $p)
        foreach($grades_comments as $gc)
          if($gc['id_product'] == $p['id_product'])
          {
            $products[$kp]['newmodule']['grade_avg'] = round($gc['grade_avg']);
            $products[$kp]['newmodule']['nb_comments'] = $gc['nb_comments'];
          }
    $find['result'] = $products;
      }
  return $find;
  }
}
?>
