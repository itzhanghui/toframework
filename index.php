<?php
echo 'index';
exit;
require('./Common/core.php');
//$UserProxy = new \Common\Database\UserProxy();
//$UserProxy->getUserName($id);

$db = \Common\Database\Factory::getDatabase();
echo $db();