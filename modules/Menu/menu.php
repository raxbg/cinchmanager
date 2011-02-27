<ul id="menu">
    <li class="level_1">
        <a href=# onmouseover="openLevel_2('users_submenu')" onmouseout="closeLevel_2AfterTime()">Users</a>
        <ul class="level_2" id="users_submenu" onmouseover="cancelLevel_2Timeout()" onmouseout="closeLevel_2AfterTime()">
            <li class="level_2">
                <a href=# onmouseover="openLevel_3('all_users')" onmouseout="closeLevel_3AfterTime()">View all users</a>
                <ul class="level_3" id="all_users" onmouseover="cancelLevel_3Timeout()" onmouseout="closeLevel_3AfterTime()">
                    <li class="level_3">Employees</li>
                    <li class="level_3 last">Clients</li>
                </ul>
            </li>
            <li class="level_2 last">
                <a href="index.php?page=CreateAccount">Create new account</a>
            </li>
        </ul>
    </li>
    <li class="level_1">
        <a href=# onmouseover="openLevel_2('settings_submenu')" onmouseout="closeLevel_2AfterTime()">Settings</a>
        <ul class="level_2" id="settings_submenu" onmouseover="cancelLevel_2Timeout()" onmouseout="closeLevel_2AfterTime()">
            <li class="level_2">
                <a href=# onmouseover="openLevel_3('branches')" onmouseout="closeLevel_3AfterTime()">Branches</a>
                <ul class="level_3" id="branches" onmouseover="cancelLevel_3Timeout()" onmouseout="closeLevel_3AfterTime()">
                    <li class="level_3">
                        <a href="index.php?page=EditBranches">Add new</a>
                    </li>
                    <li class="level_3 last">
                        <a href="index.php?page=Branches">View all</a>
                        </li>
                </ul>
            </li>
            <li class="level_2 last">
                <a href="index.php?page=CreateAccount">Create new account</a>
            </li>
        </ul>
    </li>
</ul>