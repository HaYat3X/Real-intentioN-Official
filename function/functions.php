<?php

// XSS対策
function h($string)
{
    echo htmlspecialchars($string, ENT_QUOTES, "UTF-8");
}

