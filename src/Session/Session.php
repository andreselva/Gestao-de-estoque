<?php

namespace Andre\GestaoDeEstoque\Session;

class Session
{
    const SESSION_STARTED = true;
    const SESSION_NOT_STARTED = false;
    private $session_state = self::SESSION_NOT_STARTED;
    private static $instance;


    private function __construct() {}

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Configura os parâmetros do cookie de sessão.
     * 
     * 
     */
    private function configureSession()
    {
        // Define as opções do cookie de sessão
        $cookieParams = [
            'lifetime' => 0, // Sessão dura até o navegador ser fechado
            'path' => '/',    // Disponível em todo o domínio
            'domain' => '',   // Usar o domínio atual
            'secure' => isset($_SERVER['HTTPS']), // Apenas enviar via HTTPS
            'httponly' => true, // Impede o acesso via JavaScript
            'samesite' => 'Lax' // Protege contra CSRF em alguns cenários
        ];

        session_set_cookie_params($cookieParams);
    }

    /**
     * Inicia a sessão se ainda não estiver iniciada.
     * 
     * @return bool Retorna true se a sessão foi iniciada com sucesso, false se já estava iniciada.
     */
    public function initSession()
    {
        if ($this->session_state === self::SESSION_NOT_STARTED) {
            $this->configureSession(); // Configura os parâmetros antes de iniciar a sessão
            if (session_start()) {
                $this->session_state = self::SESSION_STARTED;
                return true;
            } else {
                return false;
            }
        }

        return false; // A sessão já foi iniciada
    }

    /**
     * Regenera o cookie de sessão após inicialização da primeira
     * 
     * 
     */
    public function regenerateCookieSession()
    {
        return session_regenerate_id(true);
    }

    /**
     * Define um valor na sessão.
     * 
     * @param string $key A chave para o valor de sessão.
     * @param mixed $value O valor a ser armazenado.
     */
    public function set($key, $value)
    {
        if ($this->session_state === self::SESSION_STARTED) {
            $_SESSION[$key] = $value;
        }
    }

    /**
     * Obtém um valor da sessão.
     * 
     * @param string $key A chave do valor de sessão.
     * @return mixed|null Retorna o valor se existir, ou null se a chave não existir.
     */
    public function get($key)
    {
        if ($this->session_state === self::SESSION_STARTED) {
            return $_SESSION[$key] ?? null;
        }

        return null;
    }

    /**
     * Remove um valor da sessão.
     * 
     * @param string $key A chave do valor de sessão a ser removido.
     */
    public function remove($key)
    {
        if ($this->session_state === self::SESSION_STARTED) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Destroi a sessão e limpa todos os dados.
     * 
     * @return bool Retorna true se a sessão foi destruída com sucesso.
     */
    public function destroy()
    {
        if ($this->session_state === self::SESSION_STARTED) {
            $this->session_state = self::SESSION_NOT_STARTED;
            session_unset();
            session_destroy();
            return true;
        }

        return false;
    }

    // Verifica se o usuário está autenticado
    public function isAuthenticated(): bool
    {
        return $this->get('user_connected') === true;
    }
    
    /**
     * Verifica autenticação do usuário e redireciona caso não estiver
     * 
     * 
     */
    public function checkAuthentication()
    {
        $authorization = $this->isAuthenticated();
        if (!$authorization) {
            header('Location: ./../login/login.php');
            exit();
        }
    }

    /**
     * Seta as informações necessárias na autenticação. Essas informações serão usadas para autorização do usuário durante a sessão
     *
     * 
     */
    public function buildConn(?array $userData): void
    {
        $this->set('user_connected', true);
        $this->set('userId', $userData['id']);
        $this->set('username', $userData['username']);
    }
}
