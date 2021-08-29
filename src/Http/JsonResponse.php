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
     * Le code HTTP de la réponse
     *
     * @var integer
     */
    protected int $statusCode;

    /**
     * Crée une nouvelle réponse en JSON
     *
     * @param mixed $data La donnée à sérialiser
     * @param int $statusCode Le code HTTP de la réponse (par défaut: 200)
     */
    public function __construct($data, int $statusCode = 200)
    {
        $this->data = $data;
        $this->statusCode = $statusCode;
    }

    /**
     * Récupère le code HTTP de la réponse
     *
     * @return integer
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
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
