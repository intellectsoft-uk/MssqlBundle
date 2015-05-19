<?php
/**
 * Overrides default DateType type to fix the issue with MSSQL's date fields
 *
 * @author Felix Nagel <fna@move-elevator.de>
 */

namespace Realestate\MssqlBundle\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\DateType as BaseDateType;
use Doctrine\DBAL\Types\ConversionException;

/**
 * Type that maps an SQL DATE/TIMESTAMP to a PHP DateTime object.
 *
 * @since 2.0
 */
class DateType extends BaseDateType
{
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        if ($value === "") {
            return null;
        }

       $val = \DateTime::createFromFormat('Y-m-d', $value);
		if (!$val) {
			throw ConversionException::conversionFailedFormat($value, $this->getName(), 'Y-m-d');
		}

        return $val;
    }

    /**
     *
     * @param DateTime $value
     * @param AbstractPlatform $platform
     * @return string|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return ($value !== null) ? $value->format('Y-m-d') : null;
    }
}