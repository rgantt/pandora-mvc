<?php
namespace Pandora\Framework;

use Pandora\Data\HTTP;

class AuthenticatedRenderableDecorator extends RenderableDecorator {
    public function __construct( Renderable $renderable ) {
        parent::__construct($renderable);
    }
    
    public function render() {
        HTTP::checkBasicAuthentication();
        return parent::render();
    }
}