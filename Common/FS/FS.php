<?php
/**
 * @package Common\FS
 * @copyright (c) 2022-2025 HuaLang Technologies Co.,Ltd.
 * @web http://www.hualangcloud.com
 * @author hui zhang
 * @create date 2022.03.02
 * @edit date 2022.03.27
 * @file FS.php
 * */
namespace Common\FS;
class FS
{
    public static function filePut($file, $data){
        self::mkDir(dirname($file));
        $fp = fopen($file, 'wb') or die("Unable to open file!");
        flock($fp, LOCK_EX);
        $length = fwrite($fp, $data);
        flock($fp, LOCK_UN);
        fclose($fp);
        if(HL_CHMOD) @chmod($file, HL_CHMOD);
        return $length;
    }
    public static function getFileContents($file) {
        return @file_get_contents($file);
    }
    public static function checkDir($dir) {
        $dir = str_replace('\\', '/', $dir);
        if(substr($dir, -1) != '/') $dir .= '/';
        return $dir;
    }
    public static function mkDir($dir){
        if(is_dir($dir)) return true;
        $dir = self::checkDir($dir);
        $basedir = (strpos($dir, HL_CACHE) !== false) ? HL_CACHE.'/' : HL_ROOT.'/';
        $dir = str_replace($basedir, '', $dir);
        //echo $dir;exit;
        $tmpdir = explode('/', $dir);
        $length = count($tmpdir) - 1;
        $cur_dir = $basedir;
        for($i = 0; $i < $length; $i++) {
            $cur_dir .= $tmpdir[$i].'/';
            if(is_dir($cur_dir)) continue;
            @mkdir($cur_dir);
            if(HL_CHMOD) @chmod($cur_dir, HL_CHMOD);
            if(!is_file($cur_dir.'/index.html') && !is_file($cur_dir.'/index.php')) self::fileCopy(HL_ROOT.'/data/index.html', $cur_dir.'/index.html');
        }
        return is_dir($dir);
    }
    public static function fileCopy($from, $to) {
        $from = str_replace(HL_PATH, HL_ROOT.'/', $from);
        is_file($to) ? @chmod($to, HL_CHMOD) : self::mkDir(dirname($to));
        return @copy($from, $to);
    }
    public static function fileExt($file) {
        return strtolower(trim(substr(strrchr($file, '.'), 1)));
    }

    public static function fileFilter($file) {
        return str_replace(array(' ', '\\', '/', ':', '*', '?', '"', '<', '>', '|', "'", '$', '&', '%', '#', '@'), array('-', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''), $file);
    }
    public static function fileDown($file_path, $data = '') {
        if(!$data && !is_file($file_path)) exit;
        $file_name = basename($file_path);
        $file_type = self::fileExt($file_name);
        $file_size = $data ? strlen($data) : filesize($file_path);
        ob_end_clean();
        @set_time_limit(0);
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) {
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
        } else {
            header('Pragma: no-cache');
        }
        header('Expires: '.gmdate('D, d M Y H:i:s').' GMT');
        header('Content-Encoding: none');
        header('Content-Length: '.$file_size);
        header('Content-Disposition: attachment; filename='.$file_name);
        header('Content-Type: '.$file_type);
        if($data) { echo $data; } else { readfile($file_path); }
        exit;
    }
    public static function fileList($dir, $list_file = array()) {
        $dir = self::checkDir($dir);
        if(substr($dir, -1) !== '*') $dir .= '*';
        $glob_file = glob($dir);
        if(!is_array($glob_file)) return '';
        foreach($glob_file as $file) {
            if(is_dir($file)) {
                $list_file = self::fileList($file, $list_file);
            } else {
                $list_file[] = $file;
            }
        }
        return $list_file;
    }
    public static function fileDelete($file) {
        if(!is_file($file)) return false;
        if(HL_CHMOD) @chmod($file, HL_CHMOD);
        return @unlink($file);
    }
    public  static function dirChmod($dir, $mode = '', $require = 0) {
        if(!$require) $require = substr($dir, -1) == '*' ? 2 : 0;
        if($require) {
            if($require == 2) $dir = substr($dir, 0, -1);
            $dir = self::checkDir($dir);
            $lists = glob($dir.'*');
            foreach($lists as $v) {
                if(is_dir($v)) {
                    self::dirChmod($v, $mode, 1);
                } else {
                    @chmod(basename($v), $mode);
                }
            }
        }
        if(is_dir($dir)) {
            @chmod($dir, $mode);
        } else {
            @chmod(basename($dir), $mode);
        }
    }

    public static function dirCopy($from_dir, $to_dir) {
        $from_dir = self::checkDir($from_dir);
        if(!is_dir($from_dir)) return false;
        $to_dir = self::checkDir($to_dir);
        if(!is_dir($to_dir)) self::mkDir($to_dir);
        $lists = glob($from_dir.'*');
        foreach($lists as $v) {
            $path = $to_dir.basename($v);
            if(is_file($path) && !is_writable($path)) {
                if(HL_CHMOD) @chmod($path, HL_CHMOD);
            }
            if(is_dir($v)) {
                self::dirCopy($v, $path);
            } else {
                @copy($v, $path);
                if(HL_CHMOD) @chmod($path, HL_CHMOD);
            }
        }
        return true;
    }

    public static function dirDelete($dir) {
        $dir = self::checkDir($dir);
        if(!is_dir($dir)) return false;
        $dirs = array(HL_ROOT.'/architecture/', HL_ROOT.'/sapi/', HL_CACHE.'/', HL_ROOT.'/data/', HL_ROOT.'/language/', HL_ROOT.'/mall/', HL_ROOT.'/passport/', HL_ROOT.'/wap/', HL_ROOT.'/wide/');
        if(substr($dir, 0, 1) == '.' || in_array($dir, $dirs)) die("Please do not remove the system directory $dir ");
        $lists = glob($dir.'*');
        if($lists) {
            foreach($lists as $v) {
                is_dir($v) ? self::dirDelete($v) : @unlink($v);
            }
        }
        return @rmdir($dir);
    }

    public static function getFile($dir, $ext = '', $fs = array()) {
        $files = glob($dir.'/*');
        if(!is_array($files)) return $fs;
        foreach($files as $file) {
            if(is_dir($file)) {
                if(is_file($file.'/index.php') && is_file($file.'/config.inc.php')) continue;
                $fs = self::getFile($file, $ext, $fs);
            } else {
                if($ext) {
                    if(preg_match("/\.($ext)$/i", $file)) $fs[] = $file;
                } else {
                    $fs[] = $file;
                }
            }
        }
        return $fs;
    }
}