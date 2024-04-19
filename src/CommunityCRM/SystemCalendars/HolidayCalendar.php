<?php

namespace CommunityCRM\SystemCalendars;

use CommunityCRM\data\Countries;
use CommunityCRM\data\Country;
use CommunityCRM\dto\SystemConfig;
use CommunityCRM\Interfaces\SystemCalendar;
use CommunityCRM\model\CommunityCRM\Event;
use Propel\Runtime\Collection\ObjectCollection;
use Yasumi\Holiday;
use Yasumi\Yasumi;

class HolidayCalendar implements SystemCalendar
{
    public static function isAvailable()
    {
        $systemCountry = Countries::getCountryByName(SystemConfig::getValue('sCommunityCountry'));
        if ($systemCountry instanceof Country) {
            return $systemCountry->getCountryNameYasumi() !== null;
        }
    }

    public function getAccessToken(): bool
    {
        return false;
    }

    public function getBackgroundColor(): string
    {
        return '6dfff5';
    }

    public function getForegroundColor(): string
    {
        return '000000';
    }

    public function getId(): int
    {
        return 2;
    }

    public function getName(): string
    {
        return gettext('Holidays');
    }

    public function getEvents($start, $end): ObjectCollection
    {
        $Country = Countries::getCountryByName(SystemConfig::getValue('sCommunityCountry'));
        $year = date('Y');
        $holidays = Yasumi::create($Country->getCountryNameYasumi(), $year);
        $events = new ObjectCollection();
        $events->setModel(Event::class);

        foreach ($holidays as $holiday) {
            $event = $this->yasumiHolidayToEvent($holiday);
            $events->push($event);
        }

        return $events;
    }

    public function getEventById($Id): bool
    {
        return false;
    }

    private function yasumiHolidayToEvent(Holiday $holiday): Event
    {
        $id = crc32($holiday->getName() . $holiday->getTimestamp());
        $holidayEvent = new Event();
        $holidayEvent->setId($id);
        $holidayEvent->setEditable(false);
        $holidayEvent->setTitle($holiday->getName());
        $holidayEvent->setStart($holiday->getTimestamp());

        return $holidayEvent;
    }
}
