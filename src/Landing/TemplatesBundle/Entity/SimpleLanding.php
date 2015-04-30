<?php

namespace Landing\TemplatesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SimpleLanding
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Landing\TemplatesBundle\Entity\SimpleLandingRepository")
 */
class SimpleLanding
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="template_name", type="string", length=255)
     */
    private $templateName;

    /**
     * @var string
     *
     * @ORM\Column(name="template_title", type="string", length=255)
     */
    private $templateTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="template_h1", type="string", length=255)
     */
    private $templateH1;

    /**
     * @var string
     *
     * @ORM\Column(name="template_lead", type="string", length=255)
     */
    private $templateLead;

    /**
     * @var string
     *
     * @ORM\Column(name="template_button", type="string", length=255)
     */
    private $templateButton;

    /**
     * @ORM\ManyToOne(targetEntity="Landing\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */

     private $user;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set templateName
     *
     * @param string $templateName
     * @return SimpleLanding
     */
    public function setTemplateName($templateName)
    {
        $this->templateName = $templateName;

        return $this;
    }

    /**
     * Get templateName
     *
     * @return string 
     */
    public function getTemplateName()
    {
        return $this->templateName;
    }

    /**
     * Set templateTitle
     *
     * @param string $templateTitle
     * @return SimpleLanding
     */
    public function setTemplateTitle($templateTitle)
    {
        $this->templateTitle = $templateTitle;

        return $this;
    }

    /**
     * Get templateTitle
     *
     * @return string 
     */
    public function getTemplateTitle()
    {
        return $this->templateTitle;
    }

    /**
     * Set templateH1
     *
     * @param string $templateH1
     * @return SimpleLanding
     */
    public function setTemplateH1($templateH1)
    {
        $this->templateH1 = $templateH1;

        return $this;
    }

    /**
     * Get templateH1
     *
     * @return string 
     */
    public function getTemplateH1()
    {
        return $this->templateH1;
    }

    /**
     * Set templateLead
     *
     * @param string $templateLead
     * @return SimpleLanding
     */
    public function setTemplateLead($templateLead)
    {
        $this->templateLead = $templateLead;

        return $this;
    }

    /**
     * Get templateLead
     *
     * @return string 
     */
    public function getTemplateLead()
    {
        return $this->templateLead;
    }

    /**
     * Set templateButton
     *
     * @param string $templateButton
     * @return SimpleLanding
     */
    public function setTemplateButton($templateButton)
    {
        $this->templateButton = $templateButton;

        return $this;
    }

    /**
     * Get templateButton
     *
     * @return string 
     */
    public function getTemplateButton()
    {
        return $this->templateButton;
    }
}
