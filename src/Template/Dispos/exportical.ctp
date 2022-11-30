<?php
    header('Content-type: text/calendar; charset=utf-8');
    header('Content-Disposition: attachment; filename=Events_'.$id.'.ics');    
?>
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//hacksw/handcal//NONSGML v1.0//EN
CALSCALE:GREGORIAN
<?php foreach ($eventsical as $event) { ?>
BEGIN:VEVENT
DTEND;VALUE=DATE:<?php echo $event['dateend']."\n"; ?>
UID:<?php echo $event['id']."\n"; ?>
SUMMARY:<?php echo addslashes($event['title'])."\n"; ?>
DTSTART;VALUE=DATE:<?php echo $event['datestart']."\n"; ?>
END:VEVENT
<?php } ?>
END:VCALENDAR