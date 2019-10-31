<?php

return '
<form action="{ REQUEST }" method="post">
    <p class="name">' . $this->lt['mail'] . '</p>
    <p class="input"><input type="text" name="mail" placeholder="' . $this->lt['mail_pr'] . '" value="' . $this->mail . '"></p>
    <p class="name">' . $this->lt['pass'] . '</p>
    <p class="input"><input type="password" name="pass" placeholder="' . $this->lt['pass_pr'] . '" value=""></p>' . $this->warning . '
    <p class="button"><button id="button" type="submit" name="login">' . $this->lt['sign_in-upp'] . '</button></p>
</form>';
