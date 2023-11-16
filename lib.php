<?php
defined('MOODLE_INTERNAL') || die();

function get_array_short_months()
{   
    $datetime = new DateTime('now', new DateTimeZone('UTC'));
    $months = array();

    for ($mes = 1; $mes <= 12; $mes++) {
        $datetime->setDate($datetime->format('Y'), $mes, 1);
        $shortname = strftime('%b', $datetime->getTimestamp());
        $months[] = ucfirst($shortname);
    }

    return $months;
}

function get_array_months()
{   
    $datetime = new DateTime('now', new DateTimeZone('UTC'));
    $months = array();

    for ($mes = 1; $mes <= 12; $mes++) {
        $datetime->setDate($datetime->format('Y'), $mes, 1);
        $name = strftime('%B', $datetime->getTimestamp());
        $months[] = ucfirst($name);
    }

    return $months;
}

function get_array_short_days()
{   
    $datetime = new DateTime('now', new DateTimeZone('UTC'));
    $days = array();

    for ($day = 1; $day <= 7; $day++) {
        $datetime->setISODate($datetime->format('Y'), $datetime->format('W'), $day);
        $shortname = strftime('%a', $datetime->getTimestamp());
        $days[] = ucfirst($shortname);
    }

    return $days;
}

function get_array_days()
{   
    $datetime = new DateTime('now', new DateTimeZone('UTC'));
    $days = array();

    for ($day = 1; $day <= 7; $day++) {
        $datetime->setISODate($datetime->format('Y'), $datetime->format('W'), $day);
        $shortname = strftime('%A', $datetime->getTimestamp());
        $days[] = ucfirst($shortname);
    }

    return $days;
}

function tool_languagepatch_before_footer() {
    global $PAGE;
    global $CFG;

    $short_days = get_array_short_days();
    $days = get_array_days();
    $months = get_array_months();
    $short_months = get_array_short_months();

    $PAGE->requires->js_init_code('
        var patch_language_temp = setInterval(function() {
            if (typeof Y !== "undefined" && Y.Intl && typeof Y.Intl.add === "function") {
                Y.Intl.add("datatype-date-format", "en-US", {
                    a: ["'.$short_days[6].'", "'.$short_days[0].'", "'.$short_days[1].'", "'.$short_days[2].'", "'.$short_days[3].'", "'.$short_days[4].'", "'.$short_days[5].'"],
                    A: ["'.$days[6].'", "'.$days[0].'", "'.$days[1].'", "'.$days[2].'", "'.$days[3].'", "'.$days[4].'", "'.$days[5].'"],
                    b: ["'.$short_months[0].'", "'.$short_months[1].'", "'.$short_months[2].'", "'.$short_months[3].'", "'.$short_months[4].'", "'.$short_months[5].'", "'.$short_months[6].'", "'.$short_months[7].'", "'.$short_months[8].'", "'.$short_months[9].'", "'.$short_months[10].'", "'.$short_months[11].'"],
                    B: ["'.$months[0].'", "'.$months[1].'", "'.$months[2].'", "'.$months[3].'", "'.$months[4].'", "'.$months[5].'", "'.$months[6].'", "'.$months[7].'", "'.$months[8].'", "'.$months[9].'", "'.$months[10].'", "'.$months[11].'"],
                    c: "%a, %b %d, %Y %l:%M:%S %p %Z",
                    p: ["AM", "PM"],
                    P: ["am", "pm"],
                    x: "%m/%d/%y",
                    X: "%l:%M:%S %p"
                });
                clearInterval(patch_language_temp);
            }
        }, 500);
    ');
}
