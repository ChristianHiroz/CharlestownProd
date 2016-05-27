<?php

namespace Charlestown\NotificationBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;

class NotificationBlock extends BaseBlockService  {
    protected $container;

    public function __construct($type, $templating, $container)
    {
        $this->type = $type;
        $this->templating = $templating;
        $this->container = $container;
    }

    public function getName()
    {
        return 'Notification';
    }

    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $count = 0;
        $countInfo = 0;
        $user = $this->container->get('security.context')->getToken()->getUser();
        $notification = $this->container->get('doctrine')->getRepository('CharlestownNotificationBundle:NotificationUser')->getNotificationByUser($user->getId());

        foreach($notification as $notif){
            if($notif->getState() == "info"){
                $countInfo++;
            }
            elseif($notif->getState() == "unread"){
                $count++;
            }
        }

        $resolver->setDefaults(array(
            'url'      => false,
            'user' => $user,
            'notifications' => $notification,
            'count' => $count,
            'countInfo' => $countInfo,
            'title'    => 'Notification',
            'template' => 'CharlestownNotificationBundle:Sonata:notification.html.twig',
        ));
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $settings = $blockContext->getSettings();
        $feeds = false;

        if ($settings['url']) {
            $options = array(
                'http' => array(
                    'user_agent' => 'Sonata/Notification',
                    'timeout' => 2,
                )
            );

            // retrieve contents with a specific stream context to avoid php errors
            $content = @file_get_contents($settings['url'], false, stream_context_create($options));

            if ($content) {
                // generate a simple xml element
                try {
                    $feeds = new \SimpleXMLElement($content);
                    $feeds = $feeds->channel->item;
                } catch (\Exception $e) {
                    // silently fail error
                }
            }
        }

        return $this->renderResponse($blockContext->getTemplate(), array(
            'feeds'     => $feeds,
            'block'     => $blockContext->getBlock(),
            'settings'  => $settings
        ), $response);
    }

    /**
     * @param FormMapper     $form
     * @param BlockInterface $block
     *
     * @return void
     */
    public function buildEditForm(FormMapper $form, BlockInterface $block)
    {

    }
}