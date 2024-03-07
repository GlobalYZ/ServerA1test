<?php ob_start();
include("../components/header.php"); ?>
<div>
    <div id="myGrid" style="width:400px;">

    </div>
    <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;">
        <input type="button" value="Buckets" name="Buckets" onclick="location.href='/src/database/bucket/buckets.php'" />
    </div>
</div>
<?php
session_start();
//kick out if user is not admin
if ($_SESSION['role'] != 'admin') {
    header("Location: /src/user/login.php");
    exit();
}

$db = new SQLite3($_SERVER['DOCUMENT_ROOT'] . '/A1.sqlite');
require_once '../user/user.php';
$users = User::getUsers($db);
?>
<script>
    var getFormHeight = () => window.innerHeight - 280;
    var getFormWidth = () => window.innerWidth / 2;
    var users = <?php echo json_encode($users); ?>;
    console.log(users);
    var gridData = [];

    function renderApprovedBox(checked, index) {
        // return `<input class="form-check-input" type="checkbox" role="switch" ${checked ? 'checked' : ''} ">`;
        return `<div class="w2ui-reset" style="padding-top:2px;">
        <input id=approvedSection${index} name="field.toggle" type="checkbox" class="w2ui-input1 w2ui-toggle w2ui-small" ${checked ? 'checked' : ''} />
        <div>
            <div></div>
        </div>
    </div>`
    }



    var index = 0;
    users.forEach(user => {
        gridData.push({
            recid: index,
            email: user.UserEmail,
            Approved: renderApprovedBox(user.Approved, index),
            ifApproved: user.Approved
        });
        index++;
    });
    $(function() {
        $('#myGrid').w2grid({
            name: 'myGrid',
            columns: [{
                    field: 'email',
                    text: 'user email',
                    size: '50%'
                },
                {
                    field: 'Approved',
                    text: 'Approved',
                    size: '50%'
                }
            ],
            records: gridData,
            style: `height:${getFormHeight()}px;margin:40px;width:${getFormWidth()}px;margin-left:25%;`,
        });

        // Add event listener for toggle input change
        $('#myGrid').on('change', 'input[name="field.toggle"]', function() {
            // Handle the change event here
            var index = $(this).attr('id').replace('approvedSection', ''); // Extract index from ID
            var isChecked = $(this).is(':checked');
            console.log('Toggle with index ' + index + ' changed. New state: ' + isChecked);
            var targetEmail = "";
            gridData.forEach((record, i) => {
                if (record.recid == index) {
                    targetEmail = record.email;
                    location.href = "/src/admin/update_access.php?email=" + targetEmail + "&approved=" + isChecked;
                }
            });
        });
    });
</script>
<?php include("../components/footer.php"); ?>