<?php
/**
 * Autor: UBa
 * Date: 20.05.2015
 * Time: 11:25
 * Description: The laratchet main class
 */

namespace SysMl\Laratchet;

use Illuminate\Database\Eloquent\Collection;

class Laratchet {

    protected $socket = null;

    /**
     * Class constructor
     *
     * @throws \Exception
     */
    public function __construct()
    {
        if (!class_exists('ZMQContext'))
        {
            throw new \Exception('ZeroMQ has to be available to use laratchet.');
        }

        $this->socket = $this->connect();
    }

    /**
     * Send a push message to specific users
     *
     * @param array $data
     * @param null $recipients
     * @internal param $channel
     * @return \ZMQSocket
     */
    public function message(Array $data = null, $recipients = null)
    {

        $config = [
            'mode'       => 'message',
            'data'       => $data,
            'recipients' => $this->getRecipientsSessions($recipients),
        ];

        return $this->socket->send(json_encode($config));
    }

    /**
     * Send a push message to all clients on a channel
     * @param $channel
     * @param array $data
     * @return \ZMQSocket
     */
    public function broadcast($channel, Array $data = null)
    {
        $config = [
            'mode'    => 'broadcast',
            'channel' => $channel,
            'data'    => $data,
        ];

        return $this->socket->send(json_encode($config));
    }

    /**
     * Connect to the socket server
     *
     * @return \ZMQSocket
     */
    public function connect()
    {
        $context = new \ZMQContext();
        $socket = $context->getSocket(\ZMQ::SOCKET_PUSH, 'laratchetPusher');
        $socket->connect(\Config::get('laratchet.pullServer'));

        return $socket;
    }

    /**
     * Convert a collection of users to an array of sessions
     *
     * @param array|Collection $recipients
     * @return array
     */
    public function getRecipientsSessions($recipients)
    {

        $sessions = [];

        // Detect if a single user is given
        if(class_basename($recipients) == 'User')
        {
            $sessions[] = $recipients->session->id;

            return $sessions;
        }

        foreach ($recipients AS $recipient)
        {
            if(is_a($recipient->session,'\SysMl\Laratchet\Models\Session'))
            {
                $sessions[] = $recipient->session->id;
            }
        }

        return $sessions;
    }

    /**
     * Sync the users session with his id
     */
    public function syncUserSession()
    {
        Models\Session::syncUserSession();
    }

}