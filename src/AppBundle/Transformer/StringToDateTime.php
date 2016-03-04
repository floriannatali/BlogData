<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 25/02/16
 * Time: 16:06
 */

namespace AppBundle\Transformer;


use Symfony\Component\Form\DataTransformerInterface;

class DateTimeToString implements DataTransformerInterface
{
    const FORMAT = 'Y-m-d H:i:s';

    public function transform($value)
    {
        if($value instanceof \DateTime) {
            return $value->format(self::FORMAT);
        }

        throw new \InvalidArgumentException("$value is not a DateTime instance");
    }

    public function reverseTransform($value)
    {
        return \DateTime::createFromFormat(self::FORMAT,$value);
    }

}