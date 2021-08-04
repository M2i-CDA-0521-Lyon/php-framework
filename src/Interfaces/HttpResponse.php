<?php

namespace Cda0521Framework\Interfaces;

/**
 * Interface décrivant la structure nécessaire des classes représentant des réponses HTTP
 */
interface HttpResponse
{
    /**
     * Envoie la réponse HTTP au client
     * 
     * @return void
     */
    public function send(): void;
}
