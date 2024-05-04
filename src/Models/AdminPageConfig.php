<?php

namespace Rockschtar\WordPress\AdminPage\Models;

class AdminPageConfig
{
    private bool $submenu = false;
    private string $parentSlug = '';
    private string $pageTitle = '';
    private string $menuTitle = '';
    private string $capability = '';
    private string $menuSlug = '';
    private ?string $icon = null;
    private ?float $menuPosition = null;

    public static function init(): AdminPageConfig
    {
        return new self();
    }

    public function getParentSlug() : string
    {
        return $this->parentSlug;
    }

    public function setParentSlug(string $parentSlug): self
    {
        $this->parentSlug = $parentSlug;
        return $this;
    }

    public function getPageTitle() : string
    {
        return $this->pageTitle;
    }

    public function setPageTitle(string $pageTitle): self
    {
        $this->pageTitle = $pageTitle;
        return $this;
    }

    public function getMenuTitle() : string
    {
        return $this->menuTitle;
    }

    public function setMenuTitle(string $menuTitle): self
    {
        $this->menuTitle = $menuTitle;
        return $this;
    }

    public function getCapability() : string
    {
        return $this->capability;
    }

    public function setCapability(string $capability): self
    {
        $this->capability = $capability;
        return $this;
    }

    public function getMenuSlug() : string
    {
        return $this->menuSlug;
    }

    public function setMenuSlug(string $menuSlug): self
    {
        $this->menuSlug = $menuSlug;
        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    public function getMenuPosition(): ?float
    {
        return $this->menuPosition;
    }

    public function setMenuPosition(float $menuPosition): self
    {
        $this->menuPosition = $menuPosition;
        return $this;
    }

    public function isSubmenu(): bool
    {
        return $this->submenu;
    }

    public function setSubmenu(bool $submenu): self
    {
        $this->submenu = $submenu;
        return $this;
    }
}
