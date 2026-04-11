<?php

class StickyForm {

    public function stickyText($fieldName) {
        if (isset($_POST[$fieldName])) {
            return htmlspecialchars($_POST[$fieldName]);
        }
        return '';
    }

    public function clearFields() {
        $_POST = [];
    }
}
