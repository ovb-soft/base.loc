<?php

return '
<form action="{ REQUEST }" method="post">
    <p class="name">' . $this->lt['mail'] . '</p>
    <p class="input"><input type="text" name="mail" placeholder="' . $this->lt['mail_pr'] . '" value="' . $this->mail . '"></p>' . $this->mail_wg . '
    <p class="name">' . $this->lt['user'] . '</p>
    <p class="input"><input type="text" name="user" placeholder="' . $this->lt['user_pr'] . '" value="' . $this->user . '"></p>' . $this->user_wg . '
    <p class="name">' . $this->lt['pass'] . '</p>
    <p class="input"><input type="password" name="pass" placeholder="' . $this->lt['pass_pr'] . '" value="' . $this->pass . '"></p>' . $this->pass_wg . '
    <p class="name">' . $this->lt['confirm'] . '</p>
    <p class="input"><input type="password" name="confirm" placeholder="' . $this->lt['confirm_pr'] . '" value="' . $this->confirm . '"></p>' . $this->confirm_wg . '
    <p class="button"><button id="button" type="submit" name="post">' . $this->lt['registration-upp'] . '</button></p>
</form>';
