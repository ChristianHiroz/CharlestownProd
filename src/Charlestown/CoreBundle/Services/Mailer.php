<?php
namespace Charlestown\CoreBundle\Services;

use Charlestown\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
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

    public function __construct($mailer, RouterInterface $router, EngineInterface $templating, array $parameters)
    {
        $this->mailer = $mailer;
        $this->router = $router;
        $this->templating = $templating;
        $this->parameters = $parameters;
    }

    public function sendTestMail(User $user)
    {
        $template = $this->parameters['template']['test'];
        $rendered = $this->templating->render($template, array(
        ));

        var_dump($rendered);
        $this->sendEmailMessage($rendered, "christian.hiroz@gmail.com", "christian.hiroz@gmail.com");

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
        $subject = $renderedLines[0];
        $body = implode("\n", array_slice($renderedLines, 1));
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setTo($toEmail)
            ->setBody(
                '<html>' .
                ' <head></head>' .
                ' <body>' .
                $body . 'ghjklmù'.
                ' </body>' .
                '</html>',
                'text/html');
        var_dump($message);
        $this->mailer->send($message);
    }
}