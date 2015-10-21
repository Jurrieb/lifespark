<div class="post-wrapper">
    <div class="post" data-id="<?php echo $post->id;?>">
        <div class="post-head">
            <div class="avatar"></div>
            <div class="post-information">
                <div class="name">
                    <?php
                        echo $this->Html->link($post->user->name,
                            ['controller' => 'Users', 'action' => 'profile', $post->user->slug],
                            ['escape' => false, 'class' => 'name']
                        );
                        if(!empty($post->profile)){
                            echo ' >> ';
                            echo $this->Html->link($post->profile->name,
                                ['controller' => 'Users', 'action' => 'profile', $post->user->slug],
                                ['escape' => false, 'class' => 'name']
                            );
                        }
                        ?></div>
                <div class="date"><?php echo $this->Time->elapsed( $post->created_at );?></div>
            </div>
            <button type="button" class="dropdown" data-actions="update delete"><span class="icon-more_vert"></span></button>
        </div>
        <div class="post-content">
            <?php echo $post->content;?>
        </div>
        <?php if(!empty($post->comments)) { ?>
            <div class="comments">
            <?php foreach($post->comments as $comment) { ?>
                <div class="comment" data-id="<?php echo $comment->id;?>">
                    <div class="avatar"></div>
                    <div class="comment-information">
                            <?php echo $this->Html->link($comment->user->name,
                                ['controller' => 'Users', 'action' => 'profile', $comment->user->slug],
                                ['escape' => false, 'class' => 'name']
                             ); ?>
                        <div class="date"><?php echo $this->Time->elapsed( $comment->created_at );?></div>
                    </div>
                    <div class="comment-content"><?php echo $comment->content;?></div>
                    <button type="button" class="dropdown" data-actions="delete"><span class="icon-more_vert"></span></button>
                </div>
            <?php } ?>

            </div>
        <?php } ?>
        <div class="create-comment">
            <?php
                echo $this->Form->create(null);
                echo $this->Form->hidden('post_id', ['value' => $post->id]);
                echo $this->Form->textarea('content', ['placeholder' => 'Plaats een reactie']);
                echo $this->Form->button('Plaatsen', ['class' => 'button green']);
                echo $this->Form->end();
            ?>
        </div>
    </div>
</div>