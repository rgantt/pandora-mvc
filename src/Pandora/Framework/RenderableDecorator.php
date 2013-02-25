<?php
namespace Pandora\Framework;

class RenderableDecorator implements Renderable {
    protected $renderable = null;
    
    public function __construct( Renderable $renderable ) {
        $this->renderable = $renderable;
    }
    
    public function render() {
        return $this->renderable->render();
    }
}