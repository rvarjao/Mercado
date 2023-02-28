<?php

namespace Model;

interface ModelInterface
{
    public function save();
    public function delete();
    public static function find($id);
    public static function findAll();
}
