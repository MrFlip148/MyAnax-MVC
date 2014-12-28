<hr>

<h2>Comments</h2>

<?php if (is_array($comments)) : ?>

    <ul class="post-list">
        <?php foreach ($comments as $comment) : ?>
            <li class="post">

            <div class="post-body">
                    
                <!-- <div class="avatar">
                <img class="avatar" src="<?=$this->url->asset('img/icon-avatar.png')?>" alt="Avatar">
                </div> -->
                
                <div class="post-header">
                <span class="post-name"><?= $comment->name ?></span>
                <span class="post-id"> | Comment #<?= $comment->id ?></span>
                <span class="post-menu">
                <a href="<?=$this->url->create('comment/add/' . $comment->id) ?>"><i class="fa fa-edit"></i></a>
                <a href="<?=$this->url->create('comment/remove-id/' . $comment->id) ?>"><i class="fa fa-trash-o"></i></a>
                </span>
                </div>
                
                <div class="post-content ">
                <?= $comment->comment ?>
                </div>
                
                <div class="post-footer">
                <?= $comment->web ?> | <?= $comment->mail ?>
                </div>
                    
            </div>

            </li>
        <?php endforeach; ?>
    </ul>

<?php endif; ?>
<!--
<a href="<?=$this->url->create('comment/add') ?>">[add comment]</a>
<a href="<?=$this->url->create('comment/setup') ?>">[delete all comments]</a> -->