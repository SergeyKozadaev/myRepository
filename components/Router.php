<?php
//построитель маршрутов по URI, сопостовляет Controller->action введенному URI
class Router
{
    // $routes - массив заданных маршрутов
    private $routes;
    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include ($routesPath);
    }
    //получить URI с обрезанными символами /
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim ($_SERVER['REQUEST_URI'], '/');
        }
    }
    // основной метод: ищет полученный URI в массиве заданных маршрутов $routes,
    // если находит - создает объект класса NameController и выполняет actionName при условии его наличия в контроллере
    public function run()
    {
        $uri = $this->getURI();
        foreach ($this->routes as $uriPattern => $path) {
            if(preg_match("~$uriPattern~", $uri)) {

                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                $segments = explode('/', $internalRoute);

                $controllerName = array_shift($segments) . 'Controller';
                $controllerName = ucfirst($controllerName);

                $actionName = 'action' . ucfirst(array_shift($segments));
                $actionParams = $segments;

                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';

                if(file_exists($controllerFile)) {
                    include_once($controllerFile);
                    $controllerObject = new $controllerName;

                    if(method_exists($controllerObject, $actionName)) {
                        $result = call_user_func_array(array($controllerObject, $actionName), $actionParams);
                        if($result != null) {
                            return true;
                        }
                    }
                }
            }
        }
        //если нет контроллера и\или экшена - 404 ошибка
        require_once ROOT . '/views/site/404View.php';
        return false;
    }
}