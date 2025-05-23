<?php 
include_once 'code/functions.php';
connection("localhost", "root", "", "19086");

if(isset($_POST['submit'])){
    $user = $_POST['user'];
    $passw = $_POST['passw'];

    if(authorization($user, $passw)){
        echo "<center><h3><b>$user<br />Nume și Parola corecte. Acces autorizat.</b></h3></center>"; 
        sleep(5);
        header("Location: index.php");           
    } else {
        echo "<center><h3><b>$user<br />Nume sau Parola greșite. Acces neautorizat.</b></h3></center>";
        echo "<center><a href='" . $_SERVER['PHP_SELF'] . "'>Înapoi</a></center>"; 
    }
} else {
?>
    <center>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="login-form">
        <h2 class="form-title">Autentificare</h2>
        <table>
            <tr>
                <td><label for="user"><b>Utilizator:</b></label></td>
                <td><input type="text" id="user" name="user" required /></td>
            </tr>
            <tr>
                <td><label for="passw"><b>Parola:</b></label></td>
                <td><input type="password" id="passw" name="passw" required /></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="submit" value="Login" class="login-button" /></td>
            </tr>
        </table>
    </form>
    </center>
<?php 
}
?>

<style>
/* Overall layout styling */
body {
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg,rgb(122, 186, 245),rgb(40, 5, 241));
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

/* Centered form */
.login-form {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 30px;
    max-width: 400px;
    width: 100%;
}

/* Title */
.form-title {
    text-align: center;
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
}

/* Table styling */
table {
    width: 100%;
    margin-top: 10px;
}

td {
    padding: 8px;
    font-size: 16px;
}

/* Input fields */
input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    margin-top: 5px;
    margin-bottom: 20px;
}

/* Button styling */
.login-button {
    width: 100%;
    padding: 12px;
    background-color:rgb(23, 201, 255);
    color: #fff;
    border: none;
    border-radius: 4px;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.login-button:hover {
    background-color:rgb(2, 7, 57);
}

/* Links */
a {
    color: #6a1b9a;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

/* Responsive design */
@media (max-width: 600px) {
    .login-form {
        padding: 20px;
    }
    
    .form-title {
        font-size: 20px;
    }
}
</style>
