<?php

class SiteController {

    public function actionIndex() {

        require_once(ROOT . '/views/site/indexView.php');

        return true;
    }
}