<?php

namespace Rockschtar\WordPress\AdminPage\Controller;

use Rockschtar\WordPress\AdminPage\Models\AdminPageConfig;
use Rockschtar\WordPress\AdminPage\Views\AdminPageViewInterface;

abstract class AdminPageController
{

    private static $_instances = array();
    private string $hook_suffix = '';

    final public function __construct()
    {
        add_action('admin_menu', $this->addAdminMenu(...));
    }

    final public static function &init()
    {
        /** @noinspection ClassConstantCanBeUsedInspection */
        $class = get_called_class();
        if (!isset(self::$_instances[$class])) {
            self::$_instances[$class] = new $class();
        }
        return self::$_instances[$class];
    }

    abstract public function loadView(): void;

    final public function addAdminMenu(): void
    {

        $config = $this->getConfig();

        if (!$config->isSubmenu()) {
            $this->hook_suffix = add_menu_page(
                $config->getPageTitle(),
                $config->getMenuTitle(),
                $config->getCapability(),
                $config->getMenuSlug(),
                $this->_displayView(...),
                $config->getIcon(),
                $config->getMenuPosition()
            );
        } else {
            $this->hook_suffix =
                add_submenu_page(
                    $config->getParentSlug(),
                    $config->getPageTitle(),
                    $config->getMenuTitle(),
                    $config->getCapability(),
                    $config->getMenuSlug(),
                    $this->_displayView(...)
                );
        }

        do_action('rsap-view-created', $this->hook_suffix);
        add_action('load-' . $this->hook_suffix, $this->loadView(...));
        add_action('admin_enqueue_scripts', $this->_enqueueScripts(...));
    }

    abstract public function getConfig(): AdminPageConfig;

    final public function getViewUrl(): string
    {
        return menu_page_url($this->getConfig()
                                  ->getMenuSlug(), false);
    }

    final public function _enqueueScripts($hook): void
    {
        if ($hook === $this->hook_suffix) {
            $this->enqueueScripts();
        }
    }

    abstract public function enqueueScripts(): void;

    final public function _displayView(): void
    {
        $view = $this->getView();
        $view->displayView();
    }

    abstract public function getView(): AdminPageViewInterface;
}
