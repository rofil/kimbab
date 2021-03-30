<?php


namespace App\Admin;


use Sonata\AdminBundle\Form\FormMapper;

class ComIntellectualPropertyAdmin extends IntellectualPropertyAdmin
{
    protected $baseRouteName = 'com_intellectual_property_admin';

    protected $baseRoutePattern = 'com-intellectual-property';

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper): void
    {
        parent::configureFormFields($formMapper);
        $formMapper->remove('classification');
        $subject = $this->getSubject();
        $subject->setClassification(2);
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->andWhere($query->expr()->eq($query->getRootAlias().'.classification', 2));
        return $query;

    }

}