<?php

namespace Admingenerator\NlThemeBundle\Form\Type;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class DateType extends \Symfony\Component\Form\Extension\Core\Type\DateType
{

    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $view->setVar('widget', $options['widget']);
        $pattern =  "d MMM y"; //$form->getConfig()->getAttribute('formatter')->getPattern();

        $view->setVar('date_pattern', $pattern);
        $view->setVar('dateFormat', $this->convertJqueryDate($pattern));

        $view->setVar('locale', \Locale::getDefault());
    }

    protected function convertJqueryDate($format)
    {
        //jquery use a different syntax, have to replace
        //  php    jquery
        //  MM      mm
        //  MMM     M
        //  MMMM    MM
        //  y       yy

        if (strpos($format, "MMM") > 0) {
            $format = str_replace("MMM", "M", $format);
        } else {
            $format = str_replace("MM", "mm", $format);
        }
        $format = str_replace("LLL", "M", $format);
        $format = str_replace("y", "yy", $format);

        return $format;
    }

}
