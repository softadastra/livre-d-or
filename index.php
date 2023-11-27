<?php 
require_once("elements/header.php");
require_once("src/Message.php");
require_once("src/GuestBook.php");

$errors = null;
$success = false;

$guestBook = new GuestBook(__DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'message');

if(isset($_POST['username'],$_POST['message'])){
    $username = htmlentities($_POST['username']);
    $message = htmlentities($_POST['message']);
    
    $message = new Message($username,$message);
    if($message->isValid()){
        $guestBook->addMessage($message);

        $success = true;
        $_POST = [];
    }else{
        $errors = $message->getErrors();
    }
}

$messages = $guestBook->getMessages();
?>

<div class="container" style="margin-top:60px;">
    <h2>Notre Livre d'or</h2>

    <?php if(!empty($errors)):?>
    <div class="alert alert-danger">
        Formulaire invalid
    </div>
    <?php endif;?>

    <?php if($success):?>
    <div class="alert alert-success">
        Message envoyer avec success !
    </div>
    <?php endif;?>

    <form action="" method="post">
        <div class="form-group">
            <label>Pseudo :</label>
            <input type="text" name="username" class="form-control <?= isset($errors['username']) ? 'is-invalid':'' ?>">
            <?php if(isset($errors['username'])):?>
            <div class="invalid-feedback">
                <?= $errors['username']?>
            </div>
            <?php endif;?>
        </div>
        <div class="form-group">
            <label>Message :</label>
            <textarea name="message" class="form-control <?= isset($errors['message']) ? 'is-invalid':'' ?>"></textarea>
            <?php if(isset($errors['message'])):?>
            <div class="invalid-feedback">
                <?= $errors['message']?>
            </div>
            <?php endif;?>
        </div><br>
        <button class="btn btn-primary">Envoyer</button>
    </form>

    <?php if(!empty($messages)):?>
    <h2 class="mt-4">Vos messages</h2>

    <?php foreach($messages as $message):?>
    <?= $message->toHTML()?>
    <?php endforeach?>

    <?php endif?>

</div>

<?php require_once("elements/footer.php");?>