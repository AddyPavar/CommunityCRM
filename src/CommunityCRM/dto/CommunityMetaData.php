<?php

namespace CommunityCRM\dto;

use CommunityCRM\Utils\GeoUtils;

class CommunityMetaData
{
    public static function getCommunityName()
    {
        return SystemConfig::getValue('sCommunityName');
    }

    public static function getCommunityFullAddress(): string
    {
        $address = [];
        if (!empty(self::getCommunityAddress())) {
            $address[] = self::getCommunityAddress();
        }

        if (!empty(self::getCommunityCity())) {
            $address[] = self::getCommunityCity() . ',';
        }

        if (!empty(self::getCommunityState())) {
            $address[] = self::getCommunityState();
        }

        if (!empty(self::getCommunityZip())) {
            $address[] = self::getCommunityZip();
        }
        if (!empty(self::getCommunityCountry())) {
            $address[] = self::getCommunityCountry();
        }

        return implode(' ', $address);
    }

    public static function getCommunityAddress()
    {
        return SystemConfig::getValue('sCommunityAddress');
    }

    public static function getCommunityCity()
    {
        return SystemConfig::getValue('sCommunityCity');
    }

    public static function getCommunityState()
    {
        return SystemConfig::getValue('sCommunityState');
    }

    public static function getCommunityZip()
    {
        return SystemConfig::getValue('sCommunityZip');
    }

    public static function getCommunityCountry()
    {
        return SystemConfig::getValue('sCommunityCountry');
    }

    public static function getCommunityEmail()
    {
        return SystemConfig::getValue('sCommunityEmail');
    }

    public static function getCommunityPhone()
    {
        return SystemConfig::getValue('sCommunityPhone');
    }

    public static function getCommunityWebSite()
    {
        return SystemConfig::getValue('sCommunityWebSite');
    }

    public static function getCommunityLatitude()
    {
        if (empty(SystemConfig::getValue('iCommunityLatitude'))) {
            self::updateLatLng();
        }

        return SystemConfig::getValue('iCommunityLatitude');
    }

    public static function getCommunityLongitude()
    {
        if (empty(SystemConfig::getValue('iCommunityLongitude'))) {
            self::updateLatLng();
        }

        return SystemConfig::getValue('iCommunityLongitude');
    }

    public static function getCommunityTimeZone()
    {
        return SystemConfig::getValue('sTimeZone');
    }

    private static function updateLatLng(): void
    {
        if (!empty(self::getCommunityFullAddress())) {
            $latLng = GeoUtils::getLatLong(self::getCommunityFullAddress());
            if (!empty($latLng['Latitude']) && !empty($latLng['Longitude'])) {
                SystemConfig::setValue('iCommunityLatitude', $latLng['Latitude']);
                SystemConfig::setValue('iCommunityLongitude', $latLng['Longitude']);
            }
        }
    }
}
