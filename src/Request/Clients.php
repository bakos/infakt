<?php
namespace kiczek\infakt\Request;

use kiczek\infakt\Entity\Client;
use kiczek\infakt\Infakt;

class Clients {
    protected $api;

    public function __construct(Infakt $api)
    {
        $this->api = $api;
    }

    /**
     * Get client details.
     *
     * @param $id
     * @return Client
     */
    public function get($id)
    {
        return new Client($this->api->curl("/clients/" . $id));
    }

    /**
     * Create new client.
     *
     * @param Client $client
     * @return Client
     */
    public function create(Client $client)
    {
        return new Client($this->api->curl("/clients", Infakt::REQUEST_POST, $client->toArray()));
    }

    /**
     * Edit client.
     *
     * @param Client $client
     * @return Client
     */
    public function update($id, Client $client) {
        return new Client($this->api->curl("/clients/" . $id, Infakt::REQUEST_PUT, $client->toArray()));
    }

    /**
     * Delete client.
     *
     * @param $id
     * @return bool
     */
    public function delete($id) {
        $this->api->curl("/clients/" . $id, Infakt::REQUEST_DELETE);
        return true;
    }
}