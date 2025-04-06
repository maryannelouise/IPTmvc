<?php
class HomeController {
    public function index() {
        include $_SERVER['DOCUMENT_ROOT'] . '/careset/view/homepage/index.php';
    }

    public function homepage() {
        include $_SERVER['DOCUMENT_ROOT'] . '/careset/view/homepage/homepage.php';
    }
}
?>
