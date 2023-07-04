<?php
/**
 * @package Common\Database
 * @copyright (c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.09
 * @edit date 2022.03.27
 * @file IDatabaseProxy.php
 */
namespace Common\Database;

interface  IDatabaseProxy
{   function query($sql);
    function fetchArray($result);
}