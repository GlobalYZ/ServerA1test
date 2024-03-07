<?php
ob_start();
include("../components/header_logged_out.php"); ?>
<div id="contentContainer" style="width: 80%;margin:auto;margin-top:40px;background-color:transparent;min-height:400px;min-width:500px;">
    <div id="myForm">
        <div class="w2ui-page page-0" style="display:flex; flex-direction:column;align-items:center;justify-content:center;">
            <div>
                <p style="text-align: center;margin:auto;">LOGIN</p>
            </div>
            <div class="w2ui-field">
                <label for="user_email">Email:</label>
                <div>
                    <input id="user_email" name="user_email" maxlength="100" size="30" />
                </div>
            </div>
            <div class="w2ui-field">
                <label for="user_password">Password:</label>
                <div>
                    <input id="user_password" name="user_password" type="password" maxlength="100" size="30" />
                </div>
            </div>
        </div>
        <div class="w2ui-buttons">
            <input type="button" value="SIGN UP" name="Signup" />
            <input type="button" value="RESET" name="Reset" />
            <input type="button" value="SUBMIT" name="Submit" />
        </div>
    </div>
</div>
<script>
    var params = new URLSearchParams(window.location.search);
    //show the message
    var message = params.get('message');

    var getFormHeight = () => window.innerHeight - 200;

    // check if the email input is valid
    function isValidEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    $(function() {
        if (message) {
            window.popup1("Warning", message);
        }
        $('#myForm').w2form({
            name: 'myForm',
            fields: [{
                    field: 'user_email',
                    type: 'text',
                    required: true
                },
                {
                    field: 'user_password',
                    type: 'password',
                    required: true
                }
            ],
            actions: {
                Signup() {
                    location.href = "/src/user/signup.php";
                },
                Reset() {
                    this.clear();
                },
                Submit() {
                    formOnSubmit("submit")
                }
            },
            style: `height: 250px;margin-top:${getFormHeight()/2-150}px; width: 70%;margin-left:15%;`,
        });
    });

    var formOnSubmit = () => {
        var email = w2ui.myForm.fields[0].el.value;
        var password = w2ui.myForm.fields[1].el.value;
        if (!isValidEmail(email)) {
            window.popup1("Warning", "Invalid email address!");
            return;
        }
        if (password.length > 30 && email.length > 30) {
            window.popup1("Warning", "password and email can not be longer than 30 characters in length!");
            return;
        }
        if (password == "" || email == "") {
            window.popup1("Warning", "password and email can not be empty!");
            return;
        }
        params.set('email', email);
        params.set('password', password);
        location.href = "/src/user/login_process.php?" + params.toString();
    }
</script>

<?php include("../components/footer.php");
ob_end_flush();
?>