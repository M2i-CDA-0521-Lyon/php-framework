<?php

namespace App\Model;

use Cda0521Framework\Database\Sql\Table;
use Cda0521Framework\Database\Sql\Column;
use Cda0521Framework\Database\AbstractModel;
use Cda0521Framework\Database\Sql\SqlDatabaseHandler;

/**
 * Représente un utilisateur
 */
#[Table('user')]
class User extends AbstractModel
{
    /**
     * Identifiant en base de données
     * @var integer|null
     */
    private ?int $id;
    /**
     * Nom de l'utilisateur
     * @var string
     */
    #[Column('username')]
    private string $username;
    /**
     * Mot de passe de l'utilisateur
     * @var string
     */
    #[Column('password')]
    private string $password;
    /**
     * Token de l'utilisateur
     * @var string
     */
    #[Column('token')]
    private string $token;

    /**
     * Crée un nouveauu sujet
     *
     * @param integer|null $id Identifiant en base de données
     * @param string $username Nom de l'utilisateur
     * @param string $password Mot de passe de l'utilisateur
     * @param string $token Token de l'utilisateur
     */
    public function __construct(
        ?int $id = null,
        string $username = '',
        string $password = '',
        string $token = ''
    )
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->token = $token;
    }

    /**
     * Get identifiant en base de données
     *
     * @return  integer|null
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get nom de l'utilisateur
     *
     * @return  string
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set nom de l'utilisateur
     *
     * @param  string  $username  Nom de l'utilisateur
     *
     * @return  self
     */ 
    public function setUsername(string $username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get mot de passe de l'utilisateur
     *
     * @return  string
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set mot de passe de l'utilisateur
     *
     * @param  string  $password  Mot de passe de l'utilisateur
     *
     * @return  self
     */ 
    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get token de l'utilisateur
     *
     * @return  string
     */ 
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set token de l'utilisateur
     *
     * @param  string  $token  Token de l'utilisateur
     *
     * @return  self
     */ 
    public function setToken(string $token)
    {
        $this->token = $token;

        return $this;
    }
}
