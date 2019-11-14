<?php

namespace App\Servicec;

use Mobile_Detect;

class DeviceService
{

    protected $detect;

    public function __construct(Mobile_Detect $detect)
    {
        $this->detect = $detect;
    }

    public function isComputer(): bool
    {
        return !$this->detect->isMobile() && !$this->detect->isTablet();
    }

    public function isMobile(): bool
    {
        return $this->detect->isMobile();
    }

    public function isTablet(): bool
    {
        return $this->detect->isTablet();
    }

    public function getMobile(): string
    {
        if ($this->detect->isiPhone()) {
            return 'Iphone';
        } else if ($this->detect->isSamsung()) {
            return 'Samsung phone';
        } else if ($this->detect->isSony()) {
            return 'Sony phone';
        } else if ($this->detect->isAsus()) {
            return 'Asus phone';
        } else {
            return 'Another phone';
        }
    }

    public function getTablet(): string
    {
        if ($this->detect->isiPad()) {
            return 'Ipad';
        } else if ($this->detect->isSamsungTablet()) {
            return 'Samsung tablet';
        } else if ($this->detect->isAsusTablet()) {
            return 'Sony tablet';
        } else if ($this->detect->isAcerTablet()) {
            return 'Asus tablet';
        } else {
            return 'Another tablet';
        }
    }

    public function getDevice(): string
    {
        if ($this->isMobile()) {
            return $this->getMobile();
        } elseif ($this->isTablet()) {
            return $this->getTablet();
        } else {
            return 'unknown';
        }
    }

}
