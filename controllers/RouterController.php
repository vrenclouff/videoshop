<?php


class RouterController extends AbsController
{


        protected $controller;

        public function make($param)
        {

            $url = $this->parseURL($param[0]);

            if (empty($url[0])){
                    $this->view();
            }

            $classController = $this->toCS(array_shift($url)) . 'Controller';

            if (file_exists('controllers/' . $classController . '.php') && $classController != 'AbsController'){
                    $this->controller = new $classController;
            }
            else{
                    $this->temp = 'error';
                    $this->view();
                    exit;
            }

            $this->controller->make($url);
        }

        private function toCS($text)
        {
            return str_replace(' ', '', ucwords(str_replace('-', ' ', str_replace('-', ' ', $text))));
        }

        private function parseURL($url)
        {
            return explode("/", trim(ltrim(ltrim(parse_url($url)["path"], "/"), "/")));
        }
}