<?php

namespace KskFireworks\Subscribers;

use Doctrine\Common\Collections\ArrayCollection;
use Enlight\Event\SubscriberInterface;
use Enlight_Controller_Action;
use Enlight_Event_EventArgs;
use Shopware\Components\Theme\LessDefinition;

/**
 * Class Frontend
 * @package KskFireworks\Subscribers
 */
class Frontend implements SubscriberInterface
{
    /**
     * @var string
     */
    private $pluginDir;

    /**
     * Frontend constructor.
     * @param $pluginDir
     */
    public function __construct($pluginDir)
    {
        $this->pluginDir = $pluginDir;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Theme_Compiler_Collect_Plugin_Less' => 'addLess',
            'Theme_Compiler_Collect_Plugin_Javascript' => 'addJavascript',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend' => 'addTemplateDir',
        ];
    }

    /**
     * @param Enlight_Event_EventArgs $args
     * @return LessDefinition
     */
    public function addLess(Enlight_Event_EventArgs $args)
    {
        return new LessDefinition([], [implode(DIRECTORY_SEPARATOR, [
            $this->pluginDir, 'Resources', 'views', 'frontend', '_public', 'src', 'less', 'all.less'
        ])]);
    }

    /**
     * @param Enlight_Event_EventArgs $args
     * @return ArrayCollection
     */
    public function addJavascript(Enlight_Event_EventArgs $args)
    {
        return new ArrayCollection([implode(DIRECTORY_SEPARATOR, [
            $this->pluginDir, 'Resources', 'views', 'frontend', '_public', 'src', 'js', 'canvas-fireworks-v2.js'
        ])]);
    }

    /**
     * @param Enlight_Event_EventArgs $args
     */
    public function addTemplateDir(Enlight_Event_EventArgs $args)
    {
        /** @var Enlight_Controller_Action $controller */
        $controller = $args->get('subject');
        $controller->View()->addTemplateDir(implode(DIRECTORY_SEPARATOR, [$this->pluginDir, 'Resources', 'views']));
    }
}
