<header>
    <h1>Welcome on your profile page</h1>
    <div id="signIn">
        <a href="index.php">
               <button>Back to Form page</button>
        </a>
    </div>
</header>
<form class ="formCss"id="userForm" method="post" action="index.php?action=created&controller=users">
        <fieldset>
            <p>
              <label for="userForname">User Forname</label> :
              <input type="text" placeholder="Ex : John" name="userForname" id="userForname" value="<?php echo $data["forname"]?>" required/>
            </p>
            <p>
              <label for="userSurname">User Surname</label> :
              <input type="text" placeholder="Ex : Doe" name="userSurname" id="userSurname" value="<?php echo $data["surname"]?>" required/>
            </p>
            <p>
              <label for="userMail">User Mail</label> :
              <input type="email" placeholder="Ex : johndoe@mail.com" name="userMail" id="userMail"  value="<?php echo $data["mail"]?>"required/> 
            </p>
            <p>
              <label for="userNickname">User Nickname</label> :
              <input type="text" placeholder="Ex : doe34" name="userNickname" id="userNickname" value="<?php echo $data["nickname"]?>" required/>
              <p id="nicknameVerif"></p>
            </p>
            <p>
              <label for="userPassword">User Password</label> :
              <input type="password" minlength="6" placeholder="Ex : ******" name="userPassword" id="userPassword" required/>
            </p>
            <p>
              <label for="userPasswordVerif">User Password Confirmation</label> :
              <input type="password" minlength="6" placeholder="Ex : ******" name="userPasswordVerif" id="userPasswordVerif" required/>
            </p>
            <p id="passwordVerif"> </p>
            <p>
                <button type="button" id ="validation"/>Save modification</button> 
            </p>
        </fieldset> 
    </form>