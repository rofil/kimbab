<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Book;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

final class ResearchBookAdmin extends BookAdmin
{
    use UploaderMethod;
    protected $baseRouteName = 'research_book_admin';

    protected $baseRoutePattern = 'research-book';


    protected function configureFormFields(FormMapper $formMapper): void
    {
        parent::configureFormFields($formMapper);
        $subject = $this->getSubject();
        if (null == $subject->getId()){
            $subject->setClassification(Book::CLASSIFICATION_RESEARCH);
        }
        $formMapper->remove('classification');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper): void
    {
        parent::configureListFields($listMapper);
        $listMapper->remove('classification');
    }

    public function createQuery($context = 'list')
    {
        $query =  parent::createQuery($context);
        $query->andWhere($query->expr()->eq($query->getRootAlias().'.classification', 1));



        return $query;
    }


}
