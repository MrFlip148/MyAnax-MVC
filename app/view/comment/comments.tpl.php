<hr>

<h2>Comments</h2>

<?php if (is_array($comments)) : ?>

    <ul class="post-list">
        <?php foreach ($comments as $id => $comment) : $idHtml = $id + 1 ?>
            <li class="post">
                <div class="post-body">
                    
                    <div class="avatar">
                        <img class="avatar" src="../img/icon-avatar.png" alt="Avatar">
                    </div>
                    
                    <div class="post-header">
                        <form method=post>
                            <span class="post-name"><?= $comment['name'] ?></span>
                            <span class="post-id"> | Comment #<?= $idHtml ?></span>
                            <span class="post-menu">
                                <input type=hidden name="redirect" value="<?= $this->url->create($key) ?>">
                                <input type=hidden name="postId" value="<?= $idHtml ?>">
                                <input type=hidden name="pageKey" value="<?= $key ?>">
                                <input class="myButton" type='submit' name='doRemovePost' value='delete' onclick="this.form.action = '<?= $this->url->create('comment/remove-id') ?>'">
                                <input class="myButton" type='submit' name='doEditId' value='edit' onclick="this.form.action = '<?= $this->url->create('comment/edit') ?>'">
                            </span>
                        </form>
                    </div>
                    
                    <div class="post-content ">
                        <?= $comment['content'] ?>
                    </div>
                    
                    <div class="post-footer">
                        <?= $comment['web'] ?> | <?= $comment['mail'] ?>
                    </div>
                    
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

<?php endif; ?> 