<?php

return '
<form action="{ REQUEST }" method="post">
    <div id="block">
        <p class="name">' . $this->le['mail'] . '</p>
        <p class="input">
            <input type="text" name="mail" placeholder="' . $this->le['mail_pr'] . '" value="' . $this->mail . '">
        </p>' . $this->mail_wg . '
        <p class="name">' . $this->le['user'] . '</p>
        <p class="input">
            <input type="text" name="user" placeholder="' . $this->le['user_pr'] . '" value="' . $this->user . '">
        </p>' . $this->user_wg . '
        <p class="button"><button id="button" type="submit" name="post">' . $this->le['save-upp'] . '</button></p>
    </div>
</form>';
