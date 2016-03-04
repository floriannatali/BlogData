<?php
/**
 * Created by PhpStorm.
 * User: florian
 * Date: 25/02/16
 * Time: 14:41
 */

namespace AppBundle\Form;


use AppBundle\Transformer\StringToDateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\FormBuilderInterface;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ;
    }


    public function getDefaultOptions(array $options)
    {
        return $options['data_class'] = 'AppBundle\Entity\Article';
    }

    public function getName()
    {
        return 'article';
    }
}