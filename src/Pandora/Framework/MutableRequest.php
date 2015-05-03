<?php
namespace Pandora\Framework;

use Pandora\Data\HTTP;

class MutableRequest implements Request {
    private $get;
    private $post;

    public function __construct($get, $post) {
        $this->get = $get;
        $this->post = $post;
    }

    public function get($name, $error_msg) {
        if (isset($this->get[$name])) {
            return $this->get[$name];
        }
        throw new \Exception($error_msg);
    }

    public function get_optional($name, $default) {
        if (isset($this->get[$name])) {
            return $this->get[$name];
        }
        return $default;
    }

    public function post($name, $error_msg) {
        if (isset($this->post[$name])) {
            return $this->post[$name];
        }
        throw new \Exception($error_msg);
    }

    public function post_optional($name, $default) {
        if (isset($this->post[$name])) {
            return $this->post[$name];
        }
        return $default;
    }
}
