<?php

class Controller
{
    private $model, $view;
    public function __construct()
    {
        // Aquí puedes inicializar cualquier recurso común para tus controladores
        $this->view = new Views();
        $this->loadModel();
    }
    public function loadModel()
    {
        // Este método se puede usar para cargar el modelo específico del controlador
        $modelName = str_replace("Controller", "Model", get_class($this));
        $modelPath = "Models/" . $modelName . ".php";
        if (file_exists($modelPath)) {
            require_once $modelPath;
            $this->model = new $modelName();
        }
    }
}
