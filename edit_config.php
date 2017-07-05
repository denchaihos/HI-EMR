
<?php
include 'readConfig.php';
?>

<div class="container">
    <h2>Database Config</h2>

    <form action="edit_config.php" method="POST">
        <div class="form-group row">
            <label for="lgFormGroupInput" class="col-sm-2 col-form-label col-form-label-lg">Host</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="lgFormGroupInput" name="host" value="<?php echo $config['host'] ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="smFormGroupInput" class="col-sm-2 col-form-label col-form-label-sm">Username</label>
            <div class="col-sm-4">
                <input type="text" class="form-control " id="smFormGroupInput" name="username" value="<?php echo $config['username'] ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="lgFormGroupInput" class="col-sm-2 col-form-label col-form-label-lg">Password</label>
            <div class="col-sm-4">
                <input type="text" class="form-control " id="lgFormGroupInput" name="password" value="<?php echo $config['password'] ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="smFormGroupInput" class="col-sm-2 col-form-label col-form-label-sm">DB</label>
            <div class="col-sm-4">
                <input type="text" class="form-control " id="smFormGroupInput" name="db" value="<?php echo $config['db'] ?>">
            </div>
        </div>
        <input type="submit" name="submit" class="btn btn-success" value="Save Data">
    </form>

</div>
<?php
if(isset($_POST['username']) && isset($_POST['password'])) {
    file_put_contents("config/db.txt", "");
    $data = 'host:' . $_POST['host'] . "\r\n";/* for unix  "\n"  only*/
    $data .= 'username:' . $_POST['username'] . "\r\n";
    $data .= 'password:' . $_POST['password'] . "\r\n";
    $data .= 'db:' . $_POST['db'] . "\r\n";
    $ret = file_put_contents('config/db.txt', $data, FILE_APPEND | LOCK_EX);
    if($ret === false) {
        die('There was an error writing this file');
    }
    else {
        //echo "$ret bytes written to file";
        header("location: index.php");

    }
}
/*else {
    die('no post data to process');
}*/