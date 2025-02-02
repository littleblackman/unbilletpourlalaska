<?php $this->title = 'Editer commentaire' ?>
<?php ob_start(); ?>
    <div class="container admin add">
        <div class="row ">
            <h1><strong>Modifier ce commentaire </strong></h1>
            <br>
            <form class="form" role="form" action="index.php?action=newComment&amp;id=
<?= $comment['id']?>" method="post" enctype="multipart/form-data">
                <p style='margin-bottom:0;'><strong><?= htmlspecialchars($comment['auteur']) ?>
        </strong> le
                    <?= htmlspecialchars($comment['comment_date_fr']) ?>
                </p>
                <br />
                <div class="form-group">
                    <label for="description">Contenu:</label>
                    <textarea id="comment" name="comment">
                        <?= htmlspecialchars($comment['commentaire'])?>
                    </textarea><span class="help-inline"></span></div>
                <br>
                <div class="form-actions"> <a class="btn btn-primary" href="index.php?action=board"><span class="glyphicon glyphicon-arrow-left"> Retour</span></a><a class="btn btn-danger" href="index.php?action=eraseComment&amp;id=
<?= $comment['id']?>"><span class="glyphicon glyphicon-remove"> Supprimer</span></a><a href="index.php?action=board" type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Valider</a> </div>
            </form>
        </div>
    </div>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>