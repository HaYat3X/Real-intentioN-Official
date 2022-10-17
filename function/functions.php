<?php
function h($string)
{
    echo htmlspecialchars($string, ENT_QUOTES, "UTF-8");
}
