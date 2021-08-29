<?php

namespace Cda0521Framework\Http;

use Cda0521Framework\Interfaces\HttpResponse;

/**
 * Représente une réponse qui contient des données au format JSON
 */
class JsonResponse implements HttpResponse
{
    /**
     * La donnée à sérialiser
     *
     * @var mixed
     */
    protected $data;

    /**
     * Crée une nouvelle réponse en JSON
     *
     * @param mixed $data La donnée à sérialiser
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Envoie la réponse HTTP au client
     * 
     * @return void
     */
    public function send(): void
    {
        // Ajoute une méta-donnée signifiant que la réponse est encodée en JSON
        header("Content-Type: application/json; charset=UTF-8");
        // Sérialise la donnée en JSON et l'écrit dans la réponse
        echo \json_encode($this->data);
    }
}
