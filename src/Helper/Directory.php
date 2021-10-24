<?php

namespace Fab\Helper;

!defined( 'WPINC ' ) or die;

/**
 * Helper library for Fab plugins
 *
 * @package    Fab
 * @subpackage Fab\Includes
 */

trait Directory {

    /**
     * Get lists of directories
     * @return  void
     * @var     string  $path   Directory path
     */
    public function getDir($path, $directories = []) {
        foreach(glob($path.'/*', GLOB_ONLYDIR) as $dir) {
            $directories[] = basename($dir);
        }
        return $directories;
    }

    /**
     * Get files within directory
     * @return  array
     * @var     string  $dir   plugin hooks directory (Api, Controller)
     */
    public function getDirFiles($dir, &$results = array()) {
        $files = scandir($dir);
        foreach ($files as $key => $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $results[] = $path;
            } else if ($value != "." && $value != "..") {
                self::getDirFiles($path, $results);
            }
        }
        return $results;
    }

    /**
     * Delete directories and files
     * @return void
     */
    public function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    /**
     * Copy directories contents (Files and Dir) to another directories
     * @return void
     */
    public function copyDir($src,$dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->copyDir($src . '/' . $file,$dst . '/' . $file);
                } else { copy($src . '/' . $file,$dst . '/' . $file); }
            }
        }
        closedir($dir);
    }

}