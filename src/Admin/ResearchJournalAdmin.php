<?php


namespace App\Admin;


use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ResearchJournalAdmin extends JournalAdmin
{
    protected $baseRouteName = 'research_journal_admin';

    protected $baseRoutePattern = 'research-journal';

    protected function configureListFields(ListMapper $listMapper): void
    {
        parent::configureListFields($listMapper);
        $listMapper->remove("classification");
    }

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