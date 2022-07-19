<?php

namespace jc21\Util;

interface Item
{
    public static function fromLibrary(array $lib): self;
}
