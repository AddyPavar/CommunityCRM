<?php

namespace CommunityCRM\dto;

use CommunityCRM\Interfaces\SystemCalendar;
use CommunityCRM\model\CommunityCRM\Calendar;
use CommunityCRM\SystemCalendars\AnniversariesCalendar;
use CommunityCRM\SystemCalendars\BirthdaysCalendar;
use CommunityCRM\SystemCalendars\HolidayCalendar;
use CommunityCRM\SystemCalendars\UnpinnedEvents;
use Propel\Runtime\Collection\ObjectCollection;

class SystemCalendars
{
    /**
     * @return SystemCalendar[]
     */
    private static function getCalendars(): array
    {
        $systemCalendarNames = [
            BirthdaysCalendar::class,
            AnniversariesCalendar::class,
            HolidayCalendar::class,
            UnpinnedEvents::class,
        ];

        $calendars = [];
        foreach ($systemCalendarNames as $systemCalendarName) {
            if ($systemCalendarName::isAvailable()) {
                $calendars[] = new $systemCalendarName();
            }
        }

        return $calendars;
    }

    public static function getCalendarList(): ObjectCollection
    {
        $calendars = new ObjectCollection();
        $calendars->setModel(Calendar::class);
        foreach (self::getCalendars() as $calendar) {
            $calendars->push(self::toPropelCalendar($calendar));
        }

        return $calendars;
    }

    public static function getCalendarById($id)
    {
        $requestedCalendar = null;
        foreach (self::getCalendars() as $calendar) {
            if ($calendar->getId() == $id) {
                $requestedCalendar = $calendar;
                break;
            }
        }

        return $requestedCalendar;
    }

    public static function toPropelCalendar(SystemCalendar $calendar): Calendar
    {
        $procalendar = new Calendar();
        $procalendar->setId($calendar->getId());
        $procalendar->setName($calendar->getName());
        $procalendar->setAccessToken($calendar->getAccessToken());
        $procalendar->setBackgroundColor($calendar->getBackgroundColor());
        $procalendar->setForegroundColor($calendar->getForegroundColor());

        return $procalendar;
    }
}
