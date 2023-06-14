<?php
class core
{
    protected $currentController = 'home';
    protected $currenMethod = 'index';
    protected $parameters = [];

    public function __construct()
    {
        $url = $this->getUrl();

        if (file_exists('../app/controller/' . ucwords($url[0]) . '.php')) {
            $this->currentController = ucwords($url[0]);

            unset($url[0]);
        }

        require_once '../app/controller/' . $this->currentController . '.php';
        $this->currentController = $this->currentController;

        if (isset($url[1])) {

            if (method_exists($this->currentController, $url[1])) {
                $this->currenMethod = $url([1]);
                unset($url[1]);
            }
        }
        $this->parameters = $url ? array_values($url) : [];
        call_user_func_array([$this->currentController, $this->currenMethod], $this->parameters);
    }
    public function geturl()
    {
        if (isset($_GET('url'))) {
            $url = rtrim($_GET('url'), '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}
