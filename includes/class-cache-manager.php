<?php
class Cache_Manager {
    private $cache_dir;
    private $expiry;

    public function __construct() {
        $default_dir = defined('GRAVATAR_CACHE_DIR') ? GRAVATAR_CACHE_DIR : WP_CONTENT_DIR . '/cache/gravatar';
        $default_expiry = defined('GRAVATAR_CACHE_EXPIRY') ? GRAVATAR_CACHE_EXPIRY : 7 * 24 * 60 * 60;

        $cache_dir = get_option('gravatar_proxy_cache_dir', $default_dir);
        $cache_dir = is_string($cache_dir) ? trim($cache_dir) : $default_dir;
        if ($cache_dir === '') {
            $cache_dir = $default_dir;
        }

        $expiry = (int) get_option('gravatar_proxy_cache_expiry', $default_expiry);
        if ($expiry < 60) {
            $expiry = $default_expiry;
        }

        $this->cache_dir = $cache_dir;
        $this->expiry = $expiry;
        if (!is_dir($this->cache_dir)) {
            wp_mkdir_p($this->cache_dir);
        }
    }

    public function get_avatar($hash) {
        $file = $this->cache_dir . '/' . $hash . '.jpg';
        if (file_exists($file) && (time() - filemtime($file)) < $this->expiry) {
            return file_get_contents($file);
        }
        return false;
    }

    public function save_avatar($hash, $data) {
        $file = $this->cache_dir . '/' . $hash . '.jpg';
        file_put_contents($file, $data);
        $this->enforce_limit();
    }

    public function delete_avatar($hash) {
        $file = $this->cache_dir . '/' . $hash . '.jpg';
        if (file_exists($file)) {
            unlink($file);
        }
    }

    public function clear_all() {
        $files = glob($this->cache_dir . '/*.jpg');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    public function cleanup() {
        $files = glob($this->cache_dir . '/*.jpg');
        foreach ($files as $f) {
            if (is_file($f) && (time() - filemtime($f)) > $this->expiry) {
                unlink($f);
            }
        }
    }

    private function enforce_limit() {
        $max = (int) get_option('gravatar_proxy_cache_size', 1000);
        $files = glob($this->cache_dir . '/*.jpg');
        if (count($files) <= $max) return;
        // 按修改时间升序排序，最旧的先删除
        usort($files, function($a, $b) { return filemtime($a) - filemtime($b); });
        while (count($files) > $max) {
            $old = array_shift($files);
            if (is_file($old)) unlink($old);
        }
    }
}
?>
