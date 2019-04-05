<?php

namespace UserBundle\Event;

use Symfony\Component\HttpFoundation\Response;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
class GetResponseUserEvent extends UserEvent
{
    /**
     * @var Response
     */
    private $response;

    /**
     * @param Response $response
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return Response|null
     */
    public function getResponse()
    {
        return $this->response;
    }
}
