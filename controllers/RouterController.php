<?php


class RouterController extends Controller
{


        protected $controller;

        public function make($param)
        {
            $url = $this->parseURL($param[0]);


            if (empty($url[0])){
                $this->homepage();
            }
            $classController = $this->toCS(array_shift($url)) . 'Controller';

            if (file_exists('controllers/' . $classController . '.php')){
                    $this->controller = new $classController;
            }
            else{
                    $this->set_url('error');
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

        private function homepage(){

            $this->data = array('title' => 'Půjčovna filmů');
            $this->temp = 'login';
            $this->view();

            $this->data = array('text' => 'neco', 'button' => 'Registrace »');
            $this->temp = 'singup';
            $this->view();
        }
}