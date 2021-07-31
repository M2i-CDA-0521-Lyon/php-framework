<?php

namespace Cda0521Framework\Http;

use Cda0521Framework\Interfaces\HttpResponse;

/**
 * Représente une réponse qui donne lieu à une redirection
 */
final class RedirectResponse implements HttpResponse
{
    /**
     * L'adresse vers laquelle la requête doit être redirigée
     * @var string
     */
    private string $url;

    /**
     * Crée une nouvelle redirection
     *
     * @param string $url L'adresse vers laquelle la requête doit être redirigée
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * Envoie la réponse HTTP au client
     * 
     * @see HttpResponse::send()
     * @return void
     */
    public function send(): void
    {
        header('Location: ' . $this->url);
    }
}
