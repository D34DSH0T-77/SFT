<?php

namespace App\Traits;

trait Traits {

    protected function textoValidate($texto): bool {
        return preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/', $texto);
    }
}
