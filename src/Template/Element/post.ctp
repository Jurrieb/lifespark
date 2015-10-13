<div class="post-wrapper">
    <div class="post">
        <div class="post-head">
            <div class="avatar"></div>
            <div class="post-information">
                <div class="name">
                    <?php echo $this->Html->link($post->user->name,
                    ['controller' => 'Users', 'action' => 'profile', $post->user->slug],
                    ['escape' => false, 'class' => 'name']
                        ); ?></div>
                <div class="date"><?php echo $this->Time->elapsed( $post->created_at );?></div>
            </div>
            <button class="action" data-dropup=""><span class="icon-more_vert"></span></button>
            <div class="dropup"></div>
        </div>
        <div class="post-content">
            <?php echo $post->content;?>
        </div>
        <?php if(!empty($post->comments)) { ?>
            <div class="comments">
            <?php foreach($post->comments as $comment) { ?>
                <div class="comment">
                    <div class="avatar"></div>
                    <div class="comment-information">
                            <?php echo $this->Html->link($comment->user->name,
                                ['controller' => 'Users', 'action' => 'profile', $comment->user->slug],
                                ['escape' => false, 'class' => 'name']
                             ); ?>
                        <div class="date"><?php echo $this->Time->elapsed( $comment->created_at );?></div>
                    </div>
                    <div class="comment-content"><?php echo $comment->content;?></div>
                    <button class="action"><span class="icon-more_vert"></span></button>
                </div>
            <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>