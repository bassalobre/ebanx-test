<?php

namespace Source\Application;

abstract class Output
{
    public function toArray(): array
    {
        return json_decode(json_encode($this), true);
    }
}
