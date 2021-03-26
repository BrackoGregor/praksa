<?php
include "model.php";

function SignUp()
{
    if (isset($_POST['button']))
        {
            echo nl2br("\n");
            $username = strip_tags($_POST['username']);
            $password = strip_tags($_POST['password']);
            $repassword = strip_tags($_POST['repassword']);
            $email = strip_tags($_POST['email']);
            $date = date("Y-m-d H:i:sa");

            if ($username == "" || $password == "" || $repassword == "" || $email =="")
            {
                echo '<div class="form-register">'.'<div class="alert alert-danger">'."Missing fields!".'</div>'.'</div>';
            }
            else if (trim($username) == "")
            {
                echo '<div class="form-register">'.'<div class="alert alert-danger">'."No spaces in username!".'</div>'.'</div>';
            }
            else if(strlen($password) == "")
            {
                echo '<div class="form-register">'.'<div class="alert alert-danger">'."Password must not be empty!".'</div>'.'</div>';
            }
            else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                echo '<div class="form-register">'.'<div class="alert alert-danger">'."Email does not exsist!".'</div>'.'</div>';
            }
            else if ($password != $repassword)
            {
                echo '<div class="form-register">'.'<div class="alert alert-danger">'."Passwords does not match!".'</div>'.'</div>';
            }

        else
        {
            $link=open_database_connection();
            $coded_password = sha1($password);
            $insert="INSERT INTO users (username, password, email, signup_date) VALUES ('$username', '$coded_password', '$email', '$date')";

            $check_username = "SELECT * FROM users WHERE username = '".$username."'";
            $result_username = mysqli_query($link,$check_username);

            $check_email = "SELECT * FROM users WHERE email = '".$email."'";
            $result_email = mysqli_query($link,$check_email);

            if(mysqli_num_rows($result_username)>=1)
            {
                echo '<div class="form-register">'.'<div class="alert alert-warning">'."Username already exsists!".'</div>'.'</div>';
            }
            else if(mysqli_num_rows($result_email)>=1)
            {
                echo '<div class="form-register">'.'<div class="alert alert-warning">'."Email already exists!".'</div>'.'</div>';
            }
            else
            {
                if (!mysqli_query($link,$insert))
                {
                    echo("Error description: " . mysqli_error($link));
                }
                else
                {
                    header('Location: http://localhost/praksa/index.php?site=login');
                    $message = "Your registration on Solve-X meme library has been successful!";
                    mail($email, 'Registracija na strani http://localhost/praksa', $message);
                }                
            }
            close_database_connection($link);
        }
    }
}

function Login()
{
    if (isset($_POST['button']))
    {
        echo nl2br("\n");
        $username = strip_tags($_POST['username']);
        $password = strip_tags($_POST['password']);
        $date = date("Y-m-d H:i:sa");
        $link=open_database_connection();

        if ($username == "" || $password == "")
        {
            echo '<div class="form-signin">'.'<div class="alert alert-danger">'."Fields must not be empty!".'</div>'.'</div>';
        }
        else
        {
            $link=open_database_connection();
            $coded_password = sha1($password);
            $select="SELECT idUser FROM users WHERE username='$username' AND password='$coded_password'";

            if (!mysqli_query($link,$select))
            {
                echo("Error description: " . mysqli_error($link));
            }
            else
            {
                $result = mysqli_query($link,$select);
                $steviloVrstic=mysqli_num_rows($result);

                if ($steviloVrstic == 0)
                {
                    echo '<div class="form-signin">'.'<div class="alert alert-danger">'."Invalid login!".'</div>'.'</div>';
                }
                else
                {
                    $id = mysqli_fetch_array($result);
                    $_SESSION["praksa"] = $id['idUser'];
                    $sql="UPDATE users SET last_login='$date' WHERE idUser='" . $id['idUser'] . "'";

                    if (!mysqli_query($link,$sql))
                    {
                        echo("Error description: " . mysqli_error($link));
                    }
                    if (isset($_POST['remember']))
                    {
                        setcookie("Praksa_re", "Remember", time() + (86400 * 30), "/"); 
                    }
                    setcookie("Praksa", "Hi", time()+86400);
                    header('Location: index.php');
                }
            }
            close_database_connection($link);
        }
    }
}

function Logout()
{
    session_destroy();
    setcookie("Praksa", "", time()-1);
    setcookie("Praksa_re", "", time()-1);
    header('Location: index.php');
}

function samodejnaPrijava()
{
    if (isset($_COOKIE['Praksa_re']))
    {
        $_SESSION['praksa'] = $_COOKIE['Praksa'];
    }
}

