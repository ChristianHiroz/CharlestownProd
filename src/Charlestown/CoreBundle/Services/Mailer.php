<?php
namespace Charlestown\CoreBundle\Services;

use Charlestown\CollaboratorBundle\Entity\Collaborator;
use Charlestown\CustomerBundle\Entity\Customer;
use Charlestown\DemandBundle\Entity\Demand;
use Charlestown\OperationBundle\Entity\Operation;
use Charlestown\OperationBundle\Entity\OperationAppliance;
use Charlestown\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\RouterInterface;
/**
 * Service Mailer, used to create & send message via SwiftMailer
 *
 * @author Christian Hiroz
 */
class Mailer {
    protected $mailer;
    protected $router;
    protected $templating;
    protected $parameters;

    public function __construct(ContainerInterface $container, array $parameters)
    {
        $this->mailer = $container->get('mailer');
        $this->router = $container->get('router');
        $this->templating = $container->get('templating');
        $this->parameters = $parameters;
    }

    public function sendTestMail(User $user)
    {
        $template = $this->parameters['template']['test'];
        $rendered = $this->templating->render($template, array(
        ));

        $this->sendEmailMessage($rendered, "christian.hiroz@gmail.com", "christian.hiroz@gmail.com");

    }

    public function sendDemandMail(User $user, $demand){
        $template = $this->parameters['template']['demand'];

        $rendered = $this->templating->render($template, array('demand' => $demand));

        $this->sendEmailMessage($rendered, "no-reply@charlestown.com", $user->getEmail());
    }

    public function sendDemandResponseMail(Demand $demand){

        $user = $demand->getUser();
        if($demand->isResponse() == true) $demand = "acceptée";
        else $demand = "refusée";
        $template = $this->parameters['template']['demandResponse'];
        $rendered = $this->templating->render($template, array('demand' => $demand));

        $this->sendEmailMessage($rendered, "no-reply@charlestown.com", $user->getEmail());
    }

    public function sendOperationNotificationMail(OperationAppliance $operation){
        $user = $operation->getEvent();

        $template = $this->parameters['template']['operationNotification'];
        $rendered = $this->templating->render($template, array('operation' => $operation->getOperation(), 'user' => $user));

        $this->sendEmailMessage($rendered, "no-reply@charlestown.com", $operation->getOperation()->getAgency()->getEventCustomerManager()->getEmail());
    }

    public function sendUniformSelectionNotificationMail(Customer $user){
        $template = $this->parameters['template']['uniformNotification'];
        $rendered = $this->templating->render($template, array('user' => $user));

        $this->sendEmailMessage($rendered, "no-reply@charlestown.com", $user->getAgency()->getCustomerManager()->getEmail());
    }

    public function sendIdeaBoxNotificationMail(User $user){
        $type = "";
        if($user instanceof Customer){
            $type = "Client";
        }
        if($user instanceof Collaborator){
            $type = "Collaborateur";
        }

        $template = $this->parameters['template']['ideaboxNotification'];
        $rendered = $this->templating->render($template, array("type" => $type));

        $this->sendEmailMessage($rendered, "no-reply@charlestown.com", "collaborateurs@charlestown.com");
    }

    public function sendQualityMail(User $user, $title, $body, $nom){

        $template = $this->parameters['template']['quality'];
        $rendered = $this->templating->render($template, array("nom" => $nom, "body" => $body, "title" => $title, "user" => $user->getUsername()));

        $this->sendEmailMessage($rendered, "no-reply@charlestown.com", "qualite@charlestown.com");
    }

    public function sendOperationApplianceResponseMail(OperationAppliance $appliance){
        $user = $appliance->getEvent();
        $accepted = false;
        if($appliance->isAccepted() == true) $accepted = true;
        $appliance = $appliance->getOperation()->getName();

        $template = $this->parameters['template']['operationResponse'];
        $rendered = $this->templating->render($template, array('appliance' => $appliance, 'accepted' => $accepted));

        $this->sendEmailMessage($rendered, "no-reply@charlestown.com", $user->getEmail());
    }

    public function sendOperationApplianceMail(OperationAppliance $appliance){

        $user = $appliance->getEvent();

        $appliance = $appliance->getOperation()->getName();

        $template = $this->parameters['template']['operation'];
        $rendered = $this->templating->render($template, array('appliance' => $appliance));

        $this->sendEmailMessage($rendered, "no-reply@charlestown.com", $user->getEmail());
    }

    /**
     * @param string $renderedTemplate
     * @param string $fromEmail
     * @param string $toEmail
     */
    protected function sendEmailMessage($renderedTemplate, $fromEmail, $toEmail)
    {
        // Render the email, use the first line as the subject, and the rest as the body
        $renderedLines = explode("\n", trim($renderedTemplate));
        $subject = "Charlestown - " . $renderedLines[0];
        $body = implode("\n", array_slice($renderedLines, 1));
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setTo($toEmail)
            ->setBody(
                '<html>' .
                ' <head></head>' .
                ' <body>' .
                $body .
                ' </body>' .
                '</html>',
                'text/html');
        $this->mailer->send($message);
    }
}