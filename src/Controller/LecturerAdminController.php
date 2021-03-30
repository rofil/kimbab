<?php

//declare(strict_types=1);

namespace App\Controller;

use App\Entity\Lecturer;
use App\Entity\User;
use App\Form\LecturerPhotoType;
use Knp\Menu\Renderer\TwigRenderer;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Bridge\Twig\AppVariable;
use Symfony\Bridge\Twig\Command\DebugCommand;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class LecturerAdminController extends CRUDController
{
    public function profile(Request $request)
    {
        $profile = $this->getCurrentLecturer();
        $form = $this->createForm(LecturerPhotoType::class, $profile);
        $form->handleRequest($request);
        return $this->renderWithExtraParams("lecturer/profile.html.twig", [
            'lecturer' => $profile,
            'form' => $form->createView()

        ]);
    }

    public function edit(Request $request)
    {
        $this->admin->setSubject($this->getCurrentLecturer());
        $form = $this->admin->getForm();
//        $form->remove("filePhoto");
        $form->remove("nip");
        $form->setData($this->getCurrentLecturer());
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $lecturer = $form->getData();
            $this->admin->update($lecturer);
            return $this->redirect($this->generateUrl("admin_app_lecturer_my_profile"));
        }



        $formView = $form->createView();
        $this->setFormTheme($formView, $this->admin->getFormTheme());

        return $this->renderWithExtraParams("lecturer/edit-profile.html.twig", [
            'form' => $formView
        ]);
    }

    public function user():User
    {
        return $this->getUser();
    }

    /**
     * Sets the admin form theme to form view. Used for compatibility between Symfony versions.
     */
    protected function setFormTheme(FormView $formView, array $theme = null): void
    {
        $twig = $this->get('twig');

        // BC for Symfony < 3.2 where this runtime does not exists
        if (!method_exists(AppVariable::class, 'getToken')) {
            $twig->getExtension(FormExtension::class)->renderer->setTheme($formView, $theme);

            return;
        }

        // BC for Symfony < 3.4 where runtime should be TwigRenderer
        if (!method_exists(DebugCommand::class, 'getLoaderPaths')) {
            $twig->getRuntime(TwigRenderer::class)->setTheme($formView, $theme);

            return;
        }

        $twig->getRuntime(FormRenderer::class)->setTheme($formView, $theme);
    }

    protected function getCurrentLecturer(): Lecturer
    {
        $repo = $this->getDoctrine()->getRepository(Lecturer::class);
        return $repo->findOneBy(["nip" => $this->getUser()->getUsername()]);
    }
}
