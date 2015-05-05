<?php

namespace Landing\TemplatesBundle\Controller;

use Landing\TemplatesBundle\Entity\CatchEmail;
use Landing\TemplatesBundle\Form\CatchEmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Landing\TemplatesBundle\Entity\SimpleLanding;
use Landing\TemplatesBundle\Form\SimpleLandingType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use ZipArchive;

/**
 * SimpleLanding controller.
 *
 * @Route("/simplelanding")
 */
class SimpleLandingController extends Controller
{

    /**
     * Lists all SimpleLanding entities.
     *
     * @Route("/", name="simplelanding")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $em = $this->getDoctrine()->getManager();
            $entities = $em->getRepository('TemplatesBundle:SimpleLanding')->findByUser($this->getUser()->getId());

            return array(
                'entities' => $entities,
            );
        } else {
//            throw new \Exception('please log in');
            return $this->redirect($this->generateUrl('landing_homepage_default_index'));
        }

    }

    /**
     * Creates a new SimpleLanding entity.
     *
     * @Route("/", name="simplelanding_create")
     * @Method("POST")
     * @Template("TemplatesBundle:SimpleLanding:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new SimpleLanding();
        $entity->setUser($this->getUser());
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('simplelanding_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a SimpleLanding entity.
     *
     * @param SimpleLanding $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(SimpleLanding $entity)
    {
        $form = $this->createForm(new SimpleLandingType(), $entity, array(
            'action' => $this->generateUrl('simplelanding_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new SimpleLanding entity.
     *
     * @Route("/new", name="simplelanding_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new SimpleLanding();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a SimpleLanding entity.
     *
     * @Route("/{id}", name="simplelanding_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TemplatesBundle:SimpleLanding')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SimpleLanding entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $submitForm = $this->createForm(new CatchEmailType(), new CatchEmail());
        //$submitForm->buildView();

        return array(
            'entity' => $entity,
            'submit_form' => $submitForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SimpleLanding entity.
     *
     * @Route("/{id}/edit", name="simplelanding_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {

        $em = $this->getDoctrine()->getManager();


        /** @var SimpleLanding $entity */
        $entity = $em->getRepository('TemplatesBundle:SimpleLanding')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SimpleLanding entity.');
        }
        $sameUser = ($this->getUser()->getId() == $entity->getUser()->getId());
        if (false === ($sameUser)) {
            throw new \Exception('not your template, owner id:' . $entity->getUser()->getId() . ', your id:' . $this->getUser()->getId()
                . ', comparison result: ' . $sameUser);
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a SimpleLanding entity.
     *
     * @param SimpleLanding $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(SimpleLanding $entity)
    {
        $form = $this->createForm(new SimpleLandingType(), $entity, array(
            'action' => $this->generateUrl('simplelanding_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing SimpleLanding entity.
     *
     * @Route("/{id}", name="simplelanding_update")
     * @Method("PUT")
     * @Template("TemplatesBundle:SimpleLanding:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TemplatesBundle:SimpleLanding')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SimpleLanding entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('simplelanding_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a SimpleLanding entity.
     *
     * @Route("/{id}", name="simplelanding_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TemplatesBundle:SimpleLanding')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SimpleLanding entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('simplelanding'));
    }

    /**
     * Creates a form to delete a SimpleLanding entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('simplelanding_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * Creates a new SimpleLanding entity.
     *
     * @Route("/download/{id}", name="simplelanding_download")
     **/
    public function downloadTemplateAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var SimpleLanding $entity */
        $entity = $em->getRepository('TemplatesBundle:SimpleLanding')->find($id);
        $index = $this->renderView('TemplatesBundle:SimpleLanding:show.html.twig', array('entity' => $entity));
        $archive = new ZipArchive();
        $archive->open($this->get('kernel')->getRootDir() . '/../web/zip/' . $entity->getId() . '.zip', ZipArchive::CREATE);
        $archive->addFromString($entity->getId() . '.html', $index);
        $tempFilename = $archive->filename;
        $archive->close();
        $response = new Response(file_get_contents($tempFilename));
        $d = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $entity->getId() . '.zip');
        $response->headers->set('Content-Disposition', $d);
        return $response;
    }

    /**
     * @Route("/submit/{id}", name="simplelanding_submit")
     * @Method("POST")
     */
    public function catchAndSaveEmailFromForm(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $template = $em->getRepository('TemplatesBundle:SimpleLanding')->find($id);

        if (!$template) {
            throw $this->createNotFoundException('Unable to find SimpleLanding entity.');
        }

        $entity = new CatchEmail();
        $entity->setTemplate($template);

        $submitForm = $this->createForm(new CatchEmailType(), $entity);
        $submitForm->handleRequest($request);

        if ($submitForm->isValid()) {
            $em->persist($entity);
            $em->flush();

//            return $this->redirect($this->generateUrl('simplelanding_show', array('id' => $entity->getId())));
            echo 'success';
        }
    }
}