function newMeme()
{
    if (isset($_POST['button']))
    {
        $currentUser = $_SESSION['praksa'];
        $title = strip_tags($_POST['title']);
        $description = strip_tags($_POST['description']);
        $upload_date = date("Y-m-d H:i:sa");

        if ($title == "" || $description== "")
        {
            echo '<div class="alert alert-danger" role="alert">'."Fields must not be empty!".'</div>';
        }
        else if (empty($uploadPhoto=addslashes (file_get_contents($_FILES['uploadPhoto']['tmp_name']))))
        {
            echo '<div class="alert alert-danger" role="alert">'."You have not selected a photo!".'</div>';
        }
        else
        {
            $koncnica = explode(".", $_FILES['uploadPhoto']['name']);
            $filename = md5(gmdate("dmYHis").uniqid()) . "." . $koncnica[1];
            $filepath = "photos/" . $filename;

            $link=open_database_connection();
            $sql="INSERT INTO memes (title, idUser, description, photo, upload_date) VALUES ('$title', '$currentUser', '$description', '$filename', '$upload_date')";

            if (!mysqli_query($link,$sql))
            {
                echo("Error description: " . mysqli_error($link));
            }
            else
            {
                echo '<div class="alert alert-success" role="alert">'."You have socuessfully added a meme!".'</div>';
                move_uploaded_file($_FILES["uploadPhoto"]["tmp_name"], $filepath);
            }
        }
        close_database_connection($link);
    }
}

function importMemes()
{
    if (isset($_POST['button']))
    {
        $currentUser = $_SESSION['praksa'];
        $upload_date = date("Y-m-d H:i:sa");
        $fileName = $_FILES["uploadFile"]["tmp_name"];

        if (empty($uploadPhoto=addslashes (file_get_contents($_FILES['uploadFile']['tmp_name']))))
        {
            echo '<div class="alert alert-danger" role="alert">'."You have not selected a file!".'</div>';
        }
        else
        {    
            if ($_FILES["uploadFile"]["size"] > 0) 
            {
                
                $file = fopen($fileName, "r");
                $link=open_database_connection();
                
                    while (($column = fgetcsv($file, 10000, ",")) !== FALSE) 
                    {                    
                        $idUser = "";
                        if (isset($column[0])) 
                        {
                            $idUser = mysqli_real_escape_string($link, $column[0]);
                        }
                        $title = "";
                        if (isset($column[1])) 
                        {
                            $title = mysqli_real_escape_string($link, $column[1]);
                        }
                        $description = "";
                        if (isset($column[2])) 
                        {
                            $description = mysqli_real_escape_string($link, $column[2]);
                        }
                        $photo = "";
                        if (isset($column[3])) 
                        {
                            $photo = mysqli_real_escape_string($link, $column[3]);
                        }
                        $upload_date = "";
                        if (isset($column[4])) 
                        {
                            $upload_date = mysqli_real_escape_string($link, $column[4]);
                        }                    
                        
                        $sql="INSERT INTO memes (idUser, title, description, photo, upload_date) VALUES ('$currentUser', '$title', '$description', '$photo', '$upload_date')";

                        if (!mysqli_query($link,$sql))
                        {
                            echo("Error description: " . mysqli_error($link));
                        }                 
                    }
               
            }            
        }
        close_database_connection($link);
    }
}

function editMeme($idMeme)
{
    if (isset($_POST['button']))
    {        
        $title = strip_tags($_POST['title']);
        $description = strip_tags($_POST['description']);
        $edit_date = date("Y-m-d H:i:sa");
        $link=open_database_connection();

        if (!empty($_FILES['uploadPhoto']['tmp_name']) && file_exists($_FILES['uploadPhoto']['tmp_name']))
        {    

            $koncnica = explode(".", $_FILES['uploadPhoto']['name']);
            $filename = md5(gmdate("dmYHis").uniqid()) . "." . $koncnica[1];
            $filepath = "photos/" . $filename;

            $sql = "UPDATE memes SET photo='$filename' WHERE idMeme='$idMeme'";
            if (!mysqli_query($link,$sql))
            {
                echo("Error description: " . mysqli_error($link));
            }
            else
            {
                move_uploaded_file($_FILES["uploadPhoto"]["tmp_name"], $filepath);
            }
        }

        $sql = "UPDATE memes SET title='$title', description='$description', edit_date='$edit_date'  WHERE idMeme='$idMeme'";
        if (!mysqli_query($link,$sql))
        {
            echo("Error description: " . mysqli_error($link));
        }
        else
        {
            header('Location: http://localhost/praksa/index.php');
        }        
        close_database_connection($link);
    }
}

function deleteMeme($idMeme)
{
    $link=open_database_connection();
    $sql = "DELETE FROM memes WHERE idMeme='$idMeme' ";
    $result = mysqli_query($link, $sql);
    close_database_connection($link);
    header("location: http://localhost/praksa/index.php");
}
?>
