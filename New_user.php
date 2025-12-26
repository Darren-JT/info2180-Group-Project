<div class="view-h">
    <h1>New User</h1>


</div>


<div class="form-con">



    <form id="new-user-form" action="logic/add_user.php" method="POST">


        <div class="row">


            <div class="input">

                <label>First Name</label>
                <input type="text" name="firstname" placeholder="Jane" required>
            </div>


            <div class="input">

                <label>Last Name</label>
                <input type="text" name="lastname" placeholder="Doe" required>
            </div>
        </div>

        <div class="row">
            <div class="input">
                <label>Email</label>
                <input type="email" name="email" placeholder="something@example.com" required>
            </div>
            <div class="input">
                <label>Password</label>

                <input type="password" name="password" required>


                <small>Mst have 1 digit, 1 caps 1 letter, and be 8+ chars</small>
            </div>
        </div>

        <div class="row">
            <div class="input">
                <label>Role</label>


                <select name="role">
                    <option value="Member">Member</option>
                    <option value="Admin">Admin</option>

                </select>


            </div>
        </div>


        <div class="footer">
            <button type="submit" class="btn-primary">Save</button>
        </div>
    </form>


    <div id="message"></div>



</div>