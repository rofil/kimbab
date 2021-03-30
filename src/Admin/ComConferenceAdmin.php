<?php


namespace App\Admin;


use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ComConferenceAdmin extends AppConferenceAdmin
{
    use UploaderMethod;

    protected $baseRouteName = 'com_conference_admin';

    protected $baseRoutePattern = 'com-conference';

    protected function configureListFields(ListMapper $listMapper): void
    {
        parent::configureListFields($listMapper);
        $listMapper->remove("classification");
    }
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