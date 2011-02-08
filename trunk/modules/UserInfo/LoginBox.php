<?php
    global $TEXT;
?><form method="post">
	<table>
	    <tr>
	        <td><?php echo $TEXT['Email']; ?></td>
	        <td><?php echo $TEXT['Password']; ?></td>
	    </tr>
	    <tr>
	        <td>
	            <input type="text" name="Email" value="" style="width:120px;"/>
	        </td>
	        <td>
	            <input type="password" name="Password" value="" style="width:100px;"/>
	        </td>
	        <td>
	            <input type="submit" name="submit_button" value="<?php echo $TEXT['ButtonLogin']; ?>">
	        </td>
	    </tr>
	    <tr>
	        <td colspan=3>
	            <input type="checkbox" name="RememberMe" value="0" style="margin:0;border:0"/> <?php echo $TEXT['Remember']; ?>
	            <span id="forgotten"><a href=#><?php echo $TEXT['ForgottenPassword']; ?></a></span>
	        </td>
	    </tr>
	</table>
</form>