<div class='comment-form'>
    <form method=post>
        <input type=hidden name="redirect" value="<?= $this->url->create($key) ?>">
        <input type=hidden name="pageKey" value="<?= $key ?>">
        <fieldset>
            <legend>Leave a comment</legend>
            <label>Comment:<br><textarea name='comment'><?= $comment ?></textarea></label><br>
            <label>Name:<br><input type='text' name='name' value='<?= $name ?>'/></label><br>
            <label>Homepage:<br><input type='text' name='web' value='<?= $web ?>'/></label><br>
            <label>Email:<br><input type='text' name='mail' value='<?= $mail ?>'/></label>
            <div class=buttons>
                <input type='submit' name='doCreate' value='Comment' onClick="this.form.action = '<?= $this->url->create('comment/add') ?>'"/>
                <input type='reset' value='Reset'/>
                <input type='submit' name='doRemoveAll' value='Remove all' onClick="this.form.action = '<?= $this->url->create('comment/remove-all') ?>'"/>
            </div>
            <output><?= $output ?></output>
        </fieldset>
    </form>
</div>
