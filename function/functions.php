<?php

// XSS対策
function h($string)
{
    // htmlspecialcharsで文字をエスケープする
    echo htmlspecialchars($string, ENT_QUOTES, "UTF-8");
}
