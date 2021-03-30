<?php


namespace App\Admin;


use Sonata\AdminBundle\Form\FormMapper;

class ResearchIntellectualPropertyAdmin extends IntellectualPropertyAdmin
{
    protected $baseRouteName = 'research_intellectual_property_admin';

    protected $baseRoutePattern = 'research-intellectual-property';

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper): void
    {
        parent::configureFormFields($formMapper);
        $formMapper->remove('classification');
        $subject = $this->getSubject();
        $subject->setClassification(1);
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->andWhere($query->expr()->eq($query->getRootAlias().'.classification', 1));

        return $query;

    }

}