<?php //include config
//require_once('../includes/config.php');
 require('connect.php');
require('header.php');
//if not logged in redirect to login page
//if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<?php

//if form has been submitted process it
if(isset($_POST['submit'])){

    $_POST = array_map( 'stripslashes', $_POST );

    //collect form data
    extract($_POST);

    //very basic validation
    if($postTitle ==''){
        $error[] = 'Please enter the title.';
    }

    if($postDesc ==''){
        $error[] = 'Please enter the description.';
    }

    if($postCont ==''){
        $error[] = 'Please enter the content.';
    }

    if(!isset($error)){

        try {

            //insert into database
            $stmt = $pdo->prepare('INSERT INTO posts (title,postDesc,content,postDate) VALUES (:title, :postDesc, :content, :postDate)') ;
            $stmt->execute(array(
                ':title' => $postTitle,
                ':postDesc' => $postDesc,
                ':content' => $postCont,
                ':postDate' => date('Y-m-d H:i:s')
            ));

            //redirect to index page
            header('Location: index.php?action=added');
            exit;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }

    }

}

//check for any errors
if(isset($error)){
    foreach($error as $error){
        echo '<p class="error">'.$error.'</p>';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin - Add Post</title>
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/main.css">
<!--    <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>-->
<!--    <script>-->
<!--        tinymce.init({-->
<!--            selector: "textarea",-->
<!--            plugins: [-->
<!--                "advlist autolink lists link image charmap print preview anchor",-->
<!--                "searchreplace visualblocks code fullscreen",-->
<!--                "insertdatetime media table contextmenu paste"-->
<!--            ],-->
<!--            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"-->
<!--        });-->
<!--    </script>-->
    <script src="https://cdn.ckeditor.com/ckeditor5/1.0.0-alpha.2/classic/ckeditor.js"></script>

</head>
<body>

<div id="wrapper">

<!--    --><?php //include('menu.php');?>

    <p><a href="./">Blog Admin Index</a></p>

    <h2>Add Post</h2>



    <form action='' method='post'>

        <p><label>Title</label><br />
            <input type='text' name='postTitle' value='<?php if(isset($error)){ echo $_POST['postTitle'];}?>'></p>

        <p><label>Description</label><br />
            <textarea name='postDesc' id='postDesc' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postDesc'];}?></textarea></p>
        <script>
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace( 'postDesc' );
        </script>

        <p><label>Content</label><br />
            <textarea name='postCont' id='postCont' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postCont'];}?></textarea></p>
        <script>
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace( 'postCont' );
        </script>

        <p><input type='submit' name='submit' value='Submit'></p>

    </form>

</div>
