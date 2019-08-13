<?php
/**
 * Created by PhpStorm.
 * User: russian_rave
 * Date: 8/13/2019
 * Time: 8:07 PM
 */

namespace App\Servicec;


use Mobile_Detect;

class DeviceService
{

    protected $detect;

    public function __construct()
    {
        $detect=new Mobile_Detect();
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
        } else if ($this->detect->isSamsung()()) {
            return 'Samsung';
        } else if ($this->detect->isSony()) {
            return 'Sony';
        } else if ($this->detect->isAsus()) {
            return 'Asus';
        } else {
            return 'Another';
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
            return 'Another';
        }
    }

}