<?php

// XSS対策
function h($string)
{
    echo htmlspecialchars($string, ENT_QUOTES, "UTF-8");
}

// 　乱数生成
function genRandomStr(): string
{
    return bin2hex(random_bytes(8));
}
