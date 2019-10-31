<?php

return '
<table>
    <tr>
        <td class="solid block"><p>' . $this->le['mail'] . '</p></td>
        <td class="solid bold"><p>:</p></td>
        <td class="solid line"><p>' . $this->mail . '</p></td>
    </tr>
    <tr>
        <td class="solid block"><p>' . $this->le['user'] . '</p></td>
        <td class="solid bold"><p>:</p></td>
        <td class="solid line"><p>' . $this->user . '</p></td>
    </tr>
    <tr>
        <td colspan="3"><p class="colspan"><a href="/personal/data{ EXT }">' . $this->le['edit'] . '</a></p></td>
    </tr>
    <tr>
        <td class="solid block"><p>' . $this->le['created'] . '</p></td>
        <td class="solid bold"><p>:</p></td>
        <td class="solid line"><p><span class="line-right size-12">' . $this->time . '</span><span class="size-13">' . $this->date . '</span></p></td>
    </tr>
    <tr>
        <td class="solid block"><p>' . $this->le['password'] . '</p></td>
        <td class="solid bold"><p>:</p></td>
        <td class="solid line"><p><a href="/personal/password{ EXT }">' . $this->le['change_password'] . '</a></p></td>
    </tr>
    <tr>
        <td colspan="3"><div class="footer"></div></td>
    </tr>
</table>';
