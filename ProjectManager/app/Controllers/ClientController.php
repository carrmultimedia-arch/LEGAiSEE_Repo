<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Client;
use App\Repositories\ClientRepository;

class ClientController
{
    private ClientRepository $clients;

    public function __construct(
        ClientRepository $clients
    ) {
        $this->clients = $clients;
    }

    public function index(): array
    {
        $clients = $this->clients->all();

        $response = [];

        foreach ($clients as $client) {
            $response[] = $client->toArray();
        }

        return [
            'success' => true,
            'data' => $response
        ];
    }

    public function show(int $id): array
    {
        $client = $this->clients->find($id);

        if ($client === null) {
            return [
                'success' => false,
                'message' => 'Client not found'
            ];
        }

        return [
            'success' => true,
            'data' => $client->toArray()
        ];
    }

    public function store(array $data): array
    {
        $client = new Client($data);

        $id = $this->clients->create($client);

        return [
            'success' => true,
            'message' => 'Client created',
            'id' => $id
        ];
    }

    public function update(
        int $id,
        array $data
    ): array {

        $client = $this->clients->find($id);

        if ($client === null) {
            return [
                'success' => false,
                'message' => 'Client not found'
            ];
        }

        $client->fill($data);

        $this->clients->update($client);

        return [
            'success' => true,
            'message' => 'Client updated'
        ];
    }

    public function destroy(int $id): array
    {
        $deleted = $this->clients->delete($id);

        return [
            'success' => $deleted,
            'message' => $deleted
                ? 'Client deleted'
                : 'Unable to delete client'
        ];
    }
}