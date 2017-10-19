<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;
use Freshdesk\Api;

/**
 * Class FreshdeskPlugin
 * @package Grav\Plugin
 */
class FreshdeskPlugin extends Plugin
{
    /**
     * @return array
     *
     * The getSubscribedEvents() gives the core a list of events
     *     that the plugin wants to listen to. The key of each
     *     array section is the event that the plugin listens to
     *     and the value (in the form of an array) contains the
     *     callable (or function) as well as the priority. The
     *     higher the number the higher the priority.
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0]
        ];
    }

    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized()
    {
        // Don't proceed if we are in the admin plugin
        if ($this->isAdmin()) {
            return;
        }

        require_once __DIR__ . '/vendor/autoload.php';

        // Enable the main event we are interested in
        $this->enable([
            'onFormProcessed' => ['onFormProcessed', 0]
        ]);
    }

    /**
     * Add the Freshdesk form handler
     * @param Event $event
     */
    public function onFormProcessed(Event $event)
    {
        switch ($event['action']) {
            case 'freshdesk':
                $this->handleCreateTicket($event);
        }
    }

    /**
     * @param Event $event
     * @throws \Exception
     */
    protected function handleCreateTicket(Event $event)
    {
        $form = $event['form'];
        $params = $event['params'];

        $twig = $this->grav['twig'];
        $vars = ['form' => $form];
        $config = $this->grav['config'];

        $data = [
            'status' => 2,
            'priority' => 1,
        ];

        $data['name'] = $twig->processString($params['name'] ?? '', $vars);

        $data['email'] = $twig->processString($params['email'] ?? '', $vars);
        if (!$data['email']) {
            throw new \Exception('Freshdesk "email" is required');
        }

        $data['subject'] = $twig->processString($params['subject'] ?? '', $vars);
        if (!$data['subject']) {
            throw new \Exception('Freshdesk "subject" is required');
        }

        $data['description'] = $twig->processString($params['description'] ?? '', $vars);
        if (!$data['description']) {
            throw new \Exception('Freshdesk "description" is required');
        }

        $api = new Api($this->grav['config']->get('plugins.freshdesk.api_key'), $this->grav['config']->get('plugins.freshdesk.domain'));
        $api->tickets->create($data);
    }
}
