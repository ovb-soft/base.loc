<?php

return '
<form action="{ REQUEST }" method="post">
    <p class="name">' . $this->le['pass'] . '</p>
    <p class="input"><input type="password" name="pass" placeholder="' . $this->le['pass_ph'] . '" value="' . $this->pass . '"></p>' . $this->pass_wg . '
    <p class="name">' . $this->le['confirm'] . '</p>
    <p class="input"><input type="password" name="confirm" placeholder="' . $this->le['confirm_ph'] . '" value="' . $this->confirm . '"></p>' . $this->confirm_wg . '
    <p class="button"><button id="button" type="submit" name="post">' . $this->le['save-upp'] . '</button></p>
</form>';
