<?php
	require_once("../database.php");
	require_once("../lib/articles.php");
	
    $link = db_connect();
    
    if(isset($_GET['action'])){
        $action = $_GET['action'];
    }else{
        $action = "";
    }
    
    if($action == "add"){
        if(!empty($_POST)){
            article_new($link, $_POST['title'], $_POST['date'], $_POST['content']);
            header("Location: ./");
        }
        include("article_admin.php");
    }else if($action == "edit"){
        if(isset($_GET['id'])){
            $id = (int)$_GET['id'];
            if($id <1){
                header("Location: ./");
            }else if($id > 0 && empty($_POST)){
                $article = article_get($link, $id);
                include("article_admin.php");
            }else{
                article_edit($link, $id, $_POST['title'], $_POST['date'], $_POST['content']);
                header("Location: ./");
            }
        }else{
        	header("Location: ./");
        }
    }else if($action == "delete"){
    	$id = $_GET['id'];
    	article_delete($link, $id);
    	header("Location: ./");
    }else{
    	$articles = article_all($link);
    	include("articles_admin.php");
    }
?>