<form method="post">
	<table>
	    <tr>
                <td><?php echo EMAIL_TEXT; ?></td>
                <td><?php echo PASSWORD_TEXT; ?></td>
	    </tr>
	    <tr>
	        <td>
	            <input type="text" name="Email" value="" style="width:120px;"/>
	        </td>
	        <td>
	            <input type="password" name="Password" value="" style="width:100px;"/>
	        </td>
	        <td>
                    <input type="submit" name="submit" value="<?php echo BUTTON_LOGIN_TEXT; ?>">
	        </td>
	    </tr>
	    <tr>
	        <td colspan=3>
                    <input type="checkbox" name="RememberMe" value="RememberMe" style="margin:0;border:0"/> <?php echo REMEMBER_TEXT; ?>
                    <span id="forgotten"><a href="index.php?page=ForgottenPassword"><?php echo FORGOTTEN_PASSWORD_TEXT; ?></a></span>
	        </td>
	    </tr>
	</table>
</form>