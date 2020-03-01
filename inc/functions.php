<?php
function dateString($date)
{
    return date('F d, Y', strtotime($date));
}
