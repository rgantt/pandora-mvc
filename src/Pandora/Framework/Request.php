<?php
namespace Pandora\Framework;

use Pandora\Data\HTTP;

interface Request {
    public function get($name, $error_msg);
    public function get_optional($name, $default);
    public function post($name, $error_msg);
    public function post_optional($name, $default);
}
