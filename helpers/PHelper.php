<?php

namespace app\helpers;

class PHelper
{
    
    const OSTATUS_OPEN = 1;
    const OSTATUS_READY = 2;
    const OSTATUS_SHIPPED = 3;
    const OSTATUS_ON_HOLD = 4;
    const OSTATUS_DELAYED = 5;
    const OSTATUS_CANCELLED = 6;
    
    
    const NO = 0;
    const YES = 1;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    public static function statusOption($op = null)
    {
        if($op === null) {
            return [
                self::STATUS_ACTIVE => 'Active',
                self::STATUS_INACTIVE => 'Inactive',
            ];
        } else {
            if($op === self::STATUS_ACTIVE) {
                return 'Active';
            } elseif($op === self::STATUS_INACTIVE) {
                return 'Inactive';
            } elseif($op === 3) {
                return 'Deleted';
            } else {
                return 'Unknown';
            }
        }
    }
    public static function countryList($id = null) 
    {
        if($id === null) {
            return [
                'US' => 'United States',
                'CA' => 'Canada',
            ];
        } else {
            if($id === 'US') {
                return 'United States';
            } elseif($id === 'CA') {
                return 'Canada';
            } else {
                return 'Unknown';
            }
        }
    }
    
    public static function orderStatusOption($op = null) 
    {
        if($op === null) {
            return [
                self::OSTATUS_OPEN => 'Open',
                self::OSTATUS_READY => 'Ready',
                self::OSTATUS_SHIPPED => 'Shipped',
                self::OSTATUS_ON_HOLD => 'On Hold',
                self::OSTATUS_DELAYED => 'Delayed',
                self::OSTATUS_CANCELLED => 'Cancelled'
            ];
        } else {
            if($op === self::OSTATUS_OPEN) {
                return 'Open';
            } elseif($op === self::OSTATUS_READY) {
                return 'Ready';
            } elseif($op === self::OSTATUS_SHIPPED) {
                return 'Shipped';
            } else if($op === self::OSTATUS_ON_HOLD) {
                return 'On Hold';
            } elseif($op === self::OSTATUS_DELAYED) {
                return 'Delayed';
            } else {
                return 'Cancelled';
            }
        }
    }
    public static function yesno($op = null) 
    {
        if($op === null) {
            return [self::NO => 'No', self::YES => 'Yes'];
        } else {
            if($op === 1) {
                return 'Yes';
            } else {
                return 'No';
            }
        }
    }
    public static function s($string, $length = 120) 
    {
        strip_tags($string);
        if(strlen($string) > $length) {
            $pos=strpos($string, ' ', $length);
            $string = substr($string,0,$pos ) . '...';
        }
        return $string;
    }
}
