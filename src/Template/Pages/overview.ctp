<div class="top-block">
    <div class="block-title"><h4>Vrienden met de meeste karma</h4></div>
    <div class="friends">
        <?php foreach($friends as $friend) {
            echo $this->element('friend', ['friend' => $friend]);
        }?>
    </div>
</div>
    <div class="block">
        <div class="create-post">
            <?php
                echo $this->Form->create(null);
                echo $this->Form->textarea('content', ['placeholder' => 'Wat kun je mij vertellen?']);
                echo $this->Form->button('Plaatsen', ['class' => 'button green']);
                echo $this->Form->end();
            ?>
        </div>
        <div class="posts">
            <?php foreach($posts as $post) {
                echo $this->element('post', ['post' => $post]);
            }?>
        </div>
    </div>
</div>