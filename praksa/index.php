<?php
session_start();
include "controller.php";

if (isset($_GET['site']))
  {
    if (($_GET['site']=="home"))
    {
        include 'templates/index1.html.php';
    }      
  	else if (($_GET['site']=="login") && !(isset($_SESSION['praksa'])))
    {
        include 'templates/user/login.html.php';
    }
    else if (($_GET['site']=="signup") && !(isset($_SESSION['praksa'])))
    {
        include 'templates/user/signup.html.php';
    }
    else if (($_GET['site']=="logout") && (isset($_SESSION['praksa'])))
    {
        include 'templates/user/logout.html.php';
    }
    else if (($_GET['site']=="newmeme") && (isset($_SESSION['praksa'])))
    {
        include 'templates/meme/newMeme.html.php';
    }
    else if (($_GET['site']=="editMeme") && (isset($_SESSION['praksa'])))
    {
        include 'templates/meme/editMeme.html.php';
    }
    else if (($_GET['site']=="deleteMeme") && (isset($_SESSION['praksa'])))
    {
        include 'templates/meme/deleteMeme.html.php';
    }
    else if (($_GET['site']=="importmeme"))
    {
        include 'templates/meme/importMemes.html.php';
    }
  	else
    {
        include 'templates/error.html.php';
    }
  }
else
{
include 'templates/index1.html.php';
}
?>