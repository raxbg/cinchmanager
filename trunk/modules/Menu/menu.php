<ul id="menu">
    <?php
    if(isset($_SESSION['LoggedIn']))
    { ?>
    <li class="level_1">
        <a href="index.php?page=Tasks"><?php echo TASKS_TEXT; ?></a>
    </li>
    <li class="level_1">
        <a href=# onmouseover="openLevel_2('users_submenu')" onmouseout="closeLevel_2AfterTime()"><?php echo USERS_TEXT; ?></a>
        <ul class="level_2" id="users_submenu" onmouseover="cancelLevel_2Timeout()" onmouseout="closeLevel_2AfterTime()">
            <li class="level_2">
                <a href=# onmouseover="openLevel_3('all_users')" onmouseout="closeLevel_3AfterTime()"><?php echo VIEW_ALL_TEXT; ?></a>
                <ul class="level_3" id="all_users" onmouseover="cancelLevel_3Timeout()" onmouseout="closeLevel_3AfterTime()">
                    <li class="level_3"><a href="index.php?page=Employees"><?php echo EMPLOYEES_TEXT; ?></a></li>
                    <li class="level_3 last"><a href="index.php?page=Clients"><?php echo CLIENTS_TEXT; ?></a></li>
                </ul>
            </li>
            <li class="level_2 last">
                <a href="index.php?page=CreateAccount"><?php echo CREATE_ACCOUNT_TEXT; ?></a>
            </li>
        </ul>
    </li>
    <li class="level_1">
        <a href=# onmouseover="openLevel_2('manage_submenu')" onmouseout="closeLevel_2AfterTime()"><?php echo MANAGE_TEXT; ?></a>
        <ul class="level_2" id="manage_submenu" onmouseover="cancelLevel_2Timeout()" onmouseout="closeLevel_2AfterTime()">
            <li class="level_2">
                <a href="index.php?page=Branches" onmouseover="openLevel_3('branches')" onmouseout="closeLevel_3AfterTime()"><?php echo BRANCHES_TEXT; ?></a>
                <ul class="level_3" id="branches" onmouseover="cancelLevel_3Timeout()" onmouseout="closeLevel_3AfterTime()">
                    <li class="level_3">
                        <a href="index.php?page=EditBranches"><?php echo ADD_TEXT; ?></a>
                    </li>
                    <li class="level_3 last">
                        <a href="index.php?page=Branches"><?php echo VIEW_ALL_TEXT; ?></a>
                    </li>
                </ul>
            </li>
            <li class="level_2">
                <a href="index.php?page=EditTitles"><?php echo TITLES1_TEXT; ?></a>
            </li>
            <li class="level_2">
                <a href="index.php?page=EditPositions"><?php echo POSITIONS1_TEXT; ?></a>
            </li>
            <li class="level_2 last">
                <a href="index.php?page=Projects" onmouseover="openLevel_3('projects')" onmouseout="closeLevel_3AfterTime()"><?php echo PROJECTS_TEXT; ?></a>
                <ul class="level_3" id="projects" onmouseover="cancelLevel_3Timeout()" onmouseout="closeLevel_3AfterTime()">
                    <li class="level_3">
                        <a href="index.php?page=EditProject"><?php echo ADD_TEXT; ?></a>
                    </li>
                    <li class="level_3 last">
                        <a href="index.php?page=Projects"><?php echo VIEW_ALL_TEXT; ?></a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
    <li class="level_1">
        <a href=# onmouseover="openLevel_2('account_submenu')" onmouseout="closeLevel_2AfterTime()"><?php echo ACCOUNT_TEXT; ?></a>
        <ul class="level_2" id="account_submenu" onmouseover="cancelLevel_2Timeout()" onmouseout="closeLevel_2AfterTime()">
            <li class="level_2">
                <a href="index.php?page=ChangePassword"><?php echo CHANGE_PASSWORG_TEXT; ?></a>
            </li>
            <li class="level_2 last">
                <a href=#><?php echo EDIT_TEXT; ?></a>
            </li>
        </ul>
    </li>
    <?php }?>
</ul>