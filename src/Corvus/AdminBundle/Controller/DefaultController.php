<?php

// src/Corvus/AdminBundle/Controller/DefaultController.php
namespace Corvus\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method,

    Corvus\AdminBundle\Entity\EducationTableView,
    Corvus\AdminBundle\Entity\ProjectHistoryTableView,
    Corvus\AdminBundle\Entity\WorkHistoryTableView,
    Corvus\AdminBundle\Entity\SkillsTableView,
    Corvus\AdminBundle\Entity\NavigationTableView,
    Corvus\AdminBundle\Entity\About,

    Corvus\AdminBundle\Form\Type\EducationTableViewType,
    Corvus\AdminBundle\Form\Type\ProjectHistoryTableViewType,
    Corvus\AdminBundle\Form\Type\WorkHistoryTableViewType,
    Corvus\AdminBundle\Form\Type\SkillsTableViewType,
    Corvus\AdminBundle\Form\Type\NavigationTableViewType,
    Corvus\AdminBundle\Form\Type\AboutType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="admin_home")
     * @Method({"GET"})
     * 
     * @Template
     */
    public function indexAction()
    {
        return $this->render('CorvusAdminBundle:Default:index.html.twig');
    }

    /**
     * @Route("/site-design", name="admin_site_design")
     * @Method({"GET", "POST"})
     * 
     * @Template
     */
    public function siteDesignAction(Request $request)
    {
        $theme = $this->getDoctrine()
            ->getRepository('ILPBootstrapThemeBundle:Theme')
            ->Find(1);

        if ($theme == null) {
            $theme = new \ILP\BootstrapThemeBundle\Entity\Theme();
        }

        $form = $this->createForm('templating', $theme);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($theme);
            $em->flush();

            // Generate the Theme files, install them to web/bundles/* and dump the assets
            $themeManager = $this->get('ilp_bootstrap_theme.theme_manager');
            if ($form->get('generate_button')->isClicked()) {
                $returnCode = $themeManager->generateTheme();
            } else {
                $returnCode = $themeManager->installTheme();
            }
            
            
            if ($returnCode === 0) { // $returnCode === 0 means success
                $this->get('session')->getFlashBag()->add('notice', json_encode(array(
                    'title'     => 'Theme Choice has been saved',
                    'message'   => 'The theme has also been compiled!',
                    'level'     => 'success'
                )));
            } else {
                $this->get('session')->getFlashBag()->add('notice', json_encode(array(
                    'title'     => 'An error occured selecting/compiling the theme',
                    'level'     => 'danger'
                )));
            }

            return $this->redirect($this->generateUrl('admin_site_design'));
        } else {
            if ($form->isSubmitted()) {
                $this->get('session')->getFlashBag()->add('notice', json_encode(array(
                    'title'     => 'Validation Failed',
                    'message'   => 'Please correct the errors to continue!',
                    'level'     => 'warning'
                )));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }
    
    /**
     * @Route("/theme-editor", name="admin_theme_editor")
     * @Method({"GET", "POST"})
     * 
     * @Template
     */
    public function themeEditorAction()
    {
        return array();
    }

    /**
     * @Route("/education", name="admin_education")
     * @Method({"GET"})
     * 
     * @Template
     */
    public function educationAction()
    {
        $educationTableView = new EducationTableView();

        $education = $this->getDoctrine()
            ->getRepository('CorvusAdminBundle:Education')
            ->findAll();

        foreach ($education as $edu) {
            $educationTableView->getEducation()->add($edu);
        }

        $form = $this->createForm(new EducationTableViewType(), $educationTableView);

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/project-history", name="admin_project_history")
     * @Method({"GET"})
     * 
     * @Template
     */
    public function projectHistoryAction()
    {
        $projectHistoryTableView = new ProjectHistoryTableView();

        $projectHistory = $this->getDoctrine()
            ->getRepository('CorvusAdminBundle:ProjectHistory')
            ->findAll();

        foreach ($projectHistory as $ph) {
            $projectHistoryTableView->getProjectHistory()->add($ph);
        }

        $form = $this->createForm(new ProjectHistoryTableViewType(), $projectHistoryTableView);

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/work-history", name="admin_work_history")
     * @Method({"GET"})
     * 
     * @Template
     */
    public function workHistoryAction()
    {
        $workHistoryTableView = new WorkHistoryTableView();

        $workHistory = $this->getDoctrine()
            ->getRepository('CorvusAdminBundle:WorkHistory')
            ->findAll();

        foreach ($workHistory as $wh) {
            $workHistoryTableView->getWorkHistory()->add($wh);
        }

        $form = $this->createForm(new WorkHistoryTableViewType(), $workHistoryTableView);

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/skills", name="admin_skills")
     * @Method({"GET"})
     * 
     * @Template
     */
    public function skillsAction()
    {
        $skillsTableView = new SkillsTableView();

        $skills = $this->getDoctrine()
            ->getRepository('CorvusAdminBundle:Skills')
            ->FindAll();

        foreach ($skills as $skill) {
            $skillsTableView->getSkills()->add($skill);
        }

        $form = $this->createForm(new SkillsTableViewType(), $skillsTableView);

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/navigation", name="admin_navigation")
     * @Method({"GET"})
     * 
     * @Template
     */
    public function navigationAction()
    {
        $navigationTableView = new NavigationTableView();

        $navigation = $this->getDoctrine()
            ->getRepository('CorvusAdminBundle:Navigation')
            ->FindAll();

        foreach ($navigation as $navItem) {
            $navigationTableView->getNavItems()->add($navItem);
        }

        $form = $this->createForm(new NavigationTableViewType(), $navigationTableView); 

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/downloads", name="admin_downloads")
     * @Method({"GET"})
     * 
     * @Template
     */
    public function downloadsAction()
    {
        return $this->render('CorvusAdminBundle:Default:downloads.html.twig');
    }

    /**
     * @Route("/about", name="admin_about")
     * @Method({"GET", "POST"})
     * @Template
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function aboutAction(Request $request)
    {
        $about = $this->getDoctrine()
            ->getRepository('CorvusAdminBundle:About')
            ->Find(1);

        if($about == null) {
            $about = new About();
        }

        $form = $this->createForm(new AboutType(), $about);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($about);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', json_encode(array(
                'title'     => 'Your changes were saved!',
                'level'     => 'success'
            )));
            return $this->redirect($this->generateUrl('admin_about'));
        } else {
            if ($form->isSubmitted()) {
                $this->get('session')->getFlashBag()->add('notice', json_encode(array(
                    'title'     => 'Validation Failed',
                    'message'   => 'Please correct the errors to continue!',
                    'level'     => 'warning'
                )));
            }
        }
        
        return array(
            'form' => $form->createView(),
        );
    }
}