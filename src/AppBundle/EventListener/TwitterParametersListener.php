<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\StreamParameters;
use AppBundle\Loader\LoaderHelper;
use AppBundle\MergeStreamParameters;
use AppBundle\Stream\RequestFactory;
use Doctrine\Common\Persistence\ObjectRepository;
use SensioLabs\Consul\ConsulResponse;
use SensioLabs\Consul\Services\KV;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class TwitterParametersListener implements EventSubscriberInterface
{
    /**
     * @var KV
     */
    private $kv;

    /**
     * @var RequestFactory
     */
    private $requestFactory;
    /**
     * @var ObjectRepository
     */
    private $repo;

    public function __construct(KV $kv, RequestFactory $requestFactory, ObjectRepository $repo)
    {
        $this->kv = $kv;
        $this->requestFactory = $requestFactory;
        $this->repo = $repo;
    }

    public static function getSubscribedEvents()
    {
        return array(
          'easy_admin.post_persist' => array('onPostPersist'),
          'easy_admin.post_update' => array('onPostUpdate'),
          'easy_admin.post_remove' => array('onPostRemove'),
        );
    }

    public function onPostPersist(GenericEvent $event)
    {
        $this->onPostUpdate($event);
    }

    /**
     * @param GenericEvent $event
     * @throws \Exception
     */
    public function onPostUpdate(GenericEvent $event)
    {
        $entity = $event->getSubject();

        if (!($entity instanceof StreamParameters)) {
            return;
        }

        $streamParameter = $this->repo->findBy(['enabled' => true]);
        if (empty($streamParameter)) {
            $response = $this->kv->delete('twitter/1/request');
            $result = $response->json();
            if (!$result) {
                throw new \Exception();
            }
            return;
        }

        $merger = new MergeStreamParameters();
        $mergedStreamParameters = $merger->merge($streamParameter);

        $params = LoaderHelper::makeQueryParams($mergedStreamParameters->getTrack(), $mergedStreamParameters->getFollow(), $mergedStreamParameters->getLocations());
        $request = $this->requestFactory->filter($params);

        /** @var ConsulResponse $response */
        $response = $this->kv->put('twitter/1/request', [
          'method' => $request->getMethod(),
          'uri' => (string) $request->getUri(),
          'headers' => $request->getHeaders(),
          'body' => (string) $request->getBody(),
          'version' => $request->getProtocolVersion()
        ]);
        $result = $response->json();

        if (!$result) {
            throw new \Exception();
        }
    }

    public function onPostRemove(GenericEvent $event)
    {
        $this->onPostUpdate($event);
    }
}
