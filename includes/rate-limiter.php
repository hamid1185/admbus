<?php
class RateLimiter {
    private $cache_prefix = 'rate_limit_';
    private $storage = []; // In production, use Redis or database

    /**
     * Check if action is rate limited
     */
    public function isLimited($identifier, $limit = 5, $window = 900) {
        $key = $this->cache_prefix . $identifier;
        
        // Get current count
        $current = $this->getCount($key);
        
        if ($current >= $limit) {
            return true;
        }

        // Increment counter
        $this->incrementCount($key, $window);
        return false;
    }

    /**
     * Get request count
     */
    private function getCount($key) {
        if (isset($this->storage[$key])) {
            $data = $this->storage[$key];
            if ($data['expires'] > time()) {
                return $data['count'];
            } else {
                unset($this->storage[$key]);
            }
        }
        return 0;
    }

    /**
     * Increment counter
     */
    private function incrementCount($key, $window) {
        if (!isset($this->storage[$key])) {
            $this->storage[$key] = [
                'count' => 1,
                'expires' => time() + $window
            ];
        } else {
            $this->storage[$key]['count']++;
        }
    }

    /**
     * Reset limit
     */
    public function reset($identifier) {
        $key = $this->cache_prefix . $identifier;
        unset($this->storage[$key]);
    }
}
?>
