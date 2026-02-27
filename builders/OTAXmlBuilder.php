<?php

class OTAXmlBuilder
{
    public static function buildBulkRate($hotelCode, $roomCode, $rates)
    {
        $xml = new SimpleXMLElement('<OTA_HotelRateAmountNotifRQ/>');
        $xml->addAttribute('TimeStamp', date('c'));
        $xml->addAttribute('Version', '1.0');

        $rateAmountMessages = $xml->addChild('RateAmountMessages');
        $ram = $rateAmountMessages->addChild('RateAmountMessage');

        $statusAppControl = $ram->addChild('StatusApplicationControl');
        $statusAppControl->addAttribute('HotelCode', $hotelCode);
        $statusAppControl->addAttribute('RoomTypeCode', $roomCode);

        $ratesNode = $ram->addChild('Rates');

        foreach ($rates as $date => $amount) {

            $rateNode = $ratesNode->addChild('Rate');
            $rateNode->addAttribute('EffectiveDate', $date);
            $rateNode->addAttribute('ExpireDate', $date);

            $baseByGuestAmt = $rateNode->addChild('BaseByGuestAmts');
            $base = $baseByGuestAmt->addChild('BaseByGuestAmt');
            $base->addAttribute('AmountAfterTax', $amount);
            $base->addAttribute('CurrencyCode', 'IDR');
        }

        return $xml->asXML();
    }

    public static function buildBulkAvailability($hotelCode, $roomCode, $inventory)
    {
        $xml = new SimpleXMLElement('<OTA_HotelAvailNotifRQ/>');
        $xml->addAttribute('TimeStamp', date('c'));
        $xml->addAttribute('Version', '1.0');

        $availStatusMessages = $xml->addChild('AvailStatusMessages');
        $asm = $availStatusMessages->addChild('AvailStatusMessage');

        $statusAppControl = $asm->addChild('StatusApplicationControl');
        $statusAppControl->addAttribute('HotelCode', $hotelCode);
        $statusAppControl->addAttribute('RoomTypeCode', $roomCode);

        foreach ($inventory as $date => $available) {

            $asm->addAttribute('Start', $date);
            $asm->addAttribute('End', $date);

            $availStatus = $asm->addChild('AvailStatus');
            $availStatus->addAttribute('BookingLimit', $available);
        }

        return $xml->asXML();
    }
}