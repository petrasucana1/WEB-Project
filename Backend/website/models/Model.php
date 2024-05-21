<?php

class Model implements Stringable, JsonSerializable {
    public int $id;

    public function __toString() : string
    {
        return "id={$this->id}";
    }

    public function jsonSerialize() : array
    {
        return [
            'id' => $this->id
        ];
    }
}