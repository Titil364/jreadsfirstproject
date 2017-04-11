<header>
    <h1>Welcome on the Sign in page</h1>
    <div id="signIn">
        <a href="index.php">
               <button>Back to Form page</button>
        </a>
    </div>
</header> 
<main>
    <form class ="formCss"id="userForm" method="post" action="index.php?action=created&controller=users">
        <fieldset>
            <p>
              <label for="userNickname">User Nickname</label> :
              <input type="text" placeholder="doe34" name="userNickname" id="userNickname" required/>
              <p id="nicknameVerif"></p>
            </p>
            <p>
              <label for="userForename">User Forname</label> :
              <input type="text" placeholder="John" name="userForename" id="userForname" required/>
            </p>
            <p>
              <label for="userSurname">User Surname</label> :
              <input type="text" placeholder="Doe" name="userSurname" id="userSurname" required/>
            </p>
            <p>
              <label for="userMail">User Mail</label> :
              <input type="email" placeholder="johndoe@mail.com" name="userMail" id="userMail" required/> 
            </p>

            <p>
              <label for="userPassword">User Password</label> :
              <input type="password" minlength="6" placeholder="******" name="userPassword" id="userPassword" required/>
            </p>
            <p>
              <label for="userPasswordVerif">User Password Confirmation</label> :
              <input type="password" minlength="6" placeholder="******" name="userPasswordVerif" id="userPasswordVerif" required/>
            </p>
<!-- A quoi ça correspond ? -->
			<p id="passwordVerif"></p>
            <p>
                <button type="button" id ="validation"/>Register</button> 
            </p>
        </fieldset> 
    </form>
    <script src="script/myScriptSignin.js"></script>
</main>