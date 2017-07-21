<?php

namespace KskFireworks\Subscribers;

use Enlight\Event\SubscriberInterface;
use Enlight_Controller_Action;
use Enlight_Event_EventArgs;

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
            'Enlight_Controller_Action_PostDispatchSecure_Frontend' => 'addTemplateDir',
        ];
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
