<?php
echo $this->element('Messaging/chats_content', [
    'messages'    => $messages,
    'unreadCount' => $unreadCount,
]);
?>