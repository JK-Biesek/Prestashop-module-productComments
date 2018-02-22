<?php
 function upgrade_module_0_2($module)
 {
   $sql_file = dirname(__FILE__).'/sql/install-0.2.sql';
if (!$module->loadSQLFile($sql_file))
 return false;
return true;
  }

?>
